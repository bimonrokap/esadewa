<?php

namespace App\Http\Controllers\Admin\Pengelolaan;

use App\Exports\Usulan\SewaExport;
use App\Http\Controllers\BarangTrait;
use App\Http\Controllers\UsulanController;
use App\Model\CategoryAsset;
use App\Model\DocTemplate;
use App\Model\ImageTmp;
use App\Model\PenandatanganSurat;
use App\Model\Satker;
use App\Model\Sewa\SewaBarang;
use App\Model\Sewa\SewaFoto;
use App\Model\Sewa\SewaLog;
use App\Model\Sewa\StatusSewa;
use App\Model\Sewa\Sewa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;

class SewaController extends UsulanController
{
    use BarangTrait;

    private $route = 'admin.pengelolaan.sewa';
    private $title = 'Sewa';
    private $permission = 'pengelolaan-sewa';
    private $docForm = 'pengelolaan-sewa';
    protected $objName = 'sewa';

    public function __construct()
    {
        $this->model = new Sewa();
        $this->layout = $this->route;
        $this->breadcrumb = ['Pengelolaan BMN' => null];
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
        \Permission::access('view-' . $this->permission);

        $data['config'] = $this->config;
        $data['config']['breadcrumb'] = array_merge($this->breadcrumb, [$this->title => route($this->route . '.index')]);
        $data['table']['header'] = ['No Surat Usulan Satker', 'Satker', 'Tanggal Surat', 'Tanggal Pengajuan', 'Status'];

        $data['statuses'] = StatusSewa::get();
        $data['user'] = \Auth::user();

        return view($this->layout . '.index', $data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        \Permission::access('view-' . $this->permission);

        $model = $this->model
            ->usulanBy()
            ->join('users as u', 'u.id', '=', $this->model->getTable() . '.created_by')
            ->join('satkers as s', 's.id', '=', 'u.id_satker')
            ->join('sewa_statuses as ps', 'ps.id', '=', 'sewas.id_sewa_status')
            ->select('letter_number', 's.name as satkerName', 'letter_date', 'u.id_satker', 'state', 'sewas.created_at', "ps.name as sewaStatus", 'id_sewa_status', 's.id_wilayah');

        $user = \Auth::user();
        $dataTable = \Datatable::create($model)
            ->setId($this->model->getTable() . '.id')
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('j F Y, H:s');
            })
            ->editColumn('letter_date', function ($data) {
                return Carbon::parse($data->letter_date)->format('j F Y');
            })
            ->editColumn('satker', function ($data) {
                return $data->nama_satker . ' ( '.$data->kode_satker.' )';
            })
            ->editColumn('total_nilai_barang', function ($data) {
                return 'Rp '.numberFormatIndo($data->total_nilai_barang);
            })
            ->editColumn('sewaStatus', function ($data) {
                return '<span class="m-badge m-badge--'.$data->state.' m-badge--wide">'.$data->sewaStatus.'</span>';
            })
            ->editColumn('action', function ($data) use ($user) {
                $html = '<a href="'.route($this->route . '.show', $data->id).'" class="ajaxify"><button class="btn btn-primary m-btn btn-sm m-btn--icon"> <i class="la la-eye"></i> </button></a> ';
                if($user->can('edit', $data)){
                    $html .= '<a href="'.route($this->route . '.edit', $data->id).'" class="ajaxify"><button class="btn btn-info m-btn btn-sm m-btn--icon"> <i class="la la-pencil"></i> Edit </button></a> ';
                }
                if($user->can('verifTk', $data)) {
                    $html .= '<a class="btn btn-warning m-btn btn-sm m-btn--icon ajaxify" href="'.route($this->route . '.verif', $data->id).'"> <i class="la la-codepen"></i> Verif </a>';
                } else if($user->can('verifKepalaAdm', $data)) {
                    $html .= '<a class="btn btn-info m-btn btn-sm m-btn--icon ajaxify" href="'.route($this->route . '.disposisi', $data->id).'"> <i class="la la-check"></i> Disposisi </a>';
                } else if($user->can('dispoKepalaSub', $data)) {
                    $html .= '<a class="btn btn-info m-btn btn-sm m-btn--icon ajaxify" href="'.route($this->route . '.disposisi', $data->id).'"> <i class="la la-check"></i> Disposisi </a>';
                } else if($user->can('selesai', $data)) {
                    $html .= '<a class="btn btn-info m-btn btn-sm m-btn--icon ajaxify" href="'.route($this->route . '.selesai', $data->id).'"> <i class="la la-check-circle"></i> Proses </a>';
                } else if($user->can('tindaklanjut', $data)) {
                    $html .= '<a class="btn btn-success m-btn btn-sm m-btn--icon ajaxify" href="'.route($this->route . '.tindakLanjut', $data->id).'"> <i class="la la-check-square"></i> Tindak Lanjut </a>';
                }

                return $html == '' ? '#' : $html;
            })
            ->filterColumn('satker', function ($query, $search){
                return $query->where(function ($query) use ($search) {
                    $query->where('s.name', 'like', "%$search%")->orWhere('s.kode', 'like', "%$search%");
                });
            })
            ->filterConstraint(['letter_date' => 'date', 'created_at' => 'date']);
        $respond = $dataTable->make(true);

