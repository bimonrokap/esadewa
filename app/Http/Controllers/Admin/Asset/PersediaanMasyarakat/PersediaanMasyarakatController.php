<?php

namespace App\Http\Controllers\Admin\Asset\PersediaanMasyarakat;

use App\Http\Controllers\AssetController;
use App\Model\Asset\AssetPersediaanMasyarakat;
use App\Repositories\Datatable\Datatable;

class PersediaanMasyarakatController extends AssetController
{

    private $route = 'admin.asset.psmasyarakat';
    private $title = 'Persediaan Masyarakat';
    protected $categoryAsset = 2;

    public function __construct()
    {
        $this->model = new AssetPersediaanMasyarakat();
        $this->layout = $this->route;
        $this->config = [
            'route'     => $this->route,
            'title'     => $this->title,
            'pageTitle' => $this->title
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['config'] = $this->config;

        return view($this->layout . '.index', $data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        $action = ['edit'];
        $model = $this->model
            ->join('barangs as b', 'b.id', '=', 'asset_persediaan_masyarakats.id_barang')
            ->join('satkers as s', 's.id', '=', 'asset_persediaan_masyarakats.id_satker')
            ->select('tahun', 'periode', 'b.kode as kode_barang', 'b.name as nama_barang', 's.kode as kode_satker', 's.name as nama_satker', 'nilai', 'kuantitas');

        $dataTable = Datatable::create($model)
            ->setId('asset_persediaan_masyarakats.id')
            ->editColumn('nilai', function ($data) {
                return numberFormatIndo($data->nilai);
            })
            ->defaultAction($action, ['route' => $this->route, 'title' => $this->title])
            ->filterConstraint('active', 'match');
        $respond = $dataTable->make(true);

        return response()->json($respond);
    }
}
