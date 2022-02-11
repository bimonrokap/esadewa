<?php

namespace App\Http\Controllers\Admin\Monitoring\Penghapusan;

use App\Http\Controllers\Controller;
use App\Model\CategoryAsset;
use App\Model\MonitoringPenghapusan;
use App\Model\Penghapusan\Penghapusan;
use App\Model\Penghapusan\StatusPenghapusan;
use App\Model\Satker;
use App\Model\Wilayah;
use App\Repositories\Permission\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PenghapusanController extends Controller
{

    private $layout, $config;
    private $route = 'admin.monitoring.penghapusan';
    private $title = 'Penghapusan';
    private $permission = 'monitoring-penghapusan';

    public function __construct()
    {
        $this->layout = $this->route;
        $this->config = [
            'route'     => $this->route,
            'title'     => $this->title,
            'pageTitle' => $this->title,
            'permission'=> $this->permission
        ];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        Permission::access('view-' . $this->permission);

        $filters = $request->input('filter');

        if(isset($filters['tahun']) && $filters['tahun'] != null) {
            $year = $filters['tahun'];
        } else {
            $year = Carbon::now()->year;
        }

        $record = Penghapusan::join('users as u', 'u.id', 'penghapusans.created_by')
            ->join('satkers', 'satkers.id', 'u.id_satker')
            ->select('satkers.kode', \DB::raw('count(penghapusans.id) as sk'), 'jumlah_barang', 'nilai_perolehan')
            ->groupBy('u.id_satker')->orderBy('satkers.kode')
            ->where(\DB::raw('year(penghapusans.created_at)'), $year)
            ->where('penghapusans.id_penghapusan_status', StatusPenghapusan::SELESAI)
            ->assetBy('satkers.kode', true);

        if(is_array($filters)) {
            foreach ($filters as $key => $filter) {
                if($filter != "") {
                    switch ($key) {
                        case 'wilayah': $record->where('satkers.id_wilayah', $filter); break;
                        case 'lingkungan': $record->where('satker_type', $filter); break;
                    }
                }
            }
        }

        $satkers = Satker::select('satkers.id', 'kode', 'name', \DB::raw('SUM(kuantitas) as kuantitas'),
            \DB::raw('SUM(nilai) as nilai'))->orderBy('kode')->groupBy('satkers.id')->where(function ($query) use($year){
                $query->where('mp.year', $year)->orWhere('mp.year', null);
            })
            ->leftJoin('monitoring_penghapusan_details as pd', function ($join){
                $join->on(\DB::raw('SUBSTRING(satkers.kode, 10, 6)'), '=', \DB::raw('SUBSTRING(pd.kode_satker, -6)'))
                    ->whereIn('kode_transaksi', [301, 391, 306, 396, 308, 398, 353, 371, 372, 376, 378, 379, 381]);
            })
            ->leftJoin('monitoring_penghapusans as mp', function($join) use($year){
                $join->on('mp.id', '=', 'pd.id_monitoring_penghapusan');
            })->assetBy('satkers.kode', true);

        if(is_array($filters)) {
            foreach ($filters as $key => $filter) {
                if($filter != "") {
                    switch ($key) {
                        case 'wilayah': $satkers->where('satkers.id_wilayah', $filter); break;
                        case 'lingkungan': $satkers->where('satker_type', $filter); break;
                    }
                }
            }
        }
        $filters['tahun'] = $year;
        $satkers = $satkers->get();

        $data['data'] = $record->get()->keyBy('kode')->all();
        $data['satkers'] = $satkers;
        $data['filter'] = $filters;

        $data['filterOn'] = false;
        $viewAllAsset = Permission::can('view-all-asset');
        $viewAllLingkunganAsset = Permission::can('view-all-lingkungan-asset');
        $viewAllWilayahAsset = Permission::can('view-all-wilayah-asset');
        $data['viewAllAsset'] = $viewAllAsset;
        $data['viewAllLingkunganAsset'] = $viewAllLingkunganAsset;
        $data['viewAllWilayahAsset'] = $viewAllWilayahAsset;
        if($viewAllAsset || $viewAllWilayahAsset || $viewAllLingkunganAsset){
            $data['filterOn'] = true;
        }

        $data['config'] = $this->config;
        $data['lingkungans'] = ["PN" => "Peradilan Umum", "PA" => "Peradilan Agama", "PM" => "Peradilan Militer", "PT" => "Peradilan Tata Usaha", "PMT" => "Peradilan Militer & Tata Usaha", 'PUSAT' => 'Pusat'];
        $data['wilayahs'] = Wilayah::orderBy('name')->get();

        return view($this->layout . '.index', $data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        Permission::access('view-' . $this->permission);

        $year = $request->input('year');

        $data['config'] = $this->config;
        $data['penghapusan'] = Penghapusan::join('users as u', 'u.id', 'penghapusans.created_by')
            ->join('satkers', 'satkers.id', 'u.id_satker')
            ->select(\DB::raw('count(penghapusans.id) as sk'), 'jumlah_barang', 'nilai_perolehan')
            ->groupBy('u.id_satker')->orderBy('satkers.kode')
            ->where(\DB::raw('year(penghapusans.created_at)'), $year)
            ->where('penghapusans.id_penghapusan_status', StatusPenghapusan::SELESAI)
            ->where('satkers.id', $id)->assetBy('satkers.kode', true)->first();

        $data['satker'] = Satker::select('satkers.id', 'kode', 'name', \DB::raw('SUM(kuantitas) as kuantitas'),
                \DB::raw('SUM(nilai) as nilai'))->orderBy('kode')->groupBy('satkers.id')->where(function ($query) use($year){
                $query->where('mp.year', $year)->orWhere('mp.year', null);
            })
            ->leftJoin('monitoring_penghapusan_details as pd', function ($join){
                $join->on(\DB::raw('SUBSTRING(satkers.kode, 10, 6)'), '=', \DB::raw('SUBSTRING(pd.kode_satker, -6)'))
                    ->whereIn('kode_transaksi', [301, 391, 306, 396, 308, 398, 353, 371, 372, 376, 378, 379, 381]);
            })
            ->leftJoin('monitoring_penghapusans as mp', function($join) use($year){
                $join->on('mp.id', '=', 'pd.id_monitoring_penghapusan');
            })->where('satkers.id', $id)->assetBy('satkers.kode', true)->first();

        $data['year'] = $year;
        $data['table']['headerDokumen'] = ['No Surat Usulan Satker', 'No SK', 'File SK', 'Unit', 'Nilai', 'Tanggal Surat', 'Tanggal Pengajuan', 'Tipe Penghapusan'];
        $data['table']['headerTransaksi'] = ['Kode Satker', 'Nama Satker', 'Akun', 'Uraian AKun', 'Kode Bidang', 'Uraian Bidang', 'Kode Transaksi', 'Uraian Transaksi', 'Kuantitas', 'Nilai'];

        return view($this->layout . '.show', $data);
    }

    /**
     * @param $id
     * @param $year
     * @return \Illuminate\Http\JsonResponse
     */
    public function tableTransaksi($id, $year)
    {
        $data = MonitoringPenghapusan::where('year', $year)->firstOrFail();
        \Permission::access('view-' . $this->permission);

        $model = $data->detail()->select( 'id_monitoring_penghapusan', 'kode_satker', 'nama_satker', 'akun', 'uraian_akun',
            'kode_bidang', 'uraian_bidang', 'kode_transaksi', 'uraian_transaksi', 'kuantitas', 'nilai')
            ->join('satkers as s', \DB::raw('SUBSTRING(s.kode, 10, 6)'), \DB::raw('SUBSTRING(kode_satker, -6)'))
            ->whereIn('kode_transaksi', [301, 391, 306, 396, 308, 398, 353, 371, 372, 376, 378, 379, 381])
            ->where('s.id', $id)
            ->assetBy('s.kode');

        $dataTable = \Datatable::create($model)
            ->setId('monitoring_penghapusan_details.id')
            ->editColumn('nilai', function ($data){
                return $data->nilai == null ? '<i class="empty-text">empty</i>' : 'Rp '.numberFormatIndo($data->nilai);
            });
        $respond = $dataTable->make(true);

        return response()->json($respond);
    }

    /**
     * @param $id
     * @param $year
     * @return \Illuminate\Http\JsonResponse
     */
    public function tableDokumen($id, $year)
    {
        \Permission::access('view-' . $this->permission);

        $model = Penghapusan::join('users as u', 'u.id', '=', 'penghapusans.created_by')
            ->join('satkers as s', 's.id', '=', 'u.id_satker')
            ->join('penghapusan_statuses as ps', 'ps.id', '=', 'penghapusans.id_penghapusan_status')
            ->where('s.id', $id)
            ->whereYear('letter_date', $year)
            ->select('letter_number', 'surat_persetujuan', 'nilai_perolehan', 'jumlah_barang', 'letter_date', 'state', 'penghapusans.created_at',
                "ps.name as penghapusanStatus", 'id_penghapusan_status', 'letter_number_persetujuan', 'penghapusan_type');

        $dataTable = \Datatable::create($model)
            ->setId('penghapusans.id')
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('j F Y, H:s');
            })
            ->editColumn('letter_date', function ($data) {
                return Carbon::parse($data->letter_date)->format('j F Y');
            })
            ->editColumn('surat_persetujuan', function ($data) {
                return '<a target="_blank" class="btn btn-danger btn-sm btn-block" href="'.(Penghapusan::docLocation($data->id, $data->surat_persetujuan, true)).'">
                        <i class="fa fa-file-pdf-o"></i> File
                </a>';
            })
            ->editColumn('penghapusanType', function ($data) {
                return '<span class="m-badge m-badge--'.($data->penghapusan_type == 1 ? 'primary' : 'info').' m-badge--wide">'.($data->penghapusan_type == 1 ? 'Mebelair' : 'Non Mebelair').'</span>';
            })
            ->editColumn('satker', function ($data) {
                return $data->nama_satker . ' ( '.$data->kode_satker.' )';
            })
            ->editColumn('nilai_perolehan', function ($data) {
                return 'Rp '.numberFormatIndo($data->nilai_perolehan);
            })
            ->editColumn('jumlah_barang', function ($data) {
                return numberFormatIndo($data->jumlah_barang);
            })
            ->filterConstraint(['letter_date' => 'date', 'created_at' => 'date']);
        $respond = $dataTable->make(true);

        return response()->json($respond);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        Permission::access('view-' . $this->permission);

        $filters = $request->input('filter');

        if(isset($filters['tahun']) && $filters['tahun'] != null) {
            $year = $filters['tahun'];
        } else {
            $year = Carbon::now()->year;
        }

        $record = Penghapusan::join('users as u', 'u.id', 'penghapusans.created_by')
            ->join('satkers', 'satkers.id', 'u.id_satker')
            ->select('satkers.kode', \DB::raw('count(penghapusans.id) as sk'), 'jumlah_barang', 'nilai_perolehan')
            ->groupBy('u.id_satker')->orderBy('satkers.kode')
            ->where(\DB::raw('year(penghapusans.created_at)'), $year)
            ->where('penghapusans.id_penghapusan_status', StatusPenghapusan::SELESAI)
            ->assetBy('satkers.kode');

        if(is_array($filters)) {
            foreach ($filters as $key => $filter) {
                if($filter != "") {
                    switch ($key) {
                        case 'wilayah': $record->where('satkers.id_wilayah', $filter); break;
                        case 'lingkungan': $record->where('satker_type', $filter); break;
                    }
                }
            }
        }

        $satkers = Satker::select('satkers.id', 'kode', 'name', \DB::raw('SUM(kuantitas) as kuantitas'),
            \DB::raw('SUM(nilai) as nilai'))->orderBy('kode')->groupBy('satkers.id')->where(function ($query) use($year){
            $query->where('mp.year', $year)->orWhere('mp.year', null);
        })
            ->leftJoin('monitoring_penghapusan_details as pd', function ($join){
                $join->on(\DB::raw('SUBSTRING(satkers.kode, 10, 6)'), '=', \DB::raw('SUBSTRING(pd.kode_satker, -6)'))
                    ->whereIn('kode_transaksi', [301, 391, 306, 396, 308, 398, 353, 371, 372, 376, 378, 379, 381]);
            })
            ->leftJoin('monitoring_penghapusans as mp', function($join) use($year){
                $join->on('mp.id', '=', 'pd.id_monitoring_penghapusan');
            })->assetBy('satkers.kode');

        if(is_array($filters)) {
            foreach ($filters as $key => $filter) {
                if($filter != "") {
                    switch ($key) {
                        case 'wilayah': $satkers->where('satkers.id_wilayah', $filter); break;
                        case 'lingkungan': $satkers->where('satker_type', $filter); break;
                    }
                }
            }
        }
//        $filters['tahun'] = $year;
        $satkers = $satkers->get();

        $data['data'] = $record->get()->keyBy('kode')->all();
        $data['satkers'] = $satkers;
//        $data['filter'] = $filters;

        $data['config'] = $this->config;
        $data['lingkungans'] = ["PN" => "Peradilan Umum", "PA" => "Peradilan Agama", "PM" => "Peradilan Militer", "PT" => "Peradilan Tata Usaha", "PMT" => "Peradilan Militer & Tata Usaha", 'PUSAT' => 'Pusat'];
        $data['wilayahs'] = Wilayah::orderBy('name')->get();

        return Excel::download(new \App\Exports\Monitoring\MonitoringPenghapusan($data), 'Monitoring-Penghapusan-'.$year.'.xlsx');
    }
}
