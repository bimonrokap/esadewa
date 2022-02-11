<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Model\Asset\AssetTanah;
use App\Model\Asset\AssetBangunanGedung;
use App\Model\Asset\AssetRumahNegara;
use App\Model\Asset\AssetAlatBermotor;
use App\Model\MasterUsulan;
use App\Model\Satker;
use App\Model\TingkatBanding;
use App\Model\Wilayah;
use App\Repositories\Permission\Permission;
use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $layout;
    private $config;
    private $route = 'admin.dashboard';
    private $title = 'Dashboard';
    private $permission = 'dashboard';

    public function __construct()
    {
        $this->layout = $this->route;
        $this->config = [
            'route'     => $this->route,
            'title'     => $this->title,
            'pageTitle' => $this->title,
        ];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
//        $this->importData();
        Permission::access('view-' . $this->permission);

        $user = \Auth::user();

        $data['filterOn'] = false;
        $viewAllAsset = Permission::can('view-all-asset');
        $viewAllLingkunganAsset = Permission::can('view-all-lingkungan-asset');
        $viewAllWilayahAsset = Permission::can('view-all-wilayah-asset');
        $viewAllSatkerAsset = Permission::can('view-all-satker-asset');

        $data['viewAllAsset'] = $viewAllAsset;
        $data['viewAllLingkunganAsset'] = $viewAllLingkunganAsset;
        $data['viewAllWilayahAsset'] = $viewAllWilayahAsset;
        $data['viewAllSatkerAsset'] = $viewAllSatkerAsset;

        if($viewAllAsset || $viewAllWilayahAsset || $viewAllLingkunganAsset){
            $data['filterOn'] = true;
        }

        $data['config'] = $this->config;

        $data['title'] = 'KESELURUHAN';
        $lingkungan = ['PN' => 'Peradilan Umum', 'PA' => 'Peradilan Agama', 'PM' => 'Peradilan Militer', 'PT' => 'Peradilan Tata Usaha Negara', 'PMT' => 'Peradilan Militer & Tata Usaha Negara', 'PUSAT' => 'Pusat'];

        $filterData = $request->input('filterData');
        $filter = @$request->input('filter')[$filterData];

        if ($viewAllAsset) {

        } else if ($viewAllLingkunganAsset && $viewAllWilayahAsset) {
            $userLingkungan = $user->lingkungan;
            $wilayah = Wilayah::find($user->id_wilayah);

            $lingkunganTitle = $lingkungan[$userLingkungan];
            $data['title'] = $wilayah->name . ' - ' . $lingkunganTitle;
        } else if ($viewAllLingkunganAsset) {
            $userLingkungan = $user->lingkungan;
            $lingkunganTitle = 'Lingkungan : ' . $lingkungan[$userLingkungan];
            $data['title'] = $lingkunganTitle;
        } else if ($viewAllWilayahAsset) {
            $wilayah = Wilayah::find($user->id_wilayah);
            $data['title'] = 'Wilayah : ' . $wilayah->name;
        } else if ($viewAllSatkerAsset) {
            $satker = Satker::find($user->id_satker);
            $data['title'] = 'Satker : ' . $satker->name . ' ('.$satker->kode.')';
        }

        if ($filterData != '' && $filter != '') {
            switch ($filterData) {
                case 'satker':
                    $satker = Satker::whereKode($filter)->first();
                    $data['title'] = 'Satker : ' . $satker->name . ' ('.$satker->kode.')';
                    break;
                case 'wilayah':
                    $wilayah = Wilayah::find($filter);
                    $data['title'] = 'Wilayah : ' . $wilayah->name;
                    break;
                case 'lingkungan':
                    $data['title'] = 'Lingkungan : ' . $lingkungan[$filter];
                    break;
            }
        }

        $data['filter']['data'] = $filterData;
        $data['filter']['value'] = $filter;

        $data['tanah'] = [
            'total' => AssetTanah::filter($filterData, $filter)->assetBy()->count(),
            'kantor' => AssetTanah::filter($filterData, $filter)->assetBy()->kantor()->count(),
            'rumah' => AssetTanah::filter($filterData, $filter)->assetBy()->whereIn('kode_barang', ['2010101001', '2010101002', '2010101003'])->count()
        ];

        $data['gedung'] = [
            'total' => AssetBangunanGedung::filter($filterData, $filter)->assetBy()->count(),
            'kantor' => AssetBangunanGedung::filter($filterData, $filter)->assetBy()->kantor()->count(),
            'zitting' => AssetBangunanGedung::filter($filterData, $filter)->assetBy()->zitting()->count()
        ];

        $data['rumah'] = [
            'total' => AssetRumahNegara::filter($filterData, $filter)->assetBy()->count(),
            'gol_1' => AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1()->count(),
            'gol_2' => AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2()->count()
        ];

        $data['kendaraan'] = [
            'total' => AssetAlatBermotor::filter($filterData, $filter)->assetBy()->count(),
            'roda_2' => AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda2()->count(),
            'roda_4' => AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda4()->count()
        ];

        $data['total_usulan_psp'] = MasterUsulan::where('year', date('Y'))->whereType('psp')->first();
        if (is_null($data['total_usulan_psp'])) {
            $data['total_usulan_psp'] = 0;
        } else {
            $data['total_usulan_psp'] = $data['total_usulan_psp']->value;
        }
        $data['total_usulan_penghapusan'] = MasterUsulan::where('year', date('Y'))->whereType('penghapusan')->first();
        if (is_null($data['total_usulan_penghapusan'])) {
            $data['total_usulan_penghapusan'] = 0;
        } else {
            $data['total_usulan_penghapusan'] = $data['total_usulan_penghapusan']->value;
        }

        if ($viewAllAsset) {
            $data['satkers'] = Satker::get();
        } else if ($viewAllLingkunganAsset || $viewAllWilayahAsset) {
            $data['satkers'] = new Satker();
            if($viewAllWilayahAsset) {
                if($user->isTingkatBanding() || $user->isAdminTingkatBanding()) {
                    $tingkatBanding = TingkatBanding::join('satkers', 'satkers.id', 'id_satker')
                        ->where('tingkat_bandings.lingkungan', $user->lingkungan)
                        ->where('tingkat_bandings.id_wilayah', $user->id_wilayah)->select('satkers.kode')->get()
                        ->pluck('kode')->all();

                    if(!empty($tingkatBanding)) {
                        $data['satkers'] = $data['satkers']->whereIn('id', $tingkatBanding);
                    } else {
                        $data['satkers'] = $data['satkers']->where(DB::raw('SUBSTRING(kode, 6, 4)'), $wilayah->code);
                    }

                } else {
                    $data['satkers'] = $data['satkers']->where(DB::raw('SUBSTRING(kode, 6, 4)'), $wilayah->code);
                }
            }

            if($viewAllLingkunganAsset) {
                $lingkungan = $user->lingkungan;
                if($lingkungan == 'PMT') {
                    $data['satkers'] = $data['satkers']->where(function ($query){
                        return $query->whereSatkerType('PM')->orWhere('satker_type', 'PT');
                    });
                } else {
                    $data['satkers'] = $data['satkers']->whereSatkerType($lingkungan);
                }
            }

            $data['satkers'] = $data['satkers']->get();
        }

        $data['wilayahs'] = Wilayah::get();
        $data['lingkungans'] = $lingkungan;

        $data['request']['filter'] = $request->input('filter');

        return view('admin.dashboard.index', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function diagram(Request $request)
    {
        Permission::access('view-' . $this->permission);

        $filterData = $request->input('filter')['data'];
        $filter = $request->input('filter')['value'];

        $TanahSertifikat = AssetTanah::filter($filterData, $filter)->assetBy()->sertifikat()->count();
        $TanahTidakSertifikat =  AssetTanah::filter($filterData, $filter)->assetBy()->count() - AssetTanah::filter($filterData, $filter)->assetBy()->sertifikat()->count();

        $RumahNegaraGol = AssetRumahNegara::filter($filterData, $filter)->assetBy()->count();
        $RumahNegaraGol1 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1()->count();
        $RumahNegaraGol2 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2()->count();

        $KendaraanRoda2 = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda2()->count();
        $KendaraanRoda4 = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda4()->count();
        $KendaraanLainnya = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->count() - $KendaraanRoda2 - $KendaraanRoda4;
        $m1 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->where('luas_bangunan', '<=', 3000)->count();
        $m2 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->where('luas_bangunan', '>', 3000)->count();

        $response = array(
            'status' => true,
            'TanahSertifikat' => $TanahSertifikat,
            'TanahTidakSertifikat' => $TanahTidakSertifikat,
            'RumahNegaraGol1' => $RumahNegaraGol1,
            'RumahNegaraGol2' => $RumahNegaraGol2,
            'RumahNegaraLainnya' => $RumahNegaraGol - $RumahNegaraGol1 - $RumahNegaraGol2,
            'KendaraanRoda2' => $KendaraanRoda2,
            'KendaraanRoda4' => $KendaraanRoda4,
            'KendaraanLainnya' => $KendaraanLainnya,
            'm1' => $m1,
            'm2' => $m2
        );
        return response()->json($response);
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function asset($slug)
    {
        Permission::access('view-' . $this->permission);

        $data['config'] = $this->config;
        $data['slug'] = $slug;
        $data['option']['sertifikat'] = 'Sertifikat';

        $baseCategory = ['lingkungan' => 'Lingkungan','wilayah' => 'Wilayah'];
        $viewAllAsset = Permission::can('view-all-asset');
        $viewAllSatker = Permission::can('view-all-satker-asset');
        $viewAllWilayah = Permission::can('view-all-wilayah-asset');
        $viewAllLingkungan = Permission::can('view-all-lingkungan-asset');
        if($viewAllAsset) {

        }else if($viewAllSatker) {
            $baseCategory = [];
        } else if ($viewAllLingkungan && $viewAllWilayah) {
            $baseCategory = [];
        } else if ($viewAllLingkungan) {
            $baseCategory = ['wilayah' => 'Wilayah'];
        } else if ($viewAllWilayah) {
            $baseCategory = ['lingkungan' => 'Lingkungan'];
        }

        switch ($slug) {
            case 'tanah':
                $data['categories'] = array_merge($baseCategory, ['klasifikasi' => 'Klasifikasi']);
                $data['series'] = ['sertifikat' => 'Sertifikat', 'kondisi' => 'Kondisi', 'luasan' => 'Luasan'];

                $data['slug'] = $slug;
                $data['title'] = 'Tanah';
            break;

            case 'gedung':
                $data['categories'] = array_merge($baseCategory, ['klasifikasi' => 'Klasifikasi']);
                $data['series'] = ['sertifikat' => 'IMB', 'kondisi' => 'Kondisi', 'luasan' => 'Luasan'];

                $data['slug'] = $slug;
                $data['title'] = 'Gedung & Bangunan';
                break;
            case 'rumahnegara':
                $data['categories'] = array_merge($baseCategory, ['klasifikasi' => 'Golongan']);
                $data['series'] = ['sertifikat' => 'IMB', 'kondisi' => 'Kondisi', 'luasan' => 'Luasan'];

                $data['slug'] = $slug;
                $data['title'] = 'Rumah Negara';
                break;
            case 'kendaraan':
                $data['categories'] = array_merge($baseCategory, ['klasifikasi' => 'Klasifikasi']);
                $data['series'] = ['kondisi' => 'Kondisi'];

                $data['slug'] = $slug;
                $data['title'] = 'Kendaraan';
                break;

            default:
                abort(404);
        }

        return view('admin.dashboard.asset', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Request $request)
    {
        Permission::access('view-' . $this->permission);

        $category = $request->input('category');
        $type = $request->input('type');
        $series = $request->input('series');

        $filterData = $request->input('filter')['data'];
        $filter = $request->input('filter')['value'];

        $data = ['category' => $category];
        switch ($category) {
            case 'tanah':
                switch ($series) {
                    case 'sertifikat':
                        switch ($type) {
                            case 'total':
                                $data['title'] = '';
                                $sertifikat = AssetTanah::filter($filterData, $filter)->assetBy()->sertifikat()->count();
                                $belumSertifikat = AssetTanah::filter($filterData, $filter)->assetBy()->count() - $sertifikat;
                                break;
                            case 'kantor':
                                $data['title'] = 'Kantor';
                                $sertifikat = AssetTanah::filter($filterData, $filter)->assetBy()->kantor()->sertifikat()->count();
                                $belumSertifikat = AssetTanah::filter($filterData, $filter)->assetBy()->kantor()->count() - $sertifikat;
                                break;
                            case 'rumah_negara':
                                $data['title'] = 'Rumah Negara';
                                $sertifikat = AssetTanah::filter($filterData, $filter)->assetBy()->rumahNegara()->sertifikat()->count();
                                $belumSertifikat = AssetTanah::filter($filterData, $filter)->assetBy()->rumahNegara()->count() - $sertifikat;
                                break;
                            case 'lainnya':
                                $data['title'] = 'Lainnya';
                                $serKan = AssetTanah::filter($filterData, $filter)->assetBy()->kantor()->sertifikat()->count();
                                $serRm = AssetTanah::filter($filterData, $filter)->assetBy()->rumahNegara()->sertifikat()->count();

                                $beKan = AssetTanah::filter($filterData, $filter)->assetBy()->kantor()->count() - $serKan;
                                $beRm = AssetTanah::filter($filterData, $filter)->assetBy()->rumahNegara()->count() - $serRm;

                                $sertifikat = AssetTanah::filter($filterData, $filter)->assetBy()->sertifikat()->count() - $serKan - $serRm;
                                $belumSertifikat = AssetTanah::filter($filterData, $filter)->assetBy()->count() - AssetTanah::filter($filterData, $filter)->assetBy()->sertifikat()->count() - $beKan - $beRm;
                            break;
                        }

                        $data['data'] = [
                            ['name' => 'Sertifikat', 'y' => $sertifikat],
                            ['name' => 'Belum', 'y' => $belumSertifikat],
                        ];
                    break;
                    case 'kondisi':
                        switch ($type) {
                            case 'total':
                                $data['title'] = '';
                                $m1 = AssetTanah::filter($filterData, $filter)->assetBy()->whereKondisi('Baik')->count();
                                $m2 = AssetTanah::filter($filterData, $filter)->assetBy()->whereKondisi('Rusak Ringan')->count();
                                $m3 = AssetTanah::filter($filterData, $filter)->assetBy()->whereKondisi('Rusak Berat')->count();
                            break;
                            case 'kantor':
                                $data['title'] = 'Kantor';
                                $m1 = AssetTanah::filter($filterData, $filter)->assetBy()->kantor()->whereKondisi('Baik')->count();
                                $m2 = AssetTanah::filter($filterData, $filter)->assetBy()->kantor()->whereKondisi('Rusak Ringan')->count();
                                $m3 = AssetTanah::filter($filterData, $filter)->assetBy()->kantor()->whereKondisi('Rusak Berat')->count();
                            break;
                            case 'rumah_negara':
                                $data['title'] = 'Rumah Negara';
                                $m1 = AssetTanah::filter($filterData, $filter)->assetBy()->rumahNegara()->whereKondisi('Baik')->count();
                                $m2 = AssetTanah::filter($filterData, $filter)->assetBy()->rumahNegara()->whereKondisi('Rusak Ringan')->count();
                                $m3 = AssetTanah::filter($filterData, $filter)->assetBy()->rumahNegara()->whereKondisi('Rusak Berat')->count();
                            break;
                            case 'lainnya':
                                $data['title'] = 'Lainnya';
                                $m1 = AssetTanah::filter($filterData, $filter)->assetBy()->whereKondisi('Baik')->count() - AssetTanah::filter($filterData, $filter)->assetBy()->kantor()->whereKondisi('Baik')->count() - AssetTanah::filter($filterData, $filter)->assetBy()->rumahNegara()->whereKondisi('Baik')->count();
                                $m2 = AssetTanah::filter($filterData, $filter)->assetBy()->whereKondisi('Rusak Ringan')->count() - AssetTanah::filter($filterData, $filter)->assetBy()->kantor()->whereKondisi('Rusak Ringan')->count() - AssetTanah::filter($filterData, $filter)->assetBy()->rumahNegara()->whereKondisi('Rusak Ringan')->count();
                                $m3 = AssetTanah::filter($filterData, $filter)->assetBy()->whereKondisi('Rusak Berat')->count() - AssetTanah::filter($filterData, $filter)->assetBy()->kantor()->whereKondisi('Rusak Berat')->count() - AssetTanah::filter($filterData, $filter)->assetBy()->rumahNegara()->whereKondisi('Rusak Berat')->count();
                            break;
                        }

                        $data['data'] = [
                            ['name' => 'Baik', 'y' => $m1],
                            ['name' => 'Rusak Ringan', 'y' => $m2],
                            ['name' => 'Rusak Berat', 'y' => $m3],
                        ];
                    break;
                    case 'luasan':
                        switch ($type) {
                            case 'total':
                                $data['title'] = '';
                                $m1 = AssetTanah::filter($filterData, $filter)->assetBy()->where('luas_tanah_seluruhnya', '<=', 2000)->count();
                                $m2 = AssetTanah::filter($filterData, $filter)->assetBy()->whereBetween('luas_tanah_seluruhnya', [2001, 5000])->count();
                                $m3 = AssetTanah::filter($filterData, $filter)->assetBy()->where('luas_tanah_seluruhnya', '>', 5000)->count();
                            break;
                            case 'kantor':
                                $data['title'] = 'Kantor';
                                $m1 = AssetTanah::filter($filterData, $filter)->assetBy()->kantor()->where('luas_tanah_seluruhnya', '<=', 2000)->count();
                                $m2 = AssetTanah::filter($filterData, $filter)->assetBy()->kantor()->whereBetween('luas_tanah_seluruhnya', [2001, 5000])->count();
                                $m3 = AssetTanah::filter($filterData, $filter)->assetBy()->kantor()->where('luas_tanah_seluruhnya', '>', 5000)->count();
                            break;
                            case 'rumah_negara':
                                $data['title'] = 'Rumah Negara';
                                $m1 = AssetTanah::filter($filterData, $filter)->assetBy()->rumahNegara()->where('luas_tanah_seluruhnya', '<=', 2000)->count();
                                $m2 = AssetTanah::filter($filterData, $filter)->assetBy()->rumahNegara()->whereBetween('luas_tanah_seluruhnya', [2001, 5000])->count();
                                $m3 = AssetTanah::filter($filterData, $filter)->assetBy()->rumahNegara()->where('luas_tanah_seluruhnya', '>', 5000)->count();
                            break;
                            case 'lainnya':
                                $data['title'] = 'Lainnya';
                                $m1 = AssetTanah::filter($filterData, $filter)->assetBy()->where('luas_tanah_seluruhnya', '<=', 2000)->count() - AssetTanah::filter($filterData, $filter)->assetBy()->kantor()->where('luas_tanah_seluruhnya', '<=', 2000)->count() - AssetTanah::filter($filterData, $filter)->assetBy()->rumahNegara()->where('luas_tanah_seluruhnya', '<=', 2000)->count();
                                $m2 = AssetTanah::filter($filterData, $filter)->assetBy()->whereBetween('luas_tanah_seluruhnya', [2001, 5000])->count() - AssetTanah::filter($filterData, $filter)->assetBy()->kantor()->whereBetween('luas_tanah_seluruhnya', [2001, 5000])->count() - AssetTanah::filter($filterData, $filter)->assetBy()->rumahNegara()->whereBetween('luas_tanah_seluruhnya', [2001, 5000])->count();
                                $m3 = AssetTanah::filter($filterData, $filter)->assetBy()->where('luas_tanah_seluruhnya', '>', 5000)->count() - AssetTanah::filter($filterData, $filter)->assetBy()->kantor()->where('luas_tanah_seluruhnya', '>', 5000)->count() - AssetTanah::filter($filterData, $filter)->assetBy()->rumahNegara()->where('luas_tanah_seluruhnya', '>', 5000)->count();
                            break;
                        }

                        $data['data'] = [
                            ['name' => '< 2000 m2', 'y' => $m1],
                            ['name' => '2001 – 5000 m2', 'y' => $m2],
                            ['name' => '> 5000 m2', 'y' => $m3],
                        ];
                    break;
                }
                break;
            case 'gedung':
                switch ($series) {
                    case 'prototype':
                        switch ($type) {
                            case 'total':
                                $data['title'] = '';
                                $prototype = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->prototype()->count();
                                $belumPrototype = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->count() - $prototype;
                                break;
                            case 'kantor':
                                $data['title'] = 'Kantor';
                                $prototype = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->kantor()->prototype()->count();
                                $belumPrototype = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->kantor()->count() - $prototype;
                                break;
                            case 'zitting':
                                $data['title'] = 'Zitting Plaat';
                                $prototype = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->zitting()->prototype()->count();
                                $belumPrototype = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->zitting()->count() - $prototype;
                                break;
                            case 'lainnya':
                                $data['title'] = 'Lainnya';
                                $serKan = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->kantor()->prototype()->count();
                                $serRm = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->zitting()->prototype()->count();

                                $beKan = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->kantor()->count() - $serKan;
                                $beRm = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->zitting()->count() - $serRm;

                                $prototype = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->prototype()->count() - $serKan - $serRm;
                                $belumPrototype = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->count() - AssetBangunanGedung::filter($filterData, $filter)->assetBy()->prototype()->count() - $beKan - $beRm;
                            break;
                        }

                        $data['data'] = [
                            ['name' => 'Prototype', 'y' => $prototype],
                            ['name' => 'Belum', 'y' => $belumPrototype],
                        ];
                    break;
                    case 'kondisi':
                        switch ($type) {
                            case 'total':
                                $data['title'] = '';
                                $m1 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->whereKondisi('Baik')->count();
                                $m2 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->whereKondisi('Rusak Ringan')->count();
                                $m3 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->whereKondisi('Rusak Berat')->count();
                            break;
                            case 'kantor':
                                $data['title'] = 'Kantor';
                                $m1 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->kantor()->whereKondisi('Baik')->count();
                                $m2 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->kantor()->whereKondisi('Rusak Ringan')->count();
                                $m3 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->kantor()->whereKondisi('Rusak Berat')->count();
                            break;
                            case 'zitting':
                                $data['title'] = 'Zitting Plaat';
                                $m1 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->zitting()->whereKondisi('Baik')->count();
                                $m2 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->zitting()->whereKondisi('Rusak Ringan')->count();
                                $m3 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->zitting()->whereKondisi('Rusak Berat')->count();
                            break;
                            case 'lainnya':
                                $data['title'] = 'Lainnya';
                                $m1 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->whereKondisi('Baik')->count() - AssetBangunanGedung::filter($filterData, $filter)->assetBy()->kantor()->whereKondisi('Baik')->count() - AssetBangunanGedung::filter($filterData, $filter)->assetBy()->zitting()->whereKondisi('Baik')->count();
                                $m2 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->whereKondisi('Rusak Ringan')->count() - AssetBangunanGedung::filter($filterData, $filter)->assetBy()->kantor()->whereKondisi('Rusak Ringan')->count() - AssetBangunanGedung::filter($filterData, $filter)->assetBy()->zitting()->whereKondisi('Rusak Ringan')->count();
                                $m3 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->whereKondisi('Rusak Berat')->count() - AssetBangunanGedung::filter($filterData, $filter)->assetBy()->kantor()->whereKondisi('Rusak Berat')->count() - AssetBangunanGedung::filter($filterData, $filter)->assetBy()->zitting()->whereKondisi('Rusak Berat')->count();
                            break;
                        }

                        $data['data'] = [
                            ['name' => 'Baik', 'y' => $m1],
                            ['name' => 'Rusak Ringan', 'y' => $m2],
                            ['name' => 'Rusak Berat', 'y' => $m3],
                        ];
                    break;
                    case 'luasan':
                        switch ($type) {
                            case 'total':
                                $data['title'] = '';
                                $m1 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->where('luas_bangunan', '<=', 3000)->count();
                                $m2 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->where('luas_bangunan', '>', 3000)->count();
                            break;
                            case 'kantor':
                                $data['title'] = 'Kantor';
                                $m1 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->kantor()->where('luas_bangunan', '<=', 3000)->count();
                                $m2 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->kantor()->where('luas_bangunan', '>', 3000)->count();
                            break;
                            case 'zitting':
                                $data['title'] = 'Zitting Plaat';
                                $m1 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->zitting()->where('luas_bangunan', '<=', 3000)->count();
                                $m2 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->zitting()->where('luas_bangunan', '>', 3000)->count();
                            break;
                            case 'lainnya':
                                $data['title'] = 'Lainnya';
                                $m1 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->where('luas_bangunan', '<=', 3000)->count() - AssetBangunanGedung::filter($filterData, $filter)->assetBy()->kantor()->where('luas_bangunan', '<=', 3000)->count() - AssetBangunanGedung::filter($filterData, $filter)->assetBy()->zitting()->where('luas_bangunan', '<=', 3000)->count();
                                $m2 = AssetBangunanGedung::filter($filterData, $filter)->assetBy()->where('luas_bangunan', '>', 3000)->count() - AssetBangunanGedung::filter($filterData, $filter)->assetBy()->kantor()->where('luas_bangunan', '>', 3000)->count() - AssetBangunanGedung::filter($filterData, $filter)->assetBy()->zitting()->where('luas_bangunan', '>', 3000)->count();
                            break;
                        }

                        $data['data'] = [
                            ['name' => '<= 3000 m2', 'y' => $m1],
                            ['name' => '> 3000 m2', 'y' => $m2],
                        ];
                    break;
                }
                break;
            case 'rumah':
                switch ($series) {
                    case 'golongan':
                        switch ($type) {
                            case 'total':
                                $data['title'] = '';
                                $gol1 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1()->count();
                                $gol2 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2()->count();
                                $tmpData = [
                                    ['name' => 'Golongan 1', 'y' => $gol1],
                                    ['name' => 'Golongan 2', 'y' => $gol2],
                                    ['name' => 'Lainnya', 'y' => AssetRumahNegara::filter($filterData, $filter)->assetBy()->count() - $gol1 - $gol2],
                                ];
                                break;
                            case 'gol_1':
                                $data['title'] = 'Golongan 1';
                                $gola = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1a()->count();
                                $golb = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1b()->count();
                                $golc = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1c()->count();

                                $tmpData = [
                                    ['name' => 'Golongan 1a', 'y' => $gola],
                                    ['name' => 'Golongan 1b', 'y' => $golb],
                                    ['name' => 'Golongan 1c', 'y' => $golc],
                                ];
                                break;
                            case 'gol_2':
                                $data['title'] = 'Golongan 2';
                                $gola = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2a()->count();
                                $golb = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2b()->count();
                                $golc = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2c()->count();

                                $tmpData = [
                                    ['name' => 'Golongan 2a', 'y' => $gola],
                                    ['name' => 'Golongan 2b', 'y' => $golb],
                                    ['name' => 'Golongan 2c', 'y' => $golc],
                                ];
                                break;
                            case 'lainnya':
                                $data['title'] = 'Lainnya';
                                $gol1 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1Lainnya()->count();
                                $gol2 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2Lainnya()->count();

                                $tmpData = [
                                    ['name' => 'Golongan 1 Lainnya', 'y' => $gol1],
                                    ['name' => 'Golongan 2 Lainnya', 'y' => $gol2],
                                ];
                            break;
                        }

                        $data['data'] = $tmpData;
                    break;
                    case 'kondisi':
                        switch ($type) {
                            case 'total':
                                $data['title'] = '';
                                $m1 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->whereKondisi('Baik')->count();
                                $m2 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->whereKondisi('Rusak Ringan')->count();
                                $m3 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->whereKondisi('Rusak Berat')->count();
                            break;
                            case 'gol_1':
                                $data['title'] = 'Golongan 1';
                                $m1 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1()->whereKondisi('Baik')->count();
                                $m2 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1()->whereKondisi('Rusak Ringan')->count();
                                $m3 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1()->whereKondisi('Rusak Berat')->count();
                            break;
                            case 'gol_2':
                                $data['title'] = 'Golongan 2';
                                $m1 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2()->whereKondisi('Baik')->count();
                                $m2 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2()->whereKondisi('Rusak Ringan')->count();
                                $m3 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2()->whereKondisi('Rusak Berat')->count();
                            break;
                            case 'lainnya':
                                $data['title'] = 'Lainnya';
                                $m1 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->whereKondisi('Baik')->count() - AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1()->whereKondisi('Baik')->count() - AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2()->whereKondisi('Baik')->count();
                                $m2 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->whereKondisi('Rusak Ringan')->count() - AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1()->whereKondisi('Rusak Ringan')->count() - AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2()->whereKondisi('Rusak Ringan')->count();
                                $m3 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->whereKondisi('Rusak Berat')->count() - AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1()->whereKondisi('Rusak Berat')->count() - AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2()->whereKondisi('Rusak Berat')->count();
                            break;
                        }

                        $data['data'] = [
                            ['name' => 'Baik', 'y' => $m1],
                            ['name' => 'Rusak Ringan', 'y' => $m2],
                            ['name' => 'Rusak Berat', 'y' => $m3],
                        ];
                    break;
                    case 'luasan':
                        switch ($type) {
                            case 'total':
                                $data['title'] = '';
                                $m1 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->where('luas_bangunan', '<', 70)->count();
                                $m2 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->where('luas_bangunan', '>=', 70)->where('luas_bangunan', '<=', 250)->count();
                                $m3 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->where('luas_bangunan', '>', 250)->count();
                            break;
                            case 'gol_1':
                                $data['title'] = 'Golongan 1';
                                $m1 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1()->where('luas_bangunan', '<', 70)->count();
                                $m2 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1()->where('luas_bangunan', '>=', 70)->where('luas_bangunan', '<=', 250)->count();
                                $m3 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1()->where('luas_bangunan', '>', 250)->count();
                            break;
                            case 'gol_2':
                                $data['title'] = 'Golongan 2';
                                $m1 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2()->where('luas_bangunan', '<', 70)->count();
                                $m2 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2()->where('luas_bangunan', '>=', 70)->where('luas_bangunan', '<=', 250)->count();
                                $m3 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2()->where('luas_bangunan', '>', 250)->count();
                            break;
                            case 'lainnya':
                                $data['title'] = 'Lainnya';
                                $m1 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->where('luas_bangunan', '<', 70)->count() - AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1()->where('luas_bangunan', '<', 70)->count() - AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2()->where('luas_bangunan', '<', 70)->count();
                                $m2 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->where('luas_bangunan', '>=', 70)->where('luas_bangunan', '<=', 250)->count() - AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1()->where('luas_bangunan', '>=', 70)->where('luas_bangunan', '<=', 250)->count() - AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2()->where('luas_bangunan', '>=', 70)->where('luas_bangunan', '<=', 250)->count();
                                $m3 = AssetRumahNegara::filter($filterData, $filter)->assetBy()->where('luas_bangunan', '>', 250)->count() - AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan1()->where('luas_bangunan', '>', 250)->count() - AssetRumahNegara::filter($filterData, $filter)->assetBy()->golongan2()->where('luas_bangunan', '>', 250)->count();
                            break;
                        }

                        $data['data'] = [
                            ['name' => '< 70m2', 'y' => $m1],
                            ['name' => '71 - 250 m2', 'y' => $m2],
                            ['name' => '> 250 m2', 'y' => $m3],
                        ];
                    break;
                }
                break;
            case 'kendaraan':
                switch ($series) {
                    case 'klasifikasi':
                        switch ($type) {
                            case 'total':
                                $data['title'] = '';
                                $gol1 = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda2()->count();
                                $gol2 = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda4()->count();
                                $tmpData = [
                                    ['name' => 'Roda 2', 'y' => $gol1],
                                    ['name' => 'Roda 4', 'y' => $gol2],
                                    ['name' => 'Lainnya', 'y' => AssetAlatBermotor::filter($filterData, $filter)->assetBy()->count() - $gol1 - $gol2],
                                ];
                                break;
                            case 'roda2':
                                $data['title'] = 'Roda 2';
                                $gola = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda2bermotor()->count();
                                $golb = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda2lainnya()->count();

                                $tmpData = [
                                    ['name' => 'Bermotor', 'y' => $gola],
                                    ['name' => 'Tidak Bermotor', 'y' => $golb]
                                ];
                                break;
                            case 'roda4':
                                $data['title'] = 'Roda 4';
                                $gola = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda4sedan()->count();
                                $golb = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda4wagon()->count();
                                $golc = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda4mini()->count();

                                $tmpData = [
                                    ['name' => 'Sedan', 'y' => $gola],
                                    ['name' => 'Stasion Wagon', 'y' => $golb],
                                    ['name' => 'Mini Bus', 'y' => $golc],
                                ];
                                break;
                            case 'lainnya':
                                $data['title'] = 'Lainnya';
                                $gol1 = 0;
                                $gol2 = 0;

                                $tmpData = [
                                    ['name' => 'Golongan 1 Lainnya', 'y' => $gol1],
                                    ['name' => 'Golongan 2 Lainnya', 'y' => $gol2],
                                ];
                            break;
                        }

                        $data['data'] = $tmpData;
                    break;
                    case 'kondisi':
                        switch ($type) {
                            case 'total':
                                $data['title'] = '';
                                $m1 = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->whereKondisi('Baik')->count();
                                $m2 = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->whereKondisi('Rusak Ringan')->count();
                                $m3 = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->whereKondisi('Rusak Berat')->count();
                            break;
                            case 'roda2':
                                $data['title'] = 'Golongan 1';
                                $m1 = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda2()->whereKondisi('Baik')->count();
                                $m2 = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda2()->whereKondisi('Rusak Ringan')->count();
                                $m3 = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda2()->whereKondisi('Rusak Berat')->count();
                            break;
                            case 'roda4':
                                $data['title'] = 'Golongan 2';
                                $m1 = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda4()->whereKondisi('Baik')->count();
                                $m2 = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda4()->whereKondisi('Rusak Ringan')->count();
                                $m3 = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda4()->whereKondisi('Rusak Berat')->count();
                            break;
                            case 'lainnya':
                                $data['title'] = 'Lainnya';
                                $m1 = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->whereKondisi('Baik')->count() - AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda2()->whereKondisi('Baik')->count() - AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda4()->whereKondisi('Baik')->count();
                                $m2 = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->whereKondisi('Rusak Ringan')->count() - AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda2()->whereKondisi('Rusak Ringan')->count() - AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda4()->whereKondisi('Rusak Ringan')->count();
                                $m3 = AssetAlatBermotor::filter($filterData, $filter)->assetBy()->whereKondisi('Rusak Berat')->count() - AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda2()->whereKondisi('Rusak Berat')->count() - AssetAlatBermotor::filter($filterData, $filter)->assetBy()->roda4()->whereKondisi('Rusak Berat')->count();
                            break;
                        }

                        $data['data'] = [
                            ['name' => 'Baik', 'y' => $m1],
                            ['name' => 'Rusak Ringan', 'y' => $m2],
                            ['name' => 'Rusak Berat', 'y' => $m3],
                        ];
                    break;
                }
                break;
        }

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function detailDiagram(Request $request, $slug)
    {
        Permission::access('view-' . $this->permission);

        $category = $request->input('category');
        $getSeries = $request->input('series');

        $filterData = $request->input('filterData');
        $filter = $request->input('filter')[$filterData];

        switch ($slug) {
            case 'tanah':
                switch ($getSeries) {
                    case 'kondisi':
                        switch ($category) {
                            case 'klasifikasi':
                                $data['category'] = ['Tanah Kosong yg Diperuntukkan', 'Tanah Kantor Pemerintah', 'Tanah rumah Negara Golongan I', 'Tanah rumah Negara Golongan II', 'Tanah Bangunan Mess', 'Tanah Balai Sidang', 'Tanah Lainnya'];
                                $tmp = AssetTanah::selectRaw("
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 202002  , 1, 0 ) ) AS tanah_kosong,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 104001  , 1, 0 ) ) AS tanah_kantor,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 101001  , 1, 0 ) ) AS tanah_gol_i,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 101002  , 1, 0 ) ) AS tanah_gol_ii,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 101005  , 1, 0 ) ) AS tanah_mess,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 104004  , 1, 0 ) ) AS tanah_balai,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) NOT IN (202002, 104001, 101001, 101002, 101005, 104004)  , 1, 0 ) ) AS tanah_lainnya,
                                    kondisi")
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('kondisi')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $baik = [0, 0, 0, 0, 0, 0, 0];
                                    $rusakRingan = [0, 0, 0, 0, 0, 0, 0];
                                    $rusakBerat = [0, 0, 0, 0, 0, 0, 0];
                                } else {
                                    $baik = $tmp->where('kondisi', 'Baik')->first();
                                    $baik = [(int) $baik['tanah_kosong'], (int) $baik['tanah_kantor'], (int) $baik['tanah_gol_i'], (int) $baik['tanah_gol_ii'], (int) $baik['tanah_mess'], (int) $baik['tanah_balai'], (int) $baik['tanah_lainnya']];

                                    $rusakRingan = $tmp->where('kondisi', 'Rusak Ringan')->first();
                                    $rusakRingan = [(int) $rusakRingan['tanah_kosong'], (int) $rusakRingan['tanah_kantor'], (int) $rusakRingan['tanah_gol_i'], (int) $rusakRingan['tanah_gol_ii'], (int) $rusakRingan['tanah_mess'], (int) $rusakRingan['tanah_balai'], (int) $rusakRingan['tanah_lainnya']];

                                    $rusakBerat = $tmp->where('kondisi', 'Rusak Berat')->first();
                                    $rusakBerat = [(int) $rusakBerat['tanah_kosong'], (int) $rusakBerat['tanah_kantor'], (int) $rusakBerat['tanah_gol_i'], (int) $rusakBerat['tanah_gol_ii'], (int) $rusakBerat['tanah_mess'], (int) $rusakBerat['tanah_balai'], (int) $rusakBerat['tanah_lainnya']];
                                }
                                break;
                            case 'lingkungan':
                                $data['category'] = ['Umum', 'Agama', 'TUN', 'Militer', 'BUA'];

                                $tmp = AssetTanah::selectRaw("
                                    SUM( IF ( satker_type = 'PN', 1, 0 ) ) AS PN,
                                    SUM( IF ( satker_type = 'PA', 1, 0 ) ) AS PA,
                                    SUM( IF ( satker_type = 'PM', 1, 0 ) ) AS PM,
                                    SUM( IF ( satker_type = 'PT', 1, 0 ) ) AS PT,
                                    SUM( IF ( satker_type = 'PUSAT', 1, 0 ) ) AS PUSAT,
                                    kondisi")
                                    ->join('satkers', 'asset_tanahs.kode_satker', '=', 'satkers.kode')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('kondisi')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $baik = [0, 0, 0, 0, 0];
                                    $rusakRingan = [0, 0, 0, 0, 0];
                                    $rusakBerat = [0, 0, 0, 0, 0];
                                } else {
                                    $baik = $tmp->where('kondisi', 'Baik')->first();
                                    $baik = [(int) $baik['PN'], (int) $baik['PA'], (int) $baik['PT'], (int) $baik['PM'], (int) $baik['PUSAT']];

                                    $rusakRingan = $tmp->where('kondisi', 'Rusak Ringan')->first();
                                    $rusakRingan = [(int) $rusakRingan['PN'], (int) $rusakRingan['PA'], (int) $rusakRingan['PT'], (int) $rusakRingan['PM'], (int) $rusakRingan['PUSAT']];

                                    $rusakBerat = $tmp->where('kondisi', 'Rusak Berat')->first();
                                    $rusakBerat = [(int) $rusakBerat['PN'], (int) $rusakBerat['PA'], (int) $rusakBerat['PT'], (int) $rusakBerat['PM'], (int) $rusakBerat['PUSAT']];
                                }
                                break;
                            case 'wilayah':
                                $wilayah =  AssetTanah::selectRaw('wilayahs.name, wilayahs.id')
                                    ->join('wilayahs', DB::raw('substr(asset_tanahs.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->orderBy('wilayahs.name', 'ASC')
                                    ->groupBy('wilayahs.id')->get();
                                $data['category'] = $wilayah->pluck('name');

                                $tmp = AssetTanah::selectRaw("
                                    wilayahs.id as id,
                                    SUM( IF ( kondisi = 'Baik', 1, 0 ) ) AS baik,
                                    SUM( IF ( kondisi = 'Rusak Berat', 1, 0 ) ) AS rusak_berat,
                                    SUM( IF ( kondisi = 'Rusak Ringan', 1, 0 ) ) AS rusak_ringan")
                                    ->join('wilayahs', DB::raw('substr(asset_tanahs.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('wilayahs.id')
                                    ->get();

                                $dataTmp = $tmp->keyBy('id');
                                foreach ($wilayah as $row) {
                                    if (isset($dataTmp[$row->id])) {
                                        $dat = $dataTmp[$row->id];

                                        $baik[] = (int) $dat->baik;
                                        $rusakRingan[] = (int) $dat->rusak_ringan;
                                        $rusakBerat[] = (int) $dat->rusak_berat;
                                    } else {
                                        $baik[] = 0;
                                        $rusakRingan[] = 0;
                                        $rusakBerat[] = 0;
                                    }
                                }
                                break;
                            default:
                                $data['category'] = ['Tanah'];
                                $assetTanah = AssetTanah::selectRaw('SUM( IF ( kondisi = \'Baik\', 1, 0 ) ) AS baik,
                                    SUM( IF ( kondisi = \'Rusak Berat\', 1, 0 ) ) AS rusak_berat,
                                    SUM( IF ( kondisi = \'Rusak Ringan\', 1, 0 ) ) AS rusak_ringan')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->first();

                                if (is_null($assetTanah)) {
                                    $baik = [0];
                                    $rusakRingan = [0];
                                    $rusakBerat = [0];
                                } else {
                                    $baik = [(int) $assetTanah['baik']];
                                    $rusakRingan = [(int) $assetTanah['rusak_ringan']];
                                    $rusakBerat = [(int) $assetTanah['rusak_berat']];
                                }
                                break;
                        }
                        $series = [
                            ['name' => 'Baik', 'data' => $baik],
                            ['name' => 'Rusak Ringan', 'data' => $rusakRingan],
                            ['name' => 'Rusak Berat', 'data' => $rusakBerat]
                        ];
                        break;
                    case 'luasan':
                        $data['category'] = ['Tanah'];
                        switch ($category) {
                            case 'klasifikasi':
                                $data['category'] = ['Tanah Kosong yg Diperuntukkan', 'Tanah Kantor Pemerintah', 'Tanah rumah Negara Golongan I', 'Tanah rumah Negara Golongan II', 'Tanah Bangunan Mess', 'Tanah Balai Sidang', 'Tanah Lainnya'];
                                $tmp = AssetTanah::selectRaw("
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 202002  , 1, 0 ) ) AS tanah_kosong,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 104001  , 1, 0 ) ) AS tanah_kantor,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 101001  , 1, 0 ) ) AS tanah_gol_i,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 101002  , 1, 0 ) ) AS tanah_gol_ii,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 101005  , 1, 0 ) ) AS tanah_mess,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 104004  , 1, 0 ) ) AS tanah_balai,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) NOT IN (202002, 104001, 101001, 101002, 101005, 104004)  , 1, 0 ) ) AS tanah_lainnya,
                                    if(luas_tanah_seluruhnya <= 2000, 'l1', IF(luas_tanah_seluruhnya > 5000, 'l3', 'l2')) as luasan")
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('luasan')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $l1 = $l2 = $l3 = [0, 0, 0, 0, 0, 0, 0];
                                } else {
                                    $l1 = $tmp->where('luasan', 'l1')->first();
                                    $l1 = [(int) $l1['tanah_kosong'], (int) $l1['tanah_kantor'], (int) $l1['tanah_gol_i'], (int) $l1['tanah_gol_ii'], (int) $l1['tanah_mess'], (int) $l1['tanah_balai'], (int) $l1['tanah_lainnya']];

                                    $l2 = $tmp->where('luasan', 'l2')->first();
                                    $l2 = [(int) $l2['tanah_kosong'], (int) $l2['tanah_kantor'], (int) $l2['tanah_gol_i'], (int) $l2['tanah_gol_ii'], (int) $l2['tanah_mess'], (int) $l2['tanah_balai'], (int) $l2['tanah_lainnya']];

                                    $l3 = $tmp->where('luasan', 'l3')->first();
                                    $l3 = [(int) $l3['tanah_kosong'], (int) $l3['tanah_kantor'], (int) $l3['tanah_gol_i'], (int) $l3['tanah_gol_ii'], (int) $l3['tanah_mess'], (int) $l3['tanah_balai'], (int) $l3['tanah_lainnya']];
                                }
                                break;
                            case 'lingkungan':
                                $data['category'] = ['Umum', 'Agama', 'TUN', 'Militer', 'BUA'];

                                $tmp = AssetTanah::selectRaw("
                                    SUM( IF ( satker_type = 'PN', 1, 0 ) ) AS PN,
                                    SUM( IF ( satker_type = 'PA', 1, 0 ) ) AS PA,
                                    SUM( IF ( satker_type = 'PM', 1, 0 ) ) AS PM,
                                    SUM( IF ( satker_type = 'PT', 1, 0 ) ) AS PT,
                                    SUM( IF ( satker_type = 'PUSAT', 1, 0 ) ) AS PUSAT,
                                    if(luas_tanah_seluruhnya <= 2000, 'l1', IF(luas_tanah_seluruhnya > 5000, 'l3', 'l2')) as luasan")
                                    ->join('satkers', 'asset_tanahs.kode_satker', '=', 'satkers.kode')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('luasan')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $l1 = $l2 = $l3 = [0, 0, 0, 0, 0];
                                } else {
                                    $l1 = $tmp->where('luasan', 'l1')->first();
                                    $l1 = [(int) $l1['PN'], (int) $l1['PA'], (int) $l1['PT'], (int) $l1['PM'], (int) $l1['PUSAT']];

                                    $l2 = $tmp->where('luasan', 'l2')->first();
                                    $l2 = [(int) $l2['PN'], (int) $l2['PA'], (int) $l2['PT'], (int) $l2['PM'], (int) $l2['PUSAT']];

                                    $l3 = $tmp->where('luasan', 'l3')->first();
                                    $l3 = [(int) $l3['PN'], (int) $l3['PA'], (int) $l3['PT'], (int) $l3['PM'], (int) $l3['PUSAT']];
                                }
                                break;
                            case 'wilayah':
                                $wilayah =  AssetTanah::selectRaw('wilayahs.name, wilayahs.id')
                                    ->join('wilayahs', DB::raw('substr(asset_tanahs.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->orderBy('wilayahs.name', 'ASC')
                                    ->groupBy('wilayahs.id')
                                    ->get();

                                $data['category'] = $wilayah->pluck('name');

                                $tmp = AssetTanah::selectRaw("
                                    wilayahs.id as id,
                                    SUM( IF ( luas_tanah_seluruhnya <= 2000, 1, 0 ) ) AS l1,
                                    SUM( IF ( luas_tanah_seluruhnya > 2000 AND luas_tanah_seluruhnya <= 5000 , 1, 0 ) ) AS l2,
                                    SUM( IF ( luas_tanah_seluruhnya > 5000, 1, 0 ) ) AS l3")
                                    ->join('wilayahs', DB::raw('substr(asset_tanahs.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('wilayahs.id')
                                    ->get();

                                $dataTmp = $tmp->keyBy('id');

                                foreach ($wilayah as $row) {
                                    if (isset($dataTmp[$row->id])) {
                                        $dat = $dataTmp[$row->id];

                                        $l1[] = (int) $dat->l1;
                                        $l2[] = (int) $dat->l2;
                                        $l3[] = (int) $dat->l3;
                                    } else {
                                        $l1[] = 0;
                                        $l2[] = 0;
                                        $l3[] = 0;
                                    }
                                }
                                break;
                            default:
                                $assetTanah = AssetTanah::selectRaw('
                                    SUM( IF ( luas_tanah_seluruhnya <= 2000, 1, 0 ) ) AS l1,
                                    SUM( IF ( luas_tanah_seluruhnya > 2000 AND luas_tanah_seluruhnya <= 5000 , 1, 0 ) ) AS l2,
                                    SUM( IF ( luas_tanah_seluruhnya > 5000, 1, 0 ) ) AS l3')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->first();

                                if (is_null($assetTanah)) {
                                    $l1 = [0];
                                    $l2 = [0];
                                    $l3 = [0];
                                } else {
                                    $l1 = [(int) $assetTanah['l1']];
                                    $l2 = [(int) $assetTanah['l2']];
                                    $l3 = [(int) $assetTanah['l3']];
                                }
                                break;
                        }

                        $series = [
                            ['name' => '<= 2000 m2', 'data' => $l1],
                            ['name' => '2001 - 5000 m2', 'data' => $l2],
                            ['name' => '> 5000 m2', 'data' => $l3]
                        ];
                    break;
                    default:
                        $data['category'] = ['Tanah'];
                        switch ($category) {
                            case 'klasifikasi':
                                $data['category'] = ['Tanah Kosong yg Diperuntukkan', 'Tanah Kantor Pemerintah', 'Tanah rumah Negara Golongan I', 'Tanah rumah Negara Golongan II', 'Tanah Bangunan Mess', 'Tanah Balai Sidang', 'Tanah Lainnya'];
                                $tmp = AssetTanah::selectRaw("
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 202002  , 1, 0 ) ) AS tanah_kosong,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 104001  , 1, 0 ) ) AS tanah_kantor,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 101001  , 1, 0 ) ) AS tanah_gol_i,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 101002  , 1, 0 ) ) AS tanah_gol_ii,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 101005  , 1, 0 ) ) AS tanah_mess,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) = 104004  , 1, 0 ) ) AS tanah_balai,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 6) NOT IN (202002, 104001, 101001, 101002, 101005, 104004)  , 1, 0 ) ) AS tanah_lainnya,
                                    if(kepemilikan = 'Bersertifikat atas nama Pemerintah RI c.q Kementerian/ Lembaga', 's1', if(kepemilikan = 'Bersertifikat atas nama Kementerian/ Lembaga', 's2', if(kepemilikan = 'Bersertifikat atas nama Pihak Ketiga', 's3', 's4'))) as sertifikat")
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('sertifikat')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $sertifikatA = $sertifikatB = $sertifikatC = $sertifikatD = [0, 0, 0, 0, 0, 0, 0];
                                } else {
                                    $sertifikatA = $tmp->where('sertifikat', 's1')->first();
                                    $sertifikatA = [(int) $sertifikatA['tanah_kosong'], (int) $sertifikatA['tanah_kantor'], (int) $sertifikatA['tanah_gol_i'], (int) $sertifikatA['tanah_gol_ii'], (int) $sertifikatA['tanah_mess'], (int) $sertifikatA['tanah_balai'], (int) $sertifikatA['tanah_lainnya']];

                                    $sertifikatB = $tmp->where('sertifikat', 's2')->first();
                                    $sertifikatB = [(int) $sertifikatB['tanah_kosong'], (int) $sertifikatB['tanah_kantor'], (int) $sertifikatB['tanah_gol_i'], (int) $sertifikatB['tanah_gol_ii'], (int) $sertifikatB['tanah_mess'], (int) $sertifikatB['tanah_balai'], (int) $sertifikatB['tanah_lainnya']];

                                    $sertifikatC = $tmp->where('sertifikat', 's3')->first();
                                    $sertifikatC = [(int) $sertifikatC['tanah_kosong'], (int) $sertifikatC['tanah_kantor'], (int) $sertifikatC['tanah_gol_i'], (int) $sertifikatC['tanah_gol_ii'], (int) $sertifikatC['tanah_mess'], (int) $sertifikatC['tanah_balai'], (int) $sertifikatC['tanah_lainnya']];

                                    $sertifikatD = $tmp->where('sertifikat', 's4')->first();
                                    $sertifikatD = [(int) $sertifikatD['tanah_kosong'], (int) $sertifikatD['tanah_kantor'], (int) $sertifikatD['tanah_gol_i'], (int) $sertifikatD['tanah_gol_ii'], (int) $sertifikatD['tanah_mess'], (int) $sertifikatD['tanah_balai'], (int) $sertifikatD['tanah_lainnya']];
                                }
                                break;
                            case 'lingkungan':
                                $data['category'] = ['Umum', 'Agama', 'TUN', 'Militer', 'BUA'];

                                $tmp = AssetTanah::selectRaw("
                                    SUM( IF ( satker_type = 'PN', 1, 0 ) ) AS PN,
                                    SUM( IF ( satker_type = 'PA', 1, 0 ) ) AS PA,
                                    SUM( IF ( satker_type = 'PM', 1, 0 ) ) AS PM,
                                    SUM( IF ( satker_type = 'PT', 1, 0 ) ) AS PT,
                                    SUM( IF ( satker_type = 'PUSAT', 1, 0 ) ) AS PUSAT,
                                    if(kepemilikan = 'Bersertifikat atas nama Pemerintah RI c.q Kementerian/ Lembaga', 's1', if(kepemilikan = 'Bersertifikat atas nama Kementerian/ Lembaga', 's2', if(kepemilikan = 'Bersertifikat atas nama Pihak Ketiga', 's3', 's4'))) as sertifikat")
                                    ->join('satkers', 'asset_tanahs.kode_satker', '=', 'satkers.kode')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('sertifikat')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $sertifikatA = $sertifikatB = $sertifikatC = $sertifikatD = [0, 0, 0, 0, 0];
                                } else {
                                    $sertifikatA = $tmp->where('sertifikat', 's1')->first();
                                    $sertifikatA = [(int) $sertifikatA['PN'], (int) $sertifikatA['PA'], (int) $sertifikatA['PT'], (int) $sertifikatA['PM'], (int) $sertifikatA['PUSAT']];

                                    $sertifikatB = $tmp->where('sertifikat', 's2')->first();
                                    $sertifikatB = [(int) $sertifikatB['PN'], (int) $sertifikatB['PA'], (int) $sertifikatB['PT'], (int) $sertifikatB['PM'], (int) $sertifikatB['PUSAT']];

                                    $sertifikatC = $tmp->where('sertifikat', 's3')->first();
                                    $sertifikatC = [(int) $sertifikatC['PN'], (int) $sertifikatC['PA'], (int) $sertifikatC['PT'], (int) $sertifikatC['PM'], (int) $sertifikatC['PUSAT']];

                                    $sertifikatD = $tmp->where('sertifikat', 's3')->first();
                                    $sertifikatD = [(int) $sertifikatD['PN'], (int) $sertifikatD['PA'], (int) $sertifikatD['PT'], (int) $sertifikatD['PM'], (int) $sertifikatD['PUSAT']];
                                }
                                break;
                            case 'wilayah':
                                $wilayah =  AssetTanah::selectRaw('wilayahs.name, wilayahs.id')
                                    ->join('wilayahs', DB::raw('substr(asset_tanahs.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->orderBy('wilayahs.name', 'ASC')
                                    ->groupBy('wilayahs.id')
                                    ->get();

                                $data['category'] = $wilayah->pluck('name');

                                $tmp = AssetTanah::selectRaw("
                                    wilayahs.id as id,
                                    SUM( IF ( kepemilikan = 'Bersertifikat atas nama Pemerintah RI c.q Kementerian/ Lembaga', 1, 0 ) ) AS sertifikatA,
                                    SUM( IF ( kepemilikan = 'Bersertifikat atas nama Kementerian/ Lembaga', 1, 0 ) ) AS sertifikatB,
                                    SUM( IF ( kepemilikan = 'Bersertifikat atas nama Pihak Ketiga', 1, 0 ) ) AS sertifikatC,
                                    count(*) AS sertifikatD")
                                    ->join('wilayahs', DB::raw('substr(asset_tanahs.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('wilayahs.id')
                                    ->get();

                                $dataTmp = $tmp->keyBy('id');

                                foreach ($wilayah as $row) {
                                    if (isset($dataTmp[$row->id])) {
                                        $dat = $dataTmp[$row->id];

                                        $sertifikatA[] = (int) $dat->sertifikatA;
                                        $sertifikatB[] = (int) $dat->sertifikatB;
                                        $sertifikatC[] = (int) $dat->sertifikatC;
                                        $sertifikatD[] = (int) $dat->sertifikatD - $dat->sertifikatA - $dat->sertifikatB - $dat->sertifikatC;
                                    } else {
                                        $sertifikatA[] = $sertifikatB[] = $sertifikatC[] = $sertifikatD[] = 0;
                                    }
                                }
                                break;
                            default:
                                $assetTanah = AssetTanah::selectRaw('
                                    SUM( IF ( kepemilikan = \'Bersertifikat atas nama Pemerintah RI c.q Kementerian/ Lembaga\', 1, 0 ) ) AS sertifikatA,
                                    SUM( IF ( kepemilikan = \'Bersertifikat atas nama Kementerian/ Lembaga\', 1, 0 ) ) AS sertifikatB,
                                    SUM( IF ( kepemilikan = \'Bersertifikat atas nama Pihak Ketiga\', 1, 0 ) ) AS sertifikatC,
                                    count(*) AS sertifikatD')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->first();

                                if (is_null($assetTanah)) {
                                    $sertifikatA = $sertifikatB = $sertifikatC = $sertifikatD = [0];
                                } else {
                                    $sertifikatA = [(int) $assetTanah['sertifikatA']];
                                    $sertifikatB = [(int) $assetTanah['sertifikatB']];
                                    $sertifikatC = [(int) $assetTanah['sertifikatC']];
                                    $sertifikatD = [(int) $assetTanah['sertifikatD'] - (int) $assetTanah['sertifikatC'] - (int) $assetTanah['sertifikatB'] - (int) $assetTanah['sertifikatA']];
                                }
                                break;
                        }

                        $series = [
                            ['name' => 'Bersertifikat atas nama Pemerintah RI', 'data' => $sertifikatA],
                            ['name' => 'Bersertifikat atas nama Kementerian', 'data' => $sertifikatB],
                            ['name' => 'Bersertifikat atas nama Pihak Ketiga', 'data' => $sertifikatC],
                            ['name' => 'Lainnya', 'data' => $sertifikatD]
                        ];
                }
                break;
            case 'gedung':
                switch ($getSeries) {
                    case 'kondisi':
                        switch ($category) {
                            case 'klasifikasi':
                                $data['category'] = ['Prototype', 'Belum'];
                                $tmp = AssetBangunanGedung::selectRaw("
                                    SUM( IF ( prototype = '1'  , 1, 0 ) ) AS prototype,
                                    SUM( IF ( prototype = '0'  , 1, 0 ) ) AS belum,
                                    kondisi")
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('kondisi')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $baik = [0, 0];
                                    $rusakRingan = [0, 0];
                                    $rusakBerat = [0, 0];
                                } else {
                                    $baik = $tmp->where('kondisi', 'Baik')->first();
                                    $baik = [(int) $baik['prototype'], (int) $baik['belum']];

                                    $rusakRingan = $tmp->where('kondisi', 'Rusak Ringan')->first();
                                    $rusakRingan = [(int) $rusakRingan['prototype'], (int) $rusakRingan['belum']];

                                    $rusakBerat = $tmp->where('kondisi', 'Rusak Berat')->first();
                                    $rusakBerat = [(int) $rusakBerat['prototype'], (int) $rusakBerat['belum']];
                                }
                                break;
                            case 'lingkungan':
                                $data['category'] = ['Umum', 'Agama', 'TUN', 'Militer', 'BUA'];

                                $tmp = AssetBangunanGedung::selectRaw("
                                    SUM( IF ( satker_type = 'PN', 1, 0 ) ) AS PN,
                                    SUM( IF ( satker_type = 'PA', 1, 0 ) ) AS PA,
                                    SUM( IF ( satker_type = 'PM', 1, 0 ) ) AS PM,
                                    SUM( IF ( satker_type = 'PT', 1, 0 ) ) AS PT,
                                    SUM( IF ( satker_type = 'PUSAT', 1, 0 ) ) AS PUSAT,
                                    kondisi")
                                    ->join('satkers', 'asset_bangunan_gedungs.kode_satker', '=', 'satkers.kode')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('kondisi')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $baik = [0, 0, 0, 0, 0];
                                    $rusakRingan = [0, 0, 0, 0, 0];
                                    $rusakBerat = [0, 0, 0, 0, 0];
                                } else {
                                    $baik = $tmp->where('kondisi', 'Baik')->first();
                                    $baik = [(int) $baik['PN'], (int) $baik['PA'], (int) $baik['PT'], (int) $baik['PM'], (int) $baik['PUSAT']];

                                    $rusakRingan = $tmp->where('kondisi', 'Rusak Ringan')->first();
                                    $rusakRingan = [(int) $rusakRingan['PN'], (int) $rusakRingan['PA'], (int) $rusakRingan['PT'], (int) $rusakRingan['PM'], (int) $rusakRingan['PUSAT']];

                                    $rusakBerat = $tmp->where('kondisi', 'Rusak Berat')->first();
                                    $rusakBerat = [(int) $rusakBerat['PN'], (int) $rusakBerat['PA'], (int) $rusakBerat['PT'], (int) $rusakBerat['PM'], (int) $rusakBerat['PUSAT']];
                                }
                                break;
                            case 'wilayah':
                                $wilayah =  AssetBangunanGedung::selectRaw('wilayahs.name, wilayahs.id')
                                    ->join('wilayahs', DB::raw('substr(asset_bangunan_gedungs.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->orderBy('wilayahs.name', 'ASC')
                                    ->groupBy('wilayahs.id')
                                    ->get();

                                $data['category'] = $wilayah->pluck('name');

                                $tmp = AssetBangunanGedung::selectRaw("
                                    wilayahs.id as id,
                                    SUM( IF ( kondisi = 'Baik', 1, 0 ) ) AS baik,
                                    SUM( IF ( kondisi = 'Rusak Berat', 1, 0 ) ) AS rusak_berat,
                                    SUM( IF ( kondisi = 'Rusak Ringan', 1, 0 ) ) AS rusak_ringan")
                                    ->join('wilayahs', DB::raw('substr(asset_bangunan_gedungs.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('wilayahs.id')
                                    ->get();

                                $dataTmp = $tmp->keyBy('id');
                                foreach ($wilayah as $row) {
                                    if (isset($dataTmp[$row->id])) {
                                        $dat = $dataTmp[$row->id];

                                        $baik[] = (int) $dat->baik;
                                        $rusakRingan[] = (int) $dat->rusak_ringan;
                                        $rusakBerat[] = (int) $dat->rusak_berat;
                                    } else {
                                        $baik[] = 0;
                                        $rusakRingan[] = 0;
                                        $rusakBerat[] = 0;
                                    }
                                }
                                break;
                            default:
                                $data['category'] = ['Gedung & Bangunan'];
                                $assetTanah = AssetBangunanGedung::selectRaw('SUM( IF ( kondisi = \'Baik\', 1, 0 ) ) AS baik,
                                    SUM( IF ( kondisi = \'Rusak Berat\', 1, 0 ) ) AS rusak_berat,
                                    SUM( IF ( kondisi = \'Rusak Ringan\', 1, 0 ) ) AS rusak_ringan')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->first();

                                if (is_null($assetTanah)) {
                                    $baik = [0];
                                    $rusakRingan = [0];
                                    $rusakBerat = [0];
                                } else {
                                    $baik = [(int) $assetTanah['baik']];
                                    $rusakRingan = [(int) $assetTanah['rusak_ringan']];
                                    $rusakBerat = [(int) $assetTanah['rusak_berat']];
                                }
                                break;
                        }
                        $series = [
                            ['name' => 'Baik', 'data' => $baik],
                            ['name' => 'Rusak Ringan', 'data' => $rusakRingan],
                            ['name' => 'Rusak Berat', 'data' => $rusakBerat]
                        ];
                        break;
                    case 'luasan':
                        $data['category'] = ['Gedung & Bangunan'];
                        switch ($category) {
                            case 'klasifikasi':
                                $data['category'] = ['Prototype', 'Belum'];
                                $tmp = AssetBangunanGedung::selectRaw("
                                    SUM( IF ( prototype = '1'  , 1, 0 ) ) AS prototype,
                                    SUM( IF ( prototype = '0'  , 1, 0 ) ) AS belum,
                                    if(luas_bangunan < 1000, 'l1', IF(luas_bangunan >= 1000 AND luas_bangunan <= 2000, 'l2', IF(luas_bangunan > 2000 AND luas_bangunan <= 3000, 'l3', 
                                    IF(luas_bangunan > 3000 AND luas_bangunan <= 4000, 'l4', IF(luas_bangunan > 4000 AND luas_bangunan <= 5000, 'l5', IF(luas_bangunan > 5000 AND luas_bangunan <= 6000, 'l6', 'l7')))
                                    ))) as luasan")
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('luasan')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $l1 = $l2 = $l3 = $l4 = $l5 = $l6 = $l7 = [0, 0];
                                } else {
                                    $l1 = $tmp->where('luasan', 'l1')->first();
                                    $l1 = [(int) $l1['prototype'], (int) $l1['belum']];

                                    $l2 = $tmp->where('luasan', 'l2')->first();
                                    $l2 = [(int) $l2['prototype'], (int) $l2['belum']];

                                    $l3 = $tmp->where('luasan', 'l3')->first();
                                    $l3 = [(int) $l3['prototype'], (int) $l3['belum']];

                                    $l4 = $tmp->where('luasan', 'l4')->first();
                                    $l4 = [(int) $l4['prototype'], (int) $l4['belum']];

                                    $l5 = $tmp->where('luasan', 'l5')->first();
                                    $l5 = [(int) $l5['prototype'], (int) $l5['belum']];

                                    $l6 = $tmp->where('luasan', 'l6')->first();
                                    $l6 = [(int) $l6['prototype'], (int) $l6['belum']];

                                    $l7 = $tmp->where('luasan', 'l7')->first();
                                    $l7 = [(int) $l7['prototype'], (int) $l7['belum']];
                                }
                                break;
                            case 'lingkungan':
                                $data['category'] = ['Umum', 'Agama', 'TUN', 'Militer', 'BUA'];

                                $tmp = AssetBangunanGedung::selectRaw("
                                    SUM( IF ( satker_type = 'PN', 1, 0 ) ) AS PN,
                                    SUM( IF ( satker_type = 'PA', 1, 0 ) ) AS PA,
                                    SUM( IF ( satker_type = 'PM', 1, 0 ) ) AS PM,
                                    SUM( IF ( satker_type = 'PT', 1, 0 ) ) AS PT,
                                    SUM( IF ( satker_type = 'PUSAT', 1, 0 ) ) AS PUSAT,
                                    if(luas_bangunan < 1000, 'l1', IF(luas_bangunan >= 1000 AND luas_bangunan <= 2000, 'l2', IF(luas_bangunan > 2000 AND luas_bangunan <= 3000, 'l3', 
                                    IF(luas_bangunan > 3000 AND luas_bangunan <= 4000, 'l4', IF(luas_bangunan > 4000 AND luas_bangunan <= 5000, 'l5', IF(luas_bangunan > 5000 AND luas_bangunan <= 6000, 'l6', 'l7')))
                                    ))) as luasan")
                                    ->join('satkers', 'asset_bangunan_gedungs.kode_satker', '=', 'satkers.kode')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('luasan')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $l1 = $l2 = $l3 = $l4 = $l5 = $l6 = $l7 = [0, 0, 0, 0, 0];
                                } else {
                                    $l1 = $tmp->where('luasan', 'l1')->first();
                                    $l1 = [(int) $l1['PN'], (int) $l1['PA'], (int) $l1['PT'], (int) $l1['PM'], (int) $l1['PUSAT']];

                                    $l2 = $tmp->where('luasan', 'l2')->first();
                                    $l2 = [(int) $l2['PN'], (int) $l2['PA'], (int) $l2['PT'], (int) $l2['PM'], (int) $l2['PUSAT']];

                                    $l3 = $tmp->where('luasan', 'l3')->first();
                                    $l3 = [(int) $l3['PN'], (int) $l3['PA'], (int) $l3['PT'], (int) $l3['PM'], (int) $l3['PUSAT']];

                                    $l4 = $tmp->where('luasan', 'l4')->first();
                                    $l4 = [(int) $l4['PN'], (int) $l4['PA'], (int) $l4['PT'], (int) $l4['PM'], (int) $l4['PUSAT']];

                                    $l5 = $tmp->where('luasan', 'l5')->first();
                                    $l5 = [(int) $l5['PN'], (int) $l5['PA'], (int) $l5['PT'], (int) $l5['PM'], (int) $l5['PUSAT']];

                                    $l6 = $tmp->where('luasan', 'l6')->first();
                                    $l6 = [(int) $l6['PN'], (int) $l6['PA'], (int) $l6['PT'], (int) $l6['PM'], (int) $l6['PUSAT']];

                                    $l7 = $tmp->where('luasan', 'l7')->first();
                                    $l7 = [(int) $l7['PN'], (int) $l7['PA'], (int) $l7['PT'], (int) $l7['PM'], (int) $l7['PUSAT']];
                                }
                                break;
                            case 'wilayah':
                                $wilayah =  AssetBangunanGedung::selectRaw('wilayahs.name, wilayahs.id')
                                    ->join('wilayahs', DB::raw('substr(asset_bangunan_gedungs.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->orderBy('wilayahs.name', 'ASC')
                                    ->groupBy('wilayahs.id')
                                    ->get();

                                $data['category'] = $wilayah->pluck('name');

                                $tmp = AssetBangunanGedung::selectRaw("
                                    wilayahs.id as id,
                                    SUM( IF ( luas_bangunan < 1000, 1, 0 ) ) AS l1,
                                    SUM( IF ( luas_bangunan > 1000 AND luas_bangunan <= 2000 , 1, 0 ) ) AS l2,
                                    SUM( IF ( luas_bangunan > 2000 AND luas_bangunan <= 3000 , 1, 0 ) ) AS l3,
                                    SUM( IF ( luas_bangunan > 3000 AND luas_bangunan <= 4000 , 1, 0 ) ) AS l4,
                                    SUM( IF ( luas_bangunan > 4000 AND luas_bangunan <= 5000 , 1, 0 ) ) AS l5,
                                    SUM( IF ( luas_bangunan > 5000 AND luas_bangunan <= 6000 , 1, 0 ) ) AS l6,
                                    SUM( IF ( luas_bangunan > 7000, 1, 0 ) ) AS l7")
                                    ->join('wilayahs', DB::raw('substr(asset_bangunan_gedungs.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('wilayahs.id')
                                    ->get();

                                $dataTmp = $tmp->keyBy('id');

                                foreach ($wilayah as $row) {
                                    if (isset($dataTmp[$row->id])) {
                                        $dat = $dataTmp[$row->id];

                                        $l1[] = (int) $dat->l1;
                                        $l2[] = (int) $dat->l2;
                                        $l3[] = (int) $dat->l3;
                                        $l4[] = (int) $dat->l4;
                                        $l5[] = (int) $dat->l5;
                                        $l6[] = (int) $dat->l6;
                                        $l7[] = (int) $dat->l7;
                                    } else {
                                        $l1[] = 0;
                                        $l2[] = 0;
                                        $l3[] = 0;
                                        $l4[] = 0;
                                        $l5[] = 0;
                                        $l6[] = 0;
                                        $l7[] = 0;
                                    }
                                }
                                break;
                            default:
                                $assetTanah = AssetBangunanGedung::selectRaw('
                                    SUM( IF ( luas_bangunan < 1000, 1, 0 ) ) AS l1,
                                    SUM( IF ( luas_bangunan > 1000 AND luas_bangunan <= 2000 , 1, 0 ) ) AS l2,
                                    SUM( IF ( luas_bangunan > 2000 AND luas_bangunan <= 3000 , 1, 0 ) ) AS l3,
                                    SUM( IF ( luas_bangunan > 3000 AND luas_bangunan <= 4000 , 1, 0 ) ) AS l4,
                                    SUM( IF ( luas_bangunan > 4000 AND luas_bangunan <= 5000 , 1, 0 ) ) AS l5,
                                    SUM( IF ( luas_bangunan > 5000 AND luas_bangunan <= 6000 , 1, 0 ) ) AS l6,
                                    SUM( IF ( luas_bangunan > 7000, 1, 0 ) ) AS l7')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->first();

                                if (is_null($assetTanah)) {
                                    $l1 = $l2 = $l3 = $l4 = $l5 = $l6 = $l7 = [0];
                                } else {
                                    $l1 = [(int) $assetTanah['l1']];
                                    $l2 = [(int) $assetTanah['l2']];
                                    $l3 = [(int) $assetTanah['l3']];
                                    $l4 = [(int) $assetTanah['l4']];
                                    $l5 = [(int) $assetTanah['l5']];
                                    $l6 = [(int) $assetTanah['l6']];
                                    $l7 = [(int) $assetTanah['l7']];
                                }
                                break;
                        }

                        $series = [
                            ['name' => '< 1000 m2', 'data' => $l1],
                            ['name' => '1000 - 2000 m2', 'data' => $l2],
                            ['name' => '2001 - 3000 m2', 'data' => $l3],
                            ['name' => '3001 - 4000 m2', 'data' => $l4],
                            ['name' => '4001 - 5000 m2', 'data' => $l5],
                            ['name' => '5001 - 6000 m2', 'data' => $l6],
                            ['name' => '> 6000 m2', 'data' => $l7],
                        ];
                        break;
                    default:
                        $data['category'] = ['Gedung & Bangunan'];
                        switch ($category) {
                            case 'lingkungan':
                                $data['category'] = ['Umum', 'Agama', 'TUN', 'Militer', 'BUA'];

                                $tmp = AssetBangunanGedung::selectRaw("
                                    SUM( IF ( satker_type = 'PN', 1, 0 ) ) AS PN,
                                    SUM( IF ( satker_type = 'PA', 1, 0 ) ) AS PA,
                                    SUM( IF ( satker_type = 'PM', 1, 0 ) ) AS PM,
                                    SUM( IF ( satker_type = 'PT', 1, 0 ) ) AS PT,
                                    SUM( IF ( satker_type = 'PUSAT', 1, 0 ) ) AS PUSAT,
                                    if(jenis_sertifikat = 'IMB', 'ya', 'tidak') as sertifikat")
                                    ->join('satkers', 'asset_bangunan_gedungs.kode_satker', '=', 'satkers.kode')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('sertifikat')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $sertifikat = [0, 0, 0, 0, 0];
                                    $nonSertifikat = [0, 0, 0, 0, 0];
                                } else {
                                    $sertifikat = $tmp->where('sertifikat', 'ya')->first();
                                    $sertifikat = [(int) $sertifikat['PN'], (int) $sertifikat['PA'], (int) $sertifikat['PT'], (int) $sertifikat['PM'], (int) $sertifikat['PUSAT']];

                                    $nonSertifikat = $tmp->where('sertifikat', 'tidak')->first();
                                    $nonSertifikat = [(int) $nonSertifikat['PN'], (int) $nonSertifikat['PA'], (int) $nonSertifikat['PT'], (int) $nonSertifikat['PM'], (int) $nonSertifikat['PUSAT']];
                                }
                                break;
                            case 'wilayah':
                                $wilayah =  AssetBangunanGedung::selectRaw('wilayahs.name, wilayahs.id')
                                    ->join('wilayahs', DB::raw('substr(asset_bangunan_gedungs.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->orderBy('wilayahs.name', 'ASC')
                                    ->groupBy('wilayahs.id')
                                    ->get();

                                $data['category'] = $wilayah->pluck('name');

                                $tmp = AssetBangunanGedung::selectRaw("
                                    wilayahs.id as id,
                                    SUM( IF ( asset_bangunan_gedungs.jenis_sertifikat = 'IMB', 1, 0 ) ) AS sertifikat,
                                    SUM( IF ( asset_bangunan_gedungs.jenis_sertifikat = '-', 1, 0 ) ) AS non_sertifikat")
                                    ->join('wilayahs', DB::raw('substr(asset_bangunan_gedungs.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('wilayahs.id')
                                    ->get();

                                $sertifikat = [];
                                $nonSertifikat = [];
                                $dataTmp = $tmp->keyBy('id');

                                foreach ($wilayah as $row) {
                                    if (isset($dataTmp[$row->id])) {
                                        $dat = $dataTmp[$row->id];

                                        $sertifikat[] = (int) $dat->sertifikat;
                                        $nonSertifikat[] = (int) $dat->non_sertifikat;
                                    } else {
                                        $sertifikat[] = 0;
                                        $nonSertifikat[] = 0;
                                    }
                                }
                                break;
                            case 'klasifikasi':
                                $data['category'] = ['Prototype', 'Belum'];
                                $tmp = AssetBangunanGedung::selectRaw("
                                    SUM( IF ( prototype = '1'  , 1, 0 ) ) AS prototype,
                                    SUM( IF ( prototype = '0'  , 1, 0 ) ) AS belum, 
                                    IF(jenis_sertifikat = 'IMB', 'ya', 'tidak') as sertifikat")
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('sertifikat')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $sertifikat = [0, 0];
                                    $nonSertifikat = [0, 0];
                                } else {
                                    $sertifikat = $tmp->where('sertifikat', 'ya')->first();
                                    $sertifikat = [(int) $sertifikat['prototype'], (int) $sertifikat['belum']];

                                    $nonSertifikat = $tmp->where('sertifikat', 'tidak')->first();
                                    $nonSertifikat = [(int) $nonSertifikat['prototype'], (int) $nonSertifikat['belum']];
                                }
                                break;
                            default:
                                $model = AssetBangunanGedung::selectRaw("
                                    SUM( IF ( jenis_sertifikat = 'IMB', 1, 0 ) ) AS sertifikat,
                                    count(*) AS non_sertifikat")
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->first();

                                if (is_null($model)) {
                                    $sertifikat = [0];
                                    $nonSertifikat = [0];
                                } else {
                                    $sertifikat = [(int) $model['sertifikat']];
                                    $nonSertifikat = [$model['non_sertifikat'] - $model['sertifikat']];
                                }
                                break;
                        }

                        $series = [
                            ['name' => 'IMB', 'data' => $sertifikat],
                            ['name' => 'Tidak', 'data' => $nonSertifikat]
                        ];
                }
                break;
            case 'rumahnegara':
                switch ($getSeries) {
                    case 'kondisi':
                        switch ($category) {
                            case 'klasifikasi':
                                $data['category'] = [
                                    'Rumah Negara Golongan Ia','Rumah Negara Golongan Ib','Rumah Negara Golongan Ic','Rumah Negara Golongan I Lainnya',
                                    'Rumah Negara Golongan IIa','Rumah Negara Golongan IIb','Rumah Negara Golongan IIc','Rumah Negara Golongan II Lainnya'
                                ];
                                $tmp = AssetRumahNegara::selectRaw("
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 3) = 201  , 1, 0 ) ) AS golongan1,
                                    SUM( IF ( kode_barang = 4010201001, 1, 0 ) ) AS golongan1a,
                                    SUM( IF ( kode_barang = 4010201004, 1, 0 ) ) AS golongan1b,
                                    SUM( IF ( kode_barang = 4010201007, 1, 0 ) ) AS golongan1c,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 3) = 202  , 1, 0 ) ) AS golongan2,
                                    SUM( IF ( kode_barang = 4010202001, 1, 0 ) ) AS golongan2a,
                                    SUM( IF ( kode_barang = 4010202004, 1, 0 ) ) AS golongan2b,
                                    SUM( IF ( kode_barang = 4010202007, 1, 0 ) ) AS golongan2c,
                                    kondisi")
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('kondisi')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $baik = [0, 0];
                                    $rusakRingan = [0, 0];
                                    $rusakBerat = [0, 0];
                                } else {
                                    $baik = $tmp->where('kondisi', 'Baik')->first();
                                    $baik = [
                                        (int) $baik['golongan1a'], (int) $baik['golongan1b'], (int) $baik['golongan1c'], (int) $baik['golongan1'] - $baik['golongan1a'] - $baik['golongan1b'] - $baik['golongan1c'],
                                        (int) $baik['golongan2a'], (int) $baik['golongan2b'], (int) $baik['golongan2c'], (int) $baik['golongan2'] - $baik['golongan2a'] - $baik['golongan2b'] - $baik['golongan2c'],
                                    ];

                                    $rusakRingan = $tmp->where('kondisi', 'Rusak Ringan')->first();
                                    $rusakRingan = [
                                        (int) $rusakRingan['golongan1a'], (int) $rusakRingan['golongan1b'], (int) $rusakRingan['golongan1c'], (int) $rusakRingan['golongan1'] - $rusakRingan['golongan1a'] - $rusakRingan['golongan1b'] - $rusakRingan['golongan1c'],
                                        (int) $rusakRingan['golongan2a'], (int) $rusakRingan['golongan2b'], (int) $rusakRingan['golongan2c'], (int) $rusakRingan['golongan2'] - $rusakRingan['golongan2a'] - $rusakRingan['golongan2b'] - $rusakRingan['golongan2c'],
                                    ];

                                    $rusakBerat = $tmp->where('kondisi', 'Rusak Berat')->first();
                                    $rusakBerat = [
                                        (int) $rusakBerat['golongan1a'], (int) $rusakBerat['golongan1b'], (int) $rusakBerat['golongan1c'], (int) $rusakBerat['golongan1'] - $rusakBerat['golongan1a'] - $rusakBerat['golongan1b'] - $rusakBerat['golongan1c'],
                                        (int) $rusakBerat['golongan2a'], (int) $rusakBerat['golongan2b'], (int) $rusakBerat['golongan2c'], (int) $rusakBerat['golongan2'] - $rusakBerat['golongan2a'] - $rusakBerat['golongan2b'] - $rusakBerat['golongan2c'],
                                    ];
                                }
                                break;
                            case 'lingkungan':
                                $data['category'] = ['Umum', 'Agama', 'TUN', 'Militer', 'BUA'];

                                $tmp = AssetRumahNegara::selectRaw("
                                    SUM( IF ( satker_type = 'PN', 1, 0 ) ) AS PN,
                                    SUM( IF ( satker_type = 'PA', 1, 0 ) ) AS PA,
                                    SUM( IF ( satker_type = 'PM', 1, 0 ) ) AS PM,
                                    SUM( IF ( satker_type = 'PT', 1, 0 ) ) AS PT,
                                    SUM( IF ( satker_type = 'PUSAT', 1, 0 ) ) AS PUSAT,
                                    kondisi")
                                    ->join('satkers', 'asset_rumah_negaras.kode_satker', '=', 'satkers.kode')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('kondisi')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $baik = [0, 0, 0, 0, 0];
                                    $rusakRingan = [0, 0, 0, 0, 0];
                                    $rusakBerat = [0, 0, 0, 0, 0];
                                } else {
                                    $baik = $tmp->where('kondisi', 'Baik')->first();
                                    $baik = [(int) $baik['PN'], (int) $baik['PA'], (int) $baik['PT'], (int) $baik['PM'], (int) $baik['PUSAT']];

                                    $rusakRingan = $tmp->where('kondisi', 'Rusak Ringan')->first();
                                    $rusakRingan = [(int) $rusakRingan['PN'], (int) $rusakRingan['PA'], (int) $rusakRingan['PT'], (int) $rusakRingan['PM'], (int) $rusakRingan['PUSAT']];

                                    $rusakBerat = $tmp->where('kondisi', 'Rusak Berat')->first();
                                    $rusakBerat = [(int) $rusakBerat['PN'], (int) $rusakBerat['PA'], (int) $rusakBerat['PT'], (int) $rusakBerat['PM'], (int) $rusakBerat['PUSAT']];
                                }
                                break;
                            case 'wilayah':
                                $wilayah =  AssetRumahNegara::selectRaw('wilayahs.name, wilayahs.id')
                                    ->join('wilayahs', DB::raw('substr(asset_rumah_negaras.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->orderBy('wilayahs.name', 'ASC')
                                    ->groupBy('wilayahs.id')
                                    ->get();

                                $data['category'] = $wilayah->pluck('name');

                                $tmp = AssetRumahNegara::selectRaw("
                                    wilayahs.id as id,
                                    SUM( IF ( kondisi = 'Baik', 1, 0 ) ) AS baik,
                                    SUM( IF ( kondisi = 'Rusak Berat', 1, 0 ) ) AS rusak_berat,
                                    SUM( IF ( kondisi = 'Rusak Ringan', 1, 0 ) ) AS rusak_ringan")
                                    ->join('wilayahs', DB::raw('substr(asset_rumah_negaras.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('wilayahs.id')
                                    ->get();

                                $dataTmp = $tmp->keyBy('id');
                                foreach ($wilayah as $row) {
                                    if (isset($dataTmp[$row->id])) {
                                        $dat = $dataTmp[$row->id];

                                        $baik[] = (int) $dat->baik;
                                        $rusakRingan[] = (int) $dat->rusak_ringan;
                                        $rusakBerat[] = (int) $dat->rusak_berat;
                                    } else {
                                        $baik[] = 0;
                                        $rusakRingan[] = 0;
                                        $rusakBerat[] = 0;
                                    }
                                }
                                break;
                            default:
                                $data['category'] = ['Rumah Negara'];
                                $assetTanah = AssetRumahNegara::selectRaw('SUM( IF ( kondisi = \'Baik\', 1, 0 ) ) AS baik,
                                    SUM( IF ( kondisi = \'Rusak Berat\', 1, 0 ) ) AS rusak_berat,
                                    SUM( IF ( kondisi = \'Rusak Ringan\', 1, 0 ) ) AS rusak_ringan')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->first();

                                if (is_null($assetTanah)) {
                                    $baik = [0];
                                    $rusakRingan = [0];
                                    $rusakBerat = [0];
                                } else {
                                    $baik = [(int) $assetTanah['baik']];
                                    $rusakRingan = [(int) $assetTanah['rusak_ringan']];
                                    $rusakBerat = [(int) $assetTanah['rusak_berat']];
                                }
                                break;
                        }
                        $series = [
                            ['name' => 'Baik', 'data' => $baik],
                            ['name' => 'Rusak Ringan', 'data' => $rusakRingan],
                            ['name' => 'Rusak Berat', 'data' => $rusakBerat]
                        ];
                        break;
                    case 'luasan':
                        $data['category'] = ['Rumah Negara'];
                        switch ($category) {
                            case 'klasifikasi':
                                $data['category'] = [
                                    'Rumah Negara Golongan Ia','Rumah Negara Golongan Ib','Rumah Negara Golongan Ic','Rumah Negara Golongan I Lainnya',
                                    'Rumah Negara Golongan IIa','Rumah Negara Golongan IIb','Rumah Negara Golongan IIc','Rumah Negara Golongan II Lainnya'
                                ];
                                $tmp = AssetRumahNegara::selectRaw("
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 3) = 201  , 1, 0 ) ) AS golongan1,
                                    SUM( IF ( kode_barang = 4010201001, 1, 0 ) ) AS golongan1a,
                                    SUM( IF ( kode_barang = 4010201004, 1, 0 ) ) AS golongan1b,
                                    SUM( IF ( kode_barang = 4010201007, 1, 0 ) ) AS golongan1c,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 3) = 202  , 1, 0 ) ) AS golongan2,
                                    SUM( IF ( kode_barang = 4010202001, 1, 0 ) ) AS golongan2a,
                                    SUM( IF ( kode_barang = 4010202004, 1, 0 ) ) AS golongan2b,
                                    SUM( IF ( kode_barang = 4010202007, 1, 0 ) ) AS golongan2c,
                                    if(luas_bangunan <= 70, 'l1', IF(luas_bangunan >= 71 AND luas_bangunan <= 120, 'l2', IF(luas_bangunan > 120 AND luas_bangunan <= 250, 'l3', 'l4'))) as luasan")
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('luasan')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $l1 = $l2 = $l3 = $l4 = [0, 0, 0, 0, 0, 0, 0, 0];
                                } else {
                                    $l1 = $tmp->where('luasan', 'l1')->first();
                                    $l1 = [
                                        (int) $l1['golongan1a'], (int) $l1['golongan1b'], (int) $l1['golongan1c'], (int) $l1['golongan1'] - $l1['golongan1a'] - $l1['golongan1b'] - $l1['golongan1c'],
                                        (int) $l1['golongan2a'], (int) $l1['golongan2b'], (int) $l1['golongan2c'], (int) $l1['golongan2'] - $l1['golongan2a'] - $l1['golongan2b'] - $l1['golongan2c']
                                    ];

                                    $l2 = $tmp->where('luasan', 'l2')->first();
                                    $l2 = [
                                        (int) $l2['golongan1a'], (int) $l2['golongan1b'], (int) $l2['golongan1c'], (int) $l2['golongan1'] - $l2['golongan1a'] - $l2['golongan1b'] - $l2['golongan1c'],
                                        (int) $l2['golongan2a'], (int) $l2['golongan2b'], (int) $l2['golongan2c'], (int) $l2['golongan2'] - $l2['golongan2a'] - $l2['golongan2b'] - $l2['golongan2c']
                                    ];

                                    $l3 = $tmp->where('luasan', 'l3')->first();
                                    $l3 = [
                                        (int) $l3['golongan1a'], (int) $l3['golongan1b'], (int) $l3['golongan1c'], (int) $l3['golongan1'] - $l3['golongan1a'] - $l3['golongan1b'] - $l3['golongan1c'],
                                        (int) $l3['golongan2a'], (int) $l3['golongan2b'], (int) $l3['golongan2c'], (int) $l3['golongan2'] - $l3['golongan2a'] - $l3['golongan2b'] - $l3['golongan2c']
                                    ];

                                    $l4 = $tmp->where('luasan', 'l4')->first();
                                    $l4 = [
                                        (int) $l4['golongan1a'], (int) $l4['golongan1b'], (int) $l4['golongan1c'], (int) $l4['golongan1'] - $l4['golongan1a'] - $l4['golongan1b'] - $l4['golongan1c'],
                                        (int) $l4['golongan2a'], (int) $l4['golongan2b'], (int) $l4['golongan2c'], (int) $l4['golongan2'] - $l4['golongan2a'] - $l4['golongan2b'] - $l4['golongan2c']
                                    ];
                                }
                                break;
                            case 'lingkungan':
                                $data['category'] = ['Umum', 'Agama', 'TUN', 'Militer', 'BUA'];

                                $tmp = AssetRumahNegara::selectRaw("
                                    SUM( IF ( satker_type = 'PN', 1, 0 ) ) AS PN,
                                    SUM( IF ( satker_type = 'PA', 1, 0 ) ) AS PA,
                                    SUM( IF ( satker_type = 'PM', 1, 0 ) ) AS PM,
                                    SUM( IF ( satker_type = 'PT', 1, 0 ) ) AS PT,
                                    SUM( IF ( satker_type = 'PUSAT', 1, 0 ) ) AS PUSAT,
                                    if(luas_bangunan <= 70, 'l1', IF(luas_bangunan >= 71 AND luas_bangunan <= 120, 'l2', IF(luas_bangunan > 120 AND luas_bangunan <= 250, 'l3', 'l4'))) as luasan")
                                    ->join('satkers', 'asset_rumah_negaras.kode_satker', '=', 'satkers.kode')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('luasan')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $l1 = $l2 = $l3 = $l4 = [0, 0, 0, 0, 0, 0, 0, 0];
                                } else {
                                    $l1 = $tmp->where('luasan', 'l1')->first();
                                    $l1 = [(int) $l1['PN'], (int) $l1['PA'], (int) $l1['PT'], (int) $l1['PM'], (int) $l1['PUSAT']];

                                    $l2 = $tmp->where('luasan', 'l2')->first();
                                    $l2 = [(int) $l2['PN'], (int) $l2['PA'], (int) $l2['PT'], (int) $l2['PM'], (int) $l2['PUSAT']];

                                    $l3 = $tmp->where('luasan', 'l3')->first();
                                    $l3 = [(int) $l3['PN'], (int) $l3['PA'], (int) $l3['PT'], (int) $l3['PM'], (int) $l3['PUSAT']];

                                    $l4 = $tmp->where('luasan', 'l4')->first();
                                    $l4 = [(int) $l4['PN'], (int) $l4['PA'], (int) $l4['PT'], (int) $l4['PM'], (int) $l4['PUSAT']];
                                }
                                break;
                            case 'wilayah':
                                $wilayah =  AssetRumahNegara::selectRaw('wilayahs.name, wilayahs.id')
                                    ->join('wilayahs', DB::raw('substr(asset_rumah_negaras.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->orderBy('wilayahs.name', 'ASC')
                                    ->groupBy('wilayahs.id')
                                    ->get();

                                $data['category'] = $wilayah->pluck('name');

                                $tmp = AssetRumahNegara::selectRaw("
                                    wilayahs.id as id,
                                    SUM( IF ( luas_bangunan < 70, 1, 0 ) ) AS l1,
                                    SUM( IF ( luas_bangunan > 70 AND luas_bangunan <= 120 , 1, 0 ) ) AS l2,
                                    SUM( IF ( luas_bangunan > 120 AND luas_bangunan <= 250 , 1, 0 ) ) AS l3,
                                    SUM( IF ( luas_bangunan > 250, 1, 0 ) ) AS l4")
                                    ->join('wilayahs', DB::raw('substr(asset_rumah_negaras.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('wilayahs.id')
                                    ->get();

                                $dataTmp = $tmp->keyBy('id');

                                foreach ($wilayah as $row) {
                                    if (isset($dataTmp[$row->id])) {
                                        $dat = $dataTmp[$row->id];

                                        $l1[] = (int) $dat->l1;
                                        $l2[] = (int) $dat->l2;
                                        $l3[] = (int) $dat->l3;
                                        $l4[] = (int) $dat->l4;
                                    } else {
                                        $l1[] = 0;
                                        $l2[] = 0;
                                        $l3[] = 0;
                                        $l4[] = 0;
                                    }
                                }
                                break;
                            default:
                                $assetTanah = AssetBangunanGedung::selectRaw('
                                    SUM( IF ( luas_bangunan < 70, 1, 0 ) ) AS l1,
                                    SUM( IF ( luas_bangunan > 70 AND luas_bangunan <= 120 , 1, 0 ) ) AS l2,
                                    SUM( IF ( luas_bangunan > 120 AND luas_bangunan <= 250 , 1, 0 ) ) AS l3,
                                    SUM( IF ( luas_bangunan > 250, 1, 0 ) ) AS l4')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->first();

                                if (is_null($assetTanah)) {
                                    $l1 = $l2 = $l3 = $l4 = $l5 = $l6 = $l7 = [0];
                                } else {
                                    $l1 = [(int) $assetTanah['l1']];
                                    $l2 = [(int) $assetTanah['l2']];
                                    $l3 = [(int) $assetTanah['l3']];
                                    $l4 = [(int) $assetTanah['l4']];
                                }
                                break;
                        }

                        $series = [
                            ['name' => '< 70 m2', 'data' => $l1],
                            ['name' => '70 - 120 m2', 'data' => $l2],
                            ['name' => '121 - 250 m2', 'data' => $l3],
                            ['name' => '> 250 m2', 'data' => $l4],
                        ];
                        break;
                    default:
                        $data['category'] = ['Rumah Negara'];
                        switch ($category) {
                            case 'klasifikasi':
                                $data['category'] = [
                                    'Rumah Negara Golongan Ia','Rumah Negara Golongan Ib','Rumah Negara Golongan Ic','Rumah Negara Golongan I Lainnya',
                                    'Rumah Negara Golongan IIa','Rumah Negara Golongan IIb','Rumah Negara Golongan IIc','Rumah Negara Golongan II Lainnya'
                                    ];
                                $tmp = AssetRumahNegara::selectRaw("
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 3) = 201  , 1, 0 ) ) AS golongan1,
                                    SUM( IF ( kode_barang = 4010201001, 1, 0 ) ) AS golongan1a,
                                    SUM( IF ( kode_barang = 4010201004, 1, 0 ) ) AS golongan1b,
                                    SUM( IF ( kode_barang = 4010201007, 1, 0 ) ) AS golongan1c,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 3) = 202  , 1, 0 ) ) AS golongan2,
                                    SUM( IF ( kode_barang = 4010202001, 1, 0 ) ) AS golongan2a,
                                    SUM( IF ( kode_barang = 4010202004, 1, 0 ) ) AS golongan2b,
                                    SUM( IF ( kode_barang = 4010202007, 1, 0 ) ) AS golongan2c,
                                    if(jenis_sertifikat = 'IMB', 'ya', 'tidak') as sertifikat")
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('sertifikat')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $sertifikat = [0, 0, 0, 0, 0, 0, 0, 0];
                                    $nonSertifikat = [0, 0, 0, 0, 0, 0, 0, 0];
                                } else {
                                    $tmpS = $tmp->where('sertifikat', 'ya')->first();
                                    $sertifikat = [
                                        (int) $tmpS['golongan1a'], (int) $tmpS['golongan1b'], (int) $tmpS['golongan1c'], (int) $tmpS['golongan1'] - $tmpS['golongan1a'] - $tmpS['golongan1b'] - $tmpS['golongan1c'],
                                        (int) $tmpS['golongan2a'], (int) $tmpS['golongan2b'], (int) $tmpS['golongan2c'], (int) $tmpS['golongan2'] - $tmpS['golongan2a'] - $tmpS['golongan2b'] - $tmpS['golongan2c'],
                                        ];

                                    $tmpN = $tmp->where('sertifikat', 'tidak')->first();
                                    $nonSertifikat = [
                                        (int) $tmpN['golongan1a'], (int) $tmpN['golongan1b'], (int) $tmpN['golongan1c'], (int) $tmpN['golongan1'] - $tmpN['golongan1a'] - $tmpN['golongan1b'] - $tmpN['golongan1c'],
                                        (int) $tmpN['golongan2a'], (int) $tmpN['golongan2b'], (int) $tmpN['golongan2c'], (int) $tmpN['golongan2'] - $tmpN['golongan2a'] - $tmpN['golongan2b'] - $tmpN['golongan2c'],
                                    ];
                                }
                                break;
                            case 'lingkungan':
                                $data['category'] = ['Umum', 'Agama', 'TUN', 'Militer', 'BUA'];

                                $tmp = AssetRumahNegara::selectRaw("
                                    SUM( IF ( satker_type = 'PN', 1, 0 ) ) AS PN,
                                    SUM( IF ( satker_type = 'PA', 1, 0 ) ) AS PA,
                                    SUM( IF ( satker_type = 'PM', 1, 0 ) ) AS PM,
                                    SUM( IF ( satker_type = 'PT', 1, 0 ) ) AS PT,
                                    SUM( IF ( satker_type = 'PUSAT', 1, 0 ) ) AS PUSAT,
                                    if(jenis_sertifikat = 'IMB', 'ya', 'tidak') as sertifikat")
                                    ->join('satkers', 'asset_rumah_negaras.kode_satker', '=', 'satkers.kode')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('sertifikat')
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $sertifikat = [0, 0, 0, 0, 0];
                                    $nonSertifikat = [0, 0, 0, 0, 0];
                                } else {
                                    $tmpS = $tmp->where('sertifikat', 'ya')->first();
                                    $sertifikat = [(int) $tmpS['PN'], (int) $tmpS['PA'], (int) $tmpS['PT'], (int) $tmpS['PM'], (int) $tmpS['PUSAT']];

                                    $tmpN = $tmp->where('sertifikat', 'tidak')->first();
                                    $nonSertifikat = [(int) $tmpN['PN'], (int) $tmpN['PA'], (int) $tmpN['PT'], (int) $tmpN['PM'], (int) $tmpN['PUSAT']];
                                }
                                break;
                            case 'wilayah':
                                $wilayah =  AssetRumahNegara::selectRaw('wilayahs.name, wilayahs.id')
                                    ->join('wilayahs', DB::raw('substr(asset_rumah_negaras.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->orderBy('wilayahs.name', 'ASC')
                                    ->groupBy('wilayahs.id')->get();
                                $data['category'] = $wilayah->pluck('name');

                                $tmp = AssetRumahNegara::selectRaw("
                                    wilayahs.id as id,
                                    SUM( IF ( asset_rumah_negaras.jenis_sertifikat = 'IMB', 1, 0 ) ) AS sertifikat,
                                    SUM( IF ( asset_rumah_negaras.jenis_sertifikat = '-', 1, 0 ) ) AS non_sertifikat")
                                    ->join('wilayahs', DB::raw('substr(asset_rumah_negaras.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('wilayahs.id')
                                    ->get();

                                $dataTmp = $tmp->keyBy('id');

                                foreach ($wilayah as $row) {
                                    if (isset($dataTmp[$row->id])) {
                                        $dat = $dataTmp[$row->id];

                                        $sertifikat[] = (int) $dat->sertifikat;
                                        $nonSertifikat[] = (int) $dat->non_sertifikat;
                                    } else {
                                        $sertifikat[] = 0;
                                        $nonSertifikat[] = 0;
                                    }
                                }
                                break;
                            default:
                                $assetRumahNegara = AssetRumahNegara::selectRaw("
                                    SUM( IF ( jenis_sertifikat = 'IMB', 1, 0 ) ) AS sertifikat,
                                    count(*) AS non_sertifikat")
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->first();

                                if (is_null($assetRumahNegara)) {
                                    $sertifikat = [0];
                                    $nonSertifikat = [0];
                                } else {
                                    $sertifikat = [(int) $assetRumahNegara['sertifikat']];
                                    $nonSertifikat = [$assetRumahNegara['non_sertifikat'] - $assetRumahNegara['sertifikat']];
                                }

                                break;
                        }

                        $series = [
                            ['name' => 'IMB', 'data' => $sertifikat],
                            ['name' => 'Tidak', 'data' => $nonSertifikat]
                        ];
                }
                break;
            case 'kendaraan':
                switch ($getSeries) {
                    default:
                        $data['category'] = ['Kendaraan'];
                        switch ($category) {
                            case 'klasifikasi':
                                $data['category'] = ['Kendaraan Roda 2', 'Kendaraan Roda 4', 'Kendaraan Lainnya'];
                                $tmp = AssetAlatBermotor::selectRaw("
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 3) = 104  , 1, 0 ) ) AS kendaraan_roda_2,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 3) = 101 OR SUBSTRING(kode_barang, 5, 3) = 102 OR SUBSTRING(kode_barang, 5, 3) = 103 OR SUBSTRING(kode_barang, 5, 3) = 105 OR SUBSTRING(kode_barang, 5, 3) = 199 , 1, 0 ) ) AS kendaraan_roda_4,
                                    SUM( IF ( SUBSTRING(kode_barang, 5, 3) = 302  , 1, 0 ) ) AS kendaraan_lainnya,
                                    kondisi")
                                    ->groupBy('kondisi')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $baik = [0, 0, 0];
                                    $rusakRingan = [0, 0, 0];
                                    $rusakBerat = [0, 0, 0];
                                } else {
                                    $baikT = $tmp->where('kondisi', 'Baik')->first();
                                    $baik = [(int) $baikT['kendaraan_roda_2'], (int) $baikT['kendaraan_roda_4'], (int) $baikT['kendaraan_lainnya']];

                                    $ringanT = $tmp->where('kondisi', 'Rusak Ringan')->first();
                                    $rusakRingan = [(int) $ringanT['kendaraan_roda_2'], (int) $ringanT['kendaraan_roda_4'], (int) $ringanT['kendaraan_lainnya']];

                                    $beratT = $tmp->where('kondisi', 'Rusak Berat')->first();
                                    $rusakBerat = [(int) $beratT['kendaraan_roda_2'], (int) $beratT['kendaraan_roda_4'], (int) $beratT['kendaraan_lainnya']];
                                }
                                break;
                            case 'lingkungan':
                                $data['category'] = ['Umum', 'Agama', 'TUN', 'Militer', 'BUA'];

                                $tmp = AssetAlatBermotor::selectRaw("
                                    SUM( IF ( satker_type = 'PN', 1, 0 ) ) AS PN,
                                    SUM( IF ( satker_type = 'PA', 1, 0 ) ) AS PA,
                                    SUM( IF ( satker_type = 'PM', 1, 0 ) ) AS PM,
                                    SUM( IF ( satker_type = 'PT', 1, 0 ) ) AS PT,
                                    SUM( IF ( satker_type = 'PUSAT', 1, 0 ) ) AS PUSAT,
                                    kondisi")
                                    ->join('satkers', 'asset_alat_bermotors.kode_satker', '=', 'satkers.kode')
                                    ->groupBy('kondisi')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->get();

                                if ($tmp->isEmpty()) {
                                    $baik = [0, 0, 0, 0, 0];
                                    $rusakRingan = [0, 0, 0, 0, 0];
                                    $rusakBerat = [0, 0, 0, 0, 0];
                                } else {
                                    $baik = $tmp->where('kondisi', 'Baik')->first();
                                    $baik = [(int) $baik['PN'], (int) $baik['PA'], (int) $baik['PT'], (int) $baik['PM'], (int) $baik['PUSAT']];

                                    $rusakRingan = $tmp->where('kondisi', 'Rusak Ringan')->first();
                                    $rusakRingan = [(int) $rusakRingan['PN'], (int) $rusakRingan['PA'], (int) $rusakRingan['PT'], (int) $rusakRingan['PM'], (int) $rusakRingan['PUSAT']];

                                    $rusakBerat = $tmp->where('kondisi', 'Rusak Berat')->first();
                                    $rusakBerat = [(int) $rusakBerat['PN'], (int) $rusakBerat['PA'], (int) $rusakBerat['PT'], (int) $rusakBerat['PM'], (int) $rusakBerat['PUSAT']];
                                }
                                break;
                            case 'wilayah':
                                $wilayah =  AssetAlatBermotor::selectRaw('wilayahs.name, wilayahs.id')
                                    ->join('wilayahs', DB::raw('substr(asset_alat_bermotors.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->orderBy('wilayahs.name', 'ASC')
                                    ->groupBy('wilayahs.id')
                                    ->get();
                                $data['category'] = $wilayah->pluck('name');

                                $tmp = AssetAlatBermotor::selectRaw("
                                    wilayahs.id as id,
                                    SUM( IF ( kondisi = 'Baik', 1, 0 ) ) AS baik,
                                    SUM( IF ( kondisi = 'Rusak Berat', 1, 0 ) ) AS rusak_berat,
                                    SUM( IF ( kondisi = 'Rusak Ringan', 1, 0 ) ) AS rusak_ringan")
                                    ->join('wilayahs', DB::raw('substr(asset_alat_bermotors.kode_satker, 6, 4)'), '=', 'wilayahs.code')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->groupBy('wilayahs.id')
                                    ->get();

                                $series['bpkb'] = [];
                                $series['non_bpkb'] = [];
                                $dataTmp = $tmp->keyBy('id');

                                foreach ($wilayah as $row) {
                                    if (isset($dataTmp[$row->id])) {
                                        $dat = $dataTmp[$row->id];

                                        $baik[] = (int) $dat->baik;
                                        $rusakRingan[] = (int) $dat->rusak_ringan;
                                        $rusakBerat[] = (int) $dat->rusak_berat;
                                    } else {
                                        $baik[] = 0;
                                        $rusakRingan[] = 0;
                                        $rusakBerat[] = 0;
                                    }
                                }
                                break;
                            default:
                                $data['category'] = ['Kendaraan Bermotor'];
                                $assetAlatBermotor = AssetAlatBermotor::selectRaw('SUM( IF ( kondisi = \'Baik\', 1, 0 ) ) AS baik,
                                    SUM( IF ( kondisi = \'Rusak Berat\', 1, 0 ) ) AS rusak_berat,
                                    SUM( IF ( kondisi = \'Rusak Ringan\', 1, 0 ) ) AS rusak_ringan')
                                    ->filter($filterData, $filter)
                                    ->assetBy()
                                    ->first();

                                if (is_null($assetAlatBermotor)) {
                                    $baik = [0];
                                    $rusakRingan = [0];
                                    $rusakBerat = [0];
                                } else {
                                    $baik = [(int) $assetAlatBermotor['baik']];
                                    $rusakRingan = [(int) $assetAlatBermotor['rusak_ringan']];
                                    $rusakBerat = [(int) $assetAlatBermotor['rusak_berat']];
                                }

                                break;
                        }

                        $series = [
                            ['name' => 'Baik', 'data' => $baik],
                            ['name' => 'Rusak Ringan', 'data' => $rusakRingan],
                            ['name' => 'Rusak Berat', 'data' => $rusakBerat]
                        ];
                }
                break;
            default:
                abort(404);
        }

        $data['series'] = $series;

        return response()->json($data);
    }

    public function importData()
    {
        $reader = ReaderFactory::create(Type::XLSX);
        $reader->open(public_path('reffsatker.xlsx'));
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $k => $row) {
                if($k > 1) {
                    $data = Satker::whereKode($row[0])->first();
                    if($data != null){
                        $data->city = $row[1] == "" ? null : $row[1];
                        $data->dirjen = $row[2] == "" ? null : $row[2];
                        $data->kpknl = $row[3] == "" ? null : $row[3];
                        $data->kanwil = $row[4] == "" ? null : $row[4];
                        $data->save();
                    }
                }
            }
        }
    }
}
