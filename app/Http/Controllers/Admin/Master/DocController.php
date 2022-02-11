<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Model\DocTemplate;
use App\Model\DocTemplateHistory;
use App\Repositories\Datatable\Datatable;
use App\Repositories\Permission\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DocController extends Controller
{

    private $route = 'admin.master.doc';
    private $config, $layout;
    private $title = 'Dokumen Template';
    private $permission = 'master-doc';

    public function __construct()
    {
        $this->model = new DocTemplate();
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
        $data['table']['header'] = ['Nama', 'Slug', 'Versi'];

        return view($this->layout . '.index', $data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        Permission::access('view-' . $this->permission);

        Permission::can('view-' . $this->permission) ? $action[] = 'show' : '';

        $model = $this->model
            ->leftJoin('doc_template_histories as d', 'd.id', '=', 'doc_templates.id_default_doc_template_history')
            ->select('name', 'slug', 'version');

        $dataTable = Datatable::create($model)
            ->setId('doc_templates.id')
            ->defaultAction($action, ['route' => $this->route, 'title' => $this->title]);
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
        $data['data'] = DocTemplate::find($id);

        return view($this->layout . '.show', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        Permission::access('create-' . $this->permission);

        $data['config'] = $this->config;
        $data['data'] = DocTemplate::find($request->input('id'));
        return view($this->layout . '.create', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Permission::access('create-' . $this->permission);

        $validate = [
            'version'  => 'required',
            'file' => 'required|max:3000|mimes:docx',
        ];

        $validator = Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $param = $request->all();
            $param['id_doc_template'] = $request->input('id');
            $param['created_by'] = Auth::user()->id;

            $docTemplate = DocTemplate::find($param['id_doc_template']);

            $fileDoc = $request->file('file');
            $filename = time().'-'.str_slug($docTemplate->name).'-'.str_slug($param['version']).'.'.$fileDoc->getClientOriginalExtension();
            $fileDoc->storeAs('usulan/template', $filename);

            $param['file'] = $filename;

            $model = DocTemplateHistory::create($param);
            if ($model) {
                $res = [
                    'status'  => 1,
                    'message' => 'Berhasil menambahkan Data Dokumen Histori'
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
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        Permission::access('edit-' . $this->permission);

        $data['config'] = $this->config;

        $data['history'] = DocTemplateHistory::find($id);
        $data['data'] = $data['history']->document;
        return view($this->layout . '.edit', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        Permission::access('edit-' . $this->permission);

        $validate = [
            'version'  => 'required',
            'file' => 'required|max:3000|mimes:docx',
        ];

        $validator = Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $param = $request->all();
            $model = DocTemplateHistory::find($id);
            $docTemplate = $model->document;

            $model->version = $param['version'];
            if($model->file != null && \Storage::has('usulan/template/'.$model->file)) {
                \Storage::delete('usulan/template/'.$model->file);
            }

            $fileDoc = $request->file('file');
            $filename = time().'-'.str_slug($docTemplate->name).'-'.str_slug($param['version']).'.'.$fileDoc->getClientOriginalExtension();
            $fileDoc->storeAs('usulan/template', $filename);

            $model->file = $filename;

            if ($model->save()) {
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
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function default(Request $request, $id)
    {
        $value = $request->input('value');

        $doc = $this->model->find($id);
        $doc->id_default_doc_template_history = $value;

        return response()->json(['status' => $doc->save()]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function generate($id)
    {
        $history = DocTemplateHistory::find($id);

        return \Storage::download('usulan/template/'.$history->file);
    }
}
