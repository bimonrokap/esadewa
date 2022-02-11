<?php

namespace App\Http\Controllers\Admin\Asset\PeralatanNonTik;

use App\Http\Controllers\AssetController;
use App\Model\Asset\AssetPeralatanNonTik;
use App\Repositories\Datatable\Datatable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeralatanNonTikController extends AssetController
{

    private $route = 'admin.asset.peralatannontik';
    private $title = 'Mesin & Peralatan Non TIK';
    public $tableHeader = ['Kode Barang', 'NUP', 'Kode Satker', 'Nama Satker', 'Nama Barang', 'Kondisi', 'Merk/Tipe', 'Tgl Perolehan', 'Nilai Perolehan Pertama', 'Nilai Mutasi', 'Nilai Perolehan', 'Nilai Penyusutan', 'Nilai Buku', 'Kuantitas', 'Jml Foto', 'Status Penggunaan', 'Status Pengelolaan', 'No PSP', 'Tgl PSP', 'Jumlah KIB', 'Tanggal Update'];
    protected $categoryAsset = 5;

    public function __construct()
    {
        $this->model = new AssetPeralatanNonTik();
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
        $data['table']['header'] = $this->tableHeader;

        $data['tableRoute'] = route($this->route . '.table');
        $data['importSlug'] = 'peralatannontik';

        $data['filter'] = $this->generalFilter();
        $data['baseFilter'] = $this->baseFilter;
        return view($this->layout . '.index', $data);
    }

    /**
     * @param $param
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewTable($param)
    {
        $data['config'] = $this->config;
        $data['table']['header'] = $this->tableHeader;
        $data['tableRoute'] = route($this->route . '.table', $param);
        $data['tableLayout'] = $this->route . '.table';

        return view('template.usulan.table-container', $data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function table(Request $request)
    {
        $filter = $request->input('filter');

        $model = $this->model
            ->generalFilter($filter)
            ->assetBy()
            ->select('*');

        list($model, $hasUsulan)  = $this->searchUsulan($request, $model);

        $dataTable = Datatable::create($model)
            ->editColumn('kode_barang', function ($data) {
                return $this->canLaporBmn($data);
            })
            ->editColumn('nilai_perolehan_pertama', function ($data) {
                return 'Rp ' .numberFormatIndo($data->nilai_perolehan_pertama);
            })
            ->editColumn('nilai_mutasi', function ($data) {
                return 'Rp ' .numberFormatIndo($data->nilai_mutasi);
            })
            ->editColumn('nilai_perolehan', function ($data) {
                return 'Rp ' .numberFormatIndo($data->nilai_perolehan);
            })
            ->editColumn('nilai_penyusutan', function ($data) {
                return 'Rp ' .numberFormatIndo($data->nilai_penyusutan);
            })
            ->editColumn('nilai_buku', function ($data) {
                return 'Rp ' .numberFormatIndo($data->nilai_buku);
            })
            ->editColumn('tanggal_update', function ($data) {
                return $data->tanggal_update == null ? '-' : Carbon::parse($data->tanggal_update)->format('j F Y');
            })
            ->editColumn('action', function ($data) use($hasUsulan){
                $html = '#';
                if($hasUsulan){
                    return '<button type="button" data-attr="'.htmlspecialchars(json_encode(['id' => $data->id, 'category' => 'Peralatan & Mesin NON TIK', 'nup' => $data->nup, 'kode' => $data->kode_barang, 'nama' => $data->nama_barang, 'nilai' => $data->nilai_perolehan, 'tgl' => Carbon::parse($data->tgl_perolehan)->format('d F Y')])).'" title="Tambah Barang" class="btn btn-success btn-xs m-btn m-btn--icon m-btn--icon-only btn-barang">
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
