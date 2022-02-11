<?php

namespace App\Http\Controllers\Admin\Lapor;

use App\Http\Controllers\Controller;
use App\Model\CategoryAsset;
use App\Model\ImageTmp;
use App\Model\LaporBmn\LaporBmn;
use App\Model\LaporBmn\LaporBmnFoto;
use App\Repositories\Datatable\Datatable;
use App\Repositories\Permission\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LaporController extends Controller
{

    private $route = 'admin.lapor';
    private $config, $layout;
    private $title = 'Lapor BMN';
    private $permission = 'lapor';

    public function __construct()
    {
        $this->model = new LaporBmn();
        $this->layout = $this->route;
        $this->breadcrumb = [$this->title => route($this->route . '.index')];
        $this->config = [
            'route'     => $this->route,
            'title'     => $this->title,
            'pageTitle' => $this->title,
            'permission'=> $this->permission,
            'breadcrumb'=> $this->breadcrumb
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Permission::access('view-' . $this->permission);

        $data['config'] = $this->config;
        $canCreate = Permission::can('create-' . $this->permission);
        if(!$canCreate) {
            $data['table']['header'] = ['Satker', 'Kategori Aset', 'Jenis Lapor', 'Uraian Singkat', 'Tanggal Lapor', 'Status'];
        } else {
            $data['table']['header'] = ['Kategori Aset', 'Jenis Lapor', 'Uraian Singkat', 'Tanggal Lapor', 'Status'];
        }

        $data['canCreate'] = $canCreate;
        $data['categoryAsset'] = CategoryAsset::where('table_name', '!=', null)->get();

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

        $model = $this->model
            ->usulanBy()
            ->join('users as u', 'u.id', '=', $this->model->getTable() . '.created_by')
            ->join('satkers as s', 's.id', '=', 'u.id_satker')
            ->join('category_assets as ca', 'ca.id', '=', 'id_category_asset')
            ->select('s.name as satkerName', 'created_by', 'ca.name as categoryAsset', 'jenis', 'uraian', $this->model->getTable().'.created_at', 'status');

        $balasLapor = Permission::can('balas-'. $this->permission);

        $dataTable = Datatable::create($model)
            ->setId($this->model->getTable().'.id')
            ->editColumn('jenis', function ($data){
                return $data->jenis == '1' ? 'Permasalahan Umum' : 'Force Majeure';
            })
            ->editColumn('created_at', function ($data){
                return Carbon::parse($data->created_at)->format('j F Y, H:i');
            })
            ->editColumn('uraian', function ($data){
                $line = $data->uraian;
                if (preg_match('/^.{1,200}\b/s', $data->uraian, $match))
                {
                    $line= $match[0];
                }
                return $line;
            })
            ->editColumn('status', function ($data){
                return '<span class="m-badge m-badge--' . ($data->status == 1 ? 'info' : 'success') . ' m-badge--wide">' . ($data->status == 1 ? 'Proses' : 'Terjawab') . '</span>';
            })
            ->filterConstraint('created_at', 'date')
            ->editColumn('action', function ($data) use ($balasLapor, $action){
                $html = '<a href="' . route($this->route . '.show', $data->id) . '" class="btn btn-info btn-sm m-btn m-btn--icon m-btn--icon-only tooltips ajaxify" title="Detail ' . $this->title . '">
                    <i class="la la-eye"></i>
                </a> ';

                if($data->status == 1) {
                    if($balasLapor || $data->created_by == \Auth::user()->id){
                        $html .= '<a class="btn btn-warning m-btn btn-sm ajaxify" href="'.route($this->route . '.edit', $data->id).'"> <i class="flaticon-chat"></i> Balas </a> ';
                    }

                    if(in_array('delete', $action)) {
                        $html .= '<a href="' . route($this->route . '.destroy', $data->id) . '" class="btn btn-danger btn-delete btn-sm m-btn m-btn--icon m-btn--icon-only tooltips" title="Delete ' . $this->title . '">
                                <i class="la la-trash"></i>
                            </a>';
                    }
                }

                return $html == '' ? '#' : $html;
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
        $data['config']['breadcrumb'] = array_merge($this->breadcrumb, ['Usulan' => route($this->route . '.create')]);
        $data['categoryAsset'] = CategoryAsset::where('table_name', '!=', null)->get();
        $data['uuid'] = Str::uuid();

        return view($this->layout . '.create', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        Permission::access('create-' . $this->permission);

        $jml = ImageTmp::where("uuid", $request->input("uuid"))->count();
        if($jml > 10) {
            return response()->json([
                'status'  => 2,
                'message' => '<ul class="m--marginless">Jumlah foto melebihi dari maximal benda.</ul>'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'jenis'   => 'required',
            'uraian'   => 'required',
            'category_asset'   => 'required|exists:category_assets,id',
            'file' => 'nullable|mimes:pdf|max:5000',
        ]);

        if (!$validator->fails()) {
            $param = $request->all();

            if(isset($param['id'])) {
                $category = CategoryAsset::find($param['category_asset']);
                $barang = \DB::table($category->table_name)->where('id', $param['id'])->first();
                $idAset = $barang->kode_satker . '-' . $barang->kode_barang . '-' . $barang->nup;
            }

            $param['id_asset'] = isset($param['id']) ? $idAset : null;
            $param['id_category_asset'] = $param['category_asset'];
            $param['status'] = 1;
            $param['created_by'] = \Auth::user()->id;

            $model = $this->model;
            $lapor = $model->create($param);
            if ($lapor) {

                if($request->hasFile('file')) {
                    $docLocation = $this->model->docLocation($lapor->id);
                    if(!file_exists($docLocation)) {
                        mkdir($this->model->docLocation($lapor->id), 0775, true);
                    }

                    $fileDoc = $param['file'];
                    $filename = time().'-'.str_slug(explode('.', $fileDoc->getClientOriginalName())[0]).'.'.$fileDoc->getClientOriginalExtension();
                    $fileDoc->move($docLocation, $filename);
                    $lapor->file = $filename;
                    $lapor->save();
                }

                $images = ImageTmp::where("uuid", $param["uuid"])->get();
                foreach ($images as $image) {
                    if(file_exists(ImageTmp::imageLocation()."/".$image->file)){
                        if(!file_exists(LaporBmnFoto::imageLocation($lapor->id))){
                            mkdir(LaporBmnFoto::imageLocation($lapor->id), 0775, true);
                        }
                        rename(ImageTmp::imageLocation()."/".$image->file, LaporBmnFoto::imageLocation($lapor->id)."/".$image->file);
                    }

                    LaporBmnFoto::create([
                        'id_lapor_bmn' => $lapor->id,
                        'foto' => $image->file,
                    ]);

                    $image->delete();
                }

                $res = [
                    'status'  => 1,
                    'message' => 'Berhasil Melaporkan BMN'
                ];
            } else {
                $res = [
                    'status'  => 0,
                    'message' => 'Gagal Melaporkan BMN'
                ];
            }
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
        $record = $this->model->find($id);
        if($record->created_by != \Auth::user()->id) {
            Permission::access('balas-' . $this->permission);
        }

        $data['config'] = $this->config;
        $data['config']['breadcrumb'] = array_merge($this->breadcrumb, ['Balas' => route($this->route . '.edit', $id)]);
        $data['categoryAsset'] = CategoryAsset::where('table_name', '!=', null)->get()->pluck('name', 'id');

        $data['data'] = $record;
        if($data['data']->id_asset != null){
            $data['detail'] = $this->_detailAsset($data['data']->id_category_asset, $data['data']->id_asset, true);
        }
        return view($this->layout . '.edit', $data);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        Permission::access('view-' . $this->permission);

        $model = $this->model->findOrFail($id);
        if(!\Auth::user()->can('view', $model)) {
            abort(403);
        }

        $data['config'] = $this->config;
        $data['config']['breadcrumb'] = array_merge($this->breadcrumb, ['Detail' => route($this->route . '.show', $id)]);
        $data['categoryAsset'] = CategoryAsset::where('table_name', '!=', null)->get()->pluck('name', 'id');

        $data['data'] = $model;
        if($data['data']->id_asset != null){
            $data['detail'] = $this->_detailAsset($data['data']->id_category_asset, $data['data']->id_asset, true);
        }

        return view($this->layout . '.show', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $lapor = $this->model->find($id);
        if($lapor->created_by != \Auth::user()->id) {
            Permission::access('balas-' . $this->permission);
        }

        $validate = [
            'balas_file' => 'nullable|mimes:pdf|max:5000',
        ];

        if($request->input('submit') == 1) {
            $validator['jawaban'] = 'required';
        }

        $validator = Validator::make($request->all(), $validate);

        if (!$validator->fails()) {
            $param = $request->all();

            $submit = $request->input('submit');

            if($submit == 1) {
                $balas = $lapor->reply()->create([
                    'jawaban' => $param['jawaban'],
                    'created_by' => \Auth::user()->id
                ]);

                if($request->hasFile('balas_file')) {
                    $docLocation = $this->model->balasLocation($lapor->id);
                    if(!file_exists($docLocation)) {
                        mkdir($this->model->balasLocation($lapor->id), 0775, true);
                    }

                    $fileDoc = $param['balas_file'];
                    $filename = time().'-'.str_slug(explode('.', $fileDoc->getClientOriginalName())[0]).'.'.$fileDoc->getClientOriginalExtension();
                    $fileDoc->move($docLocation, $filename);
                    $balas->file = $filename;
                    $balas->save();
                }
            } else {
                $lapor->status = 2;
            }

            if ($lapor->save()) {
                $res = [
                    'status'  => 1,
                    'message' => 'Berhasil '.($submit == 1 ? 'menjawab' : 'menyelesaikan').' Data ' . $this->title
                ];
            } else {
                $res = [
                    'status'  => 0,
                    'message' => 'Gagal '.($submit == 1 ? 'menjawab' : 'menyelesaikan').' data ' . $this->title
                ];
            }
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

        if(!\Auth::user()->can('delete', $data)) {
           abort(403);
        }

        $result = $data->delete();

        $res['status'] = $result ? 1 : 0;

        return response()->json($res);
    }

    public function detailAsset($id, $category)
    {
        $data = $this->_detailAsset($category, $id);

        return response()->json(['status' => true, 'data' => $data, 'param' => ['id' => $id, 'category_asset' => $category]]);
    }

    /**
     * @param $category
     * @param $id
     * @param bool $parse
     * @return array|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    private function _detailAsset($category, $id, $parse = false)
    {
        $categoryAsset = CategoryAsset::findOrFail($category);

        if($parse) {
            $id = explode('-', $id);
            $data = \DB::table($categoryAsset->table_name)
                ->join('satkers as s', 's.kode', $categoryAsset->table_name . '.kode_satker')
                ->where('kode_satker', $id[0])->where('kode_barang', $id[1])->where('nup', $id[2])
                ->first();
        } else {
            $data = \DB::table($categoryAsset->table_name)
                ->join('satkers as s', 's.kode', $categoryAsset->table_name . '.kode_satker')
                ->where($categoryAsset->table_name . '.id', $id)->first();
        }

        $data = [
            'Kode Barang'     => $data->kode_satker,
            'Nama Barang'     => $data->name,
            'NUP'             => $data->nup,
            'Kondisi'         => $data->kondisi,
            'Nilai Perolehan' => 'Rp ' . numberFormatIndo($data->nilai_perolehan),
            'Kategori Aset'   => $categoryAsset->name,
        ];

        return $data;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function imageUpload(Request $request, $id)
    {
        $validate = [
            'file' => 'required|mimes:jpg,jpeg,png|max:3000'
        ];
        $validator = \Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($request, $id) {
                $file = $request->file("file");
                $fileName = time().'-'.$file->getClientOriginalName();
                $location = ImageTmp::imageLocation();
                if(!file_exists($location)){
                    mkdir($location, 0755, true);
                }

                $maxFoto = 10;

                $jml = ImageTmp::where("uuid", $id)->count();
                if($jml >= $maxFoto) {
                    return $res = [
                        'status'  => 0,
                        'message' => 'Jumlah foto melebihi dari maximal.',
                        'statusCode' => 400
                    ];
                }

                $file->move($location, $fileName);

                $status = ImageTmp::create([
                    'uuid' => $id,
                    'file' => $fileName
                ]);

                if ($status) {
                    $res = [
                        'id' => $status->id,
                        'status'  => 1,
                        'message' => 'Berhasil menambahkan Foto.',
                        'fileName' => $fileName,
                        'statusCode' => 200
                    ];
                } else {
                    $res = [
                        'status'  => 0,
                        'message' => 'Gagal menambahkan Foto',
                        'statusCode' => 400
                    ];
                }

                return $res;
            });
        } else {
            $messages = $validator->errors()->all('<li>:message</li>');
            $res = [
                'status'  => 2,
                'message' => '<ul class="m--marginless">' . implode('', $messages) . '</ul>',
                'statusCode' => 400
            ];
        }

        return response($res, $res['statusCode']);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function imageDelete($id)
    {
        $image = ImageTmp::findOrFail($id);
        $oldImage = $image->file;
        $location = ImageTmp::imageLocation() . '/' . $oldImage;
        if(file_exists($location)) {
            unlink($location);
        }

        if($image->delete()) {
            $status = 1;
        } else {
            $status = 0;
        }

        return response(['status' => $status]);
    }
}
