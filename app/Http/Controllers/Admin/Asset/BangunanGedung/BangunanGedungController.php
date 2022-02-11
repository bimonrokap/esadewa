<?php

namespace App\Http\Controllers\Admin\Asset\BangunanGedung;

use App\Http\Controllers\AssetController;
use App\Model\Asset\AssetBangunanGedung;
use App\Model\AssetImage;
use App\Model\AssetVariable;
use App\Model\AssetVideo;
use App\Model\Satker;
use App\Repositories\Datatable\Datatable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BangunanGedungController extends AssetController
{

    private $route = 'admin.asset.bangunangedung';
    private $title = 'Bangunan Gedung';
    public $tableHeader = ['Kode Barang', 'NUP', 'Kode Satker', 'Nama Satker', 'KIB', 'Nama Barang', 'Kondisi', 'Dokumen', 'Kepemilikan', 'Jenis Sertifikat', 'Merk/Tipe', 'Tgl Perolehan', 'Tgl Rekam Pertama', 'Nilai Perolehan Pertama', 'Nilai Mutasi', 'Nilai Perolehan', 'Nilai Penyusutan', 'Nilai Buku', 'Kuantitas', 'Luas Bangunan', 'Luas Dasar Bangunan', 'Jumlah Lantai', 'Jml Foto', 'Jalan', 'Kode Kab/Kota', 'Uraian Kota/Kabupaten', 'Kode Provinsi', 'Status Penggunaan', 'Status Pengelolaan', 'No PSP', 'Tgl PSP', 'Jmlh KIB', 'Kode Pos', 'SBSK', 'Optimalisasi', 'Tanggal Update'];
    protected $categoryAsset = 9;

    public function __construct()
    {
        $this->model = new AssetBangunanGedung();
        $this->layout = $this->route;
        $this->config = [
            'route'     => $this->route,
            'title'     => $this->title,
            'pageTitle' => $this->title
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['config'] = $this->config;
        $data['table']['header'] = $this->tableHeader;

        $data['tableRoute'] = route($this->route . '.table');
        $data['importSlug'] = 'bangunangedung';

        $data['filter'] = $this->generalFilter();
        $data['baseFilter'] = $this->baseFilter;
        return view($this->layout . '.index', $data);
    }

    /**
     * @param $param
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewTable($param)
    {
        $data['config'] = $this->config;
        $data['table']['header'] = $this->tableHeader;
        $data['tableRoute'] = route($this->route . '.table', $param);
        $data['tableLayout'] = $this->route . '.table';

        return view('template.usulan.table-container', $data);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $data['data'] = $this->model->find($id);
        $idAsset = $data['data']->kode_satker . '-' . $data['data']->kode_barang . '-' . $data['data']->nup;
        $data['idAsset'] = $idAsset;
        $images = AssetImage::whereIdCategory($this->categoryAsset)->whereIdAsset($idAsset)->orderBy('order')->get();
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
        $data['variables'] = AssetVariable::whereIdAsset($idAsset)->get()->keyBy('variable');
        $data['satker'] = Satker::whereKode($data['data']->kode_satker)->first();

        return view($this->layout . '.show', $data);
    }

    public function edit($id)
    {
        $data['config'] = $this->config;
        $data['data'] = $this->model->find($id);
        $idAsset = $data['data']->kode_satker.'-'.$data['data']->kode_barang.'-'.$data['data']->nup;
        $data['idAsset'] = $idAsset;
        $images = AssetImage::whereIdCategory($this->categoryAsset)->whereIdAsset($idAsset)->orderBy('order')->get();
        $video = AssetVideo::whereIdCategory($this->categoryAsset)->whereIdAsset($idAsset)->first();
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

        if($video != null) {
            $images[] = ['src' => asset($video->file), 'opts' => ['caption' => $video->caption]];
        }

        $data['preview'] = $preview;
        $data['images'] = $images;
        $data['video'] = $video;
        $data['dataImages'] = $dataImages;
        $data['statusHukums'] = ['Bersengketa', 'Tidak Bersengketa', 'Lainnya'];
        $data['variables'] = AssetVariable::whereIdAsset($idAsset)->get()->keyBy('variable');
        $data['satker'] = Satker::whereKode($data['data']->kode_satker)->first();

        return view($this->layout . '.edit', $data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        $validate = [
            'bukti_kepemilikan' => 'nullable|file|mimes:pdf|max:5120',
            'foto.1' => 'nullable|mimes:jpeg,png,jpg|max:5120',
            'foto.2' => 'nullable|mimes:jpeg,png,jpg|max:5120',
            'foto.3' => 'nullable|mimes:jpeg,png,jpg|max:5120',
            'video' => 'nullable|mimes:mp4|max:100120',
        ];

        $validator = Validator::make($request->all(), $validate);
        if (!$validator->fails()) {

            $model = $this->model->find($id);
            $user = Auth::user();
            if($user->cannot('edit', $model)){
                abort(409, 'Denied');
            }

            $model->prototype = $request->has('prototype') ? 1 : 0;
            $model->save();

            $idAsset = $model->kode_satker . '-' . $model->kode_barang . '-' . $model->nup;
            $data = AssetVariable::whereVariable('status_hukum')->whereIdAsset($idAsset)->first();
            if($data == null){
                AssetVariable::create([
                    'id_asset' => $idAsset,
                    'variable' => 'status_hukum',
                    'value' => $request->input('status_hukum'),
                    'created_by' => $user->id
                ]);
            } else {
                $data->value = $request->input('status_hukum');
                $data->save();
            }

            $data = AssetVariable::whereVariable('koordinat')->whereIdAsset($idAsset)->first();
            $koord = $request->input('latitude') . ',' . $request->input('longitude');
            if($koord == ',') {
                $koord = null;
            }
            if($data == null){
                AssetVariable::create([
                    'id_asset' => $idAsset,
                    'variable' => 'koordinat',
                    'value' => $koord,
                    'created_by' => $user->id
                ]);
            } else {
                $data->value = $koord;
                $data->save();
            }


            if($request->hasFile('bukti_kepemilikan')){
                $file = $request->file('bukti_kepemilikan');
                $filename = time().'-' . str_slug(explode('.', $file->getClientOriginalName())[0]).'.'.$file->getClientOriginalExtension();
                $path = 'file/' . $idAsset . '/bukti_kepemilikan';

                $file->storeAs($path, $filename);
                $loc = $path . '/' . $filename;

                $data = AssetVariable::whereVariable('bukti_kepemilikan')->whereIdAsset($idAsset)->first();
                if($data == null){
                    AssetVariable::create([
                        'id_asset' => $idAsset,
                        'variable' => 'bukti_kepemilikan',
                        'value' => $loc,
                        'created_by' => $user->id
                    ]);
                } else {
                    $data->value = $loc;
                    $data->save();
                }
            }

            if(!empty($request->file('foto'))) {
                $limit = 3;
                for ($i = 1;$i <= $limit;$i++) {
                    if(isset($request->file('foto')[$i])) {
                        $file = $request->file('foto')[$i];

                        $filename = time().'-' . str_slug(explode('.', $file->getClientOriginalName())[0]).'.'.$file->getClientOriginalExtension();
                        $path = 'file/asset/tanah/' . $idAsset;

                        $image = AssetImage::whereIdAsset($idAsset)->whereOrder($i)->first();
                        $file->storeAs($path, $filename, ['disk' => 'public_non']);
                        if($image == null) {
                            AssetImage::create([
                                'id_asset' => $idAsset,
                                'id_category' => $this->categoryAsset,
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

            if (!empty($request->file('video'))) {
                if ($request->file('video') != null) {
                    $file = $request->file('video');

                    $filename = time().'-' . str_slug(explode('.', $file->getClientOriginalName())[0]).'.'.$file->getClientOriginalExtension();
                    $path = 'file/asset/tanah/' . $idAsset;

                    $video = AssetVideo::whereIdAsset($idAsset)->first();
                    $file->storeAs($path, $filename, ['disk' => 'public_non']);
                    if ($video == null) {
                        AssetVideo::create([
                            'id_asset' => $idAsset,
                            'id_category' => $this->categoryAsset,
                            'file' => $path.'/'.$filename,
                            'caption' => null,
                            'created_by' => $user->id
                        ]);
                    } else {
                        $tmpVideo = $video->file;

                        $video->file = $path.'/'.$filename;
                        $video->save();

                        if (file_exists(public_path($tmpVideo))) {
                            unlink(public_path($tmpVideo));
                        }
                    }
                }
            }

            if(!empty($request->input('hapus'))) {
                foreach ($request->input('hapus') as $hapus) {
                    $image = AssetImage::whereIdAsset($idAsset)->whereOrder($hapus)->first();
                    if($image != null) {
                        if(file_exists(public_path($image->file))){
                            unlink(public_path($image->file));
                        }
                        $image->delete();
                    }
                }
            }

            if (!empty($request->input('hapusVideo'))) {
                $image = AssetVideo::whereIdAsset($idAsset)->first();
                if ($image != null) {
                    if (file_exists(public_path($image->file))) {
                        unlink(public_path($image->file));
                    }
                    $image->delete();
                }
            }

            $captions = $request->input('caption');
            foreach ($captions as $k => $caption) {
                $image = AssetImage::whereIdAsset($idAsset)->whereOrder($k)->first();
                if($image != null) {
                    $image->caption = $caption;
                    $image->save();
                }
            }

            $caption = $request->input('captionVideo');
            $video = AssetVideo::whereIdAsset($idAsset)->first();
            if ($video != null) {
                $video->caption = $caption;
                $video->save();
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function table(Request $request)
    {
        $filter = $request->input('filter');

        $model = $this->model
            ->generalFilter($filter)
            ->assetBy()
            ->select('*');

        $user = Auth::user();
        list($model, $hasUsulan)  = $this->searchUsulan($request, $model);

        $dataTable = Datatable::create($model)
            ->editColumn('kode_barang', function ($data) {
                return $this->canLaporBmn($data);
            })
            ->editColumn('nilai_perolehan_pertama', function ($data) {
                return 'Rp ' .numberFormatIndo($data->nilai_perolehan_pertama);
            })
            ->editColumn('nilai_mutasi', function ($data) {
                return 'Rp ' .numberFormatIndo($data->nilai_mutasi);
            })
            ->editColumn('nilai_perolehan', function ($data) {
                return 'Rp ' .numberFormatIndo($data->nilai_perolehan);
            })
            ->editColumn('nilai_penyusutan', function ($data) {
                return 'Rp ' .numberFormatIndo($data->nilai_penyusutan);
            })
            ->editColumn('nilai_buku', function ($data) {
                return 'Rp ' .numberFormatIndo($data->nilai_buku);
            })
            ->editColumn('tanggal_update', function ($data) {
                return $data->tanggal_update == null ? '-' : Carbon::parse($data->tanggal_update)->format('j F Y');
            })
            ->editColumn('action', function ($data) use($hasUsulan, $user){
                $html = '<button type="button" data-url="'.route($this->route . '.show', $data->id).'" title="Profil Aset" class="btn btn-info btn-xs m-btn m-btn--icon m-btn--icon-only btn-show">
                        <i class="la la-eye"></i>
                    </button> ';
                if($user->can('edit', $data)){
                    $html .= '<a href="'.route($this->route . '.edit', $data->id).'" title="Edit Aset" class="btn btn-warning btn-xs m-btn m-btn--icon m-btn--icon-only ajaxify">
                        <i class="la la-pencil"></i>
                    </button> ';
                }
                if($hasUsulan){
                    return '<button type="button" data-attr="'.htmlspecialchars(json_encode(['id' => $data->id, 'category' => 'Bangunan Gedung', 'nup' => $data->nup, 'kode' => $data->kode_barang, 'nama' => $data->nama_barang, 'nilai' => $data->nilai_perolehan, 'tgl' => Carbon::parse($data->tgl_perolehan)->format('d F Y')])).'" title="Tambah Barang" class="btn btn-success btn-xs m-btn m-btn--icon m-btn--icon-only btn-barang">
                        <i class="la la-plus"></i>
                    </button>';
                }
                return $html;
            })
            ->filterConstraint('active', 'match');
        $respond = $dataTable->make(true);

        return response()->json($respond);
    }
}
