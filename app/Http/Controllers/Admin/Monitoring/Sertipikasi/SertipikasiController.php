<?php

namespace App\Http\Controllers\Admin\Monitoring\Sertipikasi;

use App\Http\Controllers\BarangTrait;
use App\Http\Controllers\Controller;
use App\Model\Asset\AssetTanah;
use App\Model\CategoryAsset;
use App\Model\Satker;
use App\Model\Sertipikasi\SertipikasiTanah;
use App\Model\Sertipikasi\SertipikasiTanahDetail;
use App\Repositories\Datatable\Datatable;
use App\Repositories\Permission\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SertipikasiController extends Controller
{
    use BarangTrait;

    private $route = 'admin.monitoring.sertipikasi';
    private $config, $layout;
    private $title = 'Sertipikasi Tanah';
    private $permission = 'monitoring-sertipikasi';
    protected $objName = 'sertipikat';

    public function __construct()
    {
        $this->model = new SertipikasiTanah();
        $this->layout = $this->route;
        $this->breadcrumb = ['Monitoring' => null];
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
        $canCreate = !\Auth::user()->isSatker() && !\Auth::user()->isAdminSatker();
        if($canCreate) {
            $data['table']['header'] = ['Satker', 'Kode Barang - NUP', 'Nama Barang', 'Jumlah Anggaran', 'Tindak Lanjut Ke', 'Status', 'Tanggal Pengajuan', 'Tanggal Update Tindak Lanjut'];
        } else {
            $data['table']['header'] = ['Kode Barang - NUP', 'Nama Barang', 'Jumlah Anggaran', 'Tindak Lanjut Ke', 'Status', 'Tanggal Pengajuan', 'Tanggal Update Tindak Lanjut'];
        }

        $data['canCreate'] = $canCreate;

        return view($this->layout . '.index', $data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        Permission::access('view-' . $this->permission);

        $action = [];
        Permission::can('delete-' . $this->permission) ? $action[] = 'delete' : '';
        Permission::can('edit-' . $this->permission) ? $action[] = 'edit' : '';

        $model = $this->model
            ->join('satkers as s', 's.id', '=', 'sertipikasi_tanahs.id_satker')
            ->join('asset_tanahs', \DB::raw("CONCAT_WS('-', asset_tanahs.kode_satker, asset_tanahs.kode_barang, asset_tanahs.nup)"), 'id_tanah')
            ->select('s.name as satkerName', 's.kode as kodeSatker','kode_barang', 'nup', 'nama_barang', 'jumlah_anggaran', 'progress', 'status', $this->model->getTable().'.created_at', 'tanggal_tindak_lanjut');

        if(Permission::can('edit-'.$this->permission) && !\Auth::user()->isSuperAdmin()) {
            $model->where('s.id', \Auth::user()->id_satker);
        }

        $dataTable = Datatable::create($model)
            ->setId($this->model->getTable().'.id')
            ->editColumn('satkerName', function ($data){
                return $data->satkerName.' <br>(<strong>'.$data->kodeSatker.'</strong>)';
            })
            ->editColumn('kode_barang', function ($data){
                return $data->kode_barang.'-'.$data->nup;
            })
            ->editColumn('jumlah_anggaran', function ($data){
                return 'Rp '. numberFormatIndo($data->jumlah_anggaran);
            })
            ->editColumn('progress', function ($data){
                return '<strong>Ke-'.$data->progress.'</strong>';
            })
            ->editColumn('created_at', function ($data){
                return Carbon::parse($data->created_at)->format('j F Y, H:i');
            })
            ->editColumn('tanggal_tindak_lanjut', function ($data){
                return Carbon::parse($data->tanggal_tindak_lanjut)->format('j F Y, H:i');
            })
            ->editColumn('status', function ($data){
                return '<span class="m-badge m-badge--' . ($data->status == 1 ? 'info' : 'success') . ' m-badge--wide">' . ($data->status == 1 ? 'Proses' : 'Selesai') . '</span>';
            })
            ->filterConstraint(['created_at' => 'date', 'tanggal_tindak_lanjut' => 'date'])
            ->editColumn('action', function ($data) use ($action){
                $html = '<a type="button" href="'.route($this->route . '.show', $data->id).'" title="Detail '.$this->title.'" class="btn btn-info btn-sm m-btn m-btn--icon m-btn--icon-only tooltips ajaxify">
                        <i class="la la-eye"></i>
                    </a> ';
                if($data->status == 1 && in_array('edit', $action)) {
                    $html .= '<a class="btn btn-warning m-btn btn-sm m-btn--icon-only tooltips ajaxify" href="'.route($this->route . '.edit', $data->id).'" title="Progres '.$this->title.'"> <i class="la la-pencil"></i> Tindak Lanjut</a>';
                }

                if($data->status == 1 && $data->progress == 0 && in_array('delete', $action)) {
                    $html .= '<a class="btn btn-danger m-btn btn-sm m-btn--icon-only btn-delete tooltips ajaxify" href="'.route($this->route . '.destroy', $data->id).'" title="Hapus '.$this->title.'"> <i class="la la-trash"></i></a>';
                }

                return $html == '' && empty($action) ? '#' : $html;
            });
        $respond = $dataTable->make(true);

        return response()->json($respond);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        Permission::access('view-' . $this->permission);

        $data['config'] = $this->config;
        $data['config']['breadcrumb'] = array_merge($this->breadcrumb, [$this->title => route($this->route . '.index'), 'Detail' => route($this->route . '.show', $id)]);
        $data['data'] = $this->model->find($id);

        $idTanah = $data['data']->id_tanah;

        $idTanah = explode('-', $idTanah);
        $dataTanah = AssetTanah::join('satkers as s', 's.kode', 'kode_satker')
            ->where('kode_satker', $idTanah[0])->where('kode_barang', $idTanah[1])->where('nup', $idTanah[2])
            ->first();

        $satker = Satker::findOrFail($data['data']->id_satker);
        $data['detail'] = [
            'Kode Barang'     => $dataTanah->kode_satker,
            'Nama Barang'     => $dataTanah->name,
            'NUP'             => $dataTanah->nup,
            'Kondisi'         => $dataTanah->kondisi,
            'Nilai Perolehan' => 'Rp ' . numberFormatIndo($dataTanah->nilai_perolehan),
            'Jumlah Anggaran' => 'Rp ' . numberFormatIndo($data['data']->jumlah_anggaran),
            'Status Sertipikat'=> '<span class="m-badge m-badge--' . ($data['data']->status == 1 ? 'info' : 'success') . ' m-badge--wide">' . ($data['data']->status == 1 ? 'Proses' : 'Selesai') . '</span>',
            'Satker' => $satker->name . '('.$satker->kode.')'
        ];
        $data['details'] = $data['data']->detail()->select('sertipikasi_tanah_details.*', 'u.name', 'u.nip')->join('users as u', 'u.id', '=', 'sertipikasi_tanah_details.created_by')->get()->reverse();


        return view($this->layout . '.show', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        Permission::access('create-' . $this->permission);

        $data['config'] = $this->config;
        $data['satkers'] = Satker::get(['kode', 'name']);
        $data['config']['breadcrumb'] = array_merge($this->breadcrumb, [$this->title => route($this->route . '.index'), 'Tambah' => route($this->route . '.create')]);
        $data['kategoriBarang'] = CategoryAsset::findOrFail(3);

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

        $validate = [
            'satker'          => 'required|exists:satkers,kode',
            'jumlah_anggaran' => 'required|numeric',
        ];

        $param = $this->cleanNumber($request->all(), ['jumlah_anggaran']);

        $idBarang = json_decode($request->input('data'))->id;
        if($idBarang == null){
            return response()->json([
                'status'  => 2,
                'message' => '<ul class="m--marginless">Barang tidak boleh Kosong.</ul>'
            ]);
        } else {
            $jmlBarang = count($idBarang);
            if($jmlBarang > 1) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Jumlah Barang melebihi dari maximal.</ul>'
                ]);
            } else {
                $satker = Satker::where('kode', $param['satker'])->firstOrFail();
                $barang = AssetTanah::findOrFail(json_decode($param['data'])->id[0]);

                if($barang->kode_satker != $satker->kode) {
                    return response()->json([
                        'status'  => 2,
                        'message' => '<ul class="m--marginless">Barang tersebut bukan milik satker ini.</ul>'
                    ]);
                }
            }
        }

        $validator = Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $barang, $satker) {
                $param['id_tanah'] = $barang->kode_satker . '-' . $barang->kode_barang . '-' . $barang->nup;
                $param['id_satker'] = $satker->id;
                $param['jumlah_anggaran'] = $param['jumlah_anggaran'];
                $param['created_by'] = \Auth::user()->id;

                $model = $this->model;
                if ($model->create($param)) {
                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil menambahkan data ' . $this->title
                    ];
                } else {
                    $res = [
                        'status'  => 0,
                        'message' => 'Gagal menambahkan data ' . $this->title
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        Permission::access('edit-' . $this->permission);

        $data['config'] = $this->config;
        $data['config']['breadcrumb'] = array_merge($this->breadcrumb, [$this->title => route($this->route . '.index'), 'Tindak Lanjut' => route($this->route . '.edit', $id)]);
        $data['data'] = $this->model->find($id);

        $idTanah = $data['data']->id_tanah;

        $idTanah = explode('-', $idTanah);
        $dataTanah = AssetTanah::join('satkers as s', 's.kode', 'kode_satker')
            ->where('kode_satker', $idTanah[0])->where('kode_barang', $idTanah[1])->where('nup', $idTanah[2])
            ->first();

        $data['detail'] = [
            'Kode Barang'     => $dataTanah->kode_satker,
            'Nama Barang'     => $dataTanah->name,
            'NUP'             => $dataTanah->nup,
            'Kondisi'         => $dataTanah->kondisi,
            'Nilai Perolehan' => 'Rp ' . numberFormatIndo($dataTanah->nilai_perolehan),
            'Jumlah Anggaran' => 'Rp ' . numberFormatIndo($data['data']->jumlah_anggaran),
            'Status Sertipikat'=> '<span class="m-badge m-badge--' . ($data['data']->status == 1 ? 'info' : 'success') . ' m-badge--wide">' . ($data['data']->status == 1 ? 'Proses' : 'Selesai') . '</span>'
        ];

        return view($this->layout . '.edit', $data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        Permission::access('edit-' . $this->permission);

        $validator = Validator::make($request->all(), [
            'letter_number' => 'required|max:20',
            'letter_date' => 'required|date_format:j F Y',
            'perihal' => 'required',
            'dokumen' => 'required|file|mimes:pdf|max:20000',
            'catatan' => 'required'
        ]);
        $param = $request->all();

        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $id) {
                $model = $this->model->find($id);

                $param['created_by'] = \Auth::user()->id;
                $param['letter_date'] = Carbon::parse($param['letter_date'])->toDateString();

                $docLocation = SertipikasiTanahDetail::docLocation($id);
                $fileDokumen = $param['dokumen'];
                $filename = time().'-'.str_slug(explode('.', $fileDokumen->getClientOriginalName())[0]).'.'.$fileDokumen->getClientOriginalExtension();
                $fileDokumen->move($docLocation, $filename);
                $param['dokumen'] = $filename;

                $detail = $model->detail()->create($param);
                if ($detail) {
                    $model->progress = $model->progress + 1;
                    $model->tanggal_tindak_lanjut = Carbon::now()->toDateTimeString();
                    $model->save();

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil melakukan tindak lanjut Data ' . $this->title
                    ];
                } else {
                    $res = [
                        'status'  => 0,
                        'message' => 'Gagal melakukan tindak lanjut data ' . $this->title
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
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function selesai(Request $request, $id)
    {
        Permission::access('create-' . $this->permission);
        $res = \DB::transaction(function () use ($id) {
            $model = $this->model->find($id);

            $model->status = 2;
            $model->save();
            if ($model) {

                $res = [
                    'status'  => 1,
                    'message' => 'Berhasil menyelesaikan Data ' . $this->title
                ];
            } else {
                $res = [
                    'status'  => 0,
                    'message' => 'Gagal menyelesaikan data ' . $this->title
                ];
            }

            return $res;
        });

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
        $result = $data->delete();

        $res['status'] = $result ? 1 : 0;

        return response()->json($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTable(Request $request)
    {
        return $this->_getTable($request, ['usulan' => $this->objName]);
    }

    /**
     * @param $param
     * @param $clean
     * @return array
     */
    private function cleanNumber($param, $clean)
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
