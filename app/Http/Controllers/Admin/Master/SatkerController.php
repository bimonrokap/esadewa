<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Model\Asset\AssetAlatBermotor;
use App\Model\Asset\AssetRumahNegara;
use App\Model\Asset\AssetTanah;
use App\Model\ProfileSatker;
use App\Model\Satker;
use App\Model\SatkerImage;
use App\Repositories\Datatable\Datatable;
use App\Repositories\Permission\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SatkerController extends Controller
{

    private $route = 'admin.master.satker';
    private $config, $layout;
    private $title = 'Satker';
    private $permission = 'master-satker';

    public function __construct()
    {
        $this->model = new Satker();
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
        $data['table']['header'] = ['Kode', 'Nama', 'Wilayah', 'Kota', 'Lingkungan', 'Type'];
        $data['listLingkungan'] = ["PN" => "Peradilan Umum", "PA" => "Peradilan Agama", "PM" => "Peradilan Militer", "PT" => "Peradilan Tata Usaha", "PMT" => "Peradilan Militer & Tata Usaha", 'PUSAT' => 'Pusat'];
        $data['listType'] = ["general" => "Umum", "tingkatbanding" => "Tingkat Banding", "pusat" => "Pusat"];

        return view($this->layout . '.index', $data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        Permission::access('view-' . $this->permission);

        Permission::can('edit-' . $this->permission) ? $action[] = 'edit' : '';

        $listLingkungan = ["PN" => "Peradilan Umum", "PA" => "Peradilan Agama", "PM" => "Peradilan Militer", "PT" => "Peradilan Tata Usaha", "PMT" => "Peradilan Militer & Tata Usaha", 'PUSAT' => 'Pusat'];
        $listType = ["general" => "Umum", "tingkatbanding" => "Tingkat Banding", "pusat" => "Pusat"];

        $model = $this->model
            ->join('wilayahs', 'wilayahs.id','=','satkers.id_wilayah')
            ->select('satkers.kode', 'satkers.name', 'wilayahs.name as wilayah', 'city', 'satker_type', 'type');

        $dataTable = Datatable::create($model)
            ->setId('satkers.id')
            ->editColumn('satker_type', function ($data) use ($listLingkungan){
                return isset($listLingkungan[$data->satker_type]) ? $listLingkungan[$data->satker_type] : '<i class="empty-text">Empty</i>';
            })
            ->editColumn('type', function ($data) use ($listType){
                return isset($listType[$data->type]) ? $listType[$data->type] : '<i class="empty-text">Empty</i>';
            })
            ->editColumn('action', function ($data){
                return '<a href="'.route($this->route . '.show', $data->id).'" class="btn btn-primary btn-xs m-btn m-btn--icon m-btn--icon-only tooltips btn-show" title="Detail Satker">
                    <i class="la la-eye"></i>
                </a> ';
            })
            ->defaultAction($action, ['route' => $this->route, 'title' => $this->title]);
        $respond = $dataTable->make(true);

        return response()->json($respond);
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
        $data['profile'] = ProfileSatker::whereidSatker($id)->first();
        $data['listLingkungan'] = ["PN" => "Peradilan Umum", "PA" => "Peradilan Agama", "PM" => "Peradilan Militer", "PT" => "Peradilan Tata Usaha", "PMT" => "Peradilan Militer & Tata Usaha", 'PUSAT' => 'Pusat'];
        $data['listType'] = ["general" => "Umum", "tingkatbanding" => "Tingkat Banding", "pusat" => "Pusat"];

        $images = SatkerImage::whereKodeSatker($data['data']->kode)->orderBy('order')->get();
        if($images->isEmpty()){
            $preview = asset('assets/app/media/img/unavailable-image.png');
            $images = [
                ['src' => $preview, 'opts' => ['caption' => 'Gambar tidak tersedia']]
            ];
            $dataImages = [];
        } else {
            $preview = asset($images[0]->file);
            $tmp = [];
            foreach ($images as $image) {
                $tmp[] = ['src' => asset($image->file), 'opts' => ['caption' => $image->caption]];
            }

            $images = $tmp;
            $dataImages = $images;
        }

        $data['preview'] = $preview;
        $data['images'] = $images;
        $data['dataImages'] = $dataImages;
        return view($this->layout . '.edit', $data);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        Permission::access('edit-' . $this->permission);

        $data['config'] = $this->config;

        $data['data'] = $this->model->find($id);
        $data['profile'] = ProfileSatker::whereidSatker($id)->first();
        $data['listLingkungan'] = ["PN" => "Peradilan Umum", "PA" => "Peradilan Agama", "PM" => "Peradilan Militer", "PT" => "Peradilan Tata Usaha", "PMT" => "Peradilan Militer & Tata Usaha", 'PUSAT' => 'Pusat'];
        $data['listType'] = ["general" => "Umum", "tingkatbanding" => "Tingkat Banding", "pusat" => "Pusat"];
        $data['aset'] = [
            'tanah_kantor' => [
                'bidang' => AssetTanah::kantor()->whereKodeSatker($data['data']->kode)->count(),
                'luas' => AssetTanah::kantor()->whereKodeSatker($data['data']->kode)->sum('luas_tanah_seluruhnya')
            ],
            'tanah_rumah_negara' => [
                'bidang' => AssetTanah::whereIn('kode_barang', ['2010101001', '2010101002', '2010101003'])->whereKodeSatker($data['data']->kode)->count(),
                'luas' => AssetTanah::whereIn('kode_barang', ['2010101001', '2010101002', '2010101003'])->whereKodeSatker($data['data']->kode)->sum('luas_tanah_seluruhnya')
            ],
            'rumah_negara' => [
                'I' => AssetRumahNegara::golongan1()->whereKodeSatker($data['data']->kode)->count(),
                'II' => AssetRumahNegara::golongan1()->whereKodeSatker($data['data']->kode)->count(),
            ],
            'kendaraan' => [
                '4' => AssetAlatBermotor::roda2()->whereKodeSatker($data['data']->kode)->count(),
                '2' => AssetAlatBermotor::roda2()->whereKodeSatker($data['data']->kode)->count(),
                'lainnya' => AssetAlatBermotor::whereKodeSatker($data['data']->kode)->count() - AssetAlatBermotor::roda2()->whereKodeSatker($data['data']->kode)->count() - AssetAlatBermotor::roda4()->whereKodeSatker($data['data']->kode)->count(),
            ],
        ];

        $images = SatkerImage::whereKodeSatker($data['data']->kode)->orderBy('order')->get();
        if($images->isEmpty()){
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
        $data['images'] = $images;

        return view($this->layout . '.show', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        Permission::access('edit-' . $this->permission);

        $validate = [
            'ketua_pengadilan' => 'required',
            'wakil_ketua_pengadilan' => 'required',
            'jumlah_hakim' => 'required',
            'panitera_pengadilan' => 'required',
            'jumlah_tenaga_teknis' => 'required',
//            'jumlah_perkara_perdata_pertahun' => 'required',
//            'jumlah_perkara_perdana_pertahun' => 'required',
            'klasifikasi' => 'required',
            'sekretaris_pengadilan' => 'required',
            'jumlah_tenaga_kesekratariatan' => 'required',
            'jumlah_ptt' => 'required',
            'operator_simak' => 'required',
            'alamat_kantor' => 'required',
            'foto.1' => 'nullable|image|max:5120',
            'foto.2' => 'nullable|image|max:5120',
            'foto.3' => 'nullable|image|max:5120',
        ];

        $validator = Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $satker = Satker::find($id);
            $satker->city = $request->input('city');
            $satker->kpknl = $request->input('kpknl');
            $satker->dirjen = $request->input('dirjen');
            $satker->kanwil = $request->input('kanwil');
            $satker->type = $request->input('type');
            $satker->satker_type = $request->input('satker_type');
            $satker->save();
            $model = ProfileSatker::whereIdSatker($id)->first();
            if(is_null($model)){
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
                    'telp' => $request->input('telp'),
                    'no_hp' => $request->input('no_hp'),
                    'website' => $request->input('website'),
                    'email_kantor' => $request->input('email_kantor'),
                    'email_admin' => $request->input('email_admin'),
                    'koord' => $request->input('koord'),
                    'alamat_kantor' => $request->input('alamat_kantor')
                ]);
            } else{
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
                $model->telp = $request->input('telp');
                $model->no_hp = $request->input('no_hp');
                $model->email_kantor = $request->input('email_kantor');
                $model->email_admin = $request->input('email_admin');
                $model->koord = $request->input('koord');

                $model = $model->save();
            }

            if(!empty($request->file('foto'))) {
                $limit = 3;
                for ($i = 1;$i <= $limit;$i++) {
                    if(isset($request->file('foto')[$i])) {
                        $file = $request->file('foto')[$i];

                        $filename = time().'-' . str_slug(explode('.', $file->getClientOriginalName())[0]).'.'.$file->getClientOriginalExtension();
                        $path = 'file/satker/' . $satker->kode;

                        $image = SatkerImage::whereKodeSatker($satker->kode)->whereOrder($i)->first();
                        if($image == null) {
                            $file->storeAs($path, $filename, ['disk' => 'public_non']);
                            SatkerImage::create([
                                'kode_satker' => $satker->kode,
                                'file' => $path.'/'.$filename,
                                'caption' => null,
                                'order' => $i,
                                'created_by' => Auth::user()->id
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
}
