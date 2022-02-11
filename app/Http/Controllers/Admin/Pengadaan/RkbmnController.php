<?php

namespace App\Http\Controllers\Admin\Pengadaan;

use App\Http\Controllers\Controller;
use App\Model\Pengadaan\Rkbmn\Rkbmn;
use App\Model\Pengadaan\Rkbmn\RkbmnPemeliharaan;
use App\Model\Pengadaan\Rkbmn\RkbmnPengadaan;
use App\Model\Wilayah;
use App\Repositories\Datatable\Datatable;
use App\Repositories\Permission\Permission;
use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RkbmnController extends Controller
{

    private $route = 'admin.pengadaan.rkbmn';
    private $config, $layout;
    private $title = 'RKBMN';
    private $permission = 'pengadaan-rkbmn';

    public function __construct()
    {
        $this->model = new Rkbmn();
        $this->breadcrumb = ['Pengadaan Barang' => null];
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
        Permission::access('view-' . $this->permission);

        $data['config'] = $this->config;
        $data['config']['breadcrumb'] = array_merge($this->breadcrumb, [$this->title => route($this->route . '.index')]);
        $data['canOpenFile'] = \Auth::user()->isAdminPusat() || \Auth::user()->isSuperAdmin();
        if($data['canOpenFile']) {
            $data['table']['header'] = ['Jenis', 'Tahun', 'File'];
        } else {
            $data['table']['header'] = ['Jenis', 'Tahun'];
        }

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
        $data['config']['breadcrumb'] = array_merge($this->breadcrumb, [$this->title => route($this->route . '.index'), 'Detail' => route($this->route . '.show', $id)]);

        $data['data'] = $this->model->findOrFail($id);
        if($data['data']->type == 2) {
            $data['table']['header'] = ['ES1', 'DU', 'APIP', 'UAPB', 'DJKN', 'Anggaran', 'Jumlah Anggaran', 'Kode Barang', 'Nama Barang', 'Kode Satker', 'Nama Satker', 'NUP'];
        } else {
            $data['table']['header'] = ['ES1', 'DU', 'APIP', 'UAPB', 'DJKN', 'Anggaran', 'Jumlah Anggaran', 'No Pengadaan', 'Kode Barang', 'Nama Barang', 'Kode Satker', 'Nama Satker'];
        }

        $data['filter'] = [
            'lingkungan' => ['PN' => 'Peradilan Umum', 'PA' => 'Peradilan Agama', 'PM' => 'Peradilan Militer', 'PT' => 'Peradilan Tata Usaha Negara'],
            'wilayah' => Wilayah::get()
        ];
        $data['baseFilter'] = ['lingkungan' => 'lingkungan', 'wilayah' => 'wilayah', 'djkn' => 'djkn', 'anggaran' => 'anggaran'];

        return view($this->layout . '.show', $data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        Permission::access('view-' . $this->permission);

        Permission::can('view-' . $this->permission) ? $action[] = 'show' : '';
        Permission::can('delete-' . $this->permission) ? $action[] = 'delete' : '';

        $model = $this->model->select('type', 'year', 'file');

        $dataTable = Datatable::create($model)
            ->editColumn('type', function ($data){
                return '<span class="m-badge m-badge--' . ($data->type == 2 ? 'info' : 'success') . ' m-badge--wide">' . ($data->type == 2 ? 'Pemeliharaan' : 'Pengadaan') . '</span>';
            })
            ->editColumn('file', function ($data){
                return '<a target="_blank" href="'.asset('file/rkbmn/'.$data->file).'">
                    <button class="btn btn-warning btn-sm btn-block" type="button">
                        <i class="fa fa-file-excel-o"></i> File RKBMN
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

        $model = $data->detail()->join('satkers as s', 's.kode', '=', 'kode_satker')->assetBy('s.kode', true)
            ->generalFilter($filter)->select(['eselon1', 'draftuapb', 'apip', 'uapb', 'djkn', 'kode_barang',
                'nama_barang', 'kode_satker', 'nama_satker', 'is_anggaran', 'jumlah_anggaran']);
        if($data->type == 2) {
            $table = 'rkbmn_pemeliharaans';
            $model = $model->addSelect('nup');
        } else {
            $table = 'rkbmn_pengadaans';
            $model = $model->addSelect('no_pengadaan');
        }

        $canPagu = \Permission::can('pagu-'.$this->permission);
        $dataTable = Datatable::create($model)
            ->setId($table.'.id')
            ->editColumn('eselon1', function ($data){
                return '<i class="fa fa-'.($data->eselon1 == 1 ? 'check' : ($data->eselon1 == 2 ? 'remove' : 'minus')).'" style="color: #'.($data->eselon1 == 1 ? '2ecc71' : ($data->eselon1 == 2 ? 'e74c3c' : '2c3e50')).';"></i>';
            })
            ->editColumn('draftuapb', function ($data){
                return '<i class="fa fa-'.($data->draftuapb == 1 ? 'check' : ($data->draftuapb == 2 ? 'remove' : 'minus')).'" style="color: #'.($data->draftuapb == 1 ? '2ecc71' : ($data->draftuapb == 2 ? 'e74c3c' : '2c3e50')).';"></i>';
            })
            ->editColumn('apip', function ($data){
                return '<i class="fa fa-'.($data->apip == 1 ? 'check' : ($data->apip == 2 ? 'remove' : 'minus')).'" style="color: #'.($data->apip == 1 ? '2ecc71' : ($data->apip == 2 ? 'e74c3c' : '2c3e50')).';"></i>';
            })
            ->editColumn('uapb', function ($data){
                return '<i class="fa fa-'.($data->uapb == 1 ? 'check' : ($data->uapb == 2 ? 'remove' : 'minus')).'" style="color: #'.($data->uapb == 1 ? '2ecc71' : ($data->uapb == 2 ? 'e74c3c' : '2c3e50')).';"></i>';
            })
            ->editColumn('djkn', function ($data){
                return '<i class="fa fa-'.($data->djkn == 1 ? 'check' : ($data->djkn == 2 ? 'remove' : 'minus')).'" style="color: #'.($data->djkn == 1 ? '2ecc71' : ($data->djkn == 2 ? 'e74c3c' : '2c3e50')).';"></i>';
            })
            ->editColumn('is_anggaran', function ($data){
                return '<i class="fa fa-'.($data->is_anggaran == 1 ? 'check' : ($data->is_anggaran == 2 ? 'remove' : 'minus')).'" style="color: #'.($data->is_anggaran == 1 ? '2ecc71' : ($data->is_anggaran == 2 ? 'e74c3c' : '2c3e50')).';"></i>';
            })
            ->editColumn('jumlah_anggaran', function ($data){
                return $data->jumlah_anggaran == null ? '<i class="empty-text">empty</i>' : 'Rp '.numberFormatIndo($data->jumlah_anggaran);
            })
            ->editColumn('action', function ($data) use($id, $canPagu){
                if($data->djkn == 1 && $canPagu) {
                    return '<a href="' . route($this->route . '.pagu', ['id' => $id, 'rkbmn' => $data->id]) . '" data-anggaran="'.$data->is_anggaran.'" data-jumlah="'.$data->jumlah_anggaran.'" class="btn btn-info btn-xs m-btn m-btn--icon m-btn--icon-only tooltips ajaxify btn-pagu" title="Pagu Alokasi">
                        <i class="la la-check"></i>
                    </a> ';
                }

                return '<i class="empty-text">empty</i>';
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
        $data['config']['breadcrumb'] = array_merge($this->breadcrumb, [$this->title => route($this->route . '.index'), 'Tambah' => route($this->route . '.create')]);

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
            'type'   => 'required|in:1,2',
            'year'   => 'required|date_format:Y',
            'file' => 'required|mimes:xlsx'
        ]);

        if (!$validator->fails()) {
            $param = $request->all();
            $res = \DB::transaction(function () use ($param) {
                $type = $param['type'];
                $file = $param['file'];
                $year = $param['year'];

                $checkRkbmn = Rkbmn::where('year', $year)->where('type', $type)->first();
                $filename = time().'-rkbmn-'.$year.'-'.($type == 1 ? 'pengadaan' : 'pemeliharaan').'.'.$file->getClientOriginalExtension();
                $file->storeAs('file/rkbmn', $filename, ['disk' => 'public_non']);

                if($checkRkbmn == null) {
                    $checkRkbmn = Rkbmn::create([
                        'year' => $year,
                        'type' => $type,
                        'file' => $filename,
                        'created_by' => \Auth::user()->id
                    ]);
                } else {
                    $checkRkbmn->file = $filename;
                    $checkRkbmn->save();

                    $checkRkbmn->detail()->delete();
                }

                $reader = ReaderFactory::create(Type::XLSX);
                $reader->open($file);

                $colData = 5;

                if($type == 2) {
                    $colomn = ['eselon1', 'draftuapb', 'apip', 'uapb', 'djkn', 'kode_barang', 'nama_barang', 'nup', 'tgl_perolehan', 'merk', 'kondisi', 'status_penggunaan', 'jumlah', 'pemanfaatan', 'keb_ril', 'nilai_perolehan', 'usulan_satker', 'usulan_es1', 'usulan_pb', 'usulan_apip', 'usulan_final', 'koreksi', 'persetujuan_djkn', 'kode_satker', 'nama_satker'];
                } else {
                    $colomn = ['eselon1', 'draftuapb', 'apip', 'uapb', 'djkn', 'no_pengadaan', 'no_output', 'kode_barang', 'nama_barang', 'kategori', 'sbsk_usulan', 'jml_eksisting', 'luas_eksisting', 'sbsk_eksisting', 'optimalisasi', 'kebutuhan_ril', 'kpb_unit', 'kpb_luas', 'eselon_unit', 'eselon_luas', 'pengguna_unit', 'pengguna_luas', 'apip_unit', 'apip_luas', 'final_unit', 'final_luas', 'koreksi', 'persetujuan_unit', 'persetujuan_luas', 'tahun_anggaran', 'kode_tiket', 'kode_satker', 'nama_satker'];
                }

                foreach ($reader->getSheetIterator() as $sheet) {
                    foreach ($sheet->getRowIterator() as $k => $row) {
                        if($k >= $colData) {
                            if($row[0] != "") {
                                $tmpData = ['id_rkbmn' => $checkRkbmn->id];
                                foreach ($colomn as $j => $r) {
                                    if(in_array($j, [0,1,2,3,4])){
                                        $value = $row[$j] == 'Setuju' ? 1 : ($row[$j] == '-' ? 0 : 2);
                                    } else if($j == 8 && $type == 2) {
                                        $date = Carbon::createFromFormat('d/m/Y G:i:s', $row[$j]);
                                        $value = $date->toDateTimeString();
                                    } else {
                                        $value = $row[$j];
                                    }
                                    $tmpData[$r] = $value;
                                }

                                if($type == 2) {
                                    RkbmnPemeliharaan::create($tmpData);
                                } else {
                                    RkbmnPengadaan::create($tmpData);
                                }
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
     * @param Request $request
     * @param $rkbmnId
     * @param $rkbmnDetailId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function pagu(Request $request, $rkbmnId, $rkbmnDetailId)
    {
        Permission::access('pagu-' . $this->permission);

        $param = $this->cleanNumber($request->all(), ['jumlah']);
        $validator = Validator::make($request->all(), [
            'jumlah' => 'required_if:anggaran,1',
        ]);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $rkbmnId, $rkbmnDetailId) {
                $rkbmn = Rkbmn::findOrFail($rkbmnId)->detail()->where('id', $rkbmnDetailId)->firstOrFail();
                if(isset($param['anggaran'])) {
                    $rkbmn->is_anggaran = 1;
                    $rkbmn->jumlah_anggaran = $param['jumlah'];
                } else {
                    $rkbmn->is_anggaran = 2;
                    $rkbmn->jumlah_anggaran = null;
                }

                if ($rkbmn->save()) {
                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil menambahkan Data Pagu Alokasi'
                    ];
                } else {
                    $res = [
                        'status'  => 0,
                        'message' => 'Gagal menambahkan data Pagu Alokasi'
                    ];
                }

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

    /**
     * @param $param
     * @param $clean
     * @return array
     */
    public function cleanNumber($param, $clean)
    {
        $param = collect($param);
        $param = $param->transform(function ($item, $key) use ($clean) {
            if (in_array($key, $clean)) {
                if (is_array($item)) {
                    $item = collect($item);
                    $item = $item->transform(function ($i, $k) {
                        $i = str_replace(['.', ','], ['', '.'], $i);
                        return $i;
                    })->toArray();
                } else {
                    $item = str_replace(['.', ','], ['', '.'], $item);
                }
            }

            return $item;
        });

        return $param->toArray();
    }
}