        return response()->json($respond);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $record = $this->model->findOrFail($id);
        if (!\Gate::allows('view', $record)) {
            abort(403, "Not Allowed.");
        }

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Detail Pengajuan '.$this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [$this->title => route($this->route . '.index'), $record->letter_number => route($this->route . '.show', $id)];

        $data['data'] = $record;
        $data['barangs'] = $this->usulanBarang($record);
        $data['logs'] = $record->log()->with(['user.satker', 'status'])->get();

        return view($this->layout . '.show', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        \Permission::access('create-' . $this->permission);

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Pengajuan '.$this->title;
        $data['config']['breadcrumb'] = array_merge($this->breadcrumb, [$this->title => route($this->route . '.index'), 'Pengajuan' => route($this->route . '.create')]);

        $data['kategoriBarang'] = CategoryAsset::sewa();
        $data['jenisBmn'] = CategoryAsset::sewaJenis();
        $data['uuid'] = Str::uuid();
        $data['penandatanganSurat'] = PenandatanganSurat::get();

        return view($this->layout . '.create', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        \Permission::access('create-' . $this->permission);

        $validate = [

            'letter_number' => 'required|max:50',
            'letter_date' => 'required|date_format:j F Y',
            'perihal' => 'required',
            'penandatangan_surat' => 'required|exists:penandatangan_surats,id',
            'no_surat_persetujuan' => 'required|max:50',
            'tanggal_surat_persetujuan' => 'required|date_format:j F Y',
            'perihal_surat_persetujuan' => 'required',
            'penandatangan_persetujuan' => 'required',
            'periode' => 'required|numeric',
            'nilai_sewa' => 'required|numeric',
            'identitas_penyewa' => 'required|max:20',
            'lokasi' => 'required',
            'jenis_bmn.*' => 'required|exists:category_assets,id',
            'luas_asset' => 'required|numeric',
            'surat_pengajuan_satker' => 'required|mimes:pdf|max:5000',
            'surat_rekomendasi' => 'required|mimes:pdf|max:5000'
        ];

        $user = \Auth::user();

        $jml = ImageTmp::where("uuid", $request->input("uuid"))->count();

        $idBarang = json_decode($request->input('data'))->id;
        if($idBarang == null){
            return response()->json([
                'status'  => 2,
                'message' => '<ul class="m--marginless">Barang tidak boleh Kosong.</ul>'
            ]);
        }

        if($jml > self::maxFoto) {
            return response()->json([
                'status'  => 2,
                'message' => '<ul class="m--marginless">Jumlah foto melebihi dari maximal benda.</ul>'
            ]);
        } else if($jml == 0) {
            return response()->json([
                'status'  => 2,
                'message' => '<ul class="m--marginless">Foto tidak boleh kosong.</ul>'
            ]);
        }

        if($request->input('jenis_bmn') != null){
            $jenisBmn = $request->input("jenis_bmn");
            if(in_array(4, $jenisBmn) && count($jenisBmn) > 1) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Jenis BMN Alat Angkutan Bermotor tidak bisa di gabungkan dengan yang lain.</ul>'
                ]);
            }
        }

        $param = $this->cleanNumber($request->all(), ['nilai_sewa', 'luas_asset']);
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $user) {
                $param['id_sewa_status'] = StatusSewa::PERMOHONAN_SATKER;
                $param['created_by'] = $user->id;
                $param['letter_date'] = Carbon::parse($param['letter_date'])->toDateString();
                $param['tanggal_surat_persetujuan'] = Carbon::parse($param['tanggal_surat_persetujuan'])->toDateString();

                $sewa = $this->model;
                $sewa = $sewa->create($param);

                if ($sewa) {
                    $sewa->category()->attach($param['jenis_bmn']);

                    $docLocation = $this->model->docLocation($sewa->id);
                    if(!file_exists($docLocation)) {
                        mkdir($this->model->docLocation($sewa->id), 0775, true);
                    }

                    $arrayFile = ['surat_pengajuan_satker','surat_rekomendasi'];
                    foreach ($arrayFile as $file) {
                        $fileDoc = $param[$file];
                        $filename = time().'-'.str_slug(explode('.', $fileDoc->getClientOriginalName())[0]).'.'.$fileDoc->getClientOriginalExtension();
                        $fileDoc->move($docLocation, $filename);
                        $sewa->{$file} = $filename;
                    }

                    $sewa->save();

                    $images = ImageTmp::where("uuid", $param["uuid"])->get();
                    foreach ($images as $image) {
                        if(file_exists(ImageTmp::imageLocation()."/".$image->file)){
                            if(!file_exists(SewaFoto::imageLocation($sewa->id))){
                                mkdir(SewaFoto::imageLocation($sewa->id), 0775, true);
                            }
                            rename(ImageTmp::imageLocation()."/".$image->file, SewaFoto::imageLocation($sewa->id)."/".$image->file);
                        }

                        SewaFoto::create([
                            'id_sewa' => $sewa->id,
                            'foto' => $image->file,
                        ]);

                        $image->delete();
                    }

                    $categories = json_decode($param['data'])->category;
                    $idBarang = json_decode($param['data'])->id;
                    $i = 1;
                    foreach ($categories as $key => $cat)
                    {
                        $br = $idBarang[$key];

                        $barang = $this->findBarang($br, $cat);
                        SewaBarang::create([
                            'id_sewa' => $sewa->id,
                            'id_asset' => $barang->kode_satker . '-' . $barang->kode_barang . '-' . $barang->nup,
                            'id_category_asset' => $cat,
                            'nilai_perolehan' => $barang->nilai_perolehan,
                            'ord' => $i++
                        ]);
                    }

                    SewaLog::create([
                        'id_sewa' => $sewa->id,
                        'created_by' => \Auth::user()->id,
                        'id_status' => SewaLog::PERMOHONAN
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil menambahkan Usulan ' . $this->title . ' dengan No Surat <strong>' . $param['letter_number'] . '</strong>'
                    ];
                } else {
                    $res = [
                        'status'  => 0,
                        'message' => 'Gagal menambahkan data ' . $this->title
                    ];
                }

                return $res;
            });
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
        \Permission::access('edit-' . $this->permission);

        $record = $this->model->join('users as u', 'u.id', '=', $this->model->getTable() . '.created_by')->select($this->model->getTable() . '.*', 'id_satker')->findOrFail($id);
        if (!\Gate::allows('edit', $record)) {
            abort(403, "Not Allowed.");
        }

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Ubah Pengajuan '.$this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [$this->title => route($this->route . '.index'), 'Edit' => null, $record->letter_number => route($this->route . '.edit', $id)];

        $data['data'] = $record;

        $data['kategoriBarang'] = CategoryAsset::sewa();
        $data['jenisBmn'] = CategoryAsset::sewaJenis();
        $data['uuid'] = Str::uuid();
        $data['penandatanganSurat'] = PenandatanganSurat::get();
        $data['barangs'] = $this->usulanBarang($record);
        $data['isRevisi'] = $record->id_sewa_status == StatusSewa::DITOLAK_TK || SewaLog::whereIdSewa($id)->whereIdStatus(SewaLog::DITOLAK_TK)->count() > 0;

        return view($this->layout . '.edit', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(Request $request, $id)
    {
        \Permission::access('edit-' . $this->permission);

        $sewa = $this->model->join('users as u', 'u.id', '=', $this->model->getTable().'.created_by')->select($this->model->getTable().'.*', 'id_satker')->findOrFail($id);
        if (!\Gate::allows('edit', $sewa)) {
            abort(403, "Not Allowed.");
        }

        $validate = [

            'letter_number' => 'required|max:50',
            'letter_date' => 'required|date_format:j F Y',
            'perihal' => 'required',
            'penandatangan_surat' => 'required|exists:penandatangan_surats,id',
            'no_surat_persetujuan' => 'required|max:50',
            'tanggal_surat_persetujuan' => 'required|date_format:j F Y',
            'perihal_surat_persetujuan' => 'required',
            'penandatangan_persetujuan' => 'required',
            'periode' => 'required|numeric',
            'nilai_sewa' => 'required|numeric',
            'identitas_penyewa' => 'required|max:20',
            'lokasi' => 'required',
            'jenis_bmn.*' => 'required|exists:category_assets,id',
            'luas_asset' => 'required|numeric',
            'surat_pengajuan_satker' => 'nullable|mimes:pdf|max:5000',
            'surat_rekomendasi' => 'nullable|mimes:pdf|max:5000'
        ];

        $idBarang = json_decode($request->input('data'))->id;
        if($idBarang == null){
            return response()->json([
                'status'  => 2,
                'message' => '<ul class="m--marginless">Barang tidak boleh Kosong.</ul>'
            ]);
        }

        $imageDb = SewaFoto::where('id_sewa', $id)->count();
        $jml = ImageTmp::where("uuid", $request->input("uuid"))->count() + $imageDb;
        if($jml > self::maxFoto) {
            return response()->json([
                'status'  => 2,
                'message' => '<ul class="m--marginless">Jumlah foto melebihi dari maximal benda.</ul>'
            ]);
        }

        if($request->input('jenis_bmn') != null){
            $jenisBmn = $request->input("jenis_bmn");
            if(in_array(4, $jenisBmn) && count($jenisBmn) > 1) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Jenis BMN Alat Angkutan Bermotor tidak bisa di gabungkan dengan yang lain.</ul>'
                ]);
            }
        }

        $param = $this->cleanNumber($request->all(), ['nilai_sewa']);
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $sewa) {
                $param['letter_date'] = Carbon::parse($param['letter_date'])->toDateString();

                $sewa->letter_number = $param['letter_number'];
                $sewa->letter_date = Carbon::parse($param['letter_date'])->toDateString();
                $sewa->perihal = $param['perihal'];
                $sewa->penandatangan_surat = $param['penandatangan_surat'];
                $sewa->no_surat_persetujuan = $param['no_surat_persetujuan'];
                $sewa->tanggal_surat_persetujuan = Carbon::parse($param['tanggal_surat_persetujuan'])->toDateString();
                $sewa->perihal_surat_persetujuan = $param['perihal_surat_persetujuan'];
                $sewa->penandatangan_persetujuan = $param['penandatangan_persetujuan'];
                $sewa->periode = $param['periode'];
                $sewa->nilai_sewa = $param['nilai_sewa'];
                $sewa->identitas_penyewa = $param['identitas_penyewa'];
                $sewa->lokasi = $param['lokasi'];
                $sewa->luas_asset = $param['luas_asset'];

                if($sewa->id_sewa_status == StatusSewa::DITOLAK_TK) {
                    $sewa->id_sewa_status = StatusSewa::PERMOHONAN_SATKER;
                }

                $docLocation = $this->model->docLocation($sewa->id);
                if(!file_exists($docLocation)) {
                    mkdir($this->model->docLocation($sewa->id), 0775, true);
                }

                $arrayFile = ['surat_pengajuan_satker','surat_rekomendasi'];
                foreach ($arrayFile as $file) {
                    if($param[$file] != null) {
                        $fileDoc = $param[$file];
                        $filename = time().'-'.str_slug(explode('.', $fileDoc->getClientOriginalName())[0]).'.'.$fileDoc->getClientOriginalExtension();
                        $fileDoc->move($docLocation, $filename);
                        $sewa->{$file} = $filename;
                    }
                }

                if ($sewa->save()) {
                    $images = ImageTmp::where("uuid", $param["uuid"])->get();
                    foreach ($images as $image) {
                        if(file_exists(ImageTmp::imageLocation()."/".$image->file)){
                            if(!file_exists(SewaFoto::imageLocation($sewa->id))){
                                mkdir(SewaFoto::imageLocation($sewa->id), 0775, true);
                            }
                            rename(ImageTmp::imageLocation()."/".$image->file, SewaFoto::imageLocation($sewa->id)."/".$image->file);
                        }

                        SewaFoto::create([
                            'id_sewa' => $sewa->id,
                            'foto' => $image->file,
                        ]);

                        $image->delete();
                    }

                    $categories = json_decode($param['data'])->category;
                    $idBarang = json_decode($param['data'])->id;
                    SewaBarang::whereIdSewa($sewa->id)->delete();

                    $i = 1;
                    foreach ($categories as $key => $cat)
                    {
                        $br = $idBarang[$key];

                        $barang = $this->findBarang($br, $cat);
                        SewaBarang::create([
                            'id_sewa' => $sewa->id,
                            'id_asset' => $barang->kode_satker . '-' . $barang->kode_barang . '-' . $barang->nup,
                            'id_category_asset' => $cat,
                            'nilai_perolehan' => $barang->nilai_perolehan,
                            'ord' => $i++
                        ]);
                    }

                    SewaLog::create([
                        'id_sewa' => $sewa->id,
                        'created_by' => \Auth::user()->id,
                        'id_status' => SewaLog::EDIT
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil merubah Usulan ' . $this->title . ' dengan No Surat <strong>' . $param['letter_number'] . '</strong>'
                    ];
                } else {
                    $res = [
                        'status'  => 0,
                        'message' => 'Gagal merubah data ' . $this->title
                    ];
                }

                return $res;
            });
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
    public function verif($id)
    {
        $record = $this->model->join('users as u', 'u.id', '=', $this->model->getTable().'.created_by')->select($this->model->getTable().'.*', 'id_satker')->findOrFail($id);
        if (!\Gate::allows('verifTk', $record)) {
            abort(403, "Not Allowed.");
        }

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Verifikasi Pengajuan '.$this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [$this->title => route($this->route . '.index'), 'Verif Tk Banding' => null, $record->letter_number => route($this->route . '.verif', $id)];

        $data['data'] = $record;

        $data['penandatanganSurat'] = PenandatanganSurat::get();
        $data['barangs'] = $this->usulanBarang($record);
        $data['isRevisi'] = $record->id_sewa_status == StatusSewa::DITOLAK_ADM || SewaLog::whereIdSewa($id)->whereIdStatus(SewaLog::DITOLAK_ADM)->count() > 0;

        return view($this->layout . '.verif', $data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function storeVerif(Request $request, $id)
    {
        $sewa = $this->model->join('users as u', 'u.id', '=', $this->model->getTable().'.created_by')->select($this->model->getTable().'.*', 'id_satker')->findOrFail($id);
        if (!\Gate::allows('verifTk', $sewa)) {
            abort(403, "Not Allowed.");
        }

        $isRevisi = $sewa->id_sewa_status == StatusSewa::DITOLAK_ADM || SewaLog::whereIdSewa($id)->whereIdStatus(SewaLog::DITOLAK_ADM)->count() > 0;
        if($request->input("submit") == 0) {
            $validate = [
                'keterangan_veriftk' => 'required',
            ];
        } else {
            $validate = [
                'letter_number_banding' => 'required|max:50',
                'letter_date_banding' => 'required|date_format:j F Y',
                'perihal_banding' => 'required',
                'penandatangan_surat_banding' => 'required|exists:penandatangan_surats,id'
            ];

            if(!$isRevisi) {
                $validate['surat_penghantar_banding'] = 'required|mimes:pdf|max:5000';
            } else {
                $validate['surat_penghantar_banding'] = 'nullable|mimes:pdf|max:5000';
            }
        }

        $param = $request->all();
        $validator = \Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $sewa) {
                $submit = $param["submit"];
                $keterangan = null;
                if($submit == 0) {
                    $sewa->id_sewa_status = StatusSewa::DITOLAK_TK;
                    $keterangan = $param["keterangan_veriftk"];
                    $sewa->keterangan_veriftk = $keterangan;
                    $statusLog = SewaLog::DITOLAK_TK;
                    $keterangan = ["keterangan" => $keterangan];
                } else {
                    $paramVerif = [
                        'letter_number_banding' => $param['letter_number_banding'],
                        'letter_date_banding' => Carbon::parse($param['letter_date_banding'])->toDateString(),
                        'perihal_banding' => $param['perihal_banding'],
                        'penandatangan_surat_banding' => $param['penandatangan_surat_banding'],
                    ];


                    $docLocation = $this->model->docLocation($sewa->id);
                    if($param['surat_penghantar_banding'] != null) {
                        $fileSuratBanding = $param['surat_penghantar_banding'];
                        $filename = time().'-'.str_slug(explode('.', $fileSuratBanding->getClientOriginalName())[0]).'.'.$fileSuratBanding->getClientOriginalExtension();
                        $fileSuratBanding->move($docLocation, $filename);
                        $paramVerif['surat_penghantar_banding'] = $filename;
                    }

                    foreach ($paramVerif as $k => $row) {
                        $sewa->{$k} = $row;
                    }
                    $sewa->id_sewa_status = StatusSewa::DITERIMA_TK;

                    $statusLog = SewaLog::DITERIMA_TK;
                    $keterangan = $paramVerif;
                }

                if ($sewa->save()) {
                    SewaLog::create([
                        'id_sewa' => $sewa->id,
                        'created_by' => \Auth::user()->id,
                        'id_status' => $statusLog,
                        'keterangan' => json_encode($keterangan)
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil men-verifikasi ' . $this->title . ' dengan No Surat <strong>' . $sewa->letter_number . '</strong>'
                    ];
                } else {
                    $res = [
                        'status'  => 0,
                        'message' => 'Gagal men-verifikasi data ' . $this->title
                    ];
                }

                return $res;
            });
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
    public function disposisi($id)
    {
        $record = $this->model->findOrFail($id);
        if (!\Gate::allows('verifKepalaAdm', $record) && !\Gate::allows('dispoKepalaSub', $record)) {
            abort(403, "Not Allowed.");
        }

        $isDispo = $record->id_sewa_status == StatusSewa::DITERIMA_ADM;
        if($isDispo) {
            $titleDetail = 'Verif Kepala Sub Bagian';
        } else {
            $titleDetail = 'Verif Kepala Bag Adm Penghapusan';
        }

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Verifikasi '.$this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [$this->title => route($this->route . '.index'), $titleDetail => null, $record->letter_number => route($this->route . '.disposisi', $id)];

        $data['data'] = $record;
        $data['barangs'] = $this->usulanBarang($record);
        $data['isDispo'] = $isDispo;

        return view($this->layout . '.disposisi', $data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function storedisposisi(Request $request, $id)
    {
        $sewa = $this->model->findOrFail($id);
        if (!\Gate::allows('verifKepalaAdm', $sewa) && !\Gate::allows('dispoKepalaSub', $sewa)) {
            abort(403, "Not Allowed.");
        }

        $validate = [ 'submit' => 'required' ];
        if($request->input("submit") == 0) {
            $validate['keterangan'] = 'required';
        }

        $param = $request->all();
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $sewa) {
                $isDispo = $sewa->id_sewa_status == StatusSewa::DITERIMA_ADM;

                $submit = $param["submit"];
                $keterangan = null;
                if($submit == 0) {
                    $idSewaStatus = StatusSewa::DITOLAK_ADM;
                    $keterangan = $param["keterangan"];
                    $sewa->keterangan_verifadm = $keterangan;
                    $statusLog = SewaLog::DITOLAK_ADM;
                    $keterangan = ["keterangan" => $keterangan];
                } else {
                    if($isDispo) {
                        $idSewaStatus = StatusSewa::PROSES;
                        $statusLog = SewaLog::PROSES;
                    } else {
                        $idSewaStatus = StatusSewa::DITERIMA_ADM;
                        $statusLog = SewaLog::DITERIMA_ADM;
                    }
                }
                $sewa->id_sewa_status = $idSewaStatus;

                if ($sewa->save()) {
                    SewaLog::create([
                        'id_sewa' => $sewa->id,
                        'created_by' => \Auth::user()->id,
                        'id_status' => $statusLog,
                        'keterangan' => $keterangan == null ? null : json_encode($keterangan)
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil men-verifikasi ' . $this->title . ' dengan No Surat <strong>' . $sewa->letter_number . '</strong>'
                    ];
                } else {
                    $res = [
                        'status'  => 0,
                        'message' => 'Gagal men-verifikasi data ' . $this->title
                    ];
                }

                return $res;
            });
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
    public function selesai($id)
    {
        $record = $this->model->findOrFail($id);
        if (!\Gate::allows('selesai', $record)) {
            abort(403, "Not Allowed.");
        }

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Proses Pengajuan '.$this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [$this->title => route($this->route . '.index'), 'Proses' => null, $record->letter_number => route($this->route . '.selesai', $id)];

        $data['data'] = $record;
        $data['barangs'] = $this->usulanBarang($record);

        return view($this->layout . '.selesai', $data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function storeSelesai(Request $request, $id)
    {
        $sewa = $this->model->findOrFail($id);
        if (!\Gate::allows('selesai', $sewa)) {
            abort(403, "Not Allowed.");
        }

        $validate = [
            'letter_number_persetujuan' => 'required|max:50',
            'letter_date_persetujuan' => 'required|date_format:j F Y',
            'perihal_persetujuan' => 'required',
            'surat_persetujuan' => 'required|mimes:pdf|max:5000'
        ];

        $param = $request->all();
        $validator = \Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $sewa) {
                $paramVerif = [
                    'letter_number_persetujuan' => $param['letter_number_persetujuan'],
                    'letter_date_persetujuan' => Carbon::parse($param['letter_date_persetujuan'])->toDateString(),
                    'perihal_persetujuan' => $param['perihal_persetujuan'],
                ];

                $docLocation = $this->model->docLocation($sewa->id);
                $fileSurat = $param['surat_persetujuan'];
                $filename = time().'-'.str_slug(explode('.', $fileSurat->getClientOriginalName())[0]).'.'.$fileSurat->getClientOriginalExtension();
                $fileSurat->move($docLocation, $filename);
                $paramVerif['surat_persetujuan'] = $filename;

                foreach ($paramVerif as $k => $row) {
                    $sewa->{$k} = $row;
                }
                $sewa->id_sewa_status = StatusSewa::MENUNGGU;
                $statusLog = SewaLog::MENUNGGU;
                $keterangan = $paramVerif;

                if ($sewa->save()) {
                    SewaLog::create([
                        'id_sewa' => $sewa->id,
                        'created_by' => \Auth::user()->id,
                        'id_status' => $statusLog,
                        'keterangan' => json_encode($keterangan)
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil men-verifikasi ' . $this->title . ' dengan No Surat <strong>' . $sewa->letter_number . '</strong>'
                    ];
                } else {
                    $res = [
                        'status'  => 0,
                        'message' => 'Gagal men-verifikasi data ' . $this->title
                    ];
                }

                return $res;
            });
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
    public function tindakLanjut($id)
    {
        $record = $this->model->join('users as u', 'u.id', '=', $this->model->getTable() . '.created_by')->select($this->model->getTable() . '.*', 'id_satker')->findOrFail($id);
        if (!\Gate::allows('tindaklanjut', $record)) {
            abort(403, "Not Allowed.");
        }

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Proses Tindak Lanjut '.$this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [$this->title => route($this->route . '.index'), 'Tindak Lanjut' => null, $record->letter_number => route($this->route . '.tindakLanjut', $id)];

        $data['data'] = $record;
        $data['barangs'] = $this->usulanBarang($record);

        return view($this->layout . '.tindaklanjut', $data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function storeTindakLanjut(Request $request, $id)
    {
        $sewa = $this->model->join('users as u', 'u.id', '=', $this->model->getTable() . '.created_by')->select($this->model->getTable() . '.*', 'id_satker')->findOrFail($id);
        if (!\Gate::allows('tindaklanjut', $sewa)) {
            abort(403, "Not Allowed.");
        }

        $validate = [
            'tanggal_pembayaran' => 'required|date_format:j F Y',
            'akun_pembayaran' => 'required|max:6',
            'nomor_ntb' => 'required|max:30',
            'nomor_ntpn' => 'required|max:30',
            'jumlah_pembayaran' => 'required|numeric',
            'bukti_pembayaran' => 'required|mimes:pdf|max:5000',
            'nomor_perjanjian' => 'required|max:50',
            'tanggal_perjanjian' => 'required|date_format:j F Y',
            'periode_perjanjian' => 'required|numeric',
            'tanggal_jatuh_tempo' => 'required|date_format:j F Y',
            'nilai_perjanjian_sewa' => 'required|numeric',
            'surat_perjanjian_sewa' => 'required|mimes:pdf|max:5000'
        ];

        $param = $this->cleanNumber($request->all(), ['jumlah_pembayaran', 'nilai_perjanjian_sewa', 'periode_perjanjian']);
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $sewa) {
                $paramVerif = [
                    'tanggal_pembayaran' => Carbon::parse($param['tanggal_pembayaran'])->toDateString(),
                    'akun_pembayaran' => $param['akun_pembayaran'],
                    'nomor_ntb' => $param['nomor_ntb'],
                    'nomor_ntpn' => $param['nomor_ntpn'],
                    'jumlah_pembayaran' => $param['jumlah_pembayaran'],
                    'nomor_perjanjian' => $param['nomor_perjanjian'],
                    'tanggal_perjanjian' => Carbon::parse($param['tanggal_perjanjian'])->toDateString(),
                    'periode_perjanjian' => $param['periode_perjanjian'],
                    'tanggal_jatuh_tempo' => Carbon::parse($param['tanggal_jatuh_tempo'])->toDateString(),
                    'nilai_perjanjian_sewa' => $param['nilai_perjanjian_sewa'],
                ];

                $docLocation = $this->model->docLocation($sewa->id);
                $arrayFile = ['bukti_pembayaran','surat_perjanjian_sewa'];
                foreach ($arrayFile as $file) {
                    $fileDoc = $param[$file];
                    $filename = time().'-'.str_slug(explode('.', $fileDoc->getClientOriginalName())[0]).'.'.$fileDoc->getClientOriginalExtension();
                    $fileDoc->move($docLocation, $filename);
                    $paramVerif[$file] = $filename;
                }

                foreach ($paramVerif as $k => $row) {
                    $sewa->{$k} = $row;
                }

                $sewa->id_sewa_status = StatusSewa::SELESAI;
                $statusLog = SewaLog::SELESAI;
                $keterangan = $paramVerif;

                if ($sewa->save()) {
                    SewaLog::create([
                        'id_sewa' => $sewa->id,
                        'created_by' => \Auth::user()->id,
                        'id_status' => $statusLog,
                        'keterangan' => json_encode($keterangan)
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil menindak lanjuti ' . $this->title . ' dengan No Surat <strong>' . $sewa->letter_number . '</strong>'
                    ];
                } else {
                    $res = [
                        'status'  => 0,
                        'message' => 'Gagal menindak lanjuti data ' . $this->title
                    ];
                }

                return $res;
            });
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
     * @param $slug
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     */
    public function draft($id, $slug)
    {
        $template = DocTemplate::whereSlug($slug)->firstOrFail();
        $document = $template->defaultDocument->file;
        $params = $template->param()->select('name', 'value')->get()->map(function ($value){
            if($value['value'] == null) {
                $value['value'] = snakeCaseToCamelCase($value['name']);
            }
            return $value;
        })->toArray();

        $data = $this->model
            ->join('users as u', 'u.id', $this->model->getTable().'.created_by')
            ->join('satkers as s', 's.id', 'u.id_satker')
            ->join('penandatangan_surats as psb', 'psb.id', 'penandatangan_surat_banding')
            ->select('s.satker_type', 's.dirjen', 's.kpknl', 's.kanwil as kanwilDjkn', 's.id_wilayah','psb.name as penandatanganTingkatBanding', 'letter_number_banding as noSuratBanding',
                'letter_date_banding as tanggalSuratBanding', 'perihal_banding as perihalSuratBanding', 's.name as satkerName', 'identitas_penyewa as identitasPenyewa',
                'no_surat_persetujuan as noSuratPersetujuan', 'tanggal_surat_persetujuan as tanggalSuratPersetujuan', 'perihal_surat_persetujuan as perihalSuratPersetujuan')
            ->find($id)->toArray();

        $tingkatBanding = Satker::where('satker_type', $data['satker_type'])->where('type', 'tingkatbanding')
            ->where('id_wilayah', $data['id_wilayah'])->select('name', 'city')->first();

        $data['satkerName'] = ucwords(strtolower($data['satkerName']));
        $data['satkerNameUpper'] = strtoupper($data['satkerName']);
        $data['tanggalSuratBanding'] = bulanReplace(Carbon::parse($data['tanggalSuratBanding'])->format('j F Y'));
        $data['tanggalSuratPersetujuan'] = bulanReplace(Carbon::parse($data['tanggalSuratPersetujuan'])->format('j F Y'));
        $data['tingkatBandingName'] = !is_null($tingkatBanding) ? ucwords(strtolower($tingkatBanding->name)) : 'empty';
        $data['tingkatBandingCity'] = !is_null($tingkatBanding) ? $tingkatBanding->city : 'empty';

        $templateProcessor = new TemplateProcessor(\Storage::path('usulan/template/'.$document));
        foreach ($params as $param) {
            if(isset($data[$param['value']])) {
                $templateProcessor->setValue($param['name'], $data[$param['value']]);
            }
        }

        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="'.$template->name.'.docx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $templateProcessor->saveAs('php://output');
    }

    /**
     * @param $id
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function lampiran($id)
    {
        $record = $this->model
            ->join('users as u', 'u.id', $this->model->getTable().'.created_by')
            ->join('satkers as s', 's.id', 'u.id_satker')
            ->select($this->model->getTable().'.*', 's.name as satkerName')
            ->find($id);

        $data['data'] = $record;
        $data['barang'] = $this->usulanBarang($record);

        return \Excel::download(new SewaExport($data), 'Lampiran Persetujuan Sewa.xlsx');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTable(Request $request)
    {
        return $this->_getTable($request, ['usulan' => $this->objName]);
    }
}
