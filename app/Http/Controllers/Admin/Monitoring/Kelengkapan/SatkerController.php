<?php

namespace App\Http\Controllers\Admin\Monitoring\Kelengkapan;

use App\Exports\AssetExport;
use App\Http\Controllers\Admin\Asset\AirIrigasi\AirIrigasiController;
use App\Http\Controllers\Admin\Asset\AlatAngkutan\AlatAngkutanController;
use App\Http\Controllers\Admin\Asset\AlatBerat\AlatBeratController;
use App\Http\Controllers\Admin\Asset\BangunanGedung\BangunanGedungController;
use App\Http\Controllers\Admin\Asset\InstalasiJaringan\InstalasiJaringanController;
use App\Http\Controllers\Admin\Asset\JalanJembatan\JalanJembatanController;
use App\Http\Controllers\Admin\Asset\KonstruksiDalamPengerjaan\KonstruksiDalamPengerjaanController;
use App\Http\Controllers\Admin\Asset\PeralatanKhususTik\PeralatanKhususTikController;
use App\Http\Controllers\Admin\Asset\PeralatanNonTik\PeralatanNonTikController;
use App\Http\Controllers\Admin\Asset\Renovasi\RenovasiController;
use App\Http\Controllers\Admin\Asset\RumahNegara\RumahNegaraController;
use App\Http\Controllers\Admin\Asset\TakBerwujud\TakBerwujudController;
use App\Http\Controllers\Admin\Asset\Tanah\TanahController;
use App\Http\Controllers\Admin\Asset\TetapLainnya\TetapLainnyaController;
use App\Http\Controllers\Controller;
use App\Model\Asset\AssetAirIrigasi;
use App\Model\Asset\AssetAlatBerat;
use App\Model\Asset\AssetAlatBermotor;
use App\Model\Asset\AssetBangunanGedung;
use App\Model\Asset\AssetInstalasiJaringan;
use App\Model\Asset\AssetJalanJembatan;
use App\Model\Asset\AssetKonstruksiDalamPengerjaan;
use App\Model\AssetMonitoring;
use App\Model\Asset\AssetPeralatanKhususTik;
use App\Model\Asset\AssetPeralatanNonTik;
use App\Model\Asset\AssetRenovasi;
use App\Model\Asset\AssetRumahNegara;
use App\Model\Asset\AssetTakBerwujud;
use App\Model\Asset\AssetTanah;
use App\Model\Asset\AssetTetapLainnya;
use App\Model\Satker;
use App\Repositories\Permission\Permission;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SatkerController extends Controller
{

    private $layout, $config;
    private $route = 'admin.monitoring.kelengkapan.satker';
    private $title = 'Dashboard';
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
     * @param $kodeSatker
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($kodeSatker)
    {
        Permission::access('view-' . $this->permission);

        $assetMonitoring = AssetMonitoring::whereIn('data', ['asset_tanahs', 'asset_rumah_negaras','asset_bangunan_gedungs', 'asset_alat_bermotors'])->whereType('high')->get()->keyBy('data');

        $user = \Auth::user();
        $isSatker = $user->type == 'satker';
        if($isSatker) {
            $satker = Satker::find($user->id_satker);
            if($satker->kode != $kodeSatker) {
                abort(404);
            }
        }

        $data = [
            'tanah' => [
                'total' => AssetTanah::whereKodeSatker($kodeSatker)->count(),
                'belum' => AssetTanah::where('filled', '<', $assetMonitoring['asset_tanahs']->start)->whereKodeSatker($kodeSatker)->count()
            ],
            'gedung_kantor' => [
                'total' => AssetBangunanGedung::whereKodeSatker($kodeSatker)->count(),
                'belum' => AssetBangunanGedung::where('filled', '<', $assetMonitoring['asset_bangunan_gedungs']->start)->whereKodeSatker($kodeSatker)->count()
            ],
            'rumah_negara' => [
                'total' => AssetRumahNegara::whereKodeSatker($kodeSatker)->count(),
                'belum' => AssetRumahNegara::where('filled', '<', $assetMonitoring['asset_rumah_negaras']->start)->whereKodeSatker($kodeSatker)->count()
            ],
            'kendaraan_bermotor' => [
                'total' => AssetAlatBermotor::whereKodeSatker($kodeSatker)->count(),
                'belum' => AssetAlatBermotor::where('filled', '<', $assetMonitoring['asset_alat_bermotors']->start)->whereKodeSatker($kodeSatker)->count()
            ]
        ];
        $data['isSatker'] = $isSatker;
        $data['config'] = $this->config;
        $data['satker'] = Satker::whereKode($kodeSatker)->first();

        $assetMonitoring = AssetMonitoring::select('*', DB::raw('CONCAT(data, "_", type) as identity'))->get();
        $data['categories'] = $this->generateCategory($assetMonitoring, $kodeSatker);

        return view($this->layout . '.index',  $data);
    }

    /**
     * @param $assetMonitoring
     * @param $kodeSatker
     * @return array
     */
    public function generateCategory($assetMonitoring, $kodeSatker)
    {
        Permission::access('view-' . $this->permission);

        $category = [];
        $keyBy = $assetMonitoring->keyBy('identity');
        foreach ($assetMonitoring->unique('data') as $row) {
            $category[$row->name] = [
                'data' => $row->data,
                'low' => DB::table($row->data)->whereKodeSatker($kodeSatker)->where('filled', '>=', $keyBy[$row->data.'_low']->start)->where('filled', '<=', $keyBy[$row->data.'_low']->end)->count(),
                'mid' => DB::table($row->data)->whereKodeSatker($kodeSatker)->where('filled', '>=', $keyBy[$row->data.'_mid']->start)->where('filled', '<=', $keyBy[$row->data.'_mid']->end)->count(),
                'high' => DB::table($row->data)->whereKodeSatker($kodeSatker)->where('filled', '>=', $keyBy[$row->data.'_high']->start)->count(),
                'total' => DB::table($row->data)->whereKodeSatker($kodeSatker)->count()
            ];
        }

        return $category;
    }

    /**
     * @param Request $request
     * @param $kode
     * @param null $slugasset
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function asset(Request $request, $kode, $slugasset)
    {
        Permission::access('view-' . $this->permission);

        $data['config'] = $this->config;
        $data['satker'] = Satker::whereKode($kode)->first();
        $data['asset'] = AssetMonitoring::where('data', $slugasset)->first();

        $data['request']['display'] = $request->input('display');
        $data['request']['filter'] = $request->input('filter');
        $data['from'] = $request->input('from');
        return view($this->layout . '.asset', $data);
    }

    /**
     * @param Request $request
     * @param $kode
     * @param $slugasset
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assetTable(Request $request, $kode, $slugasset)
    {
        Permission::access('view-' . $this->permission);

        $data = $this->getAssetTable($request, $slugasset, $kode);

        return view($this->layout . '.assettable', $data);
    }

    /**
     * @param Request $request
     * @param $kode
     * @param $slugasset
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(Request $request, $kode, $slugasset)
    {
        Permission::access('view-' . $this->permission);

        $data = $this->getAssetTable($request, $slugasset, $kode);

        $excelData = [];
        $header = [null, 'No'];
        foreach ($data['table']['header'] as $row){
            $header[] = $row;
        }
        $excelData[] = $header;

        $i = 1;
        foreach ($data['table']['data'] as $row){
            $tmp = [null, $i++];
            foreach ($data['table']['dataValue'] as $value){
                $tmp[] = $row->{$value};
            }
            $excelData[] = $tmp;
        }

        return Excel::download(new AssetExport($excelData), 'Aset.xlsx');
    }

    /**
     * @param Request $request
     * @param $slugasset
     * @param $kode
     * @return mixed
     */
    public function getAssetTable(Request $request, $slugasset, $kode = null)
    {
        Permission::access('view-' . $this->permission);

        switch ($slugasset) {
            case 'asset_tanahs':
                $con = new TanahController();
                $modelTmp = new AssetTanah();
                break;
            case 'asset_rumah_negaras':
                $con = new RumahNegaraController();
                $modelTmp = new AssetRumahNegara();
                break;
            case 'asset_peralatan_non_tiks':
                $con = new PeralatanNonTikController();
                $modelTmp = new AssetPeralatanNonTik();
                break;
            case 'asset_peralatan_khusus_tiks':
                $con = new PeralatanKhususTikController();
                $modelTmp = new AssetPeralatanKhususTik();
                break;
            case 'asset_jalan_jembatans':
                $con = new JalanJembatanController();
                $modelTmp = new AssetJalanJembatan();
                break;
            case 'asset_instalasi_jaringans':
                $con = new InstalasiJaringanController();
                $modelTmp = new AssetInstalasiJaringan();
                break;
            case 'asset_bangunan_gedungs':
                $con = new BangunanGedungController();
                $modelTmp = new AssetBangunanGedung();
                break;
            case 'asset_air_irigasis':
                $con = new AirIrigasiController();
                $modelTmp = new AssetAirIrigasi();
                break;
            case 'asset_tetap_lainnyas':
                $con = new TetapLainnyaController();
                $modelTmp = new AssetTetapLainnya();
                break;
            case 'asset_tak_berwujuds':
                $con = new TakBerwujudController();
                $modelTmp = new AssetTakBerwujud();
                break;
            case 'asset_renovasis':
                $con = new RenovasiController();
                $modelTmp = new AssetRenovasi();
                break;
            case 'asset_konstruksi_dalam_pengerjaans':
                $con = new KonstruksiDalamPengerjaanController();
                $modelTmp = new AssetKonstruksiDalamPengerjaan();
                break;
            case 'asset_alat_berats':
                $con = new AlatBeratController();
                $modelTmp = new AssetAlatBerat();
                break;
            case 'asset_alat_bermotors':
                $con = new AlatAngkutanController();
                $modelTmp = new AssetAlatBermotor();
                break;
        }
        $dataValue = $modelTmp->getFillable();

        $model = DB::table("v_$slugasset as a")
            ->join('satkers as b', 'a.kode_satker', '=', 'b.kode')
            ->select('*', DB::raw("CASE
                WHEN filled >= (select start from asset_monitorings where data = '".$modelTmp->getTable()."' and type = 'low' ) AND filled <= (select end from asset_monitorings where data = '".$modelTmp->getTable()."' and type = 'low' ) THEN \"low\"
                WHEN filled >= (select start from asset_monitorings where data = '".$modelTmp->getTable()."' and type = 'mid' ) AND filled <= (select end from asset_monitorings where data = '".$modelTmp->getTable()."' and type = 'mid' ) THEN \"mid\"
                WHEN filled >= (select start from asset_monitorings where data = '".$modelTmp->getTable()."' and type = 'high' ) THEN \"high\"
		        ELSE \"\"
		        END as filled_status"));
        if(!is_null($kode)){
            $model = $model->where('kode_satker', $kode);
        }

        if($request->has('filter')){
            foreach ($request->input('filter') as $key => $row){
                if($row != '' || !empty($row)) {
                    switch ($key) {
                        case 'wilayah':
                            $model->where('b.id_wilayah', $row);
                            break;
                        case 'lingkungan':
                            $model->where('b.satker_type', $row);
                            break;
                        case 'luastanah':
                            if($row[0] != null){
                                $model->where('a.luas_tanah_seluruhnya', '>=', $row[0]);
                            }
                            if($row[1] != null){
                                $model->where('a.luas_tanah_seluruhnya', '<=', $row[1]);
                            }
                            break;
                        case 'perolehan':
                            if($row[0] != null){
                                $model->where('a.nilai_perolehan', '>=', $row[0]);
                            }
                            if($row[1] != null){
                                $model->where('a.nilai_perolehan', '<=', $row[1]);
                            }
                            break;
                    }
                }
            }
        }

        $data['table']['header'] = $con->getTableHeader();
        $data['table']['dataValue'] = $dataValue;
        $data['table']['data'] = $model->get();

        return $data;
    }
}
