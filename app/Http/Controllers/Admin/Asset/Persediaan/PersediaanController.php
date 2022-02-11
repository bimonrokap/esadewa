<?php

namespace App\Http\Controllers\Admin\Asset\Persediaan;

use App\Http\Controllers\AssetController;
use App\Model\Asset\AssetPersediaan;
use App\Repositories\Datatable\Datatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PersediaanController extends AssetController
{

    private $route = 'admin.asset.persediaan';
    private $title = 'Persediaan';
    protected $categoryAsset = 1;

    public function __construct()
    {
        $this->model = new AssetPersediaan();
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

        $data['tableRoute'] = route($this->route . '.table');
        return view($this->layout . '.index', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function table(Request $request)
    {
        $model = $this->model
            ->join('barangs as b', 'b.id', '=', 'asset_persediaans.id_barang')
            ->join('satkers as s', 's.id', '=', 'asset_persediaans.id_satker')
            ->select('tahun', 'periode', 'b.kode as kode_barang', 'b.name as nama_barang', 's.kode as kode_satker', 's.name as nama_satker', 'nilai', 'kuantitas');

        $this->nilaiPerolehan = 'nilai';
        $this->hasPsp = false;
        $this->barangJoin = true;
        list($model, $hasUsulan)  = $this->searchUsulan($request, $model);

        $dataTable = Datatable::create($model)
            ->setId('asset_persediaans.id')
            ->editColumn('nilai', function ($data) {
                return 'Rp '.numberFormatIndo($data->nilai);
            })
            ->editColumn('action', function ($data) use($hasUsulan) {
                $html = '#';
                if($hasUsulan){
                    return '<button type="button" data-attr="'.htmlspecialchars(json_encode(['id' => $data->id, 'nup' => '-', 'kode' => $data->kode_barang, 'nama' => $data->nama_barang, 'nilai' => $data->nilai, 'tgl' => '-'])).'" title="Tambah Barang" class="btn btn-success btn-xs m-btn m-btn--icon m-btn--icon-only btn-barang">
                        <i class="la la-plus"></i>
                    </button>';
                }
                return $html;
            })
            ->filterConstraint('active', 'match');
        $respond = $dataTable->make(true);

        return response()->json($respond);
    }
}
