<?php

namespace App\Http\Controllers\Admin\Monitoring\Interconnection;

use App\Http\Controllers\Controller;
use App\Model\InterconnectionConfig;
use App\Repositories\Permission\Permission;
use DB;
use Illuminate\Http\Request;

class InterconnectionController extends Controller
{

    private $layout, $config;
    private $route = 'admin.monitoring.interconnection';
    private $title = 'Interconnection';
    private $permission = 'monitoring-interconnection';

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
        Permission::access('view-' . $this->permission);

        $data['categoriesRep'] = [
            'MA_ASET_TETAP_LAINNYA' =>'Tetap Lainnya',
            'MA_ASET_TANAH' =>'Tanah',
            'MA_ASET_TAK_BERWUJUD' =>'Aset Tidak Berwujud',
            'MA_ASET_RUMAH_NEGARA' =>'Rumah Negara',
            'MA_ASET_RENOVASI' =>'Aset Renovasi',
            'MA_ASET_PM_NON_TIK' =>'Aset Peralatan Non TIK',
            'MA_ASET_PM_KHUSUS_TIK' =>'Aset Peralatan Khusus TIK',
            'MA_ASET_KDP' =>'Konstruksi Dalam Pengerjaan',
            'MA_ASET_JALAN_JEMBATAN' =>'Jalan Jembatan',
            'MA_ASET_INSTALASI_JARINGAN' =>'Instalasi Jaringan',
            'MA_ASET_GEDUNG_BANGUNAN' =>'Gedung Bangunan',
            'MA_ASET_BANGUNAN_AIR' =>'Bangunan Air',
            'MA_ASET_ALAT_BERAT' =>'Alat Berat',
            'MA_ASET_ALAT_ANGKUTAN' =>'Alat Angkutan',
        ];
        $data['categories'] = DB::table(\DB::raw("(SELECT * from interconnections order by date desc LIMIT 18446744073709551615) as sub"))->groupBy("table")->get();
        $data['interConfig'] = InterconnectionConfig::get()->pluck('value', 'name')->toArray();

        return view($this->layout . '.index',  $data);
    }
}
