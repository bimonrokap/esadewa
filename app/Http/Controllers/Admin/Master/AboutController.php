<?php
namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Model\Config;
use App\Repositories\Permission\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutController extends Controller
{

    private $route = 'admin.master.about';
    private $config, $layout;
    private $title = 'Tentang Aplikasi';
    private $permission = 'master-about';

    public function __construct()
    {
        $this->model = new Config();
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
        $data['file'] = Config::where('name', 'about_apps')->first()->value;

        return view($this->layout . '.index', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Permission::access('edit-' . $this->permission);

        $validator = Validator::make($request->all(), [
            'file'        => 'required|file|mimes:pdf',
        ]);

        if (!$validator->fails()) {
            $file = $request->file('file');
            $file->move(public_path('file/about'), 'TENTANG_APLIKASI.pdf');

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
