<?php

namespace App\Http\Controllers\Admin\Help;

use App\Http\Controllers\Controller;
use App\Model\Tutorial;
use App\Repositories\Datatable\Datatable;
use App\Repositories\Permission\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TutorialController extends Controller
{

    private $route = 'admin.help.tutorial';
    private $config, $layout;
    private $title = 'Tutorial';
    private $permission = 'help-tutorial';

    public function __construct()
    {
        $this->model = new Tutorial();
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
        $data['tutorials'] = Tutorial::where('id_parent', null)->orderBy('type')
            ->orderBy('order')->get();

        return view($this->layout . '.index', $data);
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id = 0)
    {
        if($id == 0) {
            $id = null;
        }
        $data['config'] = $this->config;
        $data['tutorials'] = Tutorial::where('id_parent', $id)->orderBy('type')->get();

        return view($this->layout . '.show', $data);
    }

    /**
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function data($id = null)
    {
        Permission::access('create-' . $this->permission);

        $data['config'] = $this->config;
        $data['table']['header'] = ['Filename', 'Type', 'Order'];
        $data['id'] = $id;
        $data['config']['pageTitle'] = [route($this->route . '.data') => 'Tutorial'];
        if($id != null) {
            $reg = Tutorial::with('allParent')->where('id', $id)->first();

            $ar = [];
            function recPar($ar, $reg, $route)
            {
                if($reg->allParent != null){
                    $p = $reg->allParent;
                    $ar[route($route . '.data', $p->id)] = $p->filename;
                    $ar = recpar($ar, $p, $route);
                }

                return $ar;
            }

            $data['config']['pageTitle'] = array_merge($data['config']['pageTitle'], array_reverse(recpar($ar, $reg, $this->route)));
            $data['config']['pageTitle'][route($this->route . '.data', $reg->id)] = $reg->filename;
        }

        return view($this->layout . '.data', $data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function table($id = null)
    {
        Permission::access('view-' . $this->permission);

        Permission::can('delete-' . $this->permission) ? $action[] = 'delete' : '';
        Permission::can('edit-' . $this->permission) ? $action[] = 'edit' : '';

        $model = $this->model->select('filename', 'file', 'order', 'type')->whereIdParent($id)->orderBy('type');

        $dataTable = Datatable::create($model)
            ->editColumn('filename', function ($data){
                return $data->type == 'folder' ? $data->filename : '<a href="'.asset('file/tutorials/'.$data->file).'">'.$data->filename.'</a>';
            })
            ->editColumn('action', function ($data){
                return $data->type == 'folder' ? '<a href="'.(route($this->route. '.data', $data->id)).'" class="btn btn-success btn-xs m-btn m-btn--icon m-btn--icon-only tooltips ajaxify" title="Tampilkan '.$this->title.'">
                    <i class="la la-eye"></i>
                </a> ' : '';
            })
            ->defaultAction($action, ['route' => $this->route, 'title' => $this->title]);
        $respond = $dataTable->make(true);

        return response()->json($respond);
    }

    /**
     * @param $type
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($type, $id = null)
    {
        Permission::access('create-' . $this->permission);

        $data['config'] = $this->config;
        $data['type'] = $type;
        $data['id'] = $id;

        return view($this->layout . '.create', $data);
    }

    /**
     * @param Request $request
     * @param $type
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $type, $id = null)
    {
        Permission::access('create-' . $this->permission);

        if($type == 'folder') {
            $valid = [
                'filename' => 'required'
            ];
        } else {
            $valid = [
                'file' => 'required|file'
            ];
        }
        $valid['order'] = 'required';

        $validator = Validator::make($request->all(), $valid);
        if (!$validator->fails()) {
            $param = $request->all();
            $param['type'] = $request->input('type');
            $param['id_parent'] = $id;
            $param['type'] = $type;

            if($type == 'file') {
                $file = $request->file('file');
                $param['filename'] = $file->getClientOriginalName();
                $param['file'] = time().'_'.$file->getClientOriginalName();
                $param['filetype'] = $file->getClientOriginalExtension();
                $file->move(public_path('file/tutorials'), $param['file']);
            } else {
                $param['file'] = null;
                $param['filetype'] = $type;
            }

            $model = $this->model;
            if ($model->create($param)) {
                $res = [
                    'status'  => 1,
                    'message' => 'Berhasil menambahkan Data ' . $this->title
                ];
            } else {
                $res = [
                    'status'  => 0,
                    'message' => 'Gagal menambahkan data ' . $this->title
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
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id = null)
    {
        Permission::access('create-' . $this->permission);

        $record = $this->model->where('id', $id)->first();$data['parentId'] = $record->id_parent;

        $data['config'] = $this->config;
        $data['id'] = $id;
        $data['data'] = $record;

        return view($this->layout . '.edit', $data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        Permission::access('create-' . $this->permission);
        $model = $this->model->find($id);

        if($model->type == 'folder') {
            $valid = [
                'filename' => 'required'
            ];
        } else {
            $valid = [];
        }
        $valid['order'] = 'required';

        $validator = Validator::make($request->all(), $valid);
        if (!$validator->fails()) {
            $param = $request->all();

            if($model->type == 'file') {
                if($request->hasFile('file')) {
                    $file = $request->file('file');
                    $model->filename = $file->getClientOriginalName();
                    $model->file = time().'_'.$file->getClientOriginalName();
                    $model->filetype = $file->getClientOriginalExtension();
                    $file->move(public_path('file/tutorials'), $param['file']);
                }
            } else {
                $model->filename = $param['filename'];
                $model->file = null;
            }

            $model->order = $param['order'];

            $stat = $model->save();
            if ($stat) {
                $res = [
                    'status'  => 1,
                    'message' => 'Berhasil mengubah Data ' . $this->title
                ];
            } else {
                $res = [
                    'status'  => 0,
                    'message' => 'Gagal mengubah data ' . $this->title
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
        $result = $data->delete();

        $res['status'] = $result ? 1 : 0;

        return response()->json($res);
    }
}
