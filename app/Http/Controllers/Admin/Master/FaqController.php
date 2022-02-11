<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Model\Faq;
use App\Repositories\Datatable\Datatable;
use App\Repositories\Permission\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{

    private $route = 'admin.master.faq';
    private $config, $layout;
    private $title = 'FAQ';
    private $permission = 'master-faq';

    public function __construct()
    {
        $this->model = new Faq();
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
        $data['table']['header'] = ['Pertanyaan', 'Order'];

        return view($this->layout . '.index', $data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        Permission::access('view-' . $this->permission);

        Permission::can('edit-' . $this->permission) ? $action[] = 'edit' : '';
        Permission::can('delete-' . $this->permission) ? $action[] = 'delete' : '';

        $model = $this->model->select('question', 'order');

        $dataTable = Datatable::create($model)->defaultAction($action, ['route' => $this->route, 'title' => $this->title]);
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

        return view($this->layout . '.create', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Permission::access('create-' . $this->permission);

        $validator = Validator::make($request->all(), [
            'question'   => 'required',
            'answer'   => 'required',
            'order' => 'required'
        ]);

        if (!$validator->fails()) {
            $param = $request->all();

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
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        Permission::access('edit-' . $this->permission);

        $data['config'] = $this->config;

        $data['data'] = $this->model->find($id);
        return view($this->layout . '.edit', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        Permission::access('edit-' . $this->permission);

        $validator = Validator::make($request->all(), [
            'question'   => 'required',
            'answer'   => 'required',
            'order' => 'required'
        ]);

        if (!$validator->fails()) {
            $param = $request->all();

            $model = $this->model->find($id);
            $model->question = $param['question'];
            $model->answer = $param['answer'];
            $model->order = $param['order'];

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
