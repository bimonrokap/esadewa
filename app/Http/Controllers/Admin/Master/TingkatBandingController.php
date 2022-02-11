<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Model\Satker;
use App\Model\TingkatBanding;
use App\Model\Wilayah;
use App\Repositories\Datatable\Datatable;
use App\Repositories\Permission\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TingkatBandingController extends Controller
{

    private $route = 'admin.master.satker.tingkatbanding';
    private $config, $layout;
    private $title = 'Tingkat Banding';
    private $permission = 'master-satker';

    public function __construct()
    {
        $this->model = new TingkatBanding();
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
        Permission::access('tingkatbanding-' . $this->permission);

        $data['config'] = $this->config;
        $data['table']['header'] = ['Lingkungan', 'Wilayah', 'Jumlah Satker'];

        $data['listLingkungan'] = ["PN" => "Peradilan Umum", "PA" => "Peradilan Agama", "PM" => "Peradilan Militer", "PT" => "Peradilan Tata Usaha", "PMT" => "Peradilan Militer & Tata Usaha"];
        $data['wilayahs'] = Wilayah::get();

        return view($this->layout . '.index', $data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        Permission::access('tingkatbanding-' . $this->permission);

        $action = ['edit', 'delete'];

        $model = $this->model
            ->leftJoin('wilayahs as w', 'w.id', '=', 'tingkat_bandings.id_wilayah')
            ->groupBy('w.id', 'lingkungan')
            ->select('w.name as wilayahName', 'lingkungan', \DB::raw('count(id_satker) as jml'));

        $listLingkungan = ["PN" => "Peradilan Umum", "PA" => "Peradilan Agama", "PM" => "Peradilan Militer", "PT" => "Peradilan Tata Usaha", "PMT" => "Peradilan Militer & Tata Usaha"];
        $dataTable = Datatable::create($model)
            ->setId('tingkat_bandings.id')
            ->editColumn('lingkungan', function ($data) use ($listLingkungan){
                $value = '<i class="empty-text">empty</i>';
                if(isset($listLingkungan[$data->lingkungan])) {
                    $value = $listLingkungan[$data->lingkungan];
                }

                return $value;
            })
            ->defaultAction($action, ['route' => $this->route, 'title' => $this->title]);
        $respond = $dataTable->make(true);

        return response()->json($respond);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        Permission::access('tingkatbanding-' . $this->permission);
        $data['config'] = $this->config;
        $data['satkers'] = Satker::get();
        $data['wilayah'] = Wilayah::get();

        return view($this->layout . '.create', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Permission::access('tingkatbanding-' . $this->permission);

        $validate = [
            'id_wilayah'    => 'required',
            'lingkungan'    => 'required|in:PN,PA,PM,PT,PMT',
            'id_satker'     => 'required|array',
            'id_satker.*'   => 'required|exists:satkers,id'
        ];

        $validator = Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $param = $request->all();

            if($this->model->where('lingkungan', $param['lingkungan'])->where('id_wilayah', $param['id_wilayah'])->count() > 0)  {
                $res = [
                    'status'  => 0,
                    'message' => 'Gagal menambahkan data ' . $this->title.', data Tingkat banding sudah tersedia'
                ];
            } else {
                foreach ($param['id_satker'] as $row) {
                    $this->model->create([
                        'id_wilayah' => $param['id_wilayah'],
                        'lingkungan' => $param['lingkungan'],
                        'id_satker' => $row,
                    ]);
                }

                $res = [
                    'status'  => 1,
                    'message' => 'Berhasil menambahkan Data ' . $this->title
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        Permission::access('tingkatbanding-' . $this->permission);
        $data['config'] = $this->config;
        $data['satkers'] = Satker::get();
        $data['wilayah'] = Wilayah::get();
        $data['data'] = $this->model->findOrFail($id);
        $data['dataSatker'] = $this->model->where('lingkungan', $data['data']->lingkungan)->where('id_wilayah', $data['data']->id_wilayah)->get()->pluck('id_satker')->all();

        return view($this->layout . '.edit', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        Permission::access('tingkatbanding-' . $this->permission);

        $validate = [
            'id_wilayah'    => 'required',
            'lingkungan'    => 'required|in:PN,PA,PM,PT,PMT',
            'id_satker'     => 'required|array',
            'id_satker.*'   => 'required|exists:satkers,id'
        ];

        $validator = Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $param = $request->all();
            $data = $this->model->findOrFail($id);

            $this->model->where('lingkungan', $data->lingkungan)->where('id_wilayah', $data->id_wilayah)->delete();

            foreach ($param['id_satker'] as $row) {
                $this->model->create([
                    'id_wilayah' => $param['id_wilayah'],
                    'lingkungan' => $param['lingkungan'],
                    'id_satker' => $row,
                ]);
            }

            $res = [
                'status'  => 1,
                'message' => 'Berhasil mengubah Data ' . $this->title
            ];
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
        Permission::access('tingkatbanding-' . $this->permission);

        $data = $this->model->findOrFail($id);

        $result = $this->model->where('lingkungan', $data->lingkungan)->where('id_wilayah', $data->id_wilayah)->delete();

        $res['status'] = $result ? 1 : 0;

        return response()->json($res);
    }
}
