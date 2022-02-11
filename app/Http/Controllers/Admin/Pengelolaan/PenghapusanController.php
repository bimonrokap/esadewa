<?php

namespace App\Http\Controllers\Admin\Pengelolaan;

use App\Exports\Usulan\PenghapusanExport;
use App\Http\Controllers\BarangTrait;
use App\Http\Controllers\UsulanController;
use App\Model\CategoryAsset;
use App\Model\DocTemplate;
use App\Model\PenandatanganSurat;
use App\Model\Penghapusan\Penghapusan;
use App\Model\Penghapusan\PenghapusanBarang;
use App\Model\Penghapusan\PenghapusanLog;
use App\Model\Penghapusan\StatusPenghapusan;
use App\Model\Penjualan\Penjualan;
use App\Model\Penjualan\PenjualanBarang;
use App\Model\Penjualan\StatusPenjualan;
use App\Model\Satker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;

class PenghapusanController extends UsulanController
{
    use BarangTrait;

    private $route = 'admin.pengelolaan.penghapusan';
    private $title = 'Penghapusan Mebelair';
    private $permission = 'pengelolaan-penghapusan';
    private $docForm = 'pengelolaan-penghapusan';
    protected $objName = 'penghapusan';

    public function __construct()
    {
        $this->model = new Penghapusan();
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
        $data['table']['header'] = ['No Surat Usulan Satker', 'Satker', 'Tanggal Surat', 'Tanggal Pengajuan', 'Tipe Penghapusan', 'Status'];

        $data['statuses'] = StatusPenghapusan::get();
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
            ->join('penghapusan_statuses as ps', 'ps.id', '=', 'penghapusans.id_penghapusan_status')
            ->select('letter_number', 's.name as satkerName', 'letter_date', 'u.id_satker', 'state', 'penghapusans.created_at', "ps.name as penghapusanStatus", 'id_penghapusan_status', 's.id_wilayah', 'penghapusan_type');

        $user = \Auth::user();
        $dataTable = \Datatable::create($model)
            ->setId($this->model->getTable() . '.id')
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('j F Y, H:s');
            })
            ->editColumn('letter_date', function ($data) {
                return Carbon::parse($data->letter_date)->format('j F Y');
            })
            ->editColumn('penghapusanType', function ($data) {
                return '<span class="m-badge m-badge--'.($data->penghapusan_type == 1 ? 'primary' : 'info').' m-badge--wide">'.($data->penghapusan_type == 1 ? 'Mebelair' : 'Non Mebelair').'</span>';
            })
            ->editColumn('satker', function ($data) {
                return $data->nama_satker . ' ( '.$data->kode_satker.' )';
            })
            ->editColumn('total_nilai_barang', function ($data) {
                return 'Rp '.numberFormatIndo($data->total_nilai_barang);
            })
            ->editColumn('penghapusanStatus', function ($data) {
                return '<span class="m-badge m-badge--'.$data->state.' m-badge--wide">'.$data->penghapusanStatus.'</span>';
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

        $type = $record->penghapusan_type;

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Detail Pengajuan '.$this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [$this->title => route($this->route . '.index'), $record->letter_number => route($this->route . '.show', $id)];

        $data['data'] = $record;
        $isMebelair = $type == Penghapusan::MEBELAIR;
        if(!$isMebelair) {
            $data['kategoriBarang'] = CategoryAsset::penghapusan();
            $data['barangs'] = $this->usulanBarang($record);
        } else {
            $penjualan = Penjualan::findOrFail($record->id_letter_number_penjualan);
            $data['barangs'] = $this->usulanBarang($penjualan, 'penjualan');
            $data['nilaiPerolehan'] = PenjualanBarang::whereIdPenjualan($record->id_letter_number_penjualan)->sum('nilai_perolehan');
        }
        $data['isMebelair'] = $isMebelair;
        $data['type'] = $type;
        $data['penandatanganSurat'] = PenandatanganSurat::get();
        $data['logs'] = $record->log()->with(['user.satker', 'status'])->get();

        return view($this->layout . '.show', $data);
    }

    /**
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($type)
    {
        \Permission::access('create-' . $this->permission);

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Pengajuan '.$this->title . ' : '. ($type == Penghapusan::MEBELAIR ? 'Mebelair' : 'Non Mebelair');
        $data['config']['breadcrumb'] = array_merge($this->breadcrumb, [$this->title => route($this->route . '.index'), 'Pengajuan' => route($this->route . '.create', $type)]);

        $isMebelair = $type == Penghapusan::MEBELAIR;
        if(!$isMebelair) {
            $data['kategoriBarang'] = CategoryAsset::penghapusan();
        }
        $data['isMebelair'] = $isMebelair;
        $data['type'] = $type;
        $data['uuid'] = Str::uuid();
        $data['penandatanganSurat'] = PenandatanganSurat::get();

        return view($this->layout . '.create', $data);
    }

    /**
     * @param Request $request
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request, $type)
    {
        \Permission::access('create-' . $this->permission);

        $validate = [
            'letter_number' => 'required|max:50',
            'letter_date' => 'required|date_format:j F Y',
            'perihal' => 'required',
            'penandatangan_surat' => 'required|exists:penandatangan_surats,id',
            'nilai_perolehan' => 'required|numeric',
            'total_terjual' => 'required|numeric',
            'risalah_lelang_number' => 'required|max:50',
            'risalah_lelang_date' => 'required|date_format:j F Y',
            'penandatangan_risalah' => 'required|max:100',
            'nomor_berita_acara' => 'required|max:50',
            'tanggal_berita_acara' => 'required|date_format:j F Y',

            'surat_pengajuan_satker' => 'required|mimes:pdf|max:5000',
            'risalah_lelang' => 'required|mimes:pdf|max:5000',
            'surat_berita_acara' => 'required|mimes:pdf|max:5000',
            'dokumen_lainnya' => 'nullable|mimes:pdf|max:5000',
        ];

        $isMebelair = $type == Penghapusan::MEBELAIR;
        if($isMebelair) {
            $validate['letter_number_penjualan'] = 'required|exists:penjualans,id';
            $validate['daftar_barang'] = 'nullable|mimes:pdf|max:5000';
            $validate['daftar_barang_rusak'] = 'nullable|mimes:pdf|max:5000';
        } else {
            $validate['letter_number_penjualan'] = 'required|max:50';
            $validate['letter_date_penjualan'] = 'required|date_format:j F Y';
            $validate['perihal_penjualan'] = 'required';
            $validate['surat_izin_penjualan'] = 'required|mimes:pdf|max:5000';
            $validate['total_limit'] = 'required|numeric';
            $validate['daftar_barang'] = 'required|mimes:pdf|max:5000';
            $validate['daftar_barang_rusak'] = 'required|mimes:pdf|max:5000';
        }

        $isSuratKeterangan = false;
        if($isMebelair) {
            $nilaiPerolehan = (int) str_replace(['.', ','], ['', '.'], $request->input('nilai_perolehan', null));
            $dbNilaiPerolehan = (int) PenjualanBarang::whereIdPenjualan($request->input('letter_number_penjualan', null))->sum('nilai_perolehan');
            $isSuratKeterangan = $nilaiPerolehan != $dbNilaiPerolehan;
            if($isSuratKeterangan) {
                $validate['surat_keterangan'] = 'required|mimes:pdf|max:5000';
            }
        } else {
            $idBarang = json_decode($request->input('data'))->id;
            if($idBarang == null){
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Barang tidak boleh Kosong.</ul>'
                ]);
            }
        }

        $user = \Auth::user();

        $param = $this->cleanNumber($request->all(), ['nilai_perolehan', 'total_terjual', 'total_limit']);
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $user, $type, $isMebelair, $isSuratKeterangan) {
                if($isMebelair) {
                    $param['id_letter_number_penjualan'] = $param['letter_number_penjualan'];
                    $param['letter_number_penjualan'] = null;
                } else {
                    $param['letter_date_penjualan'] = Carbon::parse($param['letter_date_penjualan'])->toDateString();
                }
                $param['penghapusan_type'] = $type;
                $param['id_penghapusan_status'] = StatusPenghapusan::PERMOHONAN_SATKER;
                $param['created_by'] = $user->id;
                $param['letter_date'] = Carbon::parse($param['letter_date'])->toDateString();
                $param['risalah_lelang_date'] = Carbon::parse($param['risalah_lelang_date'])->toDateString();
                $param['tanggal_berita_acara'] = Carbon::parse($param['tanggal_berita_acara'])->toDateString();

                $penghapusan = $this->model;
                $penghapusan = $penghapusan->create($param);
                if ($penghapusan) {
                    $docLocation = $this->model->docLocation($penghapusan->id);
                    if(!file_exists($docLocation)) {
                        mkdir($this->model->docLocation($penghapusan->id), 0775, true);
                    }

                    $arrayFile = ['surat_pengajuan_satker', 'risalah_lelang', 'surat_berita_acara', 'dokumen_lainnya', 'daftar_barang','daftar_barang_rusak', 'surat_izin_penjualan'];
                    if($isSuratKeterangan) {
                        $arrayFile[] = 'surat_keterangan';
                    }
                    foreach ($arrayFile as $file) {
                        if(isset($param[$file])) {
                            $fileDoc = $param[$file];
                            $filename = time().'-'.str_slug(explode('.', $fileDoc->getClientOriginalName())[0]).'.'.$fileDoc->getClientOriginalExtension();
                            $fileDoc->move($docLocation, $filename);
                            $penghapusan->{$file} = $filename;
                        }
                    }

                    $penghapusan->save();

                    if($isMebelair) {
                        $penjualan = Penjualan::findOrFail($param['id_letter_number_penjualan']);

                        $penghapusan->jumlah_barang = $penjualan->barangs()->count();
                    } else {
                        $categories = json_decode($param['data'])->category;
                        $idBarang = json_decode($param['data'])->id;
                        $i = 1;
                        foreach ($categories as $key => $cat)
                        {
                            $br = $idBarang[$key];

                            $barang = $this->findBarang($br, $cat);
                            PenghapusanBarang::create([
                                'id_penghapusan' => $penghapusan->id,
                                'id_asset' => $barang->kode_satker . '-' . $barang->kode_barang . '-' . $barang->nup,
                                'id_category_asset' => $cat,
                                'nilai_perolehan' => $barang->nilai_perolehan,
                                'ord' => $i++
                            ]);
                        }

                        $penghapusan->jumlah_barang = $i - 1;
                    }

                    $penghapusan->save();

                    PenghapusanLog::create([
                        'id_penghapusan' => $penghapusan->id,
                        'created_by' => \Auth::user()->id,
                        'id_status' => PenghapusanLog::PERMOHONAN
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

        $record = $this->model->join('users as u', 'u.id', '=', 'penghapusans.created_by')->select('penghapusans.*', 'id_satker')->findOrFail($id);
        if (!\Gate::allows('edit', $record)) {
            abort(403, "Not Allowed.");
        }

        $type = $record->penghapusan_type;

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Ubah Pengajuan '.$this->title . ' : ' . $record->letter_number .' ( ' . ($type == Penghapusan::MEBELAIR ? 'Mebelair' : 'Non Mebelair').')';
        $data['config']['breadcrumb'] = $this->breadcrumb + [$this->title => route($this->route . '.index'), 'Edit' => null, $record->letter_number => route($this->route . '.edit', $id)];

        $data['data'] = $record;
        $isMebelair = $type == Penghapusan::MEBELAIR;
        if(!$isMebelair) {
            $data['kategoriBarang'] = CategoryAsset::penghapusan();
            $data['barangs'] = $this->usulanBarang($record);
        } else {
            $penjualan = Penjualan::findOrFail($record->id_letter_number_penjualan);
            $data['barangs'] = $this->usulanBarang($penjualan, 'penjualan');
            $data['nilaiPerolehan'] = PenjualanBarang::whereIdPenjualan($record->id_letter_number_penjualan)->sum('nilai_perolehan');
        }
        $data['isMebelair'] = $isMebelair;
        $data['type'] = $type;
        $data['uuid'] = Str::uuid();
        $data['penandatanganSurat'] = PenandatanganSurat::get();
        $data['isRevisi'] = $record->id_penghapusan_status == StatusPenghapusan::DITOLAK_TK || PenghapusanLog::whereIdPenghapusan($id)->whereIdStatus(PenghapusanLog::DITOLAK_TK)->count() > 0;

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

        $penghapusan = $this->model->join('users as u', 'u.id', '=', 'penghapusans.created_by')->select('penghapusans.*', 'id_satker')->findOrFail($id);
        if (!\Gate::allows('edit', $penghapusan)) {
            abort(403, "Not Allowed.");
        }

        $type = $penghapusan['penghapusan_type'];

        $validate = [
            'letter_number' => 'required|max:50',
            'letter_date' => 'required|date_format:j F Y',
            'perihal' => 'required',
            'penandatangan_surat' => 'required|exists:penandatangan_surats,id',
            'nilai_perolehan' => 'required|numeric',
            'total_terjual' => 'required|numeric',
            'risalah_lelang_number' => 'required|max:50',
            'risalah_lelang_date' => 'required|date_format:j F Y',
            'penandatangan_risalah' => 'required|max:100',
            'nomor_berita_acara' => 'required|max:50',
            'tanggal_berita_acara' => 'required|date_format:j F Y',

            'surat_pengajuan_satker' => 'nullable|mimes:pdf|max:5000',
            'risalah_lelang' => 'nullable|mimes:pdf|max:5000',
            'surat_berita_acara' => 'nullable|mimes:pdf|max:5000',
            'dokumen_lainnya' => 'nullable|mimes:pdf|max:5000',
        ];

        $isMebelair = $type == Penghapusan::MEBELAIR;
        if($isMebelair) {
            $validate['letter_number_penjualan'] = 'required|exists:penjualans,id';
            $validate['daftar_barang'] = 'nullable|mimes:pdf|max:5000';
            $validate['daftar_barang_rusak'] = 'nullable|mimes:pdf|max:5000';
        } else {
            $validate['letter_number_penjualan'] = 'required|max:50';
            $validate['letter_date_penjualan'] = 'required|date_format:j F Y';
            $validate['perihal_penjualan'] = 'required';
            $validate['surat_izin_penjualan'] = 'nullable|mimes:pdf|max:5000';
            $validate['total_limit'] = 'required|numeric';
            $validate['daftar_barang'] = 'nullable|mimes:pdf|max:5000';
            $validate['daftar_barang_rusak'] = 'nullable|mimes:pdf|max:5000';
        }

        $isSuratKeterangan = false;
        if($isMebelair) {
            $nilaiPerolehan = (int) str_replace(['.', ','], ['', '.'], $request->input('nilai_perolehan', null));
            $dbNilaiPerolehan = (int) PenjualanBarang::whereIdPenjualan($request->input('letter_number_penjualan', null))->sum('nilai_perolehan');
            $isSuratKeterangan = $nilaiPerolehan != $dbNilaiPerolehan;
            if($isSuratKeterangan) {
                $validate['surat_keterangan'] = 'required|mimes:pdf|max:5000';
            }
        } else {
            $idBarang = json_decode($request->input('data'))->id;
            if($idBarang == null){
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Barang tidak boleh Kosong.</ul>'
                ]);
            }
        }

        $param = $this->cleanNumber($request->all(), ['nilai_perolehan', 'total_terjual', 'total_limit']);
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $penghapusan, $type, $isMebelair, $isSuratKeterangan) {
                $penghapusan->letter_number = $param['letter_number'];
                $penghapusan->letter_date = Carbon::parse($param['letter_date'])->toDateString();
                $penghapusan->perihal = $param['perihal'];
                $penghapusan->penandatangan_surat = $param['penandatangan_surat'];
                $penghapusan->nilai_perolehan = $param['nilai_perolehan'];
                $penghapusan->total_terjual = $param['total_terjual'];
                $penghapusan->risalah_lelang_number = $param['risalah_lelang_number'];
                $penghapusan->risalah_lelang_date = Carbon::parse($param['risalah_lelang_date'])->toDateString();;
                $penghapusan->penandatangan_risalah = $param['penandatangan_risalah'];
                $penghapusan->nomor_berita_acara = $param['nomor_berita_acara'];
                $penghapusan->tanggal_berita_acara = Carbon::parse($param['tanggal_berita_acara'])->toDateString();;

                if($penghapusan->id_penghapusan_status == StatusPenghapusan::DITOLAK_TK) {
                    $penghapusan->id_penghapusan_status = StatusPenghapusan::PERMOHONAN_SATKER;
                }

                $docLocation = $this->model->docLocation($penghapusan->id);
                if(!file_exists($docLocation)) {
                    mkdir($this->model->docLocation($penghapusan->id), 0775, true);
                }

                $arrayFile = ['surat_pengajuan_satker', 'risalah_lelang', 'surat_berita_acara', 'dokumen_lainnya', 'daftar_barang','daftar_barang_rusak', 'surat_izin_penjualan'];
                if($isSuratKeterangan) {
                    $arrayFile[] = 'surat_keterangan';
                }
                foreach ($arrayFile as $file) {
                    if(isset($param[$file])) {
                        $fileDoc = $param[$file];
                        $filename = time().'-'.str_slug(explode('.', $fileDoc->getClientOriginalName())[0]).'.'.$fileDoc->getClientOriginalExtension();
                        $fileDoc->move($docLocation, $filename);
                        $penghapusan->{$file} = $filename;
                    }
                }

                if ($penghapusan->save()) {
                    if(!$isMebelair) {
                        $categories = json_decode($param['data'])->category;
                        $idBarang = json_decode($param['data'])->id;
                        PenghapusanBarang::whereIdPenghapusan($penghapusan->id)->delete();
                        $i = 1;
                        foreach ($categories as $key => $cat)
                        {
                            $br = $idBarang[$key];

                            $barang = $this->findBarang($br, $cat);
                            PenghapusanBarang::create([
                                'id_penghapusan' => $penghapusan->id,
                                'id_asset' => $barang->kode_satker . '-' . $barang->kode_barang . '-' . $barang->nup,
                                'id_category_asset' => $cat,
                                'nilai_perolehan' => $barang->nilai_perolehan,
                                'ord' => $i++
                            ]);
                        }
                    }

                    PenghapusanLog::create([
                        'id_penghapusan' => $penghapusan->id,
                        'created_by' => \Auth::user()->id,
                        'id_status' => PenghapusanLog::EDIT
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
        $record = $this->model->join('users as u', 'u.id', '=', 'penghapusans.created_by')->select('penghapusans.*', 'id_satker')->findOrFail($id);
        if (!\Gate::allows('verifTk', $record)) {
            abort(403, "Not Allowed.");
        }

        $type = $record->penghapusan_type;

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Verifikasi Pengajuan '.$this->title . ' : ' . $record->letter_number .' ( ' . ($type == Penghapusan::MEBELAIR ? 'Mebelair' : 'Non Mebelair').')';
        $data['config']['breadcrumb'] = $this->breadcrumb + [$this->title => route($this->route . '.index'), 'Verif Tk Banding' => null, $record->letter_number => route($this->route . '.verif', $id)];

        $data['data'] = $record;
        $isMebelair = $type == Penghapusan::MEBELAIR;
        if(!$isMebelair) {
            $data['kategoriBarang'] = CategoryAsset::penghapusan();
            $data['barangs'] = $this->usulanBarang($record);
        } else {
            $penjualan = Penjualan::findOrFail($record->id_letter_number_penjualan);
            $data['barangs'] = $this->usulanBarang($penjualan, 'penjualan');
            $data['nilaiPerolehan'] = PenjualanBarang::whereIdPenjualan($record->id_letter_number_penjualan)->sum('nilai_perolehan');
        }
        $data['isMebelair'] = $isMebelair;
        $data['type'] = $type;
        $data['penandatanganSurat'] = PenandatanganSurat::get();
        $data['isRevisi'] = $record->id_penghapusan_status == StatusPenghapusan::DITOLAK_ADM || PenghapusanLog::whereIdPenghapusan($id)->whereIdStatus(PenghapusanLog::DITOLAK_ADM)->count() > 0;

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
        $penghapusan = $this->model->join('users as u', 'u.id', '=', 'penghapusans.created_by')->select('penghapusans.*', 'id_satker')->findOrFail($id);
        if (!\Gate::allows('verifTk', $penghapusan)) {
            abort(403, "Not Allowed.");
        }

        $isRevisi = $penghapusan->id_penghapusan_status == StatusPenghapusan::DITOLAK_ADM || PenghapusanLog::whereIdPenghapusan($id)->whereIdStatus(PenghapusanLog::DITOLAK_ADM)->count() > 0;
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
            $res = \DB::transaction(function () use ($param, $penghapusan) {
                $submit = $param["submit"];
                $keterangan = null;
                if($submit == 0) {
                    $penghapusan->id_penghapusan_status = StatusPenghapusan::DITOLAK_TK;
                    $keterangan = $param["keterangan_veriftk"];
                    $penghapusan->keterangan_veriftk = $keterangan;
                    $statusLog = PenghapusanLog::DITOLAK_TK;
                    $keterangan = ["keterangan" => $keterangan];
                } else {
                    $paramVerif = [
                        'letter_number_banding' => $param['letter_number_banding'],
                        'letter_date_banding' => Carbon::parse($param['letter_date_banding'])->toDateString(),
                        'perihal_banding' => $param['perihal_banding'],
                        'penandatangan_surat_banding' => $param['penandatangan_surat_banding'],
                    ];


                    $docLocation = $this->model->docLocation($penghapusan->id);
                    if($param['surat_penghantar_banding'] != null) {
                        $fileSuratBanding = $param['surat_penghantar_banding'];
                        $filename = time().'-'.str_slug(explode('.', $fileSuratBanding->getClientOriginalName())[0]).'.'.$fileSuratBanding->getClientOriginalExtension();
                        $fileSuratBanding->move($docLocation, $filename);
                        $paramVerif['surat_penghantar_banding'] = $filename;
                    }

                    foreach ($paramVerif as $k => $row) {
                        $penghapusan->{$k} = $row;
                    }
                    $penghapusan->id_penghapusan_status = StatusPenghapusan::DITERIMA_TK;

                    $statusLog = PenghapusanLog::DITERIMA_TK;
                    $keterangan = $paramVerif;
                }

                if ($penghapusan->save()) {
                    PenghapusanLog::create([
                        'id_penghapusan' => $penghapusan->id,
                        'created_by' => \Auth::user()->id,
                        'id_status' => $statusLog,
                        'keterangan' => json_encode($keterangan)
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil men-verifikasi Usulan ' . $this->title . ' dengan No Surat <strong>' . $penghapusan->letter_number . '</strong>'
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

        $type = $record->penghapusan_type;

        $isDispo = $record->id_penghapusan_status == StatusPenghapusan::DITERIMA_ADM;
        if($isDispo) {
            $titleDetail = 'Verif Kepala Sub Bagian';
        } else {
            $titleDetail = 'Verif Kepala Bag Adm Penghapusan';
        }

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Verifikasi Pengajuan '.$this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [$this->title => route($this->route . '.index'), $titleDetail => null, $record->letter_number => route($this->route . '.disposisi', $id)];

        $data['data'] = $record;
        $isMebelair = $type == Penghapusan::MEBELAIR;
        if(!$isMebelair) {
            $data['kategoriBarang'] = CategoryAsset::penghapusan();
            $data['barangs'] = $this->usulanBarang($record);
        } else {
            $penjualan = Penjualan::findOrFail($record->id_letter_number_penjualan);
            $data['barangs'] = $this->usulanBarang($penjualan, 'penjualan');
            $data['nilaiPerolehan'] = PenjualanBarang::whereIdPenjualan($record->id_letter_number_penjualan)->sum('nilai_perolehan');
        }
        $data['isMebelair'] = $isMebelair;
        $data['type'] = $type;
        $data['penandatanganSurat'] = PenandatanganSurat::get();
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
        $penghapusan = $this->model->findOrFail($id);
        if (!\Gate::allows('verifKepalaAdm', $penghapusan) && !\Gate::allows('dispoKepalaSub', $penghapusan)) {
            abort(403, "Not Allowed.");
        }

        $validate = [ 'submit' => 'required' ];
        if($request->input("submit") == 0) {
            $validate['keterangan'] = 'required';
        }

        $param = $request->all();
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $penghapusan) {
                $isDispo = $penghapusan->id_penghapusan_status == StatusPenghapusan::DITERIMA_ADM;

                $submit = $param["submit"];
                $keterangan = null;
                if($submit == 0) {
                    $idPenghapusanStatus = StatusPenghapusan::DITOLAK_ADM;
                    $keterangan = $param["keterangan"];
                    $penghapusan->keterangan_verifadm = $keterangan;
                    $statusLog = PenghapusanLog::DITOLAK_ADM;
                    $keterangan = ["keterangan" => $keterangan];
                } else {
                    if($isDispo) {
                        $idPenghapusanStatus = StatusPenghapusan::PROSES;
                        $statusLog = PenghapusanLog::PROSES;
                    } else {
                        $idPenghapusanStatus = StatusPenghapusan::DITERIMA_ADM;
                        $statusLog = PenghapusanLog::DITERIMA_ADM;
                    }
                }
                $penghapusan->id_penghapusan_status = $idPenghapusanStatus;

                if ($penghapusan->save()) {
                    PenghapusanLog::create([
                        'id_penghapusan' => $penghapusan->id,
                        'created_by' => \Auth::user()->id,
                        'id_status' => $statusLog,
                        'keterangan' => $keterangan == null ? null : json_encode($keterangan)
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil men-verifikasi Usulan ' . $this->title . ' dengan No Surat <strong>' . $penghapusan->letter_number . '</strong>'
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

        $type = $record->penghapusan_type;

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Proses Pengajuan '.$this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [$this->title => route($this->route . '.index'), 'Proses' => null, $record->letter_number => route($this->route . '.selesai', $id)];

        $data['data'] = $record;
        $isMebelair = $type == Penghapusan::MEBELAIR;
        if(!$isMebelair) {
            $data['kategoriBarang'] = CategoryAsset::penghapusan();
            $data['barangs'] = $this->usulanBarang($record);
        } else {
            $penjualan = Penjualan::findOrFail($record->id_letter_number_penjualan);
            $data['barangs'] = $this->usulanBarang($penjualan, 'penjualan');
            $data['nilaiPerolehan'] = PenjualanBarang::whereIdPenjualan($record->id_letter_number_penjualan)->sum('nilai_perolehan');
        }
        $data['isMebelair'] = $isMebelair;
        $data['type'] = $type;
        $data['penandatanganSurat'] = PenandatanganSurat::get();

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
        $penghapusan = $this->model->findOrFail($id);
        if (!\Gate::allows('selesai', $penghapusan)) {
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
            $res = \DB::transaction(function () use ($param, $penghapusan) {
                $paramVerif = [
                    'letter_number_persetujuan' => $param['letter_number_persetujuan'],
                    'letter_date_persetujuan' => Carbon::parse($param['letter_date_persetujuan'])->toDateString(),
                    'perihal_persetujuan' => $param['perihal_persetujuan'],
                ];

                $docLocation = $this->model->docLocation($penghapusan->id);
                $fileSurat = $param['surat_persetujuan'];
                $filename = time().'-'.str_slug(explode('.', $fileSurat->getClientOriginalName())[0]).'.'.$fileSurat->getClientOriginalExtension();
                $fileSurat->move($docLocation, $filename);
                $paramVerif['surat_persetujuan'] = $filename;

                foreach ($paramVerif as $k => $row) {
                    $penghapusan->{$k} = $row;
                }
                $penghapusan->id_penghapusan_status = StatusPenghapusan::SELESAI;
                $statusLog = PenghapusanLog::SELESAI;
                $keterangan = $paramVerif;

                if ($penghapusan->save()) {
                    PenghapusanLog::create([
                        'id_penghapusan' => $penghapusan->id,
                        'created_by' => \Auth::user()->id,
                        'id_status' => $statusLog,
                        'keterangan' => json_encode($keterangan)
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil men-verifikasi Usulan ' . $this->title . ' dengan No Surat <strong>' . $penghapusan->letter_number . '</strong>'
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function penjualan(Request $request)
    {
        $search = $request->input('search', null);
        $penjualan = Penjualan::where('letter_number', 'like', "%$search%")
            ->usulanBy()
            ->join('users as u', 'u.id', 'penjualans.created_by')
            ->where('u.id_satker', \Auth::user()->id_satker)
            ->where('id_penjualan_status', StatusPenjualan::SELESAI)
            ->limit(10)->select('penjualans.id', 'letter_number as text')->get();

        return response()->json(['results' => $penjualan]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detailPenjualan($id)
    {
        $tmp = Penjualan::join('users as u', 'u.id', 'penjualans.created_by')
            ->where('u.id_satker', \Auth::user()->id_satker)
            ->select('penjualans.id', 'letter_date', 'perihal', 'total_limit', 'surat_persetujuan')
            ->findOrFail($id);

        $penjualan = $tmp->toArray();

        $penjualan['letter_date'] = Carbon::parse($penjualan['letter_date'])->format('j F Y');
        $penjualan['surat_persetujuan'] = Penjualan::docLocation($id, $penjualan['surat_persetujuan'], true);
        $nilaiPerolehan = PenjualanBarang::whereIdPenjualan($id)->sum('nilai_perolehan');
        $barang = $this->usulanBarang($tmp, 'penjualan');

        return response()->json(['data' => $penjualan, 'nilaiPerolehan' => $nilaiPerolehan, 'barang' => $barang]);
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
                'letter_date_banding as tanggalSuratBanding', 'perihal_banding as perihalSuratBanding', 's.name as satkerName',
                'letter_number_persetujuan as noSuratPersetujuan', 'letter_date_persetujuan as tanggalSuratPersetujuan', 'perihal_persetujuan as perihalSuratPersetujuan',
                'risalah_lelang_number as noRisalahLelang', 'risalah_lelang_date as tanggalRisalahLelang', 'penghapusan_type',
                'id_letter_number_penjualan', 'penghapusans.id as id_penghapusan',
                'nomor_berita_acara as noBast', 'tanggal_berita_acara as tanggalBast', 'total_terjual as totalNilaiTerjual')
            ->find($id)->toArray();

        $tingkatBanding = Satker::where('satker_type', $data['satker_type'])->where('type', 'tingkatbanding')
            ->where('id_wilayah', $data['id_wilayah'])->select('name', 'city')->first();

        $data['satkerName'] = ucwords(strtolower($data['satkerName']));
        $data['satkerNameUpper'] = strtoupper($data['satkerName']);
        $data['tanggalSuratBanding'] = bulanReplace(Carbon::parse($data['tanggalSuratBanding'])->format('j F Y'));
        $data['tingkatBandingName'] = !is_null($tingkatBanding) ? ucwords(strtolower($tingkatBanding->name)) : 'empty';
        $data['tingkatBandingCity'] = !is_null($tingkatBanding) ? $tingkatBanding->city : 'empty';
        $data['tanggalSuratPersetujuan'] = bulanReplace(Carbon::parse($data['tanggalSuratPersetujuan'])->format('j F Y'));
        $data['tanggalRisalahLelang'] = bulanReplace(Carbon::parse($data['tanggalRisalahLelang'])->format('j F Y'));
        $data['tanggalBast'] = bulanReplace(Carbon::parse($data['tanggalBast'])->format('j F Y'));
        $data['totalNilaiTerjualTerbilang'] = terbilang($data['totalNilaiTerjual']);
        $data['totalNilaiTerjual'] = numberFormatIndo($data['totalNilaiTerjual']);

        if($data['penghapusan_type'] == 1) { // MEBELAIR
            $data['jenisBmn'] = PenjualanBarang::where('id_penjualan', $data['id_letter_number_penjualan'])
                ->join('category_assets', 'category_assets.id', '=', 'id_category_asset')->select('category_assets.name')->get()->pluck('name')->unique()->implode(', ');
        } else { // NON MEBELAIR
            $data['jenisBmn'] = PenghapusanBarang::where('id_penghapusan', $data['id_penghapusan'])
                ->join('category_assets', 'category_assets.id', '=', 'id_category_asset')->select('category_assets.name')->get()->pluck('name')->unique()->implode(', ');
        }

        $data['jenisBmnUpper'] = strtoupper($data['jenisBmn']);

        $templateProcessor = new TemplateProcessor(\Storage::path('usulan/template/'.$document));
        foreach ($params as $param) {
            if(isset($data[$param['value']])) {
                $templateProcessor->setValue($param['name'], htmlspecialchars($data[$param['value']]));
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
        if($record->penghapusan_type == 1) {
            $penjualan = Penjualan::find($record->id_letter_number_penjualan);
            $data['barang'] = $this->usulanBarang($penjualan, 'penjualan');
        } else {
            $data['barang'] = $this->usulanBarang($record);
        }

        return \Excel::download(new PenghapusanExport($data), 'Lampiran SK Penghapusan.xlsx');
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
