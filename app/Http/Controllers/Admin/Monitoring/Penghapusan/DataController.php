<?php

namespace App\Http\Controllers\Admin\Monitoring\Penghapusan;

use App\Http\Controllers\Controller;
use App\Model\MonitoringPenghapusan;
use App\Model\Wilayah;
use App\Repositories\Datatable\Datatable;
use App\Repositories\Permission\Permission;
use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{

    private $route = 'admin.monitoring.penghapusan.data';
    private $config, $layout;
    private $title = 'Data Penghapusan';
    private $permission = 'monitoring-penghapusan';

    public function __construct()
    {
        $this->model = new MonitoringPenghapusan();
        $this->layout = $this->route;
        $this->config = [
            'route'     => $this->route,
            'title'     => $this->title,
            'pageTitle' => $this->title,
            'permission'=> $this->permission
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Permission::access('create-' . $this->permission);

        $data['config'] = $this->config;
        $data['table']['header'] = ['Tahun', 'File'];

        return view($this->layout . '.index', $data);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        Permission::access('view-' . $this->permission);

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Detail '.$this->title;

        $data['data'] = $this->model->findOrFail($id);
        $data['table']['header'] = ['Kode Satker', 'Nama Satker', 'Akun', 'Uraian AKun', 'Kode Bidang', 'Uraian Bidang', 'Kode Transaksi', 'Uraian Transaksi', 'Kuantitas', 'Nilai'];

        $data['filter'] = [
            'lingkungan' => ['PN' => 'Peradilan Umum', 'PA' => 'Peradilan Agama', 'PM' => 'Peradilan Militer', 'PT' => 'Peradilan Tata Usaha Negara'],
            'wilayah' => Wilayah::get()
        ];
        $data['baseFilter'] = ['lingkungan' => 'lingkungan', 'wilayah_kode' => 'wilayah'];

        return view($this->layout . '.show', $data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        Permission::access('create-' . $this->permission);

        Permission::can('create-' . $this->permission) ? $action[] = 'show' : '';
        Permission::can('delete-' . $this->permission) ? $action[] = 'delete' : '';

        $model = $this->model->select('year', 'file');

        $dataTable = Datatable::create($model)
            ->editColumn('file', function ($data){
                return '<a target="_blank" href="'.asset('file/penghapusan/'.$data->file).'">
                    <button class="btn btn-warning btn-sm btn-block" type="button">
                        <i class="fa fa-file-excel-o"></i> File
                    </button>
                </a>';
            })
            ->defaultAction($action, ['route' => $this->route, 'title' => $this->title]);
        $respond = $dataTable->make(true);

        return response()->json($respond);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function tableDetail(Request $request, $id)
    {
        $filter = $request->input('filter');

        $data = $this->model->find($id);
        Permission::access('view-' . $this->permission);

        $model = $data->detail()->select( 'id_monitoring_penghapusan', 'kode_satker', 'nama_satker', 'akun', 'uraian_akun',
            'kode_bidang', 'uraian_bidang', 'kode_transaksi', 'uraian_transaksi', 'kuantitas', 'nilai')
            ->join('satkers as s', \DB::raw('SUBSTRING(s.kode, 10, 6)'), \DB::raw('SUBSTRING(kode_satker, -6)'))
            ->assetBy()->generalFilter($filter);

        $dataTable = Datatable::create($model)
            ->setId('monitoring_penghapusan_details.id')
            ->editColumn('nilai', function ($data){
                return $data->nilai == null ? '<i class="empty-text">empty</i>' : 'Rp '.numberFormatIndo($data->nilai);
            });
        $respond = $dataTable->make(true);

        return response()->json($respond);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        Permission::access('create-' . $this->permission);

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Tambah '.$this->title;

        return view($this->layout . '.create', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        Permission::access('create-' . $this->permission);

        $validator = Validator::make($request->all(), [
            'year'   => 'required|date_format:Y',
            'file' => 'required|mimes:xlsx'
        ]);

        if (!$validator->fails()) {
            $param = $request->all();
            $res = \DB::transaction(function () use ($param) {
                $file = $param['file'];
                $year = $param['year'];

                $checkData = $this->model->where('year', $year)->first();
                $filename = time().'-penghapusan-'.$year.'.'.$file->getClientOriginalExtension();
                $file->storeAs('file/penghapusan', $filename, ['disk' => 'public_non']);

                if($checkData == null) {
                    $checkData = $this->model->create([
                        'year' => $year,
                        'file' => $filename,
                        'created_by' => \Auth::user()->id
                    ]);
                } else {
                    $checkData->file = $filename;
                    $checkData->save();

                    $checkData->detail()->delete();
                }

                $reader = ReaderFactory::create(Type::XLSX);
                $reader->open($file);

                $colData = 2;
                $colomn = ['kode_satker', 'nama_satker', 'akun', 'uraian_akun', 'kode_bidang', 'uraian_bidang', 'kode_transaksi', 'uraian_transaksi', 'kuantitas', 'nilai'];

                foreach ($reader->getSheetIterator() as $sheet) {
                    foreach ($sheet->getRowIterator() as $k => $row) {
                        if($k >= $colData) {
                            if($row[0] != "") {
                                $tmpData = ['id_monitoring_penghapusan' => $checkData->id];
                                foreach ($colomn as $j => $r) {
                                    $value = $row[$j+1];
                                    $tmpData[$r] = $value;
                                }

                                $checkData->detail()->create($tmpData);
                            }
                        }
                    }
                }

                $res = [
                    'status'  => 1,
                    'message' => 'Berhasil menyimpan Data ' . $this->title
                ];

                return $res;
            });

        } else {
            $messages = $validator->errors()->all('<li>:message</li>');
            $res = [
                'status'  => 2,
                'message' => '<ul class="m--marginless">' . implode('', $messages) . '</ul>'
            ];
        }

        return response()->json($res);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        Permission::access('delete-' . $this->permission);

        $data = $this->model->findOrFail($id);
        $data->detail()->delete();
        $result = $data->delete();

        $res['status'] = $result ? 1 : 0;

        return response()->json($res);
    }
}
