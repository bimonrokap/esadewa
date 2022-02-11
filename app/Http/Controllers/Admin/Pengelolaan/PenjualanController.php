<?php

namespace App\Http\Controllers\Admin\Pengelolaan;

use App\Exports\Usulan\PenjualanExport;
use App\Http\Controllers\BarangTrait;
use App\Http\Controllers\UsulanController;
use App\Model\BackupSimak;
use App\Model\CategoryAsset;
use App\Model\DocTemplate;
use App\Model\ImageTmp;
use App\Model\PenandatanganSurat;
use App\Model\Penjualan\Penjualan;
use App\Model\Penjualan\PenjualanBarang;
use App\Model\Penjualan\PenjualanFoto;
use App\Model\Penjualan\PenjualanLog;
use App\Model\Penjualan\StatusPenjualan;
use App\Model\Satker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;

class PenjualanController extends UsulanController
{
    use BarangTrait;

    private $route = 'admin.pengelolaan.penjualan';
    private $title = 'Penjualan BMN';
    private $permission = 'pengelolaan-penjualan';
    private $docForm = 'pengelolaan-penjualan';
    protected $objName = 'penjualan';

    public function __construct()
    {
        $this->model = new Penjualan();
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

        $data['statuses'] = StatusPenjualan::get();
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
            ->join('penjualan_statuses as ps', 'ps.id', '=', 'penjualans.id_penjualan_status')
            ->select('letter_number', 's.name as satkerName', 'letter_date', 'u.id_satker', 'state', 'penjualans.created_at', "ps.name as penjualanStatus", 'id_penjualan_status', 's.id_wilayah');

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
            ->editColumn('penjualanStatus', function ($data) {
                return '<span class="m-badge m-badge--'.$data->state.' m-badge--wide">'.$data->penjualanStatus.'</span>';
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
        $data['config']['pageTitle'] = 'Detail Pengajuan Izin '.$this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [$this->title => route($this->route . '.index'), $record->letter_number => route($this->route . '.show', $id)];

        $data['data'] = $record;

        $data['kategoriBarang'] = CategoryAsset::penjualan();
        $data['backupSimak'] = BackupSimak::latestData($record->created_at);
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
        $data['config']['pageTitle'] = 'Pengajuan Izin '.$this->title;
        $data['config']['breadcrumb'] = array_merge($this->breadcrumb, [$this->title => route($this->route . '.index'), 'Pengajuan Izin' => route($this->route . '.create')]);

        $data['kategoriBarang'] = CategoryAsset::penjualan();
        $data['backupSimak'] = BackupSimak::latestData();
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
            'total_limit' => 'required|numeric',
            'surat_pengajuan_satker' => 'required|mimes:pdf|max:5000',
            'sk_panitia_penghapusan' => 'required|mimes:pdf|max:5000',
            'ba_hasil' => 'required|mimes:pdf|max:5000',
            'daftar_penghentian' => 'required|mimes:pdf|max:50000',
            'surat_pernyataan_tanggung' => 'required|mimes:pdf|max:5000',
            'sk_penetapan_status' => 'required|mimes:pdf|max:50000',
        ];

        $user = \Auth::user();
        $backupSimak = BackupSimak::latestData();
        if($backupSimak == null) {
            $validate['backup_simak'] = 'required|mimes:zip';
        }

        $idBarang = json_decode($request->input('data'))->id;
        if($idBarang == null){
            return response()->json([
                'status'  => 2,
                'message' => '<ul class="m--marginless">Barang tidak boleh Kosong.</ul>'
            ]);
        } else {
            $jmlBarang = count($idBarang);
            $jml = ImageTmp::where("uuid", $request->input("uuid"))->count();
            if($jml > $jmlBarang * self::maxFoto) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Jumlah foto melebihi dari maximal benda.</ul>'
                ]);
            } else if ($jml == 0) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Jumlah foto tidak boleh kosong.</ul>'
                ]);
            }
        }

        $param = $this->cleanNumber($request->all(), ['total_limit']);
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $user, $backupSimak) {
                $param['id_penjualan_status'] = StatusPenjualan::PERMOHONAN_SATKER;
                $param['created_by'] = $user->id;
                $param['letter_date'] = Carbon::parse($param['letter_date'])->toDateString();

                if($backupSimak != null){
                    $param['backup_simak'] = null;
                }

                $penjualan = $this->model;
                $penjualan = $penjualan->create($param);

                if ($penjualan) {

                    $docLocation = $this->model->docLocation($penjualan->id);
                    if(!file_exists($docLocation)) {
                        mkdir($this->model->docLocation($penjualan->id), 0775, true);
                    }

                    if($backupSimak == null) {
                        $fileBackupSimak = $param['backup_simak'];
                        $filename = time().'-'.str_slug(explode('.', $fileBackupSimak->getClientOriginalName())[0]).'.'.$fileBackupSimak->getClientOriginalExtension();
                        $fileBackupSimak->move($docLocation, $filename);
                        $penjualan->backup_simak = $filename;
                    }

                    $arrayFile = ['surat_pengajuan_satker','sk_panitia_penghapusan','ba_hasil','daftar_penghentian','surat_pernyataan_tanggung','sk_penetapan_status'];
                    foreach ($arrayFile as $file) {
                        $fileDoc = $param[$file];
                        $filename = time().'-'.str_slug(explode('.', $fileDoc->getClientOriginalName())[0]).'.'.$fileDoc->getClientOriginalExtension();
                        $fileDoc->move($docLocation, $filename);
                        $penjualan->{$file} = $filename;
                    }

                    $penjualan->save();

                    $images = ImageTmp::where("uuid", $param["uuid"])->get();
                    foreach ($images as $image) {
                        if(file_exists(ImageTmp::imageLocation()."/".$image->file)){
                            if(!file_exists(PenjualanFoto::imageLocation($penjualan->id))){
                                mkdir(PenjualanFoto::imageLocation($penjualan->id), 0775, true);
                            }
                            rename(ImageTmp::imageLocation()."/".$image->file, PenjualanFoto::imageLocation($penjualan->id)."/".$image->file);
                        }

                        PenjualanFoto::create([
                            'id_penjualan' => $penjualan->id,
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
                        PenjualanBarang::create([
                            'id_penjualan' => $penjualan->id,
                            'id_asset' => $barang->kode_satker . '-' . $barang->kode_barang . '-' . $barang->nup,
                            'id_category_asset' => $cat,
                            'nilai_perolehan' => $barang->nilai_perolehan,
                            'ord' => $i++
                        ]);
                    }

                    PenjualanLog::create([
                        'id_penjualan' => $penjualan->id,
                        'created_by' => \Auth::user()->id,
                        'id_status' => PenjualanLog::PERMOHONAN
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

        $record = $this->model->join('users as u', 'u.id', '=', 'penjualans.created_by')->select('penjualans.*', 'id_satker')->findOrFail($id);
        if (!\Gate::allows('edit', $record)) {
            abort(403, "Not Allowed.");
        }

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Ubah Pengajuan Izin '.$this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [$this->title => route($this->route . '.index'), 'Edit' => null, $record->letter_number => route($this->route . '.edit', $id)];

        $data['data'] = $record;
        $data['kategoriBarang'] = CategoryAsset::penjualan();
        $data['backupSimak'] = BackupSimak::latestData($record->created_at);
        $data['uuid'] = Str::uuid();
        $data['penandatanganSurat'] = PenandatanganSurat::get();
        $data['barangs'] = $this->usulanBarang($record);
        $data['isRevisi'] = $record->id_penjualan_status == StatusPenjualan::DITOLAK_TK || PenjualanLog::whereIdPenjualan($id)->whereIdStatus(PenjualanLog::DITOLAK_TK)->count() > 0;

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

        $penjualan = $this->model->join('users as u', 'u.id', '=', 'penjualans.created_by')->select('penjualans.*', 'id_satker')->findOrFail($id);
        if (!\Gate::allows('edit', $penjualan)) {
            abort(403, "Not Allowed.");
        }

        $validate = [
            'letter_number' => 'required|max:30',
            'letter_date' => 'required|date_format:j F Y',
            'perihal' => 'required',
            'penandatangan_surat' => 'nullable|exists:penandatangan_surats,id',
            'total_limit' => 'required|max:20',
            'surat_pengajuan_satker' => 'nullable|mimes:pdf|max:5000',
            'sk_panitia_penghapusan' => 'nullable|mimes:pdf|max:5000',
            'ba_hasil' => 'nullable|mimes:pdf|max:5000',
            'daftar_penghentian' => 'nullable|mimes:pdf|max:5000',
            'surat_pernyataan_tanggung' => 'nullable|mimes:pdf|max:5000',
            'sk_penetapan_status' => 'nullable|mimes:pdf|max:50000',
        ];

        $backupSimak = BackupSimak::latestData();
        if($penjualan->backup_simak == null && $backupSimak == null) {
            $validate['backup_simak'] = 'required|file';
        }

        $idBarang = json_decode($request->input('data'))->id;
        if($idBarang == null){
            return response()->json([
                'status'  => 2,
                'message' => '<ul class="m--marginless">Barang tidak boleh Kosong.</ul>'
            ]);
        } else {
            $jmlBarang = count($idBarang);
            $imageDb = PenjualanFoto::where('id_penjualan', $id)->count();
            $jml = ImageTmp::where("uuid", $request->input("uuid"))->count() + $imageDb;
            if($jml > $jmlBarang * self::maxFoto) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Jumlah foto melebihi dari maximal benda.</ul>'
                ]);
            } else if ($jml == 0) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Jumlah foto tidak boleh kosong.</ul>'
                ]);
            }
        }

        $param = $this->cleanNumber($request->all(), ['total_limit']);
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $penjualan, $backupSimak) {
                $param['letter_date'] = Carbon::parse($param['letter_date'])->toDateString();

                if($backupSimak != null){
                    $param['backup_simak'] = null;
                }
                $penjualan->letter_number = $param['letter_number'];
                $penjualan->letter_date = Carbon::parse($param['letter_date'])->toDateString();
                $penjualan->perihal = $param['perihal'];
                $penjualan->penandatangan_surat = $param['penandatangan_surat'];
                $penjualan->total_limit = $param['total_limit'];

                if($penjualan->id_penjualan_status == StatusPenjualan::DITOLAK_TK) {
                    $penjualan->id_penjualan_status = StatusPenjualan::PERMOHONAN_SATKER;
                }

                $docLocation = $this->model->docLocation($penjualan->id);
                if(!file_exists($docLocation)) {
                    mkdir($this->model->docLocation($penjualan->id), 0775, true);
                }

                if($backupSimak == null && $param['backup_simak'] != null) {
                    $fileBackupSimak = $param['backup_simak'];
                    if(strtolower($fileBackupSimak->getClientOriginalExtension()) != 'bac') {
                        return [
                            'status'  => 2,
                            'message' => '<ul class="m--marginless">File Backup SIMAK harus beisi file BAC</ul>'
                        ];
                    }
                    $filename = time().'-'.str_slug(explode('.', $fileBackupSimak->getClientOriginalName())[0]).'.'.$fileBackupSimak->getClientOriginalExtension();
                    $fileBackupSimak->move($docLocation, $filename);
                    $penjualan->backup_simak = $filename;
                }

                $arrayFile = ['surat_pengajuan_satker','sk_panitia_penghapusan','ba_hasil','daftar_penghentian','surat_pernyataan_tanggung','sk_penetapan_status'];
                foreach ($arrayFile as $file) {
                    if($param[$file] != null) {
                        $fileDoc = $param[$file];
                        $filename = time().'-'.str_slug(explode('.', $fileDoc->getClientOriginalName())[0]).'.'.$fileDoc->getClientOriginalExtension();
                        $fileDoc->move($docLocation, $filename);
                        $penjualan->{$file} = $filename;
                    }
                }

                if ($penjualan->save()) {
                    $images = ImageTmp::where("uuid", $param["uuid"])->get();
                    foreach ($images as $image) {
                        if(file_exists(ImageTmp::imageLocation()."/".$image->file)){
                            if(!file_exists(PenjualanFoto::imageLocation($penjualan->id))){
                                mkdir(PenjualanFoto::imageLocation($penjualan->id), 0775, true);
                            }
                            rename(ImageTmp::imageLocation()."/".$image->file, PenjualanFoto::imageLocation($penjualan->id)."/".$image->file);
                        }

                        PenjualanFoto::create([
                            'id_penjualan' => $penjualan->id,
                            'foto' => $image->file,
                        ]);

                        $image->delete();
                    }

                    $categories = json_decode($param['data'])->category;
                    $idBarang = json_decode($param['data'])->id;
                    PenjualanBarang::whereIdPenjualan($penjualan->id)->delete();

                    $i = 1;
                    foreach ($categories as $key => $cat)
                    {
                        $br = $idBarang[$key];

                        $barang = $this->findBarang($br, $cat);
                        PenjualanBarang::create([
                            'id_penjualan' => $penjualan->id,
                            'id_asset' => $barang->kode_satker . '-' . $barang->kode_barang . '-' . $barang->nup,
                            'id_category_asset' => $cat,
                            'nilai_perolehan' => $barang->nilai_perolehan,
                            'ord' => $i++
                        ]);
                    }

                    PenjualanLog::create([
                        'id_penjualan' => $penjualan->id,
                        'created_by' => \Auth::user()->id,
                        'id_status' => PenjualanLog::EDIT
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
        $record = $this->model->join('users as u', 'u.id', '=', 'penjualans.created_by')->select('penjualans.*', 'id_satker')->findOrFail($id);
        if (!\Gate::allows('verifTk', $record)) {
            abort(403, "Not Allowed.");
        }

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Verifikasi Pengajuan Izin '.$this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [$this->title => route($this->route . '.index'), 'Verif Tk Banding' => null, $record->letter_number => route($this->route . '.verif', $id)];

        $data['data'] = $record;

        $data['backupSimak'] = BackupSimak::latestData($record->created_at);
        $data['barangs'] = $this->usulanBarang($record);
        $data['penandatanganSurat'] = PenandatanganSurat::get();
        $data['isRevisi'] = $record->id_penjualan_status == StatusPenjualan::DITOLAK_ADM || PenjualanLog::whereIdPenjualan($id)->whereIdStatus(PenjualanLog::DITOLAK_ADM)->count() > 0;

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
        $penjualan = $this->model->join('users as u', 'u.id', '=', 'penjualans.created_by')->select('penjualans.*', 'id_satker')->findOrFail($id);
        if (!\Gate::allows('verifTk', $penjualan)) {
            abort(403, "Not Allowed.");
        }

        $isRevisi = $penjualan->id_penjualan_status == StatusPenjualan::DITOLAK_ADM || PenjualanLog::whereIdPenjualan($id)->whereIdStatus(PenjualanLog::DITOLAK_ADM)->count() > 0;
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
            $res = \DB::transaction(function () use ($param, $penjualan) {
                $submit = $param["submit"];
                $keterangan = null;
                if($submit == 0) {
                    $penjualan->id_penjualan_status = StatusPenjualan::DITOLAK_TK;
                    $keterangan = $param["keterangan_veriftk"];
                    $penjualan->keterangan_veriftk = $keterangan;
                    $statusLog = PenjualanLog::DITOLAK_TK;
                    $keterangan = ["keterangan" => $keterangan];
                } else {
                    $paramVerif = [
                        'letter_number_banding' => $param['letter_number_banding'],
                        'letter_date_banding' => Carbon::parse($param['letter_date_banding'])->toDateString(),
                        'perihal_banding' => $param['perihal_banding'],
                        'penandatangan_surat_banding' => $param['penandatangan_surat_banding'],
                    ];


                    $docLocation = $this->model->docLocation($penjualan->id);
                    if($param['surat_penghantar_banding'] != null) {
                        $fileSuratBanding = $param['surat_penghantar_banding'];
                        $filename = time().'-'.str_slug(explode('.', $fileSuratBanding->getClientOriginalName())[0]).'.'.$fileSuratBanding->getClientOriginalExtension();
                        $fileSuratBanding->move($docLocation, $filename);
                        $paramVerif['surat_penghantar_banding'] = $filename;
                    }

                    foreach ($paramVerif as $k => $row) {
                        $penjualan->{$k} = $row;
                    }
                    $penjualan->id_penjualan_status = StatusPenjualan::DITERIMA_TK;

                    $statusLog = PenjualanLog::DITERIMA_TK;
                    $keterangan = $paramVerif;
                }

                if ($penjualan->save()) {
                    PenjualanLog::create([
                        'id_penjualan' => $penjualan->id,
                        'created_by' => \Auth::user()->id,
                        'id_status' => $statusLog,
                        'keterangan' => json_encode($keterangan)
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil men-verifikasi Usulan ' . $this->title . ' dengan No Surat <strong>' . $penjualan->letter_number . '</strong>'
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

        $isDispo = $record->id_penjualan_status == StatusPenjualan::DITERIMA_ADM;
        if($isDispo) {
            $titleDetail = 'Verif Kepala Sub Bagian';
        } else {
            $titleDetail = 'Verif Kepala Bag Adm Penghapusan';
        }

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Verifikasi Pengajuan Izin '.$this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [$this->title => route($this->route . '.index'), $titleDetail => null, $record->letter_number => route($this->route . '.disposisi', $id)];

        $data['data'] = $record;

        $data['backupSimak'] = BackupSimak::latestData($record->created_at);
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
        $penjualan = $this->model->findOrFail($id);
        if (!\Gate::allows('verifKepalaAdm', $penjualan) && !\Gate::allows('dispoKepalaSub', $penjualan)) {
            abort(403, "Not Allowed.");
        }

        $validate = [ 'submit' => 'required' ];
        if($request->input("submit") == 0) {
            $validate['keterangan'] = 'required';
        }

        $param = $request->all();
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $penjualan) {
                $isDispo = $penjualan->id_penjualan_status == StatusPenjualan::DITERIMA_ADM;

                $submit = $param["submit"];
                $keterangan = null;
                if($submit == 0) {
                    $idPenjualanStatus = StatusPenjualan::DITOLAK_ADM;
                    $keterangan = $param["keterangan"];
                    $penjualan->keterangan_verifadm = $keterangan;
                    $statusLog = PenjualanLog::DITOLAK_ADM;
                    $keterangan = ["keterangan" => $keterangan];
                } else {
                    if($isDispo) {
                        $idPenjualanStatus = StatusPenjualan::PROSES;
                        $statusLog = PenjualanLog::PROSES;
                    } else {
                        $idPenjualanStatus = StatusPenjualan::DITERIMA_ADM;
                        $statusLog = PenjualanLog::DITERIMA_ADM;
                    }
                }
                $penjualan->id_penjualan_status = $idPenjualanStatus;

                if ($penjualan->save()) {
                    PenjualanLog::create([
                        'id_penjualan' => $penjualan->id,
                        'created_by' => \Auth::user()->id,
                        'id_status' => $statusLog,
                        'keterangan' => $keterangan == null ? null : json_encode($keterangan)
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil men-verifikasi Usulan ' . $this->title . ' dengan No Surat <strong>' . $penjualan->letter_number . '</strong>'
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
        $data['config']['pageTitle'] = 'Proses Pengajuan Izin '.$this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [$this->title => route($this->route . '.index'), 'Proses' => null, $record->letter_number => route($this->route . '.selesai', $id)];

        $data['data'] = $record;

        $data['backupSimak'] = BackupSimak::latestData($record->created_at);
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
        $penjualan = $this->model->findOrFail($id);
        if (!\Gate::allows('selesai', $penjualan)) {
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
            $res = \DB::transaction(function () use ($param, $penjualan) {
                $paramVerif = [
                    'letter_number_persetujuan' => $param['letter_number_persetujuan'],
                    'letter_date_persetujuan' => Carbon::parse($param['letter_date_persetujuan'])->toDateString(),
                    'perihal_persetujuan' => $param['perihal_persetujuan'],
                ];

                $docLocation = $this->model->docLocation($penjualan->id);
                $fileSurat = $param['surat_persetujuan'];
                $filename = time().'-'.str_slug(explode('.', $fileSurat->getClientOriginalName())[0]).'.'.$fileSurat->getClientOriginalExtension();
                $fileSurat->move($docLocation, $filename);
                $paramVerif['surat_persetujuan'] = $filename;

                foreach ($paramVerif as $k => $row) {
                    $penjualan->{$k} = $row;
                }
                $penjualan->id_penjualan_status = StatusPenjualan::SELESAI;
                $statusLog = PenjualanLog::SELESAI;
                $keterangan = $paramVerif;

                if ($penjualan->save()) {
                    PenjualanLog::create([
                        'id_penjualan' => $penjualan->id,
                        'created_by' => \Auth::user()->id,
                        'id_status' => $statusLog,
                        'keterangan' => json_encode($keterangan)
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil men-verifikasi Usulan ' . $this->title . ' dengan No Surat <strong>' . $penjualan->letter_number . '</strong>'
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
            ->select('s.satker_type', 's.dirjen', 's.kpknl', 's.kanwil as kanwilDjkn', 's.id_wilayah', 's.name as satkerName', 'psb.name as penandatanganTingkatBanding', 'letter_number_banding as noSuratBanding',
                'letter_date_banding as tanggalSuratBanding', 'perihal_banding as perihalSuratBanding', 'total_limit as nilaiLimit')
            ->find($id)->toArray();

        $tingkatBanding = Satker::where('satker_type', $data['satker_type'])->where('type', 'tingkatbanding')
            ->where('id_wilayah', $data['id_wilayah'])->select('name', 'city')->first();

        $data['satkerName'] = ucwords(strtolower($data['satkerName']));
        $data['tanggalSuratBanding'] = bulanReplace(Carbon::parse($data['tanggalSuratBanding'])->format('j F Y'));
        $data['nilaiPerolehan'] = PenjualanBarang::where('id_penjualan', $id)->sum('nilai_perolehan');
        $data['nilaiPerolehanTerbilang'] = terbilang($data['nilaiPerolehan']);
        $data['nilaiLimitTerbilang'] = terbilang($data['nilaiLimit']);
        $data['nilaiLimit'] = numberFormatIndo($data['nilaiLimit']);
        $data['nilaiPerolehan'] = numberFormatIndo($data['nilaiPerolehan']);
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
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function lampiran($id)
    {
        $record = $this->model->join('users as u', 'u.id', $this->model->getTable().'.created_by')
            ->join('satkers as s', 's.id', 'u.id_satker')->select($this->model->getTable().'.*', 's.name as satkerName')
            ->find($id);

        $data['data'] = $record;
        $data['barang'] = $this->usulanBarang($record);

        return \Excel::download(new PenjualanExport($data), 'Lampiran SK Penjualan.xlsx');
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
