<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Model\Menu;
use App\Model\PermissionGroup;
use App\Model\Role;
use App\Model\Permission as PermissionModel;
use App\Repositories\Datatable\Datatable;
use App\Repositories\Permission\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{

    private $route = 'admin.master.role';
    private $config, $layout;
    private $title = 'Role';
    private $permission = 'master-role';

    public function __construct()
    {
        $this->model = new Role();
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
        $data['table']['header'] = ['Nama', 'Role Induk', 'Level', 'Type'];

        return view($this->layout . '.index', $data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        Permission::access('view-' . $this->permission);

        $user = Auth::user();
        $topRole = $user->maxRoleLevel();

        Permission::can('edit-' . $this->permission) ? $action[] = 'edit' : '';
        Permission::can('delete-' . $this->permission) ? $action[] = 'delete' : '';

        $model = $this->model
//            ->where('roles.level', '>', $topRole->level)
            ->leftJoin('roles as p', 'p.id', '=', 'roles.id_parent')
            ->select('roles.name', 'p.name as p_name', 'roles.level', 'roles.type');

        $dataTable = Datatable::create($model)
            ->setId('roles.id')
            ->editColumn('p_name', function ($data) {
                return $data->p_name == null ? '<i>Kosong</i>' : $data->p_name;
            })
            ->editColumn('action', function ($data) {
                if(Permission::can('permission-role')) {
                    return '<a href="' . route($this->route . '.access', $data->id) . '" class="btn btn-warning btn-xs m-btn m-btn--icon m-btn--icon-only tooltips ajaxify" title="' . $this->title . ' Akses">
                        <i class="la la-lock"></i>
                    </a> ';
                }
            })
            ->defaultAction($action, ['route' => $this->route, 'title' => $this->title]);
        $respond = $dataTable->make(true);

        return response()->json($respond);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function access($id)
    {
        Permission::access('permission-role');

        $role = $this->model->find($id);

        if($role->parent->level == 0) {
            $myPermission = PermissionModel::whereActive(1)->get()->pluck('id')->toArray();
        } else {
            $myPermission = $this->model->where('id', $role->id_parent)->with(['permission' => function ($query) {
                $query->select('permissions.id');
            }])->get()->map(function ($value) {
                return $value->permission->pluck('id');
            })->flatten()->unique()->toArray();
        }

        $selfRole = $role->permission->pluck('id');
        $data['selfRole'] = $selfRole;
        $permissionGroup = PermissionGroup::all();
        $generalPermission = $permissionGroup->where('id_permission_type', 1);

        $special = Menu::whereActive(1)->whereHas('permission', function ($query) {
            $query->where('permission_group_id', 7);
        })->with(['permission' => function ($query) {
            $query->where('permission_group_id', 7);
        }])->get();
        $data['specialMenu'] = $special;

        $menus = Menu::whereActive(1)->with(['allChildren.permission', 'permission'])->where('weight', 0)
            ->orderBy('order')->get(['id', 'title', 'route']);

        $data['config'] = $this->config;

        $data['data'] = $this->model->find($id);
        $data['htmlGeneralPermission'] = $this->generatePermission($generalPermission, $menus, $myPermission, $selfRole);
        return view($this->layout . '.access', $data);
    }

    private function generatePermission($permission, $menus, $myPermission, $selfRole)
    {
        $html = '';
        $html .='<table class="table table-advance table-rule table-hover table-bordered table-role m-table m-table--head-bg-brand">
            <thead>
                <tr>
                    <th width="30px" class="text-center">No</th>
                    <th class="text-center">Menu</th>';

            foreach ($permission as $row){
                $html .= '<th width="100px" class="text-center">
                    '.$row->name.'
                    <i style="cursor: help;" class="fa fa-info-circle tooltips" data-container="body" data-placement="top" data-original-title="'.$row->desc.'"></i>
                </th>';
            }

                $html .= '</tr>
            </thead>
            <tbody>';

        foreach ($menus as $key => $menu) {
            $html .= '<tr class="parent">
                <td class="text-center">'.($key + 1).'</td>
                <td><strong>'.$menu['title'].'</strong></td>';
                if($menu['route'] != '') {
                    foreach ($permission as $row) {
                        $html .= '<td '.(!$menu['permission']->contains('permission_group_id', $row->id) ? 'class=disabled' : 'class="text-center"').'>';
                        if($menu['permission']->contains('permission_group_id', $row->id)){
                            $permissionId = $menu['permission']->where('permission_group_id', $row->id)->first()['id'];

                            if(in_array($permissionId, $myPermission)) {
                                $html .= '<label class="checkbox-inline">
                                    <input type="checkbox" ' . ($selfRole->contains($menu['permission']->where('permission_group_id', $row->id)->first()['id']) ? 'checked' : '') . ' name="permission[]" value="' . $menu['permission']->where('permission_group_id', $row->id)->first()['id'] . '">
                                </label>';
                            } else {
                                $html .= '-';
                            }
                        }
                        $html .= '</td>';
                    }
                    $html .= '';
                } else {
                    foreach($permission as $row) {
                        $html .= '<td class="disabled"></td>';
                    }
                }
            $html .= '</tr>';
            if(!$menu["children"]->isEmpty()){
                $html .= '<tr class="child" style="display: none;">
                    <td></td>
                    <td colspan="'.(1 + $permission->count()).'">';
                $html .= $this->generatePermission($permission, $menu->children, $myPermission, $selfRole);
                $html .= '</td></tr>';
            }
        }

        $html .= '</table>';

        return $html;
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeAccess(Request $request, $id)
    {
        Permission::access('permission-role');

        $role = Role::find($id);
        $user = Auth::user();

        if($user->isSuperAdmin()) {
            $data['myPermission'] = PermissionModel::get()->pluck('id');
        } else {
            $data['myPermission'] = $user->role()->with(['permission' => function($query){
                $query->select('permissions.id');
            }])->get()->map(function($value){
                return $value->permission->pluck('id');
            })->flatten();
        }

        $permission = $data['myPermission']->intersect($request->input('permission'))->toArray();
        $stat = $this->model->find($role->id)->permission()->sync($permission);
        if($stat) {
            $res = [
                'status' => 1,
                'message' => 'Berhasil update access role'
            ];
        } else {
            $res = [
                'status' => 0,
                'message' => 'Gagal update access role'
            ];

        }

        return response()->json($res);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        Permission::access('create-' . $this->permission);

        $data['config'] = $this->config;

        $user = Auth::user();
        $topRole = $user->maxRoleLevel();

        $data['roles'] = $this->model->where('level', '>=', $topRole->level)->get();
        $data['yourRole'] = $topRole;

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
            'name'   => 'required',
            'id_parent' => 'required|exists:roles,id',
            'level' => 'required'
        ]);

        if (!$validator->fails()) {
            $param = $request->all();
            $param['type'] = 'fungsional';
            $param['slug'] = $param['name'];

            $parent = $this->model->find($param['id_parent']);
            $topRole = Auth::user()->maxRoleLevel();
            if($param['level'] <= $topRole->level){
                $res = [
                    'status'  => 0,
                    'message' => 'Level lebih tinggi dari yang ditentukan ' . $this->title
                ];

                return response()->json($res);
            } else if ($parent->level < $topRole->level) {
                $res = [
                    'status'  => 0,
                    'message' => 'Level Parent lebih tinggi dari yang ditentukan ' . $this->title
                ];

                return response()->json($res);
            }

            $model = $this->model;
            if ($model->create($param)) {
                $res = [
                    'status'  => 1,
                    'message' => 'Berhasil menambahkan Data ' . $this->title . ' dengan Nama <strong>' . $param['name'] . '</strong>'
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

        $user = Auth::user();
        $topRole = $user->maxRoleLevel();

        $data['roles'] = $this->model->where('level', '>=', $topRole->level)->get();
        $data['yourRole'] = $topRole;

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
            'name'   => 'required',
            'id_parent' => 'required|exists:roles,id',
            'level' => 'required'
        ]);

        if (!$validator->fails()) {
            $param = $request->all();

            $parent = $this->model->find($param['id_parent']);
            $topRole = Auth::user()->maxRoleLevel();
            if($param['level'] <= $topRole->level){
                $res = [
                    'status'  => 0,
                    'message' => 'Level lebih tinggi dari yang ditentukan ' . $this->title
                ];

                return response()->json($res);
            } else if ($parent->level < $topRole->level) {
                $res = [
                    'status'  => 0,
                    'message' => 'Level Parent lebih tinggi dari yang ditentukan ' . $this->title
                ];

                return response()->json($res);
            }

            $model = $this->model->find($id);
            $model->name = $param['name'];
            $model->id_parent = $param['id_parent'];
            $model->slug = $param['name'];
            $model->level = $param['level'];
            $model->description = $param['description'];

            if ($model->save()) {
                $res = [
                    'status'  => 1,
                    'message' => 'Berhasil mengubah Data ' . $this->title . ' dengan Nama <strong>' . $param['name'] . '</strong>'
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
        if(Auth::user()->type != 'satker') {
            $result = $data->delete();
        } else {
            $result = $data->delete();
        }

        $res['status'] = $result ? 1 : 0;

        return response()->json($res);
    }
}
