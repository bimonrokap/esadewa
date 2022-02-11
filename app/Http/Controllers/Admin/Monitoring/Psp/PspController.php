<?php

namespace App\Http\Controllers\Admin\Monitoring\Psp;

use App\Exports\Monitoring\MonitoringPsp;
use App\Exports\Monitoring\MonitoringPspSatker;
use App\Http\Controllers\Controller;
use App\Model\CategoryAsset;
use App\Model\Satker;
use App\Model\Wilayah;
use App\Repositories\Permission\Permission;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PspController extends Controller
{

    private $layout, $config;
    private $route = 'admin.monitoring.psp';
    private $title = 'PSP';
    private $permission = 'monitoring-psp';

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

        $data['filterOn'] = false;
        $record = Satker::join('monitoring_psps', 'monitoring_psps.kode_satker', '=', 'satkers.kode', 'left')
            ->select('satkers.kode', 'satkers.name',
                \DB::raw('sum(total_unit) as total_unit'),
                \DB::raw('sum(total_nilai) as total_nilai'),
                \DB::raw('sum(total_unit_psp) as total_unit_psp'),
                \DB::raw('sum(total_nilai_psp) as total_nilai_psp'),
                \DB::raw('sum(total_unit_belum_psp) as total_unit_belum_psp'),
                \DB::raw('sum(total_nilai_belum_psp) as total_nilai_belum_psp')
            )->groupBy('satkers.kode')->orderBy('satkers.kode')->assetBy('satkers.kode', true);

        $filters = $request->input('filter');
        if(is_array($filters)) {
            foreach ($filters as $key => $filter) {
                if($filter != "") {
                    switch ($key) {
                        case 'wilayah': $record->where('id_wilayah', $filter); break;
                        case 'lingkungan': $record->where('satker_type', $filter); break;
                    }
                }
            }
        }

        $viewAllAsset = Permission::can('view-all-asset');
        $viewAllLingkunganAsset = Permission::can('view-all-lingkungan-asset');
        $viewAllWilayahAsset = Permission::can('view-all-wilayah-asset');
        $data['viewAllAsset'] = $viewAllAsset;
        $data['viewAllLingkunganAsset'] = $viewAllLingkunganAsset;
        $data['viewAllWilayahAsset'] = $viewAllWilayahAsset;
        if($viewAllAsset || $viewAllWilayahAsset || $viewAllLingkunganAsset){
            $data['filterOn'] = true;
        }

        $data['satkers'] = $record->get();
        $data['filter'] = $filters;

        $data['config'] = $this->config;
        $data['lingkungans'] = ["PN" => "Peradilan Umum", "PA" => "Peradilan Agama", "PM" => "Peradilan Militer", "PT" => "Peradilan Tata Usaha", "PMT" => "Peradilan Militer & Tata Usaha", 'PUSAT' => 'Pusat'];
        $data['wilayahs'] = Wilayah::orderBy('name')->get();

        return view($this->layout . '.index', $data);
    }

    public function show(Request $request, $id)
    {
        Permission::access('view-' . $this->permission);

        $data['config'] = $this->config;
        $data['satker'] = Satker::where('kode', $id)->assetBy('satkers.kode', true)->firstOrFail();
        $data['categories'] = CategoryAsset::where('active', 1)->where('table_name', '!=', null)->where('id', '!=', 16)->get();

        $data['data'] = CategoryAsset::select('category_assets.name', 'total_unit', 'total_nilai', 'total_unit_psp', 'total_nilai_psp', 'total_unit_belum_psp', 'total_nilai_belum_psp')
            ->leftJoin('monitoring_psps', function ($join) use($id) {
                $join->on('monitoring_psps.id_category_asset', '=', 'category_assets.id')->where('monitoring_psps.kode_satker', $id);
            })->where('active', 1)->where('table_name', '!=', null)->where('category_assets.id', '!=', 16)
            ->orderBy('order')->get();

        $data['dataSum'] = CategoryAsset::select('kode_satker',
            \DB::raw('SUM(total_unit) as total_unit'),
            \DB::raw('SUM(total_nilai) as total_nilai'),
            \DB::raw('SUM(total_unit_psp) as total_unit_psp'),
            \DB::raw('SUM(total_nilai_psp) as total_nilai_psp'),
            \DB::raw('SUM(total_unit_belum_psp) as total_unit_belum_psp'),
            \DB::raw('SUM(total_nilai_belum_psp) as total_nilai_belum_psp'))
            ->join('monitoring_psps', function ($join) use($id) {
                $join->on('monitoring_psps.id_category_asset', '=', 'category_assets.id')->where('monitoring_psps.kode_satker', $id);
            })->groupBy('kode_satker')->first();

        return view($this->layout . '.show', $data);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        Permission::access('view-' . $this->permission);

        $record = Satker::leftJoin('monitoring_psps', 'monitoring_psps.kode_satker', '=', 'satkers.kode')
            ->select('satkers.kode',
                \DB::raw('sum(total_unit) as total_unit'),
                \DB::raw('sum(total_nilai) as total_nilai'),
                \DB::raw('sum(total_unit_psp) as total_unit_psp'),
                \DB::raw('sum(total_nilai_psp) as total_nilai_psp'),
                \DB::raw('sum(total_unit_belum_psp) as total_unit_belum_psp'),
                \DB::raw('sum(total_nilai_belum_psp) as total_nilai_belum_psp')
            )->groupBy('monitoring_psps.kode_satker')->orderBy('satkers.kode');
        $builderSatker = Satker::orderBy('satkers.kode')->select('name', 'kode')->assetBy('satkers.kode', true);

        $filters = $request->input('filter');
        if(is_array($filters)) {
            foreach ($filters as $key => $filter) {
                if($filter != "") {
                    switch ($key) {
                        case 'wilayah': $record->where('id_wilayah', $filter); $builderSatker->where('id_wilayah', $filter); break;
                        case 'lingkungan': $record->where('satker_type', $filter); $builderSatker->where('satker_type', $filter); break;
                    }
                }
            }
        }

        $data['satkers'] = $builderSatker->get();
        $data['categories'] = CategoryAsset::where('active', 1)->where('table_name', '!=', null)->where('id', '!=', 16)->get();

        foreach ($data['categories'] as $category) {
            $tmpData = Satker::leftJoin('monitoring_psps', 'monitoring_psps.kode_satker', '=', 'satkers.kode')
                ->where('id_category_asset', $category->id)
                ->select('satkers.kode', 'total_unit', 'total_nilai', 'total_unit_psp', 'total_nilai_psp',
                    'total_unit_belum_psp', 'total_nilai_belum_psp')
                ->orderBy('satkers.kode');

            if(is_array($filters)) {
                foreach ($filters as $key => $filter) {
                    if($filter != "") {
                        switch ($key) {
                            case 'wilayah': $tmpData->where('id_wilayah', $filter); break;
                            case 'lingkungan': $tmpData->where('satker_type', $filter); break;
                        }
                    }
                }
            }

            $data['data'][str_slug($category->name)] = $tmpData->get()->keyBy('kode');;
        }
        $data['data']['keseluruhan'] = $record->get()->keyBy('kode');

        return Excel::download(new MonitoringPsp($data), 'Monitoring-PSP.xlsx');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportSatker(Request $request, $id)
    {
        Permission::access('view-' . $this->permission);

        $data['satker'] = Satker::where('kode', $id)->firstOrFail();
        $data['data'] = CategoryAsset::select('category_assets.name', 'total_unit', 'total_nilai', 'total_unit_psp', 'total_nilai_psp', 'total_unit_belum_psp', 'total_nilai_belum_psp')
        ->leftJoin('monitoring_psps', function ($join) use($id) {
            $join->on('monitoring_psps.id_category_asset', '=', 'category_assets.id')->where('monitoring_psps.kode_satker', $id);
        })->where('active', 1)->where('table_name', '!=', null)->where('category_assets.id', '!=', 16)
        ->orderBy('order')->get();

        return Excel::download(new MonitoringPspSatker($data), 'Monitoring-PSP-'.(str_slug($data['satker']->name)).'.xlsx');
    }
}
