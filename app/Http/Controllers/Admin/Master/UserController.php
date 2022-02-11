<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Model\ProfileSatker;
use App\Model\Role;
use App\Model\Satker;
use App\Model\SatkerImage;
use App\Model\Wilayah;
use App\Repositories\Datatable\Datatable;
use App\Repositories\Permission\Permission;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    private $route = 'admin.master.user';
    private $config;
    private $layout;
    private $title = 'Pengguna';
    private $permission = 'master-user';
    private $limitUser = 3;

    public function __construct()
    {
        $this->model = new User();
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
        $data['table']['header'] = ['Nama', 'Username', 'Role', 'Satker', 'Lingkungan', 'Wilayah'];
        $data['listLingkungan'] = ["PN" => "Peradilan Umum", "PA" => "Peradilan Agama", "PM" => "Peradilan Militer", "PT" => "Peradilan Tata Usaha", "PMT" => "Peradilan Militer & Tata Usaha"];
        $data['roles'] = Role::whereNotin('id', [Role::SUPERADMIN])->get();
        $data['wilayahs'] = Wilayah::get();

        $data['satkers'] = Satker::get();
        $user = Auth::user();
        if(Permission::can('create-limited-user') && !$user->isSuperAdmin()) {
            $childRoleId = $this->getChildRole($user);
            $modelUser = User::where('id_role', $childRoleId);
            if($childRoleId == Role::SATKER){
                $modelUser->where('id_satker', $user->id_satker);
            } else if ($childRoleId == Role::TINGKAT_BANDING) {
                $modelUser->where('id_wilayah', $user->id_wilayah)->where('lingkungan', $user->lingkungan);
            } else if ($childRoleId == Role::KORWIL) {
                $modelUser->where('id_wilayah', $user->id_wilayah);
            } else if ($childRoleId == Role::ESELON) {
                $modelUser->where('lingkungan', $user->lingkungan);
            }
            $data['jmlUser'] = $modelUser->count();
        } else {
            $data['jmlUser'] = 0;
        }

        $data['limitUser'] = $this->limitUser;
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

        $user = Auth::user();
        $model = $this->model
            ->where('users.id', '!=', $user->id)
            ->leftJoin('satkers as s', 's.id', '=', 'users.id_satker')
            ->leftJoin('roles as r', 'r.id', '=', 'users.id_role')
            ->leftJoin('wilayahs as w', 'w.id', '=', 'users.id_wilayah')
            ->select('users.name', 'users.image', 'users.username', 'r.name as roleName', 'w.name as wilayahName', 'users.type', 's.name as satker', 'lingkungan');

        if($user->isSuperAdmin()) {

        } else if($user->isAdminPusat()) {
            $model->whereNotIn('id_role', [Role::SUPERADMIN, Role::ADMIN_PUSAT]);
        } else {
            $childRoleId = $this->getChildRole($user);
            $model->where('id_role', $childRoleId);
            if($user->isAdminSatker()){
                $model->where('users.id_satker', $user->id_satker);
            } else if ($user->isAdminTingkatBanding()) {
                $model->where('users.id_wilayah', $user->id_wilayah)->where('users.lingkungan', $user->lingkungan);
            } else if ($user->isAdminKorwil()) {
                $model->where('users.id_wilayah', $user->id_wilayah);
            } else if ($user->isAdminEselon()) {
                $model->where('users.lingkungan', $user->lingkungan);
            }
        }

        $listLingkungan = ["PN" => "Peradilan Umum", "PA" => "Peradilan Agama", "PM" => "Peradilan Militer", "PT" => "Peradilan Tata Usaha", "PMT" => "Peradilan Militer & Tata Usaha"];
        $dataTable = Datatable::create($model)
            ->setId('users.id')
            ->editColumn('image', function ($data) {
                return '<img width="40" class="m--img-rounded" src="'.asset($data->image == '' ? 'assets/app/media/img/users/dummy_user.png' : 'user_image/' . $data->image).'" />';
            })
            ->editColumn('satker', function ($data) {
                return $data->satker == null ? '<i>-</i>' : $data->satker;
            })
            ->editColumn('lingkungan', function ($data) use ($listLingkungan){
                $value = '<i class="empty-text">empty</i>';
                if(isset($listLingkungan[$data->lingkungan])) {
                    $value = $listLingkungan[$data->lingkungan];
                }

                return $value;
            })
            ->filterColumn('satker', function ($query, $search){
                return $query->where('s.id', $search);
            })
            ->filterColumn('lingkungan', function ($query, $search){
                return $query->where('lingkungan', $search);
            })
            ->filterColumn('roleName', function ($query, $search){
                return $query->where('r.id', $search);
            })
            ->filterColumn('wilayahName', function ($query, $search){
                return $query->where('w.id', $search);
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
        Permission::access('create-' . $this->permission);
        $user = Auth::user();

        if(Permission::can('create-limited-user') && !$user->isSuperAdmin()) {
            $childRoleId = $this->getChildRole($user);
            $modelUser = User::where('id_role', $childRoleId);
            if($childRoleId == Role::SATKER){
                $modelUser->where('id_satker', $user->id_satker);
            } else if ($childRoleId == Role::TINGKAT_BANDING) {
                $modelUser->where('id_wilayah', $user->id_wilayah)->where('lingkungan', $user->lingkungan);
            } else if ($childRoleId == Role::KORWIL) {
                $modelUser->where('id_wilayah', $user->id_wilayah);
            } else if ($childRoleId == Role::ESELON) {
                $modelUser->where('lingkungan', $user->lingkungan);
            }
            $check = $modelUser->count();
            if($check >= $this->limitUser){
                abort(403, 'Sudah memiliki lebih dari 3 User');
            }
        }

        $data['config'] = $this->config;
        $data['wilayah'] = Wilayah::get();
        $data['listLingkungan'] = ["PN" => "Peradilan Umum", "PA" => "Peradilan Agama", "PM" => "Peradilan Militer", "PT" => "Peradilan Tata Usaha", "PMT" => "Peradilan Militer & Tata Usaha"];
        $data['satkers'] = Satker::get();

        if($user->isAdminPusat()) {
            $data['roles'] = Role::whereNotin('id', [Role::SUPERADMIN, Role::ADMIN_PUSAT])->get();
        } else if($user->isAdminSatker()){
            $data['roles'] = Role::where('id', Role::SATKER)->get();
            $data['satkers'] = Satker::where('id', $user->id_satker)->get();
        } else if ($user->isAdminTingkatBanding()) {
            $data['roles'] = Role::where('id', Role::TINGKAT_BANDING)->get();
            $data['wilayah'] = Wilayah::where('id', $user->id_wilayah)->get();
            $data['listLingkungan'] = [$user->lingkungan => $data['listLingkungan'][$user->lingkungan]];
        } else if ($user->isAdminKorwil()) {
            $data['roles'] = Role::where('id', Role::KORWIL)->get();
            $data['wilayah'] = Wilayah::where('id', $user->id_wilayah)->get();
        } else if ($user->isAdminEselon()) {
            $data['roles'] = Role::where('id', Role::ESELON)->get();
            $data['listLingkungan'] = [$user->lingkungan => $data['listLingkungan'][$user->lingkungan]];
        } else {
            $data['roles'] = Role::get();
        }

        return view($this->layout . '.create', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Permission::access('create-' . $this->permission);
        $user = Auth::user();

        $idRole = $request->input('id_role');
        if(in_array($idRole, [Role::SATKER, Role::TINGKAT_BANDING, Role::KORWIL, Role::ESELON])) {
            $modelUser = User::where('id_role', $idRole);
            if($idRole == Role::SATKER){
                $modelUser->where('id_satker', $user->id_satker);
            } else if ($idRole == Role::TINGKAT_BANDING) {
                $modelUser->where('id_wilayah', $user->id_wilayah)->where('lingkungan', $user->lingkungan);
            } else if ($idRole == Role::KORWIL) {
                $modelUser->where('id_wilayah', $user->id_wilayah);
            } else if ($idRole == Role::ESELON) {
                $modelUser->where('lingkungan', $user->lingkungan);
            }

            $check = $modelUser->count();
            if($check >= $this->limitUser){
                $res = [
                    'status'  => 0,
                    'message' => 'Sudah memiliki lebih dari 3 User '
                ];
                return response()->json($res);
            }
        }

        $validate = [
            'name'     => 'required|max:255',
            'username' => 'required|email|unique:users,username',
            'password' => 'required|same:password_match'
        ];

        if ($request->hasFile('foto')) {
            $validate['foto'] = 'image';
        }

        $roleId = $user->id_role;
        if($roleId == Role::ADMIN_PUSAT) {
            $roleArray = Role::whereNotin('id', [Role::SUPERADMIN, Role::ADMIN_PUSAT])->get()->pluck('id')->all();
            $validate['id_role'] = 'required|in:'.implode(',', $roleArray);
        } else if($roleId == Role::ADMIN_SATKER){
            $validate['id_role'] = 'required|in:'.Role::SATKER;
        } else if ($roleId == Role::ADMIN_TINGKAT_BANDING) {
            $validate['id_role'] = 'required|in:'.Role::TINGKAT_BANDING;
        } else if ($roleId == Role::ADMIN_KORWIL) {
            $validate['id_role'] = 'required|in:'.Role::KORWIL;
        } else if ($roleId == Role::ADMIN_ESELON) {
            $validate['id_role'] = 'required|in:'.Role::ESELON;
        } else {
            $validate['id_role'] = 'required|exists:roles,id';
        }

        $idRole = $request->input('id_role');
        if(in_array($idRole, [Role::ADMIN_SATKER, Role::SATKER])) {
            $validate['id_satker'] = 'required';
            if($user->isAdminSatker()){
                $validate['id_satker'] .= '|in:'.$user->id_satker;
            }
        } else if(in_array($idRole, [Role::ADMIN_TINGKAT_BANDING, Role::TINGKAT_BANDING])) {
            $validate['id_wilayah'] = 'required';
            $validate['lingkungan'] = 'required';
            if($user->isAdminTingkatBanding()){
                $validate['id_wilayah'] .= '|in:'.$user->id_wilayah;
                $validate['lingkungan'] .= '|in:'.$user->lingkungan;
            }
        } else if(in_array($idRole, [Role::KORWIL, Role::ADMIN_KORWIL])) {
            $validate['id_wilayah'] = 'required';
            if($user->isAdminKorwil()){
                $validate['id_wilayah'] .= '|in:'.$user->id_wilayah;
            }
        } else if(in_array($idRole, [Role::ESELON, Role::ADMIN_ESELON])) {
            $validate['lingkungan'] = 'required';
            if($user->isAdminEselon()){
                $validate['lingkungan'] .= '|in:'.$user->lingkungan;
            }
        }

        $validator = Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $param = $request->all();
            $param['type'] = 'satker';

            if(in_array($idRole, [Role::ADMIN_SATKER, Role::SATKER])) {
                $param['id_wilayah'] = null;
                $param['lingkungan'] = null;
            } else if(in_array($idRole, [Role::ADMIN_TINGKAT_BANDING, Role::TINGKAT_BANDING])) {
                $param['id_satker'] = null;
            } else if(in_array($idRole, [Role::KORWIL, Role::ADMIN_KORWIL])) {
                $param['id_satker'] = null;
                $param['lingkungan'] = null;
            } else if(in_array($idRole, [Role::ESELON, Role::ADMIN_ESELON])) {
                $param['id_satker'] = null;
                $param['id_wilayah'] = null;
            }

            $param['type'] = in_array($idRole, [Role::ADMIN_PUSAT, Role::ADMIN]) ? 'pusat' : 'satker';

            $model = $this->model;
            $user = $model->create($param);
            if ($user) {
                if ($request->hasFile('foto')) {
                    $filename = time() . '_' . str_slug($param['name']) . '.' . $request->file('foto')->getClientOriginalExtension();
                    $path = public_path() . '/user_image/' . $filename;

                    $image = $request->file('foto')->getRealPath();
                    Image::make($image)->fit(300)->save($path);

                    $user->image = $filename;
                    $user->save();
                }

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
        $data['wilayah'] = Wilayah::get();
        $data['listLingkungan'] = ["PN" => "Peradilan Umum", "PA" => "Peradilan Agama", "PM" => "Peradilan Militer", "PT" => "Peradilan Tata Usaha", "PMT" => "Peradilan Militer & Tata Usaha"];
        $data['satkers'] = Satker::get();

        $user = Auth::user();
        if($user->isAdminPusat()) {
            $data['roles'] = Role::whereNotin('id', [Role::SUPERADMIN, Role::ADMIN_PUSAT])->get();
        } else if($user->isAdminSatker()){
            $data['roles'] = Role::where('id', Role::SATKER)->get();
            $data['satkers'] = Satker::where('id', $user->id_satker)->get();
        } else if ($user->isAdminTingkatBanding()) {
            $data['roles'] = Role::where('id', Role::TINGKAT_BANDING)->get();
            $data['wilayah'] = Wilayah::where('id', $user->id_wilayah)->get();
            $data['listLingkungan'] = [$user->lingkungan => $data['listLingkungan'][$user->lingkungan]];
        } else if ($user->isAdminKorwil()) {
            $data['roles'] = Role::where('id', Role::KORWIL)->get();
            $data['wilayah'] = Wilayah::where('id', $user->id_wilayah)->get();
        } else if ($user->isAdminEselon()) {
            $data['roles'] = Role::where('id', Role::ESELON)->get();
            $data['listLingkungan'] = [$user->lingkungan => $data['listLingkungan'][$user->lingkungan]];
        } else {
            $data['roles'] = Role::get();
        }

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
        $model = $this->model->find($id);

        $user = Auth::user();
        $idRole = $request->input('id_role');

        $validate = [
            'name'     => 'required|max:255',
            'username' => 'required|email|unique:users,username,' . $id,
            'password' => 'same:password_match'
        ];

        if ($request->hasFile('foto')) {
            $validate['foto'] = 'image';
        }

        $roleId = $user->id_role;
        if($roleId == Role::ADMIN_PUSAT) {
            $roleArray = Role::whereNotin('id', [Role::SUPERADMIN, Role::ADMIN_PUSAT])->get()->pluck('id')->all();
            $validate['id_role'] = 'required|in:'.implode(',', $roleArray);
        } else if($roleId == Role::ADMIN_SATKER){
            $validate['id_role'] = 'required|in:'.Role::SATKER;
        } else if ($roleId == Role::ADMIN_TINGKAT_BANDING) {
            $validate['id_role'] = 'required|in:'.Role::TINGKAT_BANDING;
        } else if ($roleId == Role::ADMIN_KORWIL) {
            $validate['id_role'] = 'required|in:'.Role::KORWIL;
        } else if ($roleId == Role::ADMIN_ESELON) {
            $validate['id_role'] = 'required|in:'.Role::ESELON;
        } else {
            $validate['id_role'] = 'required|exists:roles,id';
        }

        $idRole = $request->input('id_role');
        if(in_array($idRole, [Role::ADMIN_SATKER, Role::SATKER])) {
            $validate['id_satker'] = 'required';
            if($user->isAdminSatker()){
                $validate['id_satker'] .= '|in:'.$user->id_satker;
            }
        } else if(in_array($idRole, [Role::ADMIN_TINGKAT_BANDING, Role::TINGKAT_BANDING])) {
            $validate['id_wilayah'] = 'required';
            $validate['lingkungan'] = 'required';
            if($user->isAdminTingkatBanding()){
                $validate['id_wilayah'] .= '|in:'.$user->id_wilayah;
                $validate['lingkungan'] .= '|in:'.$user->lingkungan;
            }
        } else if(in_array($idRole, [Role::KORWIL, Role::ADMIN_KORWIL])) {
            $validate['id_wilayah'] = 'required';
            if($user->isAdminKorwil()){
                $validate['id_wilayah'] .= '|in:'.$user->id_wilayah;
            }
        } else if(in_array($idRole, [Role::ESELON, Role::ADMIN_ESELON])) {
            $validate['lingkungan'] = 'required';
            if($user->isAdminEselon()){
                $validate['lingkungan'] .= '|in:'.$user->lingkungan;
            }
        }

        $validator = Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $param = $request->all();

            $model->name = $param['name'];
            $model->username = $param['username'];

            $model->id_role = $param['id_role'];
            if(in_array($idRole, [Role::ADMIN_SATKER, Role::SATKER])) {
                $model->id_satker = $param['id_satker'];
                $model->id_wilayah = null;
                $model->lingkungan = null;
            } else if(in_array($idRole, [Role::ADMIN_TINGKAT_BANDING, Role::TINGKAT_BANDING])) {
                $model->id_satker = null;
                $model->id_wilayah = $param['id_wilayah'];
                $model->lingkungan = $param['lingkungan'];
            } else if(in_array($idRole, [Role::KORWIL, Role::ADMIN_KORWIL])) {
                $model->id_satker = null;
                $model->id_wilayah = $param['id_wilayah'];
                $model->lingkungan = null;
            } else if(in_array($idRole, [Role::ESELON, Role::ADMIN_ESELON])) {
                $model->lingkungan = $param['lingkungan'];
                $model->id_satker = null;
                $model->id_wilayah = null;
            }

            $model->type = in_array($model->id_role, [Role::ADMIN_PUSAT, Role::ADMIN]) ? 'pusat' : 'satker';
            if ($request->has('password') && $request->input('password') != '') {
                $model->password = $param['password'];
            }

            if ($model->save()) {
                $oldFoto = $model->image;
                if ($request->hasFile('foto')) {
                    $filename = time() . '_' . str_slug($param['name']) . '.' . $request->file('foto')->getClientOriginalExtension();
                    $path = public_path() . '/user_image/' . $filename;

                    $image = $request->file('foto')->getRealPath();
                    Image::make($image)->fit(300)->save($path);

                    $model->image = $filename;
                    $model->save();

                    if ($oldFoto != '' && file_exists(public_path('user_image/' . $oldFoto))) {
                        unlink(public_path('user_image/' . $oldFoto));
                    }
                }

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

        $user = Auth::user();

        $result = 0;
        if(Permission::can('create-limited-user') && !$user->isSuperAdmin()) {
            $childRoleId = $this->getChildRole($user);
            if($childRoleId == Role::SATKER){
                if ($data->id_satker == $user->id_satker) {
                    $result = $data->delete();
                } else {
                    $result = 0;
                }
            } else if ($childRoleId == Role::TINGKAT_BANDING) {
                if ($data->id_wilayah == $user->id_wilayah && $data->lingkungan == $user->lingkungan) {
                    $result = $data->delete();
                } else {
                    $result = 0;
                }
            } else if ($childRoleId == Role::KORWIL) {
                if ($data->id_wilayah == $user->id_wilayah) {
                    $result = $data->delete();
                } else {
                    $result = 0;
                }
            } else if ($childRoleId == Role::ESELON) {
                if ($data->lingkungan == $user->lingkungan) {
                    $result = $data->delete();
                } else {
                    $result = 0;
                }
            }
        } else {
            if($user->isAdminPusat()) {
                if($data->isAdminPusat() || $data->isSuperAdmin()) {
                    $result = 0;
                } else {
                    $result = $data->delete();
                }
            } else if ($user->isSuperAdmin()) {
                $result = $data->delete();
            }
        }

        $res['status'] = $result ? 1 : 0;

        return response()->json($res);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();
        $dataUser = $this->model->find($user->id);
        $data['user'] = $dataUser;
        $data['config'] = $this->config;

        $data['profile'] = ProfileSatker::whereidSatker($user->id_satker)->first();
        $data['isSatker'] = $user->isSatkerRole() || $user->isAdminSatker();
        $data['data'] = Satker::find($user->id_satker);

        if($data['isSatker']) {
            $images = SatkerImage::whereKodeSatker($data['data']->kode)->orderBy('order')->get();
            if ($images->isEmpty()) {
                $preview = asset('assets/app/media/img/unavailable-image.png');
                $images = [
                    ['src' => $preview, 'opts' => ['caption' => 'Gambar tidak tersedia']]
                ];
            } else {
                $preview = asset($images[0]->file);
                $tmp = [];
                foreach ($images as $image) {
                    $tmp[] = ['src' => asset($image->file), 'opts' => ['caption' => $image->caption]];
                }

                $images = $tmp;
            }

            $data['preview'] = $preview;
            $data['dataImages'] = $images;
        }

        return view('admin.master.user.profile', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateprofile(Request $request)
    {
        $validate = [
            'name' => 'required|max:255',
            'email' => 'email',
            'password' => 'same:password_match'
        ];

        $validator = Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $input = $request->all();
            $data = Auth::user();
            $data->name = $input['name'];
            $data->nip = $input['nip'];
            $data->jabatan = $input['jabatan'];
            $data->telp = $input['telp'];

            if ($request->has('password') && $request->input('password') != '') {
                $data->password = $input['password'];
            }

            if ($data->save()) {
                $oldFoto = $data->image;
                if ($request->hasFile('foto')) {
                    $filename = time() . '_' . str_slug($input['name']) . '.' . $request->file('foto')->getClientOriginalExtension();
                    $path = public_path() . '/user_image/' . $filename;

                    $image = $request->file('foto')->getRealPath();
                    Image::make($image)->fit(300)->save($path);

                    $data->image = $filename;
                    $data->save();

                    if ($oldFoto != '' && file_exists(public_path('user_image/' . $oldFoto))) {
                        unlink(public_path('user_image/' . $oldFoto));
                    }
                }

                $res = [
                    'status'  => 1,
                    'message' => 'Berhasil mengubah data profil'
                ];
            } else {
                $res = [
                    'status'  => 0,
                    'message' => 'Gagal mengubah data profil'
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function photosatker(Request $request)
    {
        $user = Auth::user();
        $validate = [
            'foto.1' => 'nullable|image|max:5120',
            'foto.2' => 'nullable|image|max:5120',
            'foto.3' => 'nullable|image|max:5120',
        ];

        if($user->id_satker == ''){
            abort(403);
        }

        $validator = Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $satker = Satker::find($user->id_satker);

            if(!empty($request->file('foto'))) {
                $limit = 3;
                for ($i = 1;$i <= $limit;$i++) {
                    if(isset($request->file('foto')[$i])) {
                        $file = $request->file('foto')[$i];

                        $filename = time().'-' . str_slug(explode('.', $file->getClientOriginalName())[0]).'.'.$file->getClientOriginalExtension();
                        $path = 'file/satker/' . $satker->kode;

                        $image = SatkerImage::whereKodeSatker($satker->kode)->whereOrder($i)->first();
                        $file->storeAs($path, $filename, ['disk' => 'public_non']);
                        if($image == null) {
                            SatkerImage::create([
                                'kode_satker' => $satker->kode,
                                'file' => $path.'/'.$filename,
                                'caption' => null,
                                'order' => $i,
                                'created_by' => $user->id
                            ]);
                        } else {
                            $tmpImage = $image->file;

                            $image->file = $path.'/'.$filename;
                            $image->save();

                            if(file_exists(public_path($tmpImage))){
                                unlink(public_path($tmpImage));
                            }
                        }
                    }
                }
            }

            if(!empty($request->input('hapus'))) {
                foreach ($request->input('hapus') as $hapus) {
                    $image = SatkerImage::whereKodeSatker($satker->kode)->whereOrder($hapus)->first();
                    if($image != null) {
                        if(file_exists(public_path($image->file))){
                            unlink(public_path($image->file));
                        }
                        $image->delete();
                    }
                }
            }

            $captions = $request->input('caption');
            foreach ($captions as $k => $caption) {
                $image = SatkerImage::whereKodeSatker($satker->kode)->whereOrder($k)->first();
                if($image != null) {
                    $image->caption = $caption;
                    $image->save();
                }
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatesatker(Request $request)
    {
        $validate = [
            'ketua_pengadilan' => 'required',
            'wakil_ketua_pengadilan' => 'required',
            'jumlah_hakim' => 'required',
            'panitera_pengadilan' => 'required',
            'jumlah_tenaga_teknis' => 'required',
            'klasifikasi' => 'required',
//            'sekretaris_pengadilan' => 'required',
            'jumlah_tenaga_kesekratariatan' => 'required',
            'jumlah_ptt' => 'required',
            'operator_simak' => 'required',
            'alamat_kantor' => 'required',
        ];

        $validator = Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $param = $request->all();
            $id = Auth::user()->id_satker;

            $model = ProfileSatker::whereIdSatker($id)->first();
            if (is_null($model)) {
                $model = ProfileSatker::create([
                    'id_satker' => $id,
                    'ketua_pengadilan' => $request->input('ketua_pengadilan'),
                    'wakil_ketua_pengadilan' => $request->input('wakil_ketua_pengadilan'),
                    'jumlah_hakim' => $request->input('jumlah_hakim'),
                    'panitera_pengadilan' => $request->input('panitera_pengadilan'),
                    'jumlah_tenaga_teknis' => $request->input('jumlah_tenaga_teknis'),
                    'klasifikasi' => $request->input('klasifikasi'),
                    'sekretaris_pengadilan' => $request->input('sekretaris_pengadilan'),
                    'jumlah_tenaga_kesekratariatan' => $request->input('jumlah_tenaga_kesekratariatan'),
                    'jumlah_ptt' => $request->input('jumlah_ptt'),
                    'operator_simak' => $request->input('operator_simak'),
                    'telp' => $request->input('satker_telp'),
                    'no_hp' => $request->input('no_hp'),
                    'website' => $request->input('website'),
                    'email_kantor' => $request->input('email_kantor'),
                    'email_admin' => $request->input('email_admin'),
                    'koord' => $request->input('koord'),
                    'alamat_kantor' => $request->input('alamat_kantor')
                ]);
            } else {
                $model->ketua_pengadilan = $request->input('ketua_pengadilan');
                $model->wakil_ketua_pengadilan = $request->input('wakil_ketua_pengadilan');
                $model->jumlah_hakim = $request->input('jumlah_hakim');
                $model->panitera_pengadilan = $request->input('panitera_pengadilan');
                $model->jumlah_tenaga_teknis = $request->input('jumlah_tenaga_teknis');
                $model->klasifikasi = $request->input('klasifikasi');
                $model->sekretaris_pengadilan = $request->input('sekretaris_pengadilan');
                $model->jumlah_tenaga_kesekratariatan = $request->input('jumlah_tenaga_kesekratariatan');
                $model->jumlah_ptt = $request->input('jumlah_ptt');
                $model->operator_simak = $request->input('operator_simak');
                $model->alamat_kantor = $request->input('alamat_kantor');
                $model->website = $request->input('website');
                $model->telp = $request->input('satker_telp');
                $model->no_hp = $request->input('no_hp');
                $model->email_kantor = $request->input('email_kantor');
                $model->email_admin = $request->input('email_admin');
                $model->koord = $request->input('koord');

                $model = $model->save();
            }

            if ($model) {
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
     * @param $user
     * @return int
     */
    private function getChildRole($user): int
    {
        $roleId = 0;
        switch ($user->id_role) {
            case Role::ADMIN_SATKER:
                $roleId = Role::SATKER;
                break;
            case Role::ADMIN_TINGKAT_BANDING:
                $roleId = Role::TINGKAT_BANDING;
                break;
            case Role::ADMIN_KORWIL:
                $roleId = Role::KORWIL;
                break;
            case Role::ADMIN_ESELON:
                $roleId = Role::ESELON;
                break;
            case Role::ADMIN_PUSAT:
                $roleId = Role::ADMIN;
                break;
        }

        return $roleId;
    }
}
