<?php

namespace App\Http\Controllers\Admin\Pengadaan;

use App\Http\Controllers\BarangTrait;
use App\Model\CategoryAsset;
use App\Model\FileTmp;
use App\Model\ImageTmp;
use App\Model\PenandatanganSurat;
use App\Model\Pengadaan\Rkbmn\RkbmnPengadaan;
use App\Model\Pengadaan\Usulan\Pengadaan;
use App\Model\Pengadaan\Usulan\PengadaanLog;
use App\Model\Pengadaan\Usulan\PengadaanPembangunan;
use App\Model\Pengadaan\Usulan\PengadaanPembangunanBarang;
use App\Model\Pengadaan\Usulan\PengadaanPembangunanGambar;
use App\Model\Pengadaan\Usulan\PengadaanPenawaran;
use App\Model\Pengadaan\Usulan\PengadaanRenovasi;
use App\Model\Pengadaan\Usulan\PengadaanRenovasiFoto;
use App\Model\Pengadaan\Usulan\PengadaanRenovasiGambar;
use App\Model\Pengadaan\Usulan\PengadaanTanah;
use App\Model\Pengadaan\Usulan\PengadaanType;
use App\Model\Pengadaan\Usulan\StatusPengadaan;
use App\Model\Pengadaan\Usulan\PengadaanPenawaranFoto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UsulanController extends \App\Http\Controllers\UsulanController
{
    use BarangTrait;

    const maxFoto = 10;

    private $route = 'admin.pengadaan.usulan';
    private $title = 'Usulan Pengadaan';
    private $permission = 'pengadaan-usulan';
    private $docForm = 'pengadaan-usulan';
    protected $objName = 'pengadaan';
    private $rkBmnTable = [
        'ES1',
        'DU',
        'APIP',
        'UAPB',
        'DJKN',
        'No Pengadaan',
        'Kode Barang',
        'Nama Barang',
        'Kode Satker',
        'Nama Satker'
    ];

    public function __construct()
    {
        $this->model = new Pengadaan();
        $this->layout = $this->route;
        $this->breadcrumb = ['Pengadaan' => null];
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
        $data['table']['header'] = [
            'No Surat Usulan Satker',
            'Satker',
            'Tanggal Surat',
            'Tanggal Pengajuan',
            'Tipe Pengadaan',
            'Status'
        ];

        $data['statuses'] = StatusPengadaan::get();
        $data['types'] = PengadaanType::get();
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
            ->join('pengadaan_types as pt', 'pt.id', '=', 'pengadaans.id_pengadaan_type')
            ->join('pengadaan_statuses as ps', 'ps.id', '=', 'pengadaans.id_pengadaan_status')
            ->select('letter_number', 's.name as satkerName', 'letter_date', 'u.id_satker', 'ps.state',
                'pengadaans.created_at', "ps.name as pengadaanStatus", 'id_pengadaan_status', 's.id_wilayah',
                'pt.name as pengadaanTypeName', 'pt.state as pengadaanTypeState');

        $user = \Auth::user();
        $dataTable = \Datatable::create($model)
            ->setId($this->model->getTable() . '.id')
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('j F Y, H:s');
            })
            ->editColumn('letter_date', function ($data) {
                return Carbon::parse($data->letter_date)->format('j F Y');
            })
            ->editColumn('pengadaanType', function ($data) {
                return '<span class="m-badge m-badge--' . ($data->pengadaanTypeState) . ' m-badge--wide">' . $data->pengadaanTypeName . '</span>';
            })
            ->editColumn('satker', function ($data) {
                return $data->nama_satker . ' ( ' . $data->kode_satker . ' )';
            })
            ->editColumn('total_nilai_barang', function ($data) {
                return 'Rp ' . numberFormatIndo($data->total_nilai_barang);
            })
            ->editColumn('pengadaanStatus', function ($data) {
                return '<span class="m-badge m-badge--' . $data->state . ' m-badge--wide">' . $data->pengadaanStatus . '</span>';
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

        $type = $record->id_pengadaan_type;
        $pengadaanType = PengadaanType::find($type);

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Detail Pengajuan ' . $this->title . ' : ' . $record->letter_number . ' ( ' . $pengadaanType->name . ')';
        $data['config']['breadcrumb'] = $this->breadcrumb + [
                $this->title           => route($this->route . '.index'),
                $record->letter_number => route($this->route . '.show', $id)
            ];

        $data['data'] = $record;
        $data['type'] = $type;
        $data['penandatanganSurat'] = PenandatanganSurat::get();
        $data['logs'] = $record->log()->with(['user.satker', 'status'])->get();

        switch ($type) {
            case 1:
                $data['jenisPengadaan'] = CategoryAsset::whereIn('id', [9, 10])->get();
                break;
            case 2:
                $data['barangs'] = $this->usulanBarang($record->pembangunan, 'pengadaan-pembangunan');
                $data['jenisPembangunan'] = [1 => 'Gedung Kantor', 2 => 'Rumah Negara', 3 => 'SARPRAS'];
                break;
            case 3:
                $data['jenisPekerjaan'] = [1 => 'Renovasi', 2 => 'Rehabilitasi', 3 => 'Restorasi'];
                $data['jenisBarang'] = [1 => 'Gedung Kantor', 2 => 'Rumah Dinas', 3 => 'Zitting Plat', 4 => 'Sarana Lainnya'];
                $data['tingkatKerusakan'] = [1 => 'Ringan (< 30%)', 2 => 'Sedang (>= 30% - 45%)', 3 => 'Berat (> 45% - 65%)', 4 => 'Khusus (> 65%)'];
                break;
        }

        return view($this->layout . '.show', $data);
    }

    /**
     * @param $type
     * @param null $tanah
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($type, $tanah = null)
    {
        \Permission::access('create-' . $this->permission);

        $pengadaanType = PengadaanType::find($type);

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Pengajuan ' . $this->title . ' : ' . $pengadaanType->name;
        $data['config']['breadcrumb'] = array_merge($this->breadcrumb,
            [$this->title => route($this->route . '.index'), 'Pengajuan' => route($this->route . '.create', ['type' => $type, 'tanah' => $tanah])]);

        $data['type'] = $type;
        $data['uuid'] = Str::uuid();
        $data['penandatanganSurat'] = PenandatanganSurat::get();
        $data['table']['header'] = $this->rkBmnTable;

        switch ($type) {
            case 1:
                $layout = $this->layout . '.createPengadaan';
                $data['jenisPengadaan'] = CategoryAsset::whereIn('id', [9, 10])->get();
                $data['typeTanah'] = $tanah;
                break;
            case 2:
                $layout = $this->layout . '.createPembangunan';
                $data['kategoriBarang'] = CategoryAsset::pengadaan();
                $data['jenisPembangunan'] = [1 => 'Gedung Kantor', 2 => 'Rumah Negara', 3 => 'SARPRAS'];
                break;
            case 3:
                $layout = $this->layout . '.createRenovasi';
                $data['jenisPekerjaan'] = [1 => 'Renovasi', 2 => 'Rehabilitasi', 3 => 'Restorasi'];
                $data['jenisBarang'] = [1 => 'Gedung Kantor', 2 => 'Rumah Dinas', 3 => 'Zitting Plat', 4 => 'Sarana Lainnya'];
                $data['tingkatKerusakan'] = [1 => 'Ringan (< 30%)', 2 => 'Sedang (>= 30% - 45%)', 3 => 'Berat (> 45% - 65%)', 4 => 'Khusus (> 65%)'];
                break;
        }

        return view($layout, $data);
    }

    /**
     * @param Request $request
     * @param $type
     * @param null $typeTanah
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request, $type, $typeTanah = null)
    {
        \Permission::access('create-' . $this->permission);

        $validate = [
            'letter_number'       => 'required|max:50',
            'letter_date'         => 'required|date_format:j F Y',
            'perihal'             => 'required',
            'penandatangan_surat' => 'required|exists:penandatangan_surats,id',
            'id_rkbmn_uraian'     => 'nullable|exists:rkbmn_pengadaans,id',
        ];

        if ($type == Pengadaan::PENGADAAN) {
            $validate['jenis_pengadaan'] = 'required|in:9,10';
            $validate['tor'] = 'required|mimes:pdf|max:5000';
            $validate['tanah_type'] = 'required|in:1,2';
            $validate['harga_penawaran.*'] = 'required|numeric';
            $validate['luas_tanah.*'] = 'required|numeric';
            $validate['sertifikat.*'] = 'required|mimes:pdf|max:5000';
            $validate['pernyataan.*'] = 'required|mimes:pdf|max:5000';
            $validate['penawaran.*'] = 'required|mimes:pdf|max:5000';
            $validate['ktp.*'] = 'required|mimes:pdf|max:5000';
            $validate['pajak.*'] = 'required|mimes:pdf|max:5000';
            $validate['surat_harga.*'] = 'required|mimes:pdf|max:5000';

            for ($i = 1; $i <= ($typeTanah == 2 ? 1 : 3); $i++) {
                $jml = ImageTmp::where("uuid", $request->input("uuid") . '-' . $i)->count();
                if ($jml == 0) {
                    return response()->json([
                        'status'  => 2,
                        'message' => '<ul class="m--marginless">Foto Penawaran ' . $i . ' tidak boleh kosong.</ul>'
                    ]);
                } else {
                    if ($jml > self::maxFoto) {
                        return response()->json([
                            'status'  => 2,
                            'message' => '<ul class="m--marginless">Jumlah foto melebihi dari maximal benda.</ul>'
                        ]);
                    }
                }
            }
        } else if ($type == Pengadaan::PEMBANGUNAN) {
            $validate['jenis_pembangunan'] = 'required|in:1,2,3';
            $validate['luas_bangunan'] = 'required|numeric';
            $validate['biaya_fisik'] = 'required|numeric';
            $validate['biaya_perencanaan'] = 'required|numeric';
            $validate['biaya_pengawasan'] = 'required|numeric';
            $validate['biaya_pengelolaan'] = 'required|numeric';
            $validate['pajak_pembangunan'] = 'required|numeric';

            $idBarang = json_decode($request->input('data'))->id;
            if ($idBarang == null) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Barang tidak boleh Kosong.</ul>'
                ]);
            }

            $jml = FileTmp::where("uuid", $request->input("uuid"))->count();
            if ($jml == 0) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Gambar Rencana Usulan tidak boleh kosong.</ul>'
                ]);
            } else {
                if ($jml > 5) {
                    return response()->json([
                        'status'  => 2,
                        'message' => '<ul class="m--marginless">Jumlah Gambar Rencana Usulan melebihi dari maximal 5 File.</ul>'
                    ]);
                }
            }
        } else if ($type == Pengadaan::RENOVASI) {
            $validate['jenis_pekerjaan'] = 'required|in:1,2,3';
            $validate['jenis_barang'] = 'required|in:1,2,3,4';
            $validate['luas_bangunan'] = 'required|numeric';
            $validate['luas_bangunan_rencana'] = 'required|numeric';
            $validate['tingkat_kerusakan'] = 'required|in:1,2,3,4';
            $validate['biaya_fisik'] = 'required|numeric';
            $validate['biaya_perencanaan'] = 'required|numeric';
            $validate['biaya_pengawasan'] = 'required|numeric';
            $validate['biaya_pengelolaan'] = 'required|numeric';
            $validate['pajak_pembangunan'] = 'required|numeric';
            $validate['surat_pengajuan'] = 'required|mimes:pdf|max:5000';
            $validate['surat_psp'] = 'required|mimes:pdf|max:5000';
            $validate['surat_harga'] = 'required|mimes:pdf|max:5000';
            $validate['analisa_kerusakan'] = 'required|mimes:pdf|max:5000';
            $validate['analisa_pu'] = 'required|mimes:pdf|max:5000';
            $validate['tor'] = 'required|mimes:pdf|max:5000';

            // FOTO
            $jml = ImageTmp::where("uuid", $request->input("uuid"))->count();
            if ($jml == 0) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Foto Bangunan Eksisting tidak boleh kosong.</ul>'
                ]);
            } else {
                if ($jml > self::maxFoto) {
                    return response()->json([
                        'status'  => 2,
                        'message' => '<ul class="m--marginless">Jumlah Foto Bangunan Eksisting melebihi dari maximal benda.</ul>'
                    ]);
                }
            }

            // Gambar Denah Eksisting
            $jml = FileTmp::where("uuid", $request->input("uuid").'-1')->count();
            if ($jml == 0) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Gambar Denah Eksisting tidak boleh kosong.</ul>'
                ]);
            } else {
                if ($jml > 5) {
                    return response()->json([
                        'status'  => 2,
                        'message' => '<ul class="m--marginless">Jumlah Gambar Denah Eksisting melebihi dari maximal 5 File.</ul>'
                    ]);
                }
            }

            // Gambar Rencana Usulan
            $jml = FileTmp::where("uuid", $request->input("uuid").'-2')->count();
            if ($jml == 0) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Gambar Rencana Usulan tidak boleh kosong.</ul>'
                ]);
            } else {
                if ($jml > 5) {
                    return response()->json([
                        'status'  => 2,
                        'message' => '<ul class="m--marginless">Jumlah Gambar Rencana Usulan melebihi dari maximal 5 File.</ul>'
                    ]);
                }
            }
        }

        $user = \Auth::user();
        $param = $this->cleanNumber($request->all(), [
            'harga_penawaran',
            'luas_tanah',
            'luas_bangunan',
            'luas_bangunan_rencana',
            'biaya_fisik',
            'biaya_perencanaan',
            'biaya_pengawasan',
            'biaya_pengelolaan',
            'pajak_pembangunan'
        ]);
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $user, $type, $typeTanah) {
                $param['id_pengadaan_type'] = $type;
                $param['id_pengadaan_status'] = StatusPengadaan::PERMOHONAN_SATKER;
                $param['created_by'] = $user->id;
                $param['letter_date'] = Carbon::parse($param['letter_date'])->toDateString();

                $pengadaan = $this->model;
                $pengadaan = $pengadaan->create($param);
                if ($pengadaan) {
                    // Generate Location
                    $docLocation = $this->model->docLocation($pengadaan->id);
                    if (!file_exists($docLocation)) {
                        mkdir($this->model->docLocation($pengadaan->id), 0775, true);
                    }

                    // IF Pengadaan Tanah
                    if ($type == Pengadaan::PENGADAAN) {
                        // Insert Pengadaan Tanah
                        $fileDoc = $param['tor'];
                        $filename = time() . '-' . str_slug(explode('.',
                                $fileDoc->getClientOriginalName())[0]) . '.' . $fileDoc->getClientOriginalExtension();
                        $fileDoc->move($docLocation, $filename);
                        $torFilename = $filename;

                        $tanah = PengadaanTanah::create([
                            'id_pengadaan' => $pengadaan->id,
                            'jenis_pengadaan' => $param['jenis_pengadaan'],
                            'tor' => $torFilename,
                            'tanah_type' => $typeTanah
                        ]);

                        for ($i = 0; $i < ($typeTanah == 2 ? 1 : 3); $i++) {
                            $arTanah = [
                                'id_pengadaan_tanah' => $tanah->id,
                                'harga_penawaran'    => $param['harga_penawaran'][$i],
                                'luas_tanah'         => $param['luas_tanah'][$i],
                            ];

                            $arrayFile = ['ktp', 'sertifikat', 'pajak', 'pernyataan', 'surat_harga', 'penawaran'];
                            foreach ($arrayFile as $file) {
                                if (isset($param[$file][$i])) {
                                    $fileDoc = $param[$file][$i];
                                    $filename = time() . '-' . str_slug(explode('.',
                                            $fileDoc->getClientOriginalName())[0]) . '.' . $fileDoc->getClientOriginalExtension();
                                    $fileDoc->move($docLocation, $filename);
                                    $arTanah[$file] = $filename;
                                }
                            }

                            $penawaran = PengadaanPenawaran::create($arTanah);

                            $images = ImageTmp::where("uuid", $param["uuid"] . '-' . ($i + 1))->get();
                            foreach ($images as $image) {
                                if (file_exists(ImageTmp::imageLocation() . "/" . $image->file)) {
                                    if (!file_exists(PengadaanPenawaranFoto::imageLocation($pengadaan->id))) {
                                        mkdir(PengadaanPenawaranFoto::imageLocation($pengadaan->id), 0775, true);
                                    }
                                    copy(ImageTmp::imageLocation() . "/" . $image->file,
                                        PengadaanPenawaranFoto::imageLocation($pengadaan->id) . "/" . $image->file);
                                }

                                PengadaanPenawaranFoto::create([
                                    'id_pengadaan_penawaran' => $penawaran->id,
                                    'foto'                   => $image->file,
                                ]);
                            }
                        }
                    } else if ($type == Pengadaan::PEMBANGUNAN) {
                        $arPengadaanPembangunan = $param;
                        $arPengadaanPembangunan['id_pengadaan'] = $pengadaan->id;

                        // Insert Document
                        $arrayFile = [
                            'surat_pengajuan',
                            'surat_psp',
                            'surat_rencana',
                            'surat_harga_satuan',
                            'surat_analisa',
                            'tor'
                        ];
                        foreach ($arrayFile as $file) {
                            if (isset($param[$file])) {
                                $fileDoc = $param[$file];
                                $filename = time() . '-' . str_slug(explode('.',
                                        $fileDoc->getClientOriginalName())[0]) . '.' . $fileDoc->getClientOriginalExtension();
                                $fileDoc->move($docLocation, $filename);
                                $arPengadaanPembangunan[$file] = $filename;
                            }
                        }

                        $pengadaanPembangunan = PengadaanPembangunan::create($arPengadaanPembangunan);

                        // Insert Gambar
                        $gambars = FileTmp::where("uuid", $param["uuid"])->get();
                        foreach ($gambars as $gambar) {
                            if (file_exists(FileTmp::location() . "/" . $gambar->file)) {
                                if (!file_exists(PengadaanPembangunanGambar::imageLocation($pengadaan->id))) {
                                    mkdir(PengadaanPembangunanGambar::imageLocation($pengadaan->id), 0775, true);
                                }
                                rename(FileTmp::location() . "/" . $gambar->file,
                                    PengadaanPembangunanGambar::imageLocation($pengadaan->id) . "/" . $gambar->file);
                            }

                            PengadaanPembangunanGambar::create([
                                'id_pengadaan_pembangunan' => $pengadaanPembangunan->id,
                                'file'                     => $gambar->file,
                            ]);

                            $gambar->delete();
                        }

                        // Insert Barang
                        $categories = json_decode($param['data'])->category;
                        $idBarang = json_decode($param['data'])->id;
                        $i = 1;
                        foreach ($categories as $key => $cat) {
                            $br = $idBarang[$key];

                            $barang = $this->findBarang($br, $cat);
                            PengadaanPembangunanBarang::create([
                                'id_pengadaan_pembangunan' => $pengadaanPembangunan->id,
                                'id_asset'                 => $barang->kode_satker . '-' . $barang->kode_barang . '-' . $barang->nup,
                                'id_category_asset'        => $cat,
                                'nilai_perolehan'          => $barang->nilai_perolehan,
                                'ord'                      => $i++
                            ]);
                        }
                    } else if ($type == Pengadaan::RENOVASI) {
                        // Data
                        $arParam = [
                            'id_pengadaan'          => $pengadaan->id,
                            'jenis_pekerjaan'       => $param['jenis_pekerjaan'],
                            'jenis_barang'          => $param['jenis_barang'],
                            'luas_bangunan'         => $param['luas_bangunan'],
                            'luas_bangunan_rencana' => $param['luas_bangunan_rencana'],
                            'tingkat_kerusakan'     => $param['tingkat_kerusakan'],
                            'biaya_fisik'           => $param['biaya_fisik'],
                            'biaya_perencanaan'     => $param['biaya_perencanaan'],
                            'biaya_pengawasan'      => $param['biaya_pengawasan'],
                            'biaya_pengelolaan'     => $param['biaya_pengelolaan'],
                            'pajak_pembangunan'     => $param['pajak_pembangunan']
                        ];

                        $arrayFile = [ 'surat_pengajuan','surat_psp','surat_harga','analisa_kerusakan','analisa_pu','tor'];
                        foreach ($arrayFile as $file) {
                            if (isset($param[$file])) {
                                $fileDoc = $param[$file];
                                $filename = time() . '-' . str_slug(explode('.',
                                        $fileDoc->getClientOriginalName())[0]) . '.' . $fileDoc->getClientOriginalExtension();
                                $fileDoc->move($docLocation, $filename);
                                $arParam[$file] = $filename;
                            }
                        }
                        $renovasi = PengadaanRenovasi::create($arParam);

                        // Foto
                        $images = ImageTmp::where("uuid", $param["uuid"])->get();
                        foreach ($images as $image) {
                            if (file_exists(ImageTmp::imageLocation() . "/" . $image->file)) {
                                if (!file_exists(PengadaanRenovasiFoto::imageLocation($pengadaan->id))) {
                                    mkdir(PengadaanRenovasiFoto::imageLocation($pengadaan->id), 0775, true);
                                }
                                rename(ImageTmp::imageLocation() . "/" . $image->file,
                                    PengadaanRenovasiFoto::imageLocation($pengadaan->id) . "/" . $image->file);
                            }

                            PengadaanRenovasiFoto::create([
                                'id_pengadaan_renovasi' => $renovasi->id,
                                'foto'                   => $image->file,
                            ]);

                            $image->delete();
                        }

                        // Insert Gambar Eksisting
                        for ($i=1;$i<=2;$i++) {
                            $gambars = FileTmp::where("uuid", $param["uuid"].'-'.$i)->get();
                            foreach ($gambars as $gambar) {
                                if (file_exists(FileTmp::location() . "/" . $gambar->file)) {
                                    if (!file_exists(PengadaanRenovasiGambar::imageLocation($pengadaan->id))) {
                                        mkdir(PengadaanRenovasiGambar::imageLocation($pengadaan->id), 0775, true);
                                    }
                                    rename(FileTmp::location() . "/" . $gambar->file,
                                        PengadaanRenovasiGambar::imageLocation($pengadaan->id) . "/" . $gambar->file);
                                }

                                PengadaanRenovasiGambar::create([
                                    'id_pengadaan_renovasi' => $renovasi->id,
                                    'file'                  => $gambar->file,
                                    'type' => $i,
                                ]);

                                $gambar->delete();
                            }
                        }
                    }

                    PengadaanLog::create([
                        'id_pengadaan' => $pengadaan->id,
                        'created_by'   => \Auth::user()->id,
                        'id_status'    => PengadaanLog::PERMOHONAN
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

        $record = $this->model->join('users as u', 'u.id', '=', $this->model->getTable().'.created_by')->select($this->model->getTable().'.*',
            'id_satker')->findOrFail($id);
        if (!\Gate::allows('edit', $record)) {
            abort(403, "Not Allowed.");
        }

        $type = $record->id_pengadaan_type;

        $pengadaanType = PengadaanType::find($type);

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Ubah Pengajuan ' . $this->title . ' : ' . $pengadaanType->name;
        $data['config']['breadcrumb'] = $this->breadcrumb + [
                $this->title           => route($this->route . '.index'),
                'Edit'                 => null,
                $record->letter_number => route($this->route . '.edit', $id)
            ];

        $data['data'] = $record;
        $data['type'] = $type;
        $data['uuid'] = Str::uuid();
        $data['penandatanganSurat'] = PenandatanganSurat::get();
        $data['isRevisi'] = $record->id_pengadaan_status == StatusPengadaan::DITOLAK_TK || PengadaanLog::whereIdPengadaan($id)->whereIdStatus(PengadaanLog::DITOLAK_TK)->count() > 0;
        $data['table']['header'] = $this->rkBmnTable;

        switch ($type) {
            case 1:
                $layout = $this->layout . '.editPengadaan';
                $data['jenisPengadaan'] = CategoryAsset::whereIn('id', [9, 10])->get();
                break;
            case 2:
                $data['barangs'] = $this->usulanBarang($record->pembangunan, 'pengadaan-pembangunan');
                $layout = $this->layout . '.editPembangunan';
                $data['kategoriBarang'] = CategoryAsset::pengadaan();
                $data['jenisPembangunan'] = [1 => 'Gedung Kantor', 2 => 'Rumah Negara', 3 => 'SARPRAS'];
                break;
            case 3:
                $layout = $this->layout . '.editRenovasi';
                $data['jenisPekerjaan'] = [1 => 'Renovasi', 2 => 'Rehabilitasi', 3 => 'Restorasi'];
                $data['jenisBarang'] = [1 => 'Gedung Kantor', 2 => 'Rumah Dinas', 3 => 'Zitting Plat', 4 => 'Sarana Lainnya'];
                $data['tingkatKerusakan'] = [1 => 'Ringan (< 30%)', 2 => 'Sedang (>= 30% - 45%)', 3 => 'Berat (> 45% - 65%)', 4 => 'Khusus (> 65%)'];
                break;
        }

        return view($layout, $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(Request $request, $id)
    {
        \Permission::access('edit-' . $this->permission);

        $pengadaan = $this->model->join('users as u', 'u.id', '=',
            $this->model->getTable().'.created_by')->select($this->model->getTable().'.*', 'id_satker')->findOrFail($id);
        if (!\Gate::allows('edit', $pengadaan)) {
            abort(403, "Not Allowed.");
        }

        $type = $pengadaan->id_pengadaan_type;

        $validate = [
            'letter_number'       => 'required|max:50',
            'letter_date'         => 'required|date_format:j F Y',
            'perihal'             => 'required',
            'penandatangan_surat' => 'required|exists:penandatangan_surats,id',
            'id_rkbmn_uraian'     => 'nullable|exists:rkbmn_pengadaans,id',
        ];

        if ($type == Pengadaan::PENGADAAN) {
            $validate['jenis_pengadaan'] = 'required|in:9,10';
            $validate['tor'] = 'nullable|mimes:pdf|max:5000';
            $validate['harga_penawaran.*'] = 'required|numeric';
            $validate['luas_tanah.*'] = 'required|numeric';
            $validate['sertifikat.*'] = 'nullable|mimes:pdf|max:5000';
            $validate['pernyataan.*'] = 'nullable|mimes:pdf|max:5000';
            $validate['penawaran.*'] = 'nullable|mimes:pdf|max:5000';
            $validate['ktp.*'] = 'nullable|mimes:pdf|max:5000';
            $validate['pajak.*'] = 'nullable|mimes:pdf|max:5000';
            $validate['surat_harga.*'] = 'nullable|mimes:pdf|max:5000';

            foreach ($pengadaan->tanah->penawaran as $i => $penawaran) {
                $imageDb = $penawaran->foto()->count();
                $jml = ImageTmp::where("uuid", $request->input("uuid") . '-' . ($i+1))->count() + $imageDb;
                if ($jml == 0) {
                    return response()->json([
                        'status'  => 2,
                        'message' => '<ul class="m--marginless">Foto Penawaran ' . ($i+1) . ' tidak boleh kosong.</ul>'
                    ]);
                } else {
                    if ($jml > self::maxFoto) {
                        return response()->json([
                            'status'  => 2,
                            'message' => '<ul class="m--marginless">Jumlah foto melebihi dari maximal benda.</ul>'
                        ]);
                    }
                }
            }
        } else if ($type == Pengadaan::PEMBANGUNAN) {
            $validate['jenis_pembangunan'] = 'required|in:1,2,3';
            $validate['luas_bangunan'] = 'required|numeric';
            $validate['biaya_fisik'] = 'required|numeric';
            $validate['biaya_perencanaan'] = 'required|numeric';
            $validate['biaya_pengawasan'] = 'required|numeric';
            $validate['biaya_pengelolaan'] = 'required|numeric';
            $validate['pajak_pembangunan'] = 'required|numeric';

            $idBarang = json_decode($request->input('data'))->id;
            if ($idBarang == null) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Barang tidak boleh Kosong.</ul>'
                ]);
            }

            $fileDb = PengadaanPembangunanGambar::where('id_pengadaan_pembangunan', $pengadaan->pembangunan->id)->count();
            $jml = FileTmp::where("uuid", $request->input("uuid"))->count() + $fileDb;
            if ($jml == 0) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Gambar Rencana Usulan tidak boleh kosong.</ul>'
                ]);
            } else {
                if ($jml > 5) {
                    return response()->json([
                        'status'  => 2,
                        'message' => '<ul class="m--marginless">Jumlah Gambar Rencana Usulan melebihi dari maximal 5 File.</ul>'
                    ]);
                }
            }
        } else if ($type == Pengadaan::RENOVASI) {
            $validate['jenis_pekerjaan'] = 'required|in:1,2,3';
            $validate['jenis_barang'] = 'required|in:1,2,3,4';
            $validate['luas_bangunan'] = 'required|numeric';
            $validate['luas_bangunan_rencana'] = 'required|numeric';
            $validate['tingkat_kerusakan'] = 'required|in:1,2,3,4';
            $validate['biaya_fisik'] = 'required|numeric';
            $validate['biaya_perencanaan'] = 'required|numeric';
            $validate['biaya_pengawasan'] = 'required|numeric';
            $validate['biaya_pengelolaan'] = 'required|numeric';
            $validate['pajak_pembangunan'] = 'required|numeric';
            $validate['surat_pengajuan'] = 'nullable|mimes:pdf|max:5000';
            $validate['surat_psp'] = 'nullable|mimes:pdf|max:5000';
            $validate['surat_harga'] = 'nullable|mimes:pdf|max:5000';
            $validate['analisa_kerusakan'] = 'nullable|mimes:pdf|max:5000';
            $validate['analisa_pu'] = 'nullable|mimes:pdf|max:5000';
            $validate['tor'] = 'nullable|mimes:pdf|max:5000';

            // FOTO
            $imageDb = $pengadaan->renovasi->foto()->count();
            $jml = ImageTmp::where("uuid", $request->input("uuid"))->count() + $imageDb;
            if ($jml == 0) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Foto Bangunan Eksisting tidak boleh kosong.</ul>'
                ]);
            } else {
                if ($jml > self::maxFoto) {
                    return response()->json([
                        'status'  => 2,
                        'message' => '<ul class="m--marginless">Jumlah Foto Bangunan Eksisting melebihi dari maximal benda.</ul>'
                    ]);
                }
            }

            // Gambar Denah Eksisting
            $fileDb = PengadaanRenovasiGambar::where('id_pengadaan_renovasi', $pengadaan->renovasi->id)->whereType(1)->count();
            $jml = FileTmp::where("uuid", $request->input("uuid").'-1')->count() + $fileDb;
            if ($jml == 0) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Gambar Denah Eksisting tidak boleh kosong.</ul>'
                ]);
            } else {
                if ($jml > 5) {
                    return response()->json([
                        'status'  => 2,
                        'message' => '<ul class="m--marginless">Jumlah Gambar Denah Eksisting melebihi dari maximal 5 File.</ul>'
                    ]);
                }
            }

            // Gambar Rencana Usulan
            $fileDb = PengadaanRenovasiGambar::where('id_pengadaan_renovasi', $pengadaan->renovasi->id)->whereType(2)->count();
            $jml = FileTmp::where("uuid", $request->input("uuid").'-2')->count() + $fileDb;
            if ($jml == 0) {
                return response()->json([
                    'status'  => 2,
                    'message' => '<ul class="m--marginless">Gambar Rencana Usulan tidak boleh kosong.</ul>'
                ]);
            } else {
                if ($jml > 5) {
                    return response()->json([
                        'status'  => 2,
                        'message' => '<ul class="m--marginless">Jumlah Gambar Rencana Usulan melebihi dari maximal 5 File.</ul>'
                    ]);
                }
            }
        }

        $param = $this->cleanNumber($request->all(), ['harga_penawaran', 'luas_tanah','luas_bangunan','luas_bangunan_rencana','biaya_fisik','biaya_perencanaan','biaya_pengawasan','biaya_pengelolaan','pajak_pembangunan']);
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $pengadaan, $type) {
                $pengadaan->letter_number = $param['letter_number'];
                $pengadaan->letter_date = Carbon::parse($param['letter_date'])->toDateString();
                $pengadaan->perihal = $param['perihal'];
                $pengadaan->penandatangan_surat = $param['penandatangan_surat'];
                $pengadaan->id_rkbmn_uraian = $param['id_rkbmn_uraian'] != '' ? $param['id_rkbmn_uraian'] : null;

                if ($pengadaan->id_pengadaan_status == StatusPengadaan::DITOLAK_TK) {
                    $pengadaan->id_pengadaan_status = StatusPengadaan::PERMOHONAN_SATKER;
                }

                if ($pengadaan->save()) {
                    // Generate Location
                    $docLocation = $this->model->docLocation($pengadaan->id);
                    if (!file_exists($docLocation)) {
                        mkdir($this->model->docLocation($pengadaan->id), 0775, true);
                    }
                    // IF Pengadaan Tanah
                    if ($type == Pengadaan::PENGADAAN) {

                        $tanah = $pengadaan->tanah;
                        $tanah->jenis_pengadaan = $param['jenis_pengadaan'];

                        // Insert Pengadaan Tanah
                        if($param['tor'] != null) {
                            $fileDoc = $param['tor'];
                            $filename = time() . '-' . str_slug(explode('.',
                                    $fileDoc->getClientOriginalName())[0]) . '.' . $fileDoc->getClientOriginalExtension();
                            $fileDoc->move($docLocation, $filename);
                            $tanah->tor = $filename;
                        }
                        $tanah->save();

                        foreach ($pengadaan->tanah->penawaran as $i => $penawaran) {
                            $penawaran->harga_penawaran = $param['harga_penawaran'][$penawaran->id];
                            $penawaran->luas_tanah = $param['luas_tanah'][$penawaran->id];

                            $arrayFile = ['ktp', 'sertifikat', 'pajak', 'pernyataan', 'surat_harga', 'penawaran'];
                            foreach ($arrayFile as $file) {
                                if (isset($param[$file][$penawaran->id])) {
                                    $fileDoc = $param[$file][$penawaran->id];
                                    $filename = time() . '-' . str_slug(explode('.',
                                            $fileDoc->getClientOriginalName())[0]) . '.' . $fileDoc->getClientOriginalExtension();
                                    $fileDoc->move($docLocation, $filename);
                                    $penawaran->{$file} = $filename;
                                }
                            }

                            $penawaran->save();

                            $images = ImageTmp::where("uuid", $param["uuid"] . '-' . ($i + 1))->get();
                            foreach ($images as $image) {
                                if (file_exists(ImageTmp::imageLocation() . "/" . $image->file)) {
                                    if (!file_exists(PengadaanPenawaranFoto::imageLocation($pengadaan->id))) {
                                        mkdir(PengadaanPenawaranFoto::imageLocation($pengadaan->id), 0775, true);
                                    }
                                    copy(ImageTmp::imageLocation() . "/" . $image->file,
                                        PengadaanPenawaranFoto::imageLocation($pengadaan->id) . "/" . $image->file);
                                }

                                PengadaanPenawaranFoto::create([
                                    'id_pengadaan_penawaran' => $penawaran->id,
                                    'foto'                   => $image->file,
                                ]);
                            }
                        }
                    } else if ($type == Pengadaan::PEMBANGUNAN) {
                        $pembangunan = $pengadaan->pembangunan;
                        $pembangunan->jenis_pembangunan = $param['jenis_pembangunan'];
                        $pembangunan->luas_bangunan = $param['luas_bangunan'];
                        $pembangunan->biaya_fisik = $param['biaya_fisik'];
                        $pembangunan->biaya_perencanaan = $param['biaya_perencanaan'];
                        $pembangunan->biaya_pengawasan = $param['biaya_pengawasan'];
                        $pembangunan->biaya_pengelolaan = $param['biaya_pengelolaan'];
                        $pembangunan->pajak_pembangunan = $param['pajak_pembangunan'];

                        // Insert Document
                        $arrayFile = [
                            'surat_pengajuan',
                            'surat_psp',
                            'surat_rencana',
                            'surat_harga_satuan',
                            'surat_analisa',
                            'tor'
                        ];
                        foreach ($arrayFile as $file) {
                            if (isset($param[$file])) {
                                $fileDoc = $param[$file];
                                $filename = time() . '-' . str_slug(explode('.',
                                        $fileDoc->getClientOriginalName())[0]) . '.' . $fileDoc->getClientOriginalExtension();
                                $fileDoc->move($docLocation, $filename);
                                $pembangunan->{$file} = $filename;
                            }
                        }

                        $pembangunan->save();

                        // Insert Barang
                        $pembangunan->barangs()->delete();
                        $categories = json_decode($param['data'])->category;
                        $idBarang = json_decode($param['data'])->id;
                        $i = 1;
                        foreach ($categories as $key => $cat) {
                            $br = $idBarang[$key];

                            $barang = $this->findBarang($br, $cat);
                            PengadaanPembangunanBarang::create([
                                'id_pengadaan_pembangunan' => $pembangunan->id,
                                'id_asset'                 => $barang->kode_satker . '-' . $barang->kode_barang . '-' . $barang->nup,
                                'id_category_asset'        => $cat,
                                'nilai_perolehan'          => $barang->nilai_perolehan,
                                'ord'                      => $i++
                            ]);
                        }

                        // Insert Gambar
                        $gambars = FileTmp::where("uuid", $param["uuid"])->get();
                        foreach ($gambars as $gambar) {
                            if (file_exists(FileTmp::location() . "/" . $gambar->file)) {
                                if (!file_exists(PengadaanPembangunanGambar::imageLocation($pengadaan->id))) {
                                    mkdir(PengadaanPembangunanGambar::imageLocation($pengadaan->id), 0775, true);
                                }
                                rename(FileTmp::location() . "/" . $gambar->file,
                                    PengadaanPembangunanGambar::imageLocation($pengadaan->id) . "/" . $gambar->file);
                            }

                            PengadaanPembangunanGambar::create([
                                'id_pengadaan_pembangunan' => $pembangunan->id,
                                'file'                     => $gambar->file,
                            ]);

                            $gambar->delete();
                        }
                    } else if ($type == Pengadaan::RENOVASI) {
                        $renovasi = $pengadaan->renovasi;

                        // Data
                        $renovasi->jenis_pekerjaan       = $param['jenis_pekerjaan'];
                        $renovasi->jenis_barang          = $param['jenis_barang'];
                        $renovasi->luas_bangunan         = $param['luas_bangunan'];
                        $renovasi->luas_bangunan_rencana = $param['luas_bangunan_rencana'];
                        $renovasi->tingkat_kerusakan     = $param['tingkat_kerusakan'];
                        $renovasi->biaya_fisik           = $param['biaya_fisik'];
                        $renovasi->biaya_perencanaan     = $param['biaya_perencanaan'];
                        $renovasi->biaya_pengawasan      = $param['biaya_pengawasan'];
                        $renovasi->biaya_pengelolaan     = $param['biaya_pengelolaan'];
                        $renovasi->pajak_pembangunan     = $param['pajak_pembangunan'];

                        $arrayFile = [ 'surat_pengajuan','surat_psp','surat_harga','analisa_kerusakan','analisa_pu','tor'];
                        foreach ($arrayFile as $file) {
                            if (isset($param[$file])) {
                                $fileDoc = $param[$file];
                                $filename = time() . '-' . str_slug(explode('.',
                                        $fileDoc->getClientOriginalName())[0]) . '.' . $fileDoc->getClientOriginalExtension();
                                $fileDoc->move($docLocation, $filename);
                                $renovasi->{$file} = $filename;
                            }
                        }

                        $renovasi->save();

                        // Foto
                        $images = ImageTmp::where("uuid", $param["uuid"])->get();
                        foreach ($images as $image) {
                            if (file_exists(ImageTmp::imageLocation() . "/" . $image->file)) {
                                if (!file_exists(PengadaanRenovasiFoto::imageLocation($pengadaan->id))) {
                                    mkdir(PengadaanRenovasiFoto::imageLocation($pengadaan->id), 0775, true);
                                }
                                rename(ImageTmp::imageLocation() . "/" . $image->file,
                                    PengadaanRenovasiFoto::imageLocation($pengadaan->id) . "/" . $image->file);
                            }

                            PengadaanRenovasiFoto::create([
                                'id_pengadaan_renovasi' => $renovasi->id,
                                'foto'                   => $image->file,
                            ]);

                            $image->delete();
                        }

                        // Insert Gambar Eksisting
                        for ($i=1;$i<=2;$i++) {
                            $gambars = FileTmp::where("uuid", $param["uuid"].'-'.$i)->get();
                            foreach ($gambars as $gambar) {
                                if (file_exists(FileTmp::location() . "/" . $gambar->file)) {
                                    if (!file_exists(PengadaanRenovasiGambar::imageLocation($pengadaan->id))) {
                                        mkdir(PengadaanRenovasiGambar::imageLocation($pengadaan->id), 0775, true);
                                    }
                                    rename(FileTmp::location() . "/" . $gambar->file,
                                        PengadaanRenovasiGambar::imageLocation($pengadaan->id) . "/" . $gambar->file);
                                }

                                PengadaanRenovasiGambar::create([
                                    'id_pengadaan_renovasi' => $renovasi->id,
                                    'file'                  => $gambar->file,
                                    'type' => $i,
                                ]);

                                $gambar->delete();
                            }
                        }
                    }

                    PengadaanLog::create([
                        'id_pengadaan' => $pengadaan->id,
                        'created_by'     => \Auth::user()->id,
                        'id_status'      => PengadaanLog::EDIT
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
        $record = $this->model->join('users as u', 'u.id', '=', $this->model->getTable().'.created_by')->select($this->model->getTable().'.*',
            'id_satker')->findOrFail($id);
        if (!\Gate::allows('verifTk', $record)) {
            abort(403, "Not Allowed.");
        }

        $type = $record->id_pengadaan_type;
        $pengadaanType = PengadaanType::find($type);

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Verifikasi Pengajuan ' . $this->title . ' : ' . $record->letter_number . ' ( ' . $pengadaanType->name . ')';
        $data['config']['breadcrumb'] = $this->breadcrumb + [
                $this->title           => route($this->route . '.index'),
                'Verif Tk Banding'     => null,
                $record->letter_number => route($this->route . '.verif', $id)
            ];

        $data['data'] = $record;
        $data['type'] = $type;
        $data['penandatanganSurat'] = PenandatanganSurat::get();
        $data['isRevisi'] = $record->id_pengadaan_status == StatusPengadaan::DITOLAK_ADM || PengadaanLog::whereIdPengadaan($id)->whereIdStatus(PengadaanLog::DITOLAK_ADM)->count() > 0;

        switch ($type) {
            case 1:
                $data['jenisPengadaan'] = CategoryAsset::whereIn('id', [9, 10])->get();
                break;
            case 2:
                $data['barangs'] = $this->usulanBarang($record->pembangunan, 'pengadaan-pembangunan');
                $data['jenisPembangunan'] = [1 => 'Gedung Kantor', 2 => 'Rumah Negara', 3 => 'SARPRAS'];
                break;
            case 3:
                $data['jenisPekerjaan'] = [1 => 'Renovasi', 2 => 'Rehabilitasi', 3 => 'Restorasi'];
                $data['jenisBarang'] = [1 => 'Gedung Kantor', 2 => 'Rumah Dinas', 3 => 'Zitting Plat', 4 => 'Sarana Lainnya'];
                $data['tingkatKerusakan'] = [1 => 'Ringan (< 30%)', 2 => 'Sedang (>= 30% - 45%)', 3 => 'Berat (> 45% - 65%)', 4 => 'Khusus (> 65%)'];
                break;
        }

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
        $pengadaan = $this->model->join('users as u', 'u.id', '=',
            $this->model->getTable().'.created_by')->select($this->model->getTable().'.*', 'id_satker')->findOrFail($id);
        if (!\Gate::allows('verifTk', $pengadaan)) {
            abort(403, "Not Allowed.");
        }

        $isRevisi = $pengadaan->id_pengadaan_status == StatusPengadaan::DITOLAK_ADM || PengadaanLog::whereIdPengadaan($id)->whereIdStatus(PengadaanLog::DITOLAK_ADM)->count() > 0;
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
            $res = \DB::transaction(function () use ($param, $pengadaan) {
                $submit = $param["submit"];
                $keterangan = null;
                if ($submit == 0) {
                    $pengadaan->id_pengadaan_status = StatusPengadaan::DITOLAK_TK;
                    $keterangan = $param["keterangan_veriftk"];
                    $pengadaan->keterangan_veriftk = $keterangan;
                    $statusLog = PengadaanLog::DITOLAK_TK;
                    $keterangan = ["keterangan" => $keterangan];
                } else {
                    $paramVerif = [
                        'letter_number_banding'       => $param['letter_number_banding'],
                        'letter_date_banding'         => Carbon::parse($param['letter_date_banding'])->toDateString(),
                        'perihal_banding'             => $param['perihal_banding'],
                        'penandatangan_surat_banding' => $param['penandatangan_surat_banding'],
                    ];

                    $docLocation = $this->model->docLocation($pengadaan->id);
                    if ($param['surat_penghantar_banding'] != null) {
                        $fileSuratBanding = $param['surat_penghantar_banding'];
                        $filename = time() . '-' . str_slug(explode('.',
                                $fileSuratBanding->getClientOriginalName())[0]) . '.' . $fileSuratBanding->getClientOriginalExtension();
                        $fileSuratBanding->move($docLocation, $filename);
                        $paramVerif['surat_penghantar_banding'] = $filename;
                    }

                    foreach ($paramVerif as $k => $row) {
                        $pengadaan->{$k} = $row;
                    }
                    $pengadaan->id_pengadaan_status = StatusPengadaan::DITERIMA_TK;

                    $statusLog = PengadaanLog::DITERIMA_TK;
                    $keterangan = $paramVerif;
                }

                if ($pengadaan->save()) {
                    PengadaanLog::create([
                        'id_pengadaan' => $pengadaan->id,
                        'created_by'     => \Auth::user()->id,
                        'id_status'      => $statusLog,
                        'keterangan'     => json_encode($keterangan)
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil men-verifikasi Usulan ' . $this->title . ' dengan No Surat <strong>' . $pengadaan->letter_number . '</strong>'
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

        $type = $record->id_pengadaan_type;
        $pengadaanType = PengadaanType::find($type);

        $isDispo = $record->id_pengadaan_status == StatusPengadaan::DITERIMA_ADM;
        if ($isDispo) {
            $titleDetail = 'Verif Kepala Sub Bagian';
        } else {
            $titleDetail = 'Verif Kepala Bag Adm Pengadaan';
        }

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Verifikasi Pengajuan ' . $this->title . ' : ' . $record->letter_number. ' ( ' . $pengadaanType->name . ')';
        $data['config']['breadcrumb'] = $this->breadcrumb + [
                $this->title           => route($this->route . '.index'),
                $titleDetail           => null,
                $record->letter_number => route($this->route . '.disposisi', $id)
            ];

        $data['data'] = $record;
        $data['type'] = $type;
        $data['penandatanganSurat'] = PenandatanganSurat::get();
        $data['isDispo'] = $isDispo;

        switch ($type) {
            case 1:
                $data['jenisPengadaan'] = CategoryAsset::whereIn('id', [9, 10])->get();
                break;
            case 2:
                $data['barangs'] = $this->usulanBarang($record->pembangunan, 'pengadaan-pembangunan');
                $data['jenisPembangunan'] = [1 => 'Gedung Kantor', 2 => 'Rumah Negara', 3 => 'SARPRAS'];
                break;
            case 3:
                $data['jenisPekerjaan'] = [1 => 'Renovasi', 2 => 'Rehabilitasi', 3 => 'Restorasi'];
                $data['jenisBarang'] = [1 => 'Gedung Kantor', 2 => 'Rumah Dinas', 3 => 'Zitting Plat', 4 => 'Sarana Lainnya'];
                $data['tingkatKerusakan'] = [1 => 'Ringan (< 30%)', 2 => 'Sedang (>= 30% - 45%)', 3 => 'Berat (> 45% - 65%)', 4 => 'Khusus (> 65%)'];
                break;
        }

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
        $pengadaan = $this->model->findOrFail($id);
        if (!\Gate::allows('verifKepalaAdm', $pengadaan) && !\Gate::allows('dispoKepalaSub', $pengadaan)) {
            abort(403, "Not Allowed.");
        }

        $validate = ['submit' => 'required'];
        if ($request->input("submit") == 0) {
            $validate['keterangan'] = 'required';
        }

        $param = $request->all();
        $validator = \Validator::make($param, $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $pengadaan) {
                $isDispo = $pengadaan->id_pengadaan_status == StatusPengadaan::DITERIMA_ADM;

                $submit = $param["submit"];
                $keterangan = null;
                if ($submit == 0) {
                    $idPengadaanStatus = StatusPengadaan::DITOLAK_ADM;
                    $keterangan = $param["keterangan"];
                    $pengadaan->keterangan_verifadm = $keterangan;
                    $statusLog = PengadaanLog::DITOLAK_ADM;
                    $keterangan = ["keterangan" => $keterangan];
                } else {
                    if ($isDispo) {
                        $idPengadaanStatus = StatusPengadaan::PROSES;
                        $statusLog = PengadaanLog::PROSES;
                    } else {
                        $idPengadaanStatus = StatusPengadaan::DITERIMA_ADM;
                        $statusLog = PengadaanLog::DITERIMA_ADM;
                    }
                }
                $pengadaan->id_pengadaan_status = $idPengadaanStatus;

                if ($pengadaan->save()) {
                    PengadaanLog::create([
                        'id_pengadaan' => $pengadaan->id,
                        'created_by'     => \Auth::user()->id,
                        'id_status'      => $statusLog,
                        'keterangan'     => $keterangan == null ? null : json_encode($keterangan)
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil men-verifikasi Usulan ' . $this->title . ' dengan No Surat <strong>' . $pengadaan->letter_number . '</strong>'
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

        $type = $record->id_pengadaan_type;
        $pengadaanType = PengadaanType::find($type);

        $data['config'] = $this->config;
        $data['config']['pageTitle'] = 'Proses Pengajuan ' . $this->title . ' : ' . $record->letter_number. ' ( ' . $pengadaanType->name . ')';
        $data['config']['breadcrumb'] = $this->breadcrumb + [
                $this->title           => route($this->route . '.index'),
                'Proses'               => null,
                $record->letter_number => route($this->route . '.selesai', $id)
            ];

        $data['data'] = $record;
        $data['type'] = $type;
        $data['penandatanganSurat'] = PenandatanganSurat::get();

        switch ($type) {
            case 1:
                $data['jenisPengadaan'] = CategoryAsset::whereIn('id', [9, 10])->get();
                break;
            case 2:
                $data['barangs'] = $this->usulanBarang($record->pembangunan, 'pengadaan-pembangunan');
                $data['jenisPembangunan'] = [1 => 'Gedung Kantor', 2 => 'Rumah Negara', 3 => 'SARPRAS'];
                break;
            case 3:
                $data['jenisPekerjaan'] = [1 => 'Renovasi', 2 => 'Rehabilitasi', 3 => 'Restorasi'];
                $data['jenisBarang'] = [1 => 'Gedung Kantor', 2 => 'Rumah Dinas', 3 => 'Zitting Plat', 4 => 'Sarana Lainnya'];
                $data['tingkatKerusakan'] = [1 => 'Ringan (< 30%)', 2 => 'Sedang (>= 30% - 45%)', 3 => 'Berat (> 45% - 65%)', 4 => 'Khusus (> 65%)'];
                break;
        }

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
        $pengadaan = $this->model->findOrFail($id);
        if (!\Gate::allows('selesai', $pengadaan)) {
            abort(403, "Not Allowed.");
        }

        $validate = [
            'letter_number_persetujuan' => 'required|max:50',
            'letter_date_persetujuan'   => 'required|date_format:j F Y',
            'perihal_persetujuan'       => 'required',
            'surat_persetujuan'         => 'required|mimes:pdf|max:5000'
        ];

        $param = $request->all();
        $validator = \Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($param, $pengadaan) {
                $paramVerif = [
                    'letter_number_persetujuan' => $param['letter_number_persetujuan'],
                    'letter_date_persetujuan'   => Carbon::parse($param['letter_date_persetujuan'])->toDateString(),
                    'perihal_persetujuan'       => $param['perihal_persetujuan'],
                ];

                $docLocation = $this->model->docLocation($pengadaan->id);
                $fileSurat = $param['surat_persetujuan'];
                $filename = time() . '-' . str_slug(explode('.',
                        $fileSurat->getClientOriginalName())[0]) . '.' . $fileSurat->getClientOriginalExtension();
                $fileSurat->move($docLocation, $filename);
                $paramVerif['surat_persetujuan'] = $filename;

                foreach ($paramVerif as $k => $row) {
                    $pengadaan->{$k} = $row;
                }
                $pengadaan->id_pengadaan_status = StatusPengadaan::SELESAI;
                $statusLog = PengadaanLog::SELESAI;
                $keterangan = $paramVerif;

                if ($pengadaan->save()) {
                    PengadaanLog::create([
                        'id_pengadaan' => $pengadaan->id,
                        'created_by'     => \Auth::user()->id,
                        'id_status'      => $statusLog,
                        'keterangan'     => json_encode($keterangan)
                    ]);

                    $res = [
                        'status'  => 1,
                        'message' => 'Berhasil men-verifikasi Usulan ' . $this->title . ' dengan No Surat <strong>' . $pengadaan->letter_number . '</strong>'
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
    public function tableRkbmn(Request $request)
    {
        $year = $request->input('year');
        \Permission::access('view-' . $this->permission);

        $user = \Auth::user();
        $kodeSatker = $user->satker->kode;

        $model = RkbmnPengadaan::join('rkbmns', 'rkbmns.id', 'rkbmn_pengadaans.id_rkbmn')
            ->where('rkbmns.year', $year)->where('eselon1', 1)->where('draftuapb', 1)->where('apip', 1)->where('uapb',
                1)->where('djkn', 1)
            ->where('kode_satker', $kodeSatker)
            ->select([
                'eselon1',
                'draftuapb',
                'apip',
                'uapb',
                'djkn',
                'no_pengadaan',
                'kode_barang',
                'nama_barang',
                'kode_satker',
                'nama_satker'
            ]);

        $dataTable = \Datatable::create($model)
            ->setId('rkbmn_pengadaans.id')
            ->editColumn('eselon1', function ($data) {
                return '<i class="fa fa-' . ($data->eselon1 == 1 ? 'check' : ($data->eselon1 == 2 ? 'remove' : 'minus')) . '" style="color: ' . ($data->eselon1 == 1 ? '#2ecc71' : ($data->eselon1 == 2 ? '#e74c3c' : '#2c3e50')) . ';"></i>';
            })
            ->editColumn('draftuapb', function ($data) {
                return '<i class="fa fa-' . ($data->draftuapb == 1 ? 'check' : ($data->draftuapb == 2 ? 'remove' : 'minus')) . '" style="color: ' . ($data->draftuapb == 1 ? '#2ecc71' : ($data->draftuapb == 2 ? '#e74c3c' : '#2c3e50')) . ';"></i>';
            })
            ->editColumn('apip', function ($data) {
                return '<i class="fa fa-' . ($data->apip == 1 ? 'check' : ($data->apip == 2 ? 'remove' : 'minus')) . '" style="color: ' . ($data->apip == 1 ? '#2ecc71' : ($data->apip == 2 ? '#e74c3c' : '#2c3e50')) . ';"></i>';
            })
            ->editColumn('uapb', function ($data) {
                return '<i class="fa fa-' . ($data->uapb == 1 ? 'check' : ($data->uapb == 2 ? 'remove' : 'minus')) . '" style="color: ' . ($data->uapb == 1 ? '#2ecc71' : ($data->uapb == 2 ? '#e74c3c' : '#2c3e50')) . ';"></i>';
            })
            ->editColumn('djkn', function ($data) {
                return '<i class="fa fa-' . ($data->djkn == 1 ? 'check' : ($data->djkn == 2 ? 'remove' : 'minus')) . '" style="color: ' . ($data->djkn == 1 ? '#2ecc71' : ($data->djkn == 2 ? '#e74c3c' : '#2c3e50')) . ';"></i>';
            })
            ->editColumn('action', function ($data) {
                return '<a href="' . (route($this->route . '.detailRkbmn', $data->id)) . '" class="btn btn-primary btn-xs m-btn m-btn--icon m-btn--icon-only tooltips btn-detail" title="Pilih">
                    <i class="la la-check"></i>
                </a>';
            });
        $respond = $dataTable->make(true);

        return response()->json($respond);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function detailRkbmn(Request $request, $id)
    {
        $type = $request->input('type', null);

        $data = [
            'data' => RkbmnPengadaan::find($id),
            'type' => $type
        ];

        return view($this->layout . '.detailRkbmn', $data);
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
