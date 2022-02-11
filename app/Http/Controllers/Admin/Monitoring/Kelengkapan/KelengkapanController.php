<?php

namespace App\Http\Controllers\Admin\Monitoring\Kelengkapan;

use App\Exports\SatkerAssetExport;
use App\Http\Controllers\Controller;
use App\Model\AssetMonitoring;
use App\Model\Asset\AssetTanah;
use App\Model\Asset\AssetBangunanGedung;
use App\Model\Asset\AssetRumahNegara;
use App\Model\Asset\AssetAlatBermotor;
use App\Model\Satker;
use App\Model\TingkatBanding;
use App\Model\Wilayah;
use App\Repositories\Permission\Permission;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KelengkapanController extends Controller
{

    private $layout, $config;
    private $route = 'admin.monitoring.kelengkapan';
    private $title = 'Kelengkapan';
    private $permission = 'monitoring-kelengkapan';

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

        $assetMonitoring = AssetMonitoring::whereIn('data', ['asset_tanahs', 'asset_rumah_negaras','asset_bangunan_gedungs', 'asset_alat_bermotors'])->whereType('high')->get()->keyBy('data');

        $user = \Auth::user();
        $viewAllAsset = Permission::can('view-all-asset');
        $viewAllLingkunganAsset = Permission::can('view-all-lingkungan-asset');
        $viewAllWilayahAsset = Permission::can('view-all-wilayah-asset');
        $viewAllSatkerAsset = Permission::can('view-all-satker-asset');
        if($viewAllAsset) {

        } else if($viewAllSatkerAsset) {
            return redirect()->route($this->route . '.satker', Satker::find($user->id_satker)->kode);
        }

        $data = [
            'viewAllAsset' => $viewAllAsset,
            'viewAllWilayahAsset' => $viewAllWilayahAsset,
            'viewAllLingkunganAsset' => $viewAllLingkunganAsset,
            'tanah' => [
                'total' => AssetTanah::assetBy()->count(),
                'belum' => AssetTanah::assetBy()->where('filled', '<', $assetMonitoring['asset_tanahs']->start)->count()
            ],
            'gedung_kantor' => [
                'total' => AssetBangunanGedung::assetBy()->count(),
                'belum' => AssetBangunanGedung::assetBy()->where('filled', '<', $assetMonitoring['asset_bangunan_gedungs']->start)->count()
            ],
            'rumah_negara' => [
                'total' => AssetRumahNegara::assetBy()->count(),
                'belum' => AssetRumahNegara::assetBy()->where('filled', '<', $assetMonitoring['asset_rumah_negaras']->start)->count()
            ],
            'kendaraan_bermotor' => [
                'total' => AssetAlatBermotor::assetBy()->count(),
                'belum' => AssetAlatBermotor::assetBy()->where('filled', '<', $assetMonitoring['asset_alat_bermotors']->start)->count()
            ]
        ];
        $data['config'] = $this->config;

        $assetMonitoring = AssetMonitoring::select('*', DB::raw('CONCAT(data, "_", type) as identity'))->get();
        $data['categories'] = $this->generateCategory($assetMonitoring);

        $data['wilayahs'] = Wilayah::get();
        $data['assets'] = AssetMonitoring::groupBy('name')->get();

        $data['lingkungans'] = ['PN' => 'Pengadilan Negri', 'PA' => 'Pengadilan Agama', 'PM' => 'Pengadilan Militer', 'PT' => 'Pengadilan Tata Usaha Negara'];
        $data['request']['display'] = $request->input('display');
        return view($this->layout . '.index',  $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function table(Request $request){
        Permission::access('view-' . $this->permission);

        $assetMonitoring = AssetMonitoring::select('*', DB::raw('CONCAT(data, "_", type) as identity'));
        if ($request->has('filter')) {
            foreach ($request->input('filter') as $key => $row) {
                if ($row != '' || !empty($row)) {
                    switch ($key) {
                        case 'asset':
                            $assetMonitoring->where('data', $row);
                            break;
                    }
                }
            }
        }
        $assetMonitoring = $assetMonitoring->get();

        $data['config'] = $this->config;
        $data['categories'] = $this->generateCategory($assetMonitoring);
        $data['satkers'] = $this->getAsset($request, $assetMonitoring);

        $header = 'Satker';
        if($request->has('display')){
            switch ($request->input('display')) {
                case 'wilayah':
                    $header = 'Wilayah';
                    break;
                case 'lingkungan':
                    $header = 'Lingkungan';
                    break;
                case 'asset':
                    $header = 'Asset';
                    break;
            }
        }
        $data['header'] = $header;

        return view($this->layout . '.table',  $data);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(Request $request)
    {
        Permission::access('view-' . $this->permission);

        $tmpAssetMonitoring = AssetMonitoring::select('*', DB::raw('CONCAT(data, "_", type) as identity'));
        if ($request->has('filter')) {
            foreach ($request->input('filter') as $key => $row) {
                if ($row != '' || !empty($row)) {
                    switch ($key) {
                        case 'asset':
                            $tmpAssetMonitoring->where('data', $row);
                        break;
                    }
                }
            }
        }
        $tmpAssetMonitoring = $tmpAssetMonitoring->get();
        $assetMonitoring = $this->generateCategory($tmpAssetMonitoring);

        $data = $this->getAsset($request, $tmpAssetMonitoring);

        $header = 'Satker';
        if($request->has('display')){
            switch ($request->input('display')) {
                case 'wilayah':
                    $header = 'Wilayah';
                    break;
                case 'lingkungan':
                    $header = 'Lingkungan';
                    break;
            }
        }

        $header = [null, 'No', $header];
        $row2 = [null, null, null];
        $total = [];
        foreach ($assetMonitoring as $k => $row) {
            $total[] = 0;$total[] = 0;$total[] = 0;$total[] = 0;
            $header = array_merge($header, [$k, null, null, null]);
            $row2 = array_merge($row2, ['Belum Lengkap', 'Kurang Lengkap', 'Lengkap', 'Total']);
        }

        $excelData =  [
            $header,
            $row2,
        ];

        $i = 1;
        foreach ($data as $k => $row){
            $tmp = [null, $i++, $row->name];
            $j = 0;
            foreach ($assetMonitoring as $r) {
                $total[$j++] += $row->{$r['data'].'_low'};$total[$j++] += $row->{$r['data'].'_mid'};$total[$j++] += $row->{$r['data'].'_high'};$total[$j++] += $row->{$r['data'].'_total'};

                $tmp[] = $row->{$r['data'].'_low'};
                $tmp[] = $row->{$r['data'].'_mid'};
                $tmp[] = $row->{$r['data'].'_high'};
                $tmp[] = $row->{$r['data'].'_total'};
            }
            $excelData[] = $tmp;
        }
        foreach ($total as $k => $t) {
            $total[$k] = (string)$t;
        }
        $excelData[] = array_merge([null, 'Total', null], $total);

        return Excel::download(new SatkerAssetExport($excelData), 'Satker-Kelengkapan-Aset.xlsx');
    }

    /**
     * @param $assetMonitoring
     * @return array
     */
    public function generateCategory($assetMonitoring)
    {
        Permission::access('view-' . $this->permission);
        $user = \Auth::user();

        $viewAllAsset = Permission::can('view-all-asset');
        $viewAllWilayahAsset = Permission::can('view-all-wilayah-asset');
        $viewAllLingkunganAsset = Permission::can('view-all-lingkungan-asset');

        $category = [];
        $keyBy = $assetMonitoring->keyBy('identity');
        foreach ($assetMonitoring->unique('data') as $row) {
            if($viewAllAsset) {
                $category[$row->name] = [
                    'data'  => $row->data,
                    'low'   => DB::table($row->data)->where('filled', '>=', $keyBy[$row->data . '_low']->start)->where('filled', '<=', $keyBy[$row->data . '_low']->end)->count(),
                    'mid'   => DB::table($row->data)->where('filled', '>=', $keyBy[$row->data . '_mid']->start)->where('filled', '<=', $keyBy[$row->data . '_mid']->end)->count(),
                    'high'  => DB::table($row->data)->where('filled', '>=', $keyBy[$row->data . '_high']->start)->count(),
                    'total' => DB::table($row->data)->count()
                ];
            } else if ($viewAllWilayahAsset && $viewAllLingkunganAsset) {
                $userLingkungan = $user->lingkungan;
                if($userLingkungan == 'PMT') {
                    $userLingkungan = ['PM', 'PT'];
                } else {
                    $userLingkungan = [$userLingkungan];
                }

                $wilayah = null;
                if($user->isTingkatBanding() || $user->isAdminTingkatBanding()) {
                    $tingkatBanding = TingkatBanding::join('satkers', 'satkers.id', 'id_satker')
                        ->where('tingkat_bandings.lingkungan', $user->lingkungan)
                        ->where('tingkat_bandings.id_wilayah', $user->id_wilayah)->select('satkers.kode')->get()
                        ->pluck('kode')->all();

                    if(!empty($tingkatBanding)) {
                        $category[$row->name] = [
                            'data' => $row->data,
                            'low' => DB::table($row->data)->join('satkers as a', 'a.kode', '=', $row->data.'.kode_satker')->whereIn('a.satker_type', $userLingkungan)->whereIn('kode_satker', $tingkatBanding)->where('filled', '>=', $keyBy[$row->data.'_low']->start)->where('filled', '<=', $keyBy[$row->data.'_low']->end)->count(),
                            'mid' => DB::table($row->data)->join('satkers as a', 'a.kode', '=', $row->data.'.kode_satker')->whereIn('a.satker_type', $userLingkungan)->whereIn('kode_satker', $tingkatBanding)->where('filled', '>=', $keyBy[$row->data.'_mid']->start)->where('filled', '<=', $keyBy[$row->data.'_mid']->end)->count(),
                            'high' => DB::table($row->data)->join('satkers as a', 'a.kode', '=', $row->data.'.kode_satker')->whereIn('a.satker_type', $userLingkungan)->whereIn('kode_satker', $tingkatBanding)->where('filled', '>=', $keyBy[$row->data.'_high']->start)->count(),
                            'total' => DB::table($row->data)->join('satkers as a', 'a.kode', '=', $row->data.'.kode_satker')->whereIn('a.satker_type', $userLingkungan)->whereIn('kode_satker', $tingkatBanding)->count()
                        ];
                    } else {
                        $wilayah = \Auth::user()->wilayah;
                    }
                } else {
                    $wilayah = \Auth::user()->wilayah;
                }

                if($wilayah != null) {
                    $category[$row->name] = [
                        'data' => $row->data,
                        'low' => DB::table($row->data)->join('satkers as a', 'a.kode', '=', $row->data.'.kode_satker')->whereIn('a.satker_type', $userLingkungan)->where(DB::raw('SUBSTRING(kode_satker, 6, 4)'), $wilayah->code)->where('filled', '>=', $keyBy[$row->data.'_low']->start)->where('filled', '<=', $keyBy[$row->data.'_low']->end)->count(),
                        'mid' => DB::table($row->data)->join('satkers as a', 'a.kode', '=', $row->data.'.kode_satker')->whereIn('a.satker_type', $userLingkungan)->where(DB::raw('SUBSTRING(kode_satker, 6, 4)'), $wilayah->code)->where('filled', '>=', $keyBy[$row->data.'_mid']->start)->where('filled', '<=', $keyBy[$row->data.'_mid']->end)->count(),
                        'high' => DB::table($row->data)->join('satkers as a', 'a.kode', '=', $row->data.'.kode_satker')->whereIn('a.satker_type', $userLingkungan)->where(DB::raw('SUBSTRING(kode_satker, 6, 4)'), $wilayah->code)->where('filled', '>=', $keyBy[$row->data.'_high']->start)->count(),
                        'total' => DB::table($row->data)->join('satkers as a', 'a.kode', '=', $row->data.'.kode_satker')->whereIn('a.satker_type', $userLingkungan)->where(DB::raw('SUBSTRING(kode_satker, 6, 4)'), $wilayah->code)->count()
                    ];
                }
            } else if ($viewAllWilayahAsset) {
                $wilayah = null;
                if($user->isTingkatBanding() || $user->isAdminTingkatBanding()) {
                    $tingkatBanding = TingkatBanding::join('satkers', 'satkers.id', 'id_satker')
                        ->where('tingkat_bandings.lingkungan', $user->lingkungan)
                        ->where('tingkat_bandings.id_wilayah', $user->id_wilayah)->select('satkers.kode')->get()
                        ->pluck('kode')->all();

                    if(!empty($tingkatBanding)) {
                        $category[$row->name] = [
                            'data' => $row->data,
                            'low' => DB::table($row->data)->whereIn('kode_satker', $tingkatBanding)->where('filled', '>=', $keyBy[$row->data.'_low']->start)->where('filled', '<=', $keyBy[$row->data.'_low']->end)->count(),
                            'mid' => DB::table($row->data)->whereIn('kode_satker', $tingkatBanding)->where('filled', '>=', $keyBy[$row->data.'_mid']->start)->where('filled', '<=', $keyBy[$row->data.'_mid']->end)->count(),
                            'high' => DB::table($row->data)->whereIn('kode_satker', $tingkatBanding)->where('filled', '>=', $keyBy[$row->data.'_high']->start)->count(),
                            'total' => DB::table($row->data)->whereIn('kode_satker', $tingkatBanding)->count()
                        ];
                    } else {
                        $wilayah = \Auth::user()->wilayah;
                    }
                } else {
                    $wilayah = \Auth::user()->wilayah;
                }
                if($wilayah != null) {
                    $category[$row->name] = [
                        'data' => $row->data,
                        'low' => DB::table($row->data)->where(DB::raw('SUBSTRING(kode_satker, 6, 4)'), $wilayah->code)->where('filled', '>=', $keyBy[$row->data.'_low']->start)->where('filled', '<=', $keyBy[$row->data.'_low']->end)->count(),
                        'mid' => DB::table($row->data)->where(DB::raw('SUBSTRING(kode_satker, 6, 4)'), $wilayah->code)->where('filled', '>=', $keyBy[$row->data.'_mid']->start)->where('filled', '<=', $keyBy[$row->data.'_mid']->end)->count(),
                        'high' => DB::table($row->data)->where(DB::raw('SUBSTRING(kode_satker, 6, 4)'), $wilayah->code)->where('filled', '>=', $keyBy[$row->data.'_high']->start)->count(),
                        'total' => DB::table($row->data)->where(DB::raw('SUBSTRING(kode_satker, 6, 4)'), $wilayah->code)->count()
                    ];
                }
            } else {
                $userLingkungan = $user->lingkungan;
                if($userLingkungan == 'PMT') {
                    $userLingkungan = ['PM', 'PT'];
                } else {
                    $userLingkungan = [$userLingkungan];
                }
                $category[$row->name] = [
                    'data' => $row->data,
                    'low' => DB::table($row->data)->join('satkers as a', 'a.kode', '=', $row->data.'.kode_satker')->whereIn('a.satker_type', $userLingkungan)->where('filled', '>=', $keyBy[$row->data.'_low']->start)->where('filled', '<=', $keyBy[$row->data.'_low']->end)->count(),
                    'mid' => DB::table($row->data)->join('satkers as a', 'a.kode', '=', $row->data.'.kode_satker')->whereIn('a.satker_type', $userLingkungan)->where('filled', '>=', $keyBy[$row->data.'_mid']->start)->where('filled', '<=', $keyBy[$row->data.'_mid']->end)->count(),
                    'high' => DB::table($row->data)->join('satkers as a', 'a.kode', '=', $row->data.'.kode_satker')->whereIn('a.satker_type', $userLingkungan)->where('filled', '>=', $keyBy[$row->data.'_high']->start)->count(),
                    'total' => DB::table($row->data)->join('satkers as a', 'a.kode', '=', $row->data.'.kode_satker')->whereIn('a.satker_type', $userLingkungan)->count()
                ];
            }
        }

        return $category;
    }

    /**
     * @param Request $request
     * @param $assetMonitoring
     * @return $this|string
     */
    private function getAsset(Request $request, $assetMonitoring)
    {
        Permission::access('view-' . $this->permission);

        $queries = [];
        foreach ($assetMonitoring->unique('data') as $row) {
            $queries[] = "SELECT
                sum( IF ( ( `a`.`filled_status` = cast( 'low' AS CHAR charset BINARY ) ), 1, 0 ) ) AS `low`,
                sum( IF ( ( `a`.`filled_status` = cast( 'mid' AS CHAR charset BINARY ) ), 1, 0 ) ) AS `mid`,
                sum( IF ( ( `a`.`filled_status` = cast( 'high' AS CHAR charset BINARY ) ), 1, 0 ) ) AS `high`,
                sum( IF ( isnull( `a`.`filled_status` ), 0, 1 ) ) AS `total`,
                `b`.`kode` AS `kode`,
                `b`.`name` AS `name`,
                '$row->data' AS `type` 
            FROM
	        `v_$row->data` `a` JOIN `satkers` `b` ON `a`.`kode_satker` = `b`.`kode` group by b.kode";
        }

        $query = implode(" UNION ALL ", $queries);

        $cats = [];
        foreach ($assetMonitoring->unique('data') as $row) {
            $cats[] = "SUM(IF(a.type = '$row->data', low, 0)) as {$row->data}_low,SUM(IF(a.type = '$row->data', mid, 0)) as {$row->data}_mid,SUM(IF(a.type = '$row->data', high, 0)) as {$row->data}_high,SUM(IF(a.type = '$row->data', total, 0)) as {$row->data}_total";
        }
        $cat = implode(",", $cats);

        $query = DB::table(DB::raw('(' . $query . ') as a'))->select(DB::raw($cat))
            ->join('satkers as b', 'a.kode', '=', 'b.kode');

        $user = \Auth::user();
        $viewAllAsset = Permission::can('view-all-asset');
        $viewAllWilayahAsset = Permission::can('view-all-wilayah-asset');
        $viewAllLingkunganAsset = Permission::can('view-all-lingkungan-asset');
        if($viewAllAsset) {

        } else if($viewAllLingkunganAsset || $viewAllWilayahAsset) {
            if($viewAllLingkunganAsset) {
                $userLingkungan = $user->lingkungan;
                if($userLingkungan == 'PMT') {
                    $userLingkungan = ['PM', 'PT'];
                } else {
                    $userLingkungan = [$userLingkungan];
                }
                $query->whereIn('b.satker_type', $userLingkungan);
            }

            if($viewAllWilayahAsset) {
                $wilayah = null;
                if($user->isTingkatBanding() || $user->isAdminTingkatBanding()) {
                    $tingkatBanding = TingkatBanding::join('satkers', 'satkers.id', 'id_satker')
                        ->where('tingkat_bandings.lingkungan', $user->lingkungan)
                        ->where('tingkat_bandings.id_wilayah', $user->id_wilayah)->select('satkers.kode')->get()
                        ->pluck('kode')->all();

                    if(!empty($tingkatBanding)) {
                        $query->whereIn('b.kode', $tingkatBanding);
                    } else {
                        $wilayah = $user->wilayah;
                    }
                } else {
                    $wilayah = $user->wilayah;
                }

                if($wilayah != null) {
                    $query->where(DB::raw('SUBSTRING(b.kode, 6, 4)'), $wilayah->code);
                }
            }
        }

        if ($request->has('display')) {
            switch ($request->input('display')) {
                case 'wilayah':
                    $query->join('wilayahs as c', 'c.id', '=', 'b.id_wilayah', 'right')->groupBy('c.id')
                        ->addSelect('c.name', 'c.id');
                    break;
                case 'lingkungan':
                    $query->groupBy('satker_type')->addSelect(DB::raw('satker_type as name'), 'satker_type as id');
                    break;
                default:
                    $query->addSelect('b.kode', 'b.name')->groupBy('b.kode');
            }
        } else {
            $query->addSelect('b.kode', 'b.name')->groupBy('b.kode');
        }


        if ($request->has('filter')) {
            foreach ($request->input('filter') as $key => $row) {
                if ($row != '' || !empty($row)) {
                    switch ($key) {
                        case 'wilayah':
                            $query->where('b.id_wilayah', $row);
                            break;
                        case 'lingkungan':
                            $query->where('b.satker_type', $row);
                            break;
                        case 'luastanah':
                            if ($row[0] != null) {
                                $query->where('a.luas_tanah_seluruhnya', '>=', $row[0]);
                            }
                            if ($row[1] != null) {
                                $query->where('a.luas_tanah_seluruhnya', '<=', $row[1]);
                            }
                            break;
                        case 'perolehan':
                            if ($row[0] != null) {
                                $query->where('a.nilai_perolehan', '>=', $row[0]);
                            }
                            if ($row[1] != null) {
                                $query->where('a.nilai_perolehan', '<=', $row[1]);
                            }
                            break;
                    }
                }
            }
        }

        return $query->get();
    }
}
