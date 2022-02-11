<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Model\MasterUsulan;
use App\Repositories\Permission\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsulanController extends Controller
{

    private $route = 'admin.master.usulan';
    private $config, $layout;
    private $title = 'Manual Usulan';
    private $permission = 'master-usulan';

    public function __construct()
    {
        $this->model = new MasterUsulan();
        $this->layout = $this->route;
        $this->config = [
            'route'      => $this->route,
            'title'      => $this->title,
            'pageTitle'  => $this->title,
            'permission' => $this->permission
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Permission::access('view-' . $this->permission);

        $data['config'] = $this->config;
        $data['start'] = 2015;

        $data['manual'] = $this->model->where('year', date('Y'))->get()->keyBy('type');

        return view($this->layout . '.index', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function data(Request $request)
    {
        Permission::access('view-' . $this->permission);
        $year = $request->input('year');

        $data = $this->model->where('year', $year)->get();
        if ($data->isEmpty()) {
            $data = [
                'psp'         => ['value' => 0],
                'penghapusan' => ['value' => 0]
            ];
        } else {
            $data = $data->keyBy('type');
        }

        return response()->json(['data' => $data]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Permission::access('create-' . $this->permission);

        $validator = Validator::make($request->all(), [
            'year'        => 'required',
            'psp'         => 'required',
            'penghapusan' => 'required'
        ]);

        if (!$validator->fails()) {
            MasterUsulan::create([
                'year' => $request->input('year'),
                'type' => 'psp',
                'type' => 'psp',
                'value' => $request->input('psp')
            ]);

            MasterUsulan::create([
                'year' => $request->input('year'),
                'type' => 'penghapusan',
                'value' => $request->input('penghapusan')
            ]);

            if (true) {
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
}
