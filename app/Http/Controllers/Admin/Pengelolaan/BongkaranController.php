<?php

namespace App\Http\Controllers\Admin\Pengelolaan;

use App\Exports\Usulan\BongkaranExport;
use App\Http\Controllers\BarangTrait;
use App\Http\Controllers\UsulanController;
use App\Model\Bongkaran\BongkaranBarang;
use App\Model\Bongkaran\BongkaranBarangUraian;
use App\Model\Bongkaran\BongkaranSumberDana;
use App\Model\CategoryAsset;
use App\Model\DocTemplate;
use App\Model\ImageTmp;
use App\Model\PenandatanganSurat;
use App\Model\Bongkaran\BongkaranFoto;
use App\Model\Bongkaran\BongkaranLog;
use App\Model\Bongkaran\StatusBongkaran;
use App\Model\Bongkaran\Bongkaran;
use App\Model\Satker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;

class BongkaranController extends UsulanController
{
    use BarangTrait;

    private $route = 'admin.pengelolaan.bongkaran';
    private $title = 'Penjualan Bongkaran';
    private $permission = 'pengelolaan-bongkaran';
    private $docForm = 'pengelolaan-bongkaran';
    protected $objName = 'bongkaran';

    public function __construct()
    {
        $this->model = new Bongkaran();
        $this->layout = $this->route;
        $this->breadcrumb = ['Pengelolaan BMN' => null];
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
        \Permission::access('view-' . $this->permission);

        $data['config'] = $this->config;
        $data['config']['breadcrumb'] = array_merge($this->breadcrumb,
            [$this->title => route($this->route . '.index')]);
        $data['table']['header'] = ['No Surat Usulan Satker', 'Satker', 'Tanggal Surat', 'Tanggal Pengajuan', 'Status'];

        $data['statuses'] = StatusBongkaran::get();
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
            ->join('bongkaran_statuses as ps', 'ps.id', '=', 'bongkarans.id_bongkaran_status')
            ->select('letter_number', 's.name as satkerName', 'letter_date', 'u.id_satker', 'state',
                'bongkarans.created_at', "ps.name as bongkaranStatus", 'id_bongkaran_status', 's.id_wilayah');

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
                return $data->nama_satker . ' ( ' . $data->kode_satker . ' )';
            })
            ->editColumn('bongkaranStatus', function ($data) {
                return '<span class="m-badge m-badge--' . $data->state . ' m-badge--wide">' . $data->bongkaranStatus . '</span>';
            })
            ->editColumn('action', function ($data) use ($user) {
                $html = '<a href="' . route($this->route . '.show',
                        $data->id) . '" class="ajaxify"><button class="btn btn-primary m-btn btn-sm m-btn--icon"> <i class="la la-eye"></i> </button></a> ';
                if ($user->can('edit', $data)) {
                    $html .= '<a href="' . route($this->route . '.edit',
                            $data->id) . '" class="ajaxify"><button class="btn btn-info m-btn btn-sm m-btn--icon"> <i class="la la-pencil"></i> Edit </button></a> ';
                }
                if ($user->can('verifTk', $data)) {
                    $html .= '<a class="btn btn-warning m-btn btn-sm m-btn--icon ajaxify" href="' . route($this->route . '.verif',
                            $data->id) . '"> <i class="la la-codepen"></i> Verif </a>';
                } else {
                    if ($user->can('verifKepalaAdm', $data)) {
                        $html .= '<a class="btn btn-info m-btn btn-sm m-btn--icon ajaxify" href="' . route($this->route . '.disposisi',
                                $data->id) . '"> <i class="la la-check"></i> Disposisi </a>';
                    } else {
                        if ($user->can('dispoKepalaSub', $data)) {
                            $html .= '<a class="btn btn-info m-btn btn-sm m-btn--icon ajaxify" href="' . route($this->route . '.disposisi',
                                    $data->id) . '"> <i class="la la-check"></i> Disposisi </a>';
                        } else {
                            if ($user->can('selesai', $data)) {
                                $html .= '<a class="btn btn-info m-btn btn-sm m-btn--icon ajaxify" href="' . route($this->route . '.selesai',
                                        $data->id) . '"> <i class="la la-check-circle"></i> Proses </a>';
                            } else {
                                if ($user->can('tindaklanjut', $data)) {
                                    $html .= '<a class="btn btn-success m-btn btn-sm m-btn--icon ajaxify" href="' . route($this->route . '.tindakLanjut',
                                            $data->id) . '"> <i class="la la-check-square"></i> Tindak Lanjut </a>';
                                }
                            }
                        }
                    }
                }

                return $html == '' ? '#' : $html;
            })
            ->filterColumn('satker', function ($query, $search) {
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
        $data['config']['pageTitle'] = 'Detail Pengajuan ' . $this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [
                $this->title           => route($this->route . '.index'),
                $record->letter_number => route($this->route . '.show', $id)
            ];

        $data['data'] = $record;
        $data['barangs'] = $this->usulanBarang($record);
        $data['uraians'] = BongkaranBarangUraian::whereIn('id_bongkaran_barang', $record->barangs->pluck('id')->toArray())->select('id_bongkaran_barang', 'uraian', 'jumlah', 'satuan')->get()->groupBy('id_bongkaran_barang')->all();
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
        $data['config']['pageTitle'] = 'Pengajuan ' . $this->title;
        $data['config']['breadcrumb'] = array_merge($this->breadcrumb,
            [$this->title => route($this->route . '.index'), 'Pengajuan' => route($this->route . '.create')]);

        $data['kategoriBarang'] = CategoryAsset::bongkaran();
        $data['sumberDana'] = BongkaranSumberDana::get();
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
            'letter_number'       => 'required|max:50',
            'letter_date'         => 'required|date_format:j F Y',
            'perihal'             => 'required',
            'penandatangan_surat' => 'required|exists:penandatangan_surats,id',

            'luas_bangunan.*'             => 'required|numeric',
            'uraian.*'                    => 'required|array',
            'uraian.*.*'                  => 'required|max:100',
            'jumlah.*'                    => 'required|array',
            'jumlah.*.*'                  => 'required|numeric',
            'satuan.*'                    => 'required|array',

            'sumber_dana'                 => 'required|exists:bongkaran_sumber_danas,id',
            'nilai_taksiran'              => 'required|numeric',
            'surat_pengajuan_satker'      => 'required|mimes:pdf|max:5000',
            'penetapan_status_penggunaan' => 'required|mimes:pdf|max:5000',
            'kib_bangunan'                => 'required|mimes:pdf|max:5000',
            'sk_panitia_bongkaran'        => 'required|mimes:pdf|max:5000',
            'dokumen_penganggaran'        => 'nullable|mimes:pdf|max:5000',
            'penetapan_nilai_taksiran'    => 'required|mimes:pdf|max:5000',
        ];

        $user = \Auth::user();
        $idBarang = json_decode($request->input('data'))->id;
        if ($idBarang == null) {
            return response()->json([
                'status'  => 2,
                'message' => '<ul class="m--marginless">Barang tidak boleh Kosong.</ul>'
            ]);
        } else {
            $jml = ImageTmp::where("uuid", $request->input("uuid"))->count();
            if ($jml > self::maxFoto) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Jumlah foto melebihi dari ' . self::maxFoto . '.</ul>'
                ]);
            } else {
                if ($jml == 0) {
                    return response()->json([
                        'status'  => 2,
                        'message' => '<ul class="m--marginless">Foto tidak boleh kosong.</ul>'
                    ]);
                }
            }
        }

        $param = $this->cleanNumber($request->all(), ['luas_bangunan', 'nilai_taksiran', 'jumlah']);
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $user) {
                $param['id_bongkaran_status'] = StatusBongkaran::PERMOHONAN_SATKER;
                $param['created_by'] = $user->id;
                $param['letter_date'] = Carbon::parse($param['letter_date'])->toDateString();

                $bongkaran = $this->model;
                $bongkaran = $bongkaran->create($param);
                if ($bongkaran) {
                    // Create Directory
                    $docLocation = $this->model->docLocation($bongkaran->id);
                    if (!file_exists($docLocation)) {
                        mkdir($this->model->docLocation($bongkaran->id), 0775, true);
                    }

                    // Upload File
                    $arrayFile = [
                        'surat_pengajuan_satker',
                        'penetapan_status_penggunaan',
                        'kib_bangunan',
                        'sk_panitia_bongkaran',
                        'dokumen_penganggaran',
                        'penetapan_nilai_taksiran'
                    ];
                    foreach ($arrayFile as $file) {
                        if (isset($param[$file])) {
                            $fileDoc = $param[$file];
                            $filename = time() . '-' . str_slug(explode('.',
                                    $fileDoc->getClientOriginalName())[0]) . '.' . $fileDoc->getClientOriginalExtension();
                            $fileDoc->move($docLocation, $filename);
                            $bongkaran->{$file} = $filename;
                        }
                    }

                    $bongkaran->save();

                    // Upload Image
                    $images = ImageTmp::where("uuid", $param["uuid"])->get();
                    foreach ($images as $image) {
                        if (file_exists(ImageTmp::imageLocation() . "/" . $image->file)) {
                            if (!file_exists(BongkaranFoto::imageLocation($bongkaran->id))) {
                                mkdir(BongkaranFoto::imageLocation($bongkaran->id), 0775, true);
                            }
                            rename(ImageTmp::imageLocation() . "/" . $image->file,
                                BongkaranFoto::imageLocation($bongkaran->id) . "/" . $image->file);
                        }

                        BongkaranFoto::create([
                            'id_bongkaran' => $bongkaran->id,
                            'foto'         => $image->file,
                        ]);

                        $image->delete();
                    }

                    // Upload Barang
                    $categories = json_decode($param['data'])->category;
                    $idBarang = json_decode($param['data'])->id;
                    $i = 1;
                    foreach ($categories as $key => $cat) {
                        $br = $idBarang[$key];

                        $barang = $this->findBarang($br, $cat);
                        $bongkaranBarang = BongkaranBarang::create([
                            'id_bongkaran'      => $bongkaran->id,
                            'id_asset'          => $barang->kode_satker . '-' . $barang->kode_barang . '-' . $barang->nup,
                            'id_category_asset' => $cat,
                            'nilai_perolehan'   => $barang->nilai_perolehan,
                            'ord'               => $i++,
                            'luas_bangunan'     => $param['luas_bangunan'][$key]
                        ]);

                        $uraian = array_shift($param['uraian']);
                        $jumlah = array_shift($param['jumlah']);
                        $satuan = array_shift($param['satuan']);

                        foreach ($uraian as $j => $u) {
                            $jml = $jumlah[$j];
                            $sat = $satuan[$j];
                            BongkaranBarangUraian::create([
                                'id_bongkaran_barang' => $bongkaranBarang->id,
                                'uraian' => $u,
                                'jumlah' => $jml,
                                'satuan' => $sat
                            ]);
                        }
                    }

                    // Log
                    BongkaranLog::create([
                        'id_bongkaran' => $bongkaran->id,
                        'created_by'   => \Auth::user()->id,
                        'id_status'    => BongkaranLog::PERMOHONAN
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

        $record = $this->model->join('users as u', 'u.id', '=',
            $this->model->getTable() . '.created_by')->select($this->model->getTable() . '.*',
            'id_satker')->findOrFail($id);
        if (!\Gate::allows('edit', $record)) {
            abort(403, "Not Allowed.");
        }

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Ubah Pengajuan ' . $this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [
                $this->title           => route($this->route . '.index'),
                'Edit'                 => null,
                $record->letter_number => route($this->route . '.edit', $id)
            ];

        $data['data'] = $record;

        $data['kategoriBarang'] = CategoryAsset::bongkaran();
        $data['sumberDana'] = BongkaranSumberDana::get();
        $data['uuid'] = Str::uuid();
        $data['penandatanganSurat'] = PenandatanganSurat::get();
        $data['barangs'] = $this->usulanBarang($record);
        $data['uraians'] = BongkaranBarangUraian::whereIn('id_bongkaran_barang', $record->barangs->pluck('id')->toArray())->select('id_bongkaran_barang', 'uraian', 'jumlah', 'satuan')->get()->groupBy('id_bongkaran_barang')->all();
        $data['isRevisi'] = $record->id_bongkaran_status == StatusBongkaran::DITOLAK_TK || BongkaranLog::whereIdBongkaran($id)->whereIdStatus(BongkaranLog::DITOLAK_TK)->count() > 0;

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

        $bongkaran = $this->model->join('users as u', 'u.id', '=',
            $this->model->getTable() . '.created_by')->select($this->model->getTable() . '.*',
            'id_satker')->findOrFail($id);
        if (!\Gate::allows('edit', $bongkaran)) {
            abort(403, "Not Allowed.");
        }

        $validate = [
            'letter_number'       => 'required|max:50',
            'letter_date'         => 'required|date_format:j F Y',
            'perihal'             => 'required',
            'penandatangan_surat' => 'required|exists:penandatangan_surats,id',

            'luas_bangunan.*'             => 'required|numeric',
            'uraian.*'                    => 'required|array',
            'uraian.*.*'                  => 'required|max:100',
            'jumlah.*'                    => 'required|array',
            'jumlah.*.*'                  => 'required|numeric',
            'satuan.*'                    => 'required|array',

            'sumber_dana'                 => 'required|exists:bongkaran_sumber_danas,id',
            'nilai_taksiran'              => 'required|numeric',
            'surat_pengajuan_satker'      => 'nullable|mimes:pdf|max:5000',
            'penetapan_status_penggunaan' => 'nullable|mimes:pdf|max:5000',
            'kib_bangunan'                => 'nullable|mimes:pdf|max:5000',
            'sk_panitia_bongkaran'        => 'nullable|mimes:pdf|max:5000',
            'dokumen_penganggaran'        => 'nullable|mimes:pdf|max:5000',
            'penetapan_nilai_taksiran'    => 'nullable|mimes:pdf|max:5000',
        ];

        $idBarang = json_decode($request->input('data'))->id;
        if ($idBarang == null) {
            return response()->json([
                'status'  => 2,
                'message' => '<ul class="m--marginless">Barang tidak boleh Kosong.</ul>'
            ]);
        } else {
            $imageDb = BongkaranFoto::where('id_bongkaran', $id)->count();
            $jml = ImageTmp::where("uuid", $request->input("uuid"))->count() + $imageDb;
            if ($jml > self::maxFoto) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Jumlah foto melebihi dari ' . self::maxFoto . '.</ul>'
                ]);
            } else {
                if ($jml == 0) {
                    return response()->json([
                        'status'  => 2,
                        'message' => '<ul class="m--marginless">Foto tidak boleh kosong.</ul>'
                    ]);
                }
            }
        }

        $imageDb = BongkaranFoto::where('id_bongkaran', $id)->count();
        $jml = ImageTmp::where("uuid", $request->input("uuid"))->count() + $imageDb;
        if ($jml > self::maxFoto) {
            return response()->json([
                'status'  => 2,
                'message' => '<ul class="m--marginless">Jumlah foto melebihi dari maximal benda.</ul>'
            ]);
        }

        $param = $this->cleanNumber($request->all(), ['luas_bangunan', 'jumlah', 'nilai_taksiran']);
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $bongkaran) {
                $param['letter_date'] = Carbon::parse($param['letter_date'])->toDateString();

                $bongkaran->letter_number = $param['letter_number'];
                $bongkaran->letter_date = Carbon::parse($param['letter_date'])->toDateString();
                $bongkaran->perihal = $param['perihal'];
                $bongkaran->penandatangan_surat = $param['penandatangan_surat'];
                $bongkaran->sumber_dana = $param['sumber_dana'];
                $bongkaran->nilai_taksiran = $param['nilai_taksiran'];

                if ($bongkaran->id_bongkaran_status == StatusBongkaran::DITOLAK_TK) {
                    $bongkaran->id_bongkaran_status = StatusBongkaran::PERMOHONAN_SATKER;
                }

                // Create Directory
                $docLocation = $this->model->docLocation($bongkaran->id);
                if (!file_exists($docLocation)) {
                    mkdir($this->model->docLocation($bongkaran->id), 0775, true);
                }

                // Upload File
                $arrayFile = [
                    'surat_pengajuan_satker',
                    'penetapan_status_penggunaan',
                    'kib_bangunan',
                    'sk_panitia_bongkaran',
                    'dokumen_penganggaran',
                    'penetapan_nilai_taksiran'
                ];
                foreach ($arrayFile as $file) {
                    if ($param[$file] != null) {
                        $fileDoc = $param[$file];
                        $filename = time() . '-' . str_slug(explode('.',
                                $fileDoc->getClientOriginalName())[0]) . '.' . $fileDoc->getClientOriginalExtension();
                        $fileDoc->move($docLocation, $filename);
                        $bongkaran->{$file} = $filename;
                    }
                }

                if ($bongkaran->save()) {
                    // Upload Image
                    $images = ImageTmp::where("uuid", $param["uuid"])->get();
                    foreach ($images as $image) {
                        if (file_exists(ImageTmp::imageLocation() . "/" . $image->file)) {
                            if (!file_exists(BongkaranFoto::imageLocation($bongkaran->id))) {
                                mkdir(BongkaranFoto::imageLocation($bongkaran->id), 0775, true);
                            }
                            rename(ImageTmp::imageLocation() . "/" . $image->file,
                                BongkaranFoto::imageLocation($bongkaran->id) . "/" . $image->file);
                        }

                        BongkaranFoto::create([
                            'id_bongkaran' => $bongkaran->id,
                            'foto'         => $image->file,
                        ]);

                        $image->delete();
                    }

                    // Upload Barang
                    $categories = json_decode($param['data'])->category;
                    $idBarang = json_decode($param['data'])->id;
                    BongkaranBarang::whereIdBongkaran($bongkaran->id)->delete();

                    $i = 1;
                    foreach ($categories as $key => $cat) {
                        $br = $idBarang[$key];

                        $barang = $this->findBarang($br, $cat);
                        $bongkaranBarang = BongkaranBarang::create([
                            'id_bongkaran'      => $bongkaran->id,
                            'id_asset'          => $barang->kode_satker . '-' . $barang->kode_barang . '-' . $barang->nup,
                            'id_category_asset' => $cat,
                            'nilai_perolehan'   => $barang->nilai_perolehan,
                            'ord'               => $i++,
                            'luas_bangunan'     => $param['luas_bangunan'][$key]
                        ]);

                        $uraian = array_shift($param['uraian']);
                        $jumlah = array_shift($param['jumlah']);
                        $satuan = array_shift($param['satuan']);

                        foreach ($uraian as $j => $u) {
                            $jml = $jumlah[$j];
                            $sat = $satuan[$j];
                            BongkaranBarangUraian::create([
                                'id_bongkaran_barang' => $bongkaranBarang->id,
                                'uraian' => $u,
                                'jumlah' => $jml,
                                'satuan' => $sat
                            ]);
                        }
                    }

                    BongkaranLog::create([
                        'id_bongkaran' => $bongkaran->id,
                        'created_by'   => \Auth::user()->id,
                        'id_status'    => BongkaranLog::EDIT
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
        $record = $this->model->join('users as u', 'u.id', '=',
            $this->model->getTable() . '.created_by')->select($this->model->getTable() . '.*',
            'id_satker')->findOrFail($id);
        if (!\Gate::allows('verifTk', $record)) {
            abort(403, "Not Allowed.");
        }

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Verifikasi Pengajuan ' . $this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [
                $this->title           => route($this->route . '.index'),
                'Verif Tk Banding'     => null,
                $record->letter_number => route($this->route . '.verif', $id)
            ];

        $data['data'] = $record;

        $data['penandatanganSurat'] = PenandatanganSurat::get();
        $data['barangs'] = $this->usulanBarang($record);
        $data['uraians'] = BongkaranBarangUraian::whereIn('id_bongkaran_barang', $record->barangs->pluck('id')->toArray())->select('id_bongkaran_barang', 'uraian', 'jumlah', 'satuan')->get()->groupBy('id_bongkaran_barang')->all();
        $data['isRevisi'] = $record->id_bongkaran_status == StatusBongkaran::DITOLAK_ADM || BongkaranLog::whereIdBongkaran($id)->whereIdStatus(BongkaranLog::DITOLAK_ADM)->count() > 0;

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
        $bongkaran = $this->model->join('users as u', 'u.id', '=',
            $this->model->getTable() . '.created_by')->select($this->model->getTable() . '.*',
            'id_satker')->findOrFail($id);
        if (!\Gate::allows('verifTk', $bongkaran)) {
            abort(403, "Not Allowed.");
        }

        $isRevisi = $bongkaran->id_bongkaran_status == StatusBongkaran::DITOLAK_ADM || BongkaranLog::whereIdBongkaran($id)->whereIdStatus(BongkaranLog::DITOLAK_ADM)->count() > 0;
        if ($request->input("submit") == 0) {
            $validate = [
                'keterangan_veriftk' => 'required',
            ];
        } else {
            $validate = [
                'letter_number_banding'       => 'required|max:50',
                'letter_date_banding'         => 'required|date_format:j F Y',
                'perihal_banding'             => 'required',
                'penandatangan_surat_banding' => 'required|exists:penandatangan_surats,id'
            ];

            if (!$isRevisi) {
                $validate['surat_penghantar_banding'] = 'required|mimes:pdf|max:5000';
            } else {
                $validate['surat_penghantar_banding'] = 'nullable|mimes:pdf|max:5000';
            }
        }

        $param = $request->all();
        $validator = \Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $bongkaran) {
                $submit = $param["submit"];
                $keterangan = null;
                if ($submit == 0) {
                    $bongkaran->id_bongkaran_status = StatusBongkaran::DITOLAK_TK;
                    $keterangan = $param["keterangan_veriftk"];
                    $bongkaran->keterangan_veriftk = $keterangan;
                    $statusLog = BongkaranLog::DITOLAK_TK;
                    $keterangan = ["keterangan" => $keterangan];
                } else {
                    $paramVerif = [
                        'letter_number_banding'       => $param['letter_number_banding'],
                        'letter_date_banding'         => Carbon::parse($param['letter_date_banding'])->toDateString(),
                        'perihal_banding'             => $param['perihal_banding'],
                        'penandatangan_surat_banding' => $param['penandatangan_surat_banding'],
                    ];


                    $docLocation = $this->model->docLocation($bongkaran->id);
                    if ($param['surat_penghantar_banding'] != null) {
                        $fileSuratBanding = $param['surat_penghantar_banding'];
                        $filename = time() . '-' . str_slug(explode('.',
                                $fileSuratBanding->getClientOriginalName())[0]) . '.' . $fileSuratBanding->getClientOriginalExtension();
                        $fileSuratBanding->move($docLocation, $filename);
                        $paramVerif['surat_penghantar_banding'] = $filename;
                    }

                    foreach ($paramVerif as $k => $row) {
                        $bongkaran->{$k} = $row;
                    }
                    $bongkaran->id_bongkaran_status = StatusBongkaran::DITERIMA_TK;

                    $statusLog = BongkaranLog::DITERIMA_TK;
                    $keterangan = $paramVerif;
                }

                if ($bongkaran->save()) {
                    BongkaranLog::create([
                        'id_bongkaran' => $bongkaran->id,
                        'created_by'   => \Auth::user()->id,
                        'id_status'    => $statusLog,
                        'keterangan'   => json_encode($keterangan)
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil men-verifikasi ' . $this->title . ' dengan No Surat <strong>' . $bongkaran->letter_number . '</strong>'
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

        $isDispo = $record->id_bongkaran_status == StatusBongkaran::DITERIMA_ADM;
        if ($isDispo) {
            $titleDetail = 'Verif Kepala Sub Bagian';
        } else {
            $titleDetail = 'Verif Kepala Bag Adm Penghapusan';
        }

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Verifikasi ' . $this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [
                $this->title           => route($this->route . '.index'),
                $titleDetail           => null,
                $record->letter_number => route($this->route . '.disposisi', $id)
            ];

        $data['data'] = $record;
        $data['barangs'] = $this->usulanBarang($record);
        $data['uraians'] = BongkaranBarangUraian::whereIn('id_bongkaran_barang', $record->barangs->pluck('id')->toArray())->select('id_bongkaran_barang', 'uraian', 'jumlah', 'satuan')->get()->groupBy('id_bongkaran_barang')->all();
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
        $bongkaran = $this->model->findOrFail($id);
        if (!\Gate::allows('verifKepalaAdm', $bongkaran) && !\Gate::allows('dispoKepalaSub', $bongkaran)) {
            abort(403, "Not Allowed.");
        }

        $validate = ['submit' => 'required'];
        if ($request->input("submit") == 0) {
            $validate['keterangan'] = 'required';
        }

        $param = $request->all();
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $bongkaran) {
                $isDispo = $bongkaran->id_bongkaran_status == StatusBongkaran::DITERIMA_ADM;

                $submit = $param["submit"];
                $keterangan = null;
                if ($submit == 0) {
                    $idBongkaranStatus = StatusBongkaran::DITOLAK_ADM;
                    $keterangan = $param["keterangan"];
                    $bongkaran->keterangan_verifadm = $keterangan;
                    $statusLog = BongkaranLog::DITOLAK_ADM;
                    $keterangan = ["keterangan" => $keterangan];
                } else {
                    if ($isDispo) {
                        $idBongkaranStatus = StatusBongkaran::PROSES;
                        $statusLog = BongkaranLog::PROSES;
                    } else {
                        $idBongkaranStatus = StatusBongkaran::DITERIMA_ADM;
                        $statusLog = BongkaranLog::DITERIMA_ADM;
                    }
                }
                $bongkaran->id_bongkaran_status = $idBongkaranStatus;

                if ($bongkaran->save()) {
                    BongkaranLog::create([
                        'id_bongkaran' => $bongkaran->id,
                        'created_by'   => \Auth::user()->id,
                        'id_status'    => $statusLog,
                        'keterangan'   => $keterangan == null ? null : json_encode($keterangan)
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil men-verifikasi ' . $this->title . ' dengan No Surat <strong>' . $bongkaran->letter_number . '</strong>'
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
        $data['config']['pageTitle'] = 'Proses Pengajuan ' . $this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [
                $this->title           => route($this->route . '.index'),
                'Proses'               => null,
                $record->letter_number => route($this->route . '.selesai', $id)
            ];

        $data['data'] = $record;
        $data['barangs'] = $this->usulanBarang($record);
        $data['uraians'] = BongkaranBarangUraian::whereIn('id_bongkaran_barang', $record->barangs->pluck('id')->toArray())->select('id_bongkaran_barang', 'uraian', 'jumlah', 'satuan')->get()->groupBy('id_bongkaran_barang')->all();

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
        $bongkaran = $this->model->findOrFail($id);
        if (!\Gate::allows('selesai', $bongkaran)) {
            abort(403, "Not Allowed.");
        }

        $validate = [
            'letter_number_persetujuan' => 'required|max:50',
            'letter_date_persetujuan'   => 'required|date_format:j F Y',
            'perihal_persetujuan'       => 'required',
            'surat_persetujuan'         => 'required|mimes:pdf|max:5000',
            'luas_bangunan_verif'       => 'required|numeric',
            'nilai_taksiran_verif'      => 'required|numeric'
        ];

        $param = $this->cleanNumber($request->all(), ['luas_bangunan_verif', 'nilai_taksiran_verif']);
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $bongkaran) {
                $paramVerif = [
                    'letter_number_persetujuan' => $param['letter_number_persetujuan'],
                    'letter_date_persetujuan'   => Carbon::parse($param['letter_date_persetujuan'])->toDateString(),
                    'perihal_persetujuan'       => $param['perihal_persetujuan'],
                    'luas_bangunan_verif'       => $param['luas_bangunan_verif'],
                    'nilai_taksiran_verif'      => $param['nilai_taksiran_verif'],
                ];

                $docLocation = $this->model->docLocation($bongkaran->id);
                $fileSurat = $param['surat_persetujuan'];
                $filename = time() . '-' . str_slug(explode('.',
                        $fileSurat->getClientOriginalName())[0]) . '.' . $fileSurat->getClientOriginalExtension();
                $fileSurat->move($docLocation, $filename);
                $paramVerif['surat_persetujuan'] = $filename;

                foreach ($paramVerif as $k => $row) {
                    $bongkaran->{$k} = $row;
                }
                $bongkaran->id_bongkaran_status = StatusBongkaran::MENUNGGU;
                $statusLog = BongkaranLog::MENUNGGU;
                $keterangan = $paramVerif;

                if ($bongkaran->save()) {
                    BongkaranLog::create([
                        'id_bongkaran' => $bongkaran->id,
                        'created_by'   => \Auth::user()->id,
                        'id_status'    => $statusLog,
                        'keterangan'   => json_encode($keterangan)
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil men-verifikasi ' . $this->title . ' dengan No Surat <strong>' . $bongkaran->letter_number . '</strong>'
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
        $record = $this->model->join('users as u', 'u.id', '=',
            $this->model->getTable() . '.created_by')->select($this->model->getTable() . '.*',
            'id_satker')->findOrFail($id);
        if (!\Gate::allows('tindaklanjut', $record)) {
            abort(403, "Not Allowed.");
        }

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Proses Tindak Lanjut ' . $this->title . ' : ' . $record->letter_number;
        $data['config']['breadcrumb'] = $this->breadcrumb + [
                $this->title           => route($this->route . '.index'),
                'Tindak Lanjut'        => null,
                $record->letter_number => route($this->route . '.tindakLanjut', $id)
            ];

        $data['data'] = $record;
        $data['barangs'] = $this->usulanBarang($record);
        $data['uraians'] = BongkaranBarangUraian::whereIn('id_bongkaran_barang', $record->barangs->pluck('id')->toArray())->select('id_bongkaran_barang', 'uraian', 'jumlah', 'satuan')->get()->groupBy('id_bongkaran_barang')->all();

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
        $bongkaran = $this->model->join('users as u', 'u.id', '=',
            $this->model->getTable() . '.created_by')->select($this->model->getTable() . '.*',
            'id_satker')->findOrFail($id);
        if (!\Gate::allows('tindaklanjut', $bongkaran)) {
            abort(403, "Not Allowed.");
        }

        $validate = [
            'hasil_bongkaran' => 'required|in:1,2',
        ];

        if ($request->input('hasil_bongkaran') == 1) {
            $validate['nomor_risalah_lelang'] = 'required|max:50';
            $validate['tanggal_risalah_lelang'] = 'required|date_format:j F Y';
            $validate['penandatangan_risalah_lelang'] = 'required|max:100';
            $validate['nomor_berita_acara'] = 'required|max:50';
            $validate['tanggal_berita_acara'] = 'required|date_format:j F Y';
            $validate['nilai_limit'] = 'required|numeric';
            $validate['nilai_terjual'] = 'required|numeric';
            $validate['dokumen_risalah_lelang'] = 'required|mimes:pdf|max:5000';
            $validate['dokumen_berita_acara'] = 'required|mimes:pdf|max:5000';
        } else {
            $validate['nomor_izin_pemusnahan'] = 'required|max:50';
            $validate['tanggal_izin_pemusnahan'] = 'required|date_format:j F Y';
            $validate['perihal_pemusnahan'] = 'required';
            $validate['nomor_berita_acara_pemusnahan'] = 'required|max:50';
            $validate['tanggal_berita_acara_pemusnahan'] = 'required|date_format:j F Y';
            $validate['dokumen_persetujuan_pemusnahan'] = 'required|mimes:pdf|max:5000';
            $validate['dokumen_berita_acara_pemusnahan'] = 'required|mimes:pdf|max:5000';
        }

        $param = $this->cleanNumber($request->all(), ['nilai_limit', 'nilai_terjual']);
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $bongkaran) {
                if ($param['hasil_bongkaran'] == 1) {
                    $arrayFile = ['dokumen_risalah_lelang', 'dokumen_berita_acara'];
                    $paramVerif = [
                        'hasil_bongkaran'              => 1,
                        'nomor_risalah_lelang'         => $param['nomor_risalah_lelang'],
                        'tanggal_risalah_lelang'       => Carbon::parse($param['tanggal_risalah_lelang'])->toDateString(),
                        'penandatangan_risalah_lelang' => $param['penandatangan_risalah_lelang'],
                        'nomor_berita_acara'           => $param['nomor_berita_acara'],
                        'tanggal_berita_acara'         => Carbon::parse($param['tanggal_berita_acara'])->toDateString(),
                        'nilai_limit'                  => $param['nilai_limit'],
                        'nilai_terjual'                => $param['nilai_terjual']
                    ];
                } else {
                    $arrayFile = ['dokumen_persetujuan_pemusnahan', 'dokumen_berita_acara_pemusnahan'];
                    $paramVerif = [
                        'hasil_bongkaran'                 => 2,
                        'nomor_izin_pemusnahan'           => $param['nomor_izin_pemusnahan'],
                        'tanggal_izin_pemusnahan'         => Carbon::parse($param['tanggal_izin_pemusnahan'])->toDateString(),
                        'perihal_pemusnahan'              => $param['perihal_pemusnahan'],
                        'nomor_berita_acara_pemusnahan'   => $param['nomor_berita_acara_pemusnahan'],
                        'tanggal_berita_acara_pemusnahan' => Carbon::parse($param['tanggal_berita_acara_pemusnahan'])->toDateString(),
                    ];
                }

                $docLocation = $this->model->docLocation($bongkaran->id);
                foreach ($arrayFile as $file) {
                    $fileDoc = $param[$file];
                    $filename = time() . '-' . str_slug(explode('.',
                            $fileDoc->getClientOriginalName())[0]) . '.' . $fileDoc->getClientOriginalExtension();
                    $fileDoc->move($docLocation, $filename);
                    $paramVerif[$file] = $filename;
                }

                foreach ($paramVerif as $k => $row) {
                    $bongkaran->{$k} = $row;
                }

                $bongkaran->id_bongkaran_status = StatusBongkaran::SELESAI;
                $statusLog = BongkaranLog::SELESAI;
                $keterangan = $paramVerif;

                if ($bongkaran->save()) {
                    BongkaranLog::create([
                        'id_bongkaran' => $bongkaran->id,
                        'created_by'   => \Auth::user()->id,
                        'id_status'    => $statusLog,
                        'keterangan'   => json_encode($keterangan)
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil menindak lanjuti ' . $this->title . ' dengan No Surat <strong>' . $bongkaran->letter_number . '</strong>'
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
            ->select('s.satker_type', 's.dirjen', 's.kpknl', 's.kanwil as kanwilDjkn', 's.id_wilayah', 's.name as satkerName', 'psb.name as penandatanganTingkatBanding', 'letter_number_banding as noSuratBanding',
            'letter_date_banding as tanggalSuratBanding', 'perihal_banding as perihalSuratBanding', 'nilai_limit as nilaiLimit')
            ->find($id)->toArray();

        $tingkatBanding = Satker::where('satker_type', $data['satker_type'])->where('type', 'tingkatbanding')
            ->where('id_wilayah', $data['id_wilayah'])->select('name', 'city')->first();

        $data['satkerName'] = ucwords(strtolower($data['satkerName']));
        $data['tanggalSuratBanding'] = bulanReplace(Carbon::parse($data['tanggalSuratBanding'])->format('j F Y'));
        $data['nilaiPerolehan'] = BongkaranBarang::where('id_bongkaran', $id)->sum('nilai_perolehan');
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
        $data['uraians'] = BongkaranBarangUraian::whereIn('id_bongkaran_barang', $record->barangs->pluck('id')->toArray())->select('id_bongkaran_barang', 'uraian', 'jumlah', 'satuan')->get()->groupBy('id_bongkaran_barang')->all();

        return \Excel::download(new BongkaranExport($data), 'Lampiran Persetujuan Penjualan Bongkaran.xlsx');
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
