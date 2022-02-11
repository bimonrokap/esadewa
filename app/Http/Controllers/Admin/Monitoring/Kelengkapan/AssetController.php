<?php

namespace App\Http\Controllers\Admin\Monitoring\Kelengkapan;

use App\Exports\KelengkapanExport;
use App\Http\Controllers\Controller;
use App\Model\AssetMonitoring;
use App\Model\TingkatBanding;
use App\Model\Wilayah;
use App\Repositories\Permission\Permission;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{

    private $layout, $config;
    private $route = 'admin.monitoring.kelengkapan';
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
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function asset(Request $request, $slug){
        Permission::access('view-' . $this->permission);

        $viewAllAsset = Permission::can('view-all-asset');
        $viewAllLingkunganAsset = Permission::can('view-all-lingkungan-asset');
        $viewAllWilayahAsset = Permission::can('view-all-wilayah-asset');
        if(!$viewAllAsset && !$viewAllWilayahAsset && !$viewAllLingkunganAsset) {
            abort(404);
        }

        $data['viewAllAset'] = $viewAllAsset;
        $data['viewAllWilayahAsset'] = $viewAllWilayahAsset;
        $data['viewAllLingkunganAsset'] = $viewAllLingkunganAsset;
        $data['config'] = $this->config;
        $data['asset'] = AssetMonitoring::where('data', $slug)->first();

        $data['wilayahs'] = Wilayah::get();
        $data['lingkungans'] = ['PN' => 'Pengadilan Negri', 'PA' => 'Pengadilan Agama', 'PM' => 'Pengadilan Militer', 'PT' => 'Pengadilan Tata Usaha Negara'];

        $data['request']['display'] = $request->input('display');
        $data['request']['filter'] = $request->input('filter');
        return view($this->layout . '.asset.index', $data);
    }

    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function table(Request $request, $slug)
    {
        Permission::access('view-' . $this->permission);

        $data['asset'] = AssetMonitoring::where('data', $slug)->first();
        $data['config'] = $this->config;

        if($request->input('display') == 'asset') {
            $con = new SatkerController();
            $data = $con->getAssetTable($request, $slug);

            return view('admin.monitoring.kelengkapan.satker.assettable', $data);
        } else {
            $data['table']['header'] = 'Satker';
            if($request->has('display')){
                switch ($request->input('display')) {
                    case 'wilayah':
                        $data['table']['header'] = 'Wilayah';
                        break;
                    case 'lingkungan':
                        $data['table']['header'] = 'Lingkungan';
                        break;
                }
            }
            $data['datas'] = $this->getData($request, $slug);
        }

        $data['request'] = $request->all();
        $data['lingkungan'] = ['PN' => 'Pengadilan Negri', 'PA' => 'Pengadilan Agama', 'PM' => 'Pengadilan Militer', 'PT' => 'Pengadilan Tata Usaha Negara'];
        $data['filterParam'] = $request->input('filter');

        return view($this->layout . '.asset.table', $data);
    }

    /**
     * @param Request $request
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(Request $request, $slug)
    {
        Permission::access('view-' . $this->permission);

        if($request->input('display') == 'asset') {
            $con = new SatkerController();
            return $con->export($request, null, $slug);
        } else {
            $data = $this->getData($request, $slug);

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

            $excelData =  [
                [null, 'No', $header, 'Kelengkapan Data Aset', null, null, 'Total'],
                [null, null, null, 'Belum Lengkap', 'Kurang Lengkap', 'Lengkap'],
            ];


            $i = 1;$totLow=0;$totMid=0;$totHigh=0;$tot=0;
            foreach ($data as $k => $row){
                $excelData[] = [null, $i++, $row->name, (string)$row->low, (string)$row->mid, (string)$row->high, (string)$row->total];
                $totLow += $row->low;$totMid += $row->mid;$totHigh += $row->high;$tot += $row->total;
            }
            $excelData[] = [null, 'Total', null, (string)$totLow, (string)$totMid, (string)$totHigh, (string)$tot];

            return Excel::download(new KelengkapanExport($excelData), 'Kelengkapan-Aset.xlsx');
        }
    }

    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Support\Collection
     */
    private function getData(Request $request, $slug)
    {
        Permission::access('view-' . $this->permission);

        $query = DB::table("v_$slug as a")
            ->join('satkers as b', 'a.kode_satker', '=', 'b.kode')
            ->select(
                DB::raw("sum( IF ( filled_status = BINARY 'low', 1, 0 ) ) AS low"),
                DB::raw("sum( IF ( filled_status = BINARY 'mid', 1, 0 ) ) AS mid"),
                DB::raw("sum( IF ( filled_status = BINARY 'high', 1, 0 ) ) AS high"),
                DB::raw("sum( IF ( filled_status is null, 0, 1) ) AS total")
            );


        $user = \Auth::user();
        $viewAllAsset = Permission::can('view-all-asset');
        $viewAllLingkunganAsset = Permission::can('view-all-lingkungan-asset');
        $viewAllWilayahAsset = Permission::can('view-all-wilayah-asset');
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

        // Display
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

        // Order
        if($request->input('order') != '' ){
            $query->orderBy($request->input('order'), $request->input('order_opt') != '' ? $request->input('order_opt') : 'asc');
        }

        return $query->get();
    }
}
