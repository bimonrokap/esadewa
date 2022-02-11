<?php
namespace App\Http\Controllers\Admin\Monitoring\Simak;

use App\Http\Controllers\Controller;
use App\Model\BackupSimak;
use App\Model\Satker;
use App\Model\TingkatBanding;
use App\Model\Wilayah;
use App\Repositories\Permission\Permission;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SimakController extends Controller
{
    private $layout;
    private $config;
    private $route = 'admin.monitoring.simak';
    private $title = 'Backup SIMAK';
    private $permission = 'monitoring-simak';

    public function __construct()
    {
        $this->model = new BackupSimak();
        $this->layout = $this->route;
        $this->config = [
            'route'     => $this->route,
            'title'     => $this->title,
            'pageTitle' => $this->title,
            'permission'=> $this->permission,
        ];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        Permission::access('view-' . $this->permission);
        $user = \Auth::user();

        $data['config'] = $this->config;

        $isBindBySatker = $user->isBindBySatker() && !$user->isSuperAdmin();
        if($isBindBySatker) {
            if($request->input('start') != '' && $request->input('end')){
                $tmpStart = Carbon::createFromFormat('n/Y', $request->input('start'));
                $tmpEnd = Carbon::createFromFormat('n/Y', $request->input('end'));

                $start = $tmpStart->format('Y');
                $end = $tmpEnd->format('Y');
                $startMonth = $tmpStart->format('n');;
                $endMonth = $tmpEnd->format('n');
            } else {
                $start = (date('Y') - 5) < 2018 ? 2018 : date('Y') - 5;
                $end = date('Y');
                $startMonth = 1;
                $endMonth = 12;
            }

            $data['limit'] = [
                'start' => $start,
                'end' => $end,
                'startMonth' => $startMonth,
                'endMonth' => $endMonth,
            ];
            $data['now'] = Carbon::now();
            $data['canUploadBackup'] = Permission::can('create-'.$this->permission) && !$user->isSuperAdmin();

            $idSatker = $user->id_satker;
            $satker = $user->satker;
            $data['titleSatker'] = $satker->name .' ('.$satker->kode.')';

            $data['isBindBySatker'] = $isBindBySatker;
            $data['idSatker'] = $idSatker;
            $data['data'] = $this->getData($idSatker, $data['limit']);

            return view($this->route . '.index', $data);
        } else {
            $filter = $request->input('filter');

            $viewAllAsset = Permission::can('view-all-asset');
            $viewAllLingkunganAsset = Permission::can('view-all-lingkungan-asset');
            $viewAllWilayahAsset = Permission::can('view-all-wilayah-asset');
            $viewAllSatkerAsset = Permission::can('view-all-satker-asset');

            $data['viewAllAsset'] = $viewAllAsset;
            $data['viewAllLingkunganAsset'] = $viewAllLingkunganAsset;
            $data['viewAllWilayahAsset'] = $viewAllWilayahAsset;
            $data['viewAllSatkerAsset'] = $viewAllSatkerAsset;

            if($request->input('year') != null) {
                $year = $request->input('year');
            } else {
                $year = date('Y');
            }
            $data['year'] = $year;

            $record = $this->getDataAll($year, $filter);

            $wilayah = Wilayah::find($user->id_wilayah);
            if ($viewAllAsset) {
                $satker = Satker::select('*');
            } else if ($viewAllLingkunganAsset || $viewAllWilayahAsset) {
                $satker = new Satker();

                if ($viewAllWilayahAsset) {
                    if($user->isTingkatBanding() || $user->isAdminTingkatBanding()) {
                        $tingkatBanding = TingkatBanding::join('satkers', 'satkers.id', 'id_satker')
                            ->where('tingkat_bandings.lingkungan', $user->lingkungan)
                            ->where('tingkat_bandings.id_wilayah', $user->id_wilayah)->select('satkers.kode')->get()
                            ->pluck('kode')->all();

                        if(!empty($tingkatBanding)) {
                            $satker = Satker::whereIn('kode', $tingkatBanding);
                        } else {
                            $satker = $satker->where(DB::raw('SUBSTRING(kode, 6, 4)'), $wilayah->code);
                        }
                    } else {
                        $satker = $satker->where(DB::raw('SUBSTRING(kode, 6, 4)'), $wilayah->code);
                    }
                }

                if ($viewAllLingkunganAsset) {
                    $lingkungan = $user->lingkungan;
                    if ($lingkungan == 'PMT') {
                        $satker = $satker->where(function ($query) {
                            return $query->whereSatkerType('PM')->orWhere('satker_type', 'PT');
                        });
                    } else {
                        $satker = $satker->whereSatkerType($lingkungan);
                    }
                }
            }

            if(isset($filter['lingkungan']) && $filter['lingkungan'] != null) {
                $satker = $satker->whereSatkerType($filter['lingkungan']);
            }

            if(isset($filter['wilayah']) && $filter['wilayah'] != null) {
                $wilayah = Wilayah::find($filter['wilayah']);
                $satker = $satker->where(DB::raw('SUBSTRING(kode, 6, 4)'), $wilayah->code);
            }

            $data['satkers'] = $satker->get();

            $data['data'] = $record;

            $lingkungan = ['PN' => 'Peradilan Umum', 'PA' => 'Peradilan Agama', 'PM' => 'Peradilan Militer', 'PT' => 'Peradilan Tata Usaha Negara'];
            $data['wilayahs'] = Wilayah::get();
            $data['lingkungans'] = $lingkungan;

            $data['request']['filter'] = $request->input('filter');
            $data['request']['filter']['year'] = $year;

            return view($this->route . '.indexAll', $data);
        }
    }

    private function getDataAll($year, $filter)
    {
        $record = Satker::leftJoin('backup_simaks', function ($join) use($year){
                $join->on('backup_simaks.satker_id', '=', 'satkers.id')
                    ->where(function ($query) use($year){
                        return $query->whereYear('date', $year)->orWhere('date', null);
                    });
            })
            ->leftJoin('users', 'users.id', '=', 'backup_simaks.created_by')
            ->select('satkers.id', 'satkers.name', 'kode', 'date', 'file', 'backup_simaks.id as idFile', 'backup_simaks.updated_at', 'users.name as userName', 'users.nip')
            ->orderBy('satkers.kode')
            ->assetBy('satkers.kode', true);

        if(isset($filter['lingkungan']) && $filter['lingkungan'] != null) {
            $record->whereSatkerType($filter['lingkungan']);
        }

        if(isset($filter['wilayah']) && $filter['wilayah'] != null) {
            $wilayah = Wilayah::find($filter['wilayah']);
            $record->where(DB::raw('SUBSTRING(kode, 6, 4)'), $wilayah->code);
        }

        if(isset($filter['satker']) && $filter['satker'] != null) {
            $record->whereKode($filter['satker']);
        }

        $data['data'] = $record->get()->groupBy('id')->map(function ($data){
            $tmp = $data[0];
            if(count($data) == 1 && $data[0]->date == null) {
                $tmp['data'] = [];
            } else {
                $tmp['data'] = $data->keyBy('date')->toArray();
            }

            return $tmp->toArray();
        })->values()->toArray();

        return $data['data'];
    }

    public function getSatker(Request $request)
    {
        $user = \Auth::user();
        $viewAllAsset = Permission::can('view-all-asset');
        $viewAllLingkunganAsset = Permission::can('view-all-lingkungan-asset');
        $viewAllWilayahAsset = Permission::can('view-all-wilayah-asset');

        $wilayah = Wilayah::find($user->id_wilayah);
        if ($viewAllAsset) {
            $satker = Satker::select('*');
        } else if ($viewAllLingkunganAsset || $viewAllWilayahAsset) {
            $satker = new Satker();

            if ($viewAllLingkunganAsset) {
                $lingkungan = $user->lingkungan;
                if($lingkungan == 'PMT') {
                    $satker = $satker->where(function ($query){
                        return $query->whereSatkerType('PM')->orWhere('satker_type', 'PT');
                    });
                } else {
                    $satker = $satker->whereSatkerType($lingkungan);
                }
            }

            if ($viewAllWilayahAsset) {
                if($user->isTingkatBanding() || $user->isAdminTingkatBanding()) {
                    $tingkatBanding = TingkatBanding::join('satkers', 'satkers.id', 'id_satker')
                        ->where('tingkat_bandings.lingkungan', $user->lingkungan)
                        ->where('tingkat_bandings.id_wilayah', $user->id_wilayah)->select('satkers.kode')->get()
                        ->pluck('kode')->all();

                    if(!empty($tingkatBanding)) {
                        $satker = $satker->whereIn('kode', $tingkatBanding);
                    } else {
                        $satker = $satker->where(DB::raw('SUBSTRING(kode, 6, 4)'), $wilayah->code);
                    }
                } else {
                    $satker = $satker->where(DB::raw('SUBSTRING(kode, 6, 4)'), $wilayah->code);
                }
            }
        }

        if($request->input('lingkungan') != null) {
            $satker->whereSatkerType($request->input('lingkungan'));
        }

        if($request->input('wilayah') != null) {
            $wilayah = Wilayah::find($request->input('wilayah'));
            $satker->where(DB::raw('SUBSTRING(kode, 6, 4)'), $wilayah->code);
        }

        $data['satkers'] = $satker->select('id','kode', 'name')->get();

        return response()->json($data['satkers']);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadBatch(Request $request)
    {
        $tmpStart = Carbon::createFromFormat('n/Y', $request->input('start'));
        $tmpEnd = Carbon::createFromFormat('n/Y', $request->input('end'));

        $start = $tmpStart->format('Y');
        $end = $tmpEnd->format('Y');
        $startMonth = $tmpStart->format('n');;
        $endMonth = $tmpEnd->format('n');

        $limit = [
            'start' => $start,
            'end' => $end,
            'startMonth' => $startMonth,
            'endMonth' => $endMonth,
        ];

        $addFileName = '';

        $user = \Auth::user();
        if($user->isBindBySatker()) {
            $idSatker = $user->id_satker;
            $addFileName .= '-'.$user->satker->kode;
        } else {
            $idSatker = $request->input('satker');
            $satker = Satker::findOrFail($idSatker);
            $addFileName .= '-'.$satker->kode;
        }
        $data = $this->getData($idSatker, $limit);

        $zip_file = 'backupSimakZip/'.date('dmY').'/'. uniqid($user->id.'-');
        \Storage::put($zip_file, '');
        $zip = new \ZipArchive();
        $zip->open(storage_path('app/' .$zip_file), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($data as $d) {
            $zip->addFile(storage_path('app/'.$d->file), 'bac'.Carbon::createFromFormat('n-Y', $d->date)->format('mY').$d->user->satker->kode.'.bac');
        }

        $zip->close();

        if($data->isEmpty()){
            return redirect()->route($this->route . '.index' );
        }

        $filename = 'backup-' . $tmpStart->format('nY') . '-' . $tmpEnd->format('nY') . ($addFileName) . '.zip';
        return response()->download(storage_path('app/'.$zip_file), $filename);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadBatchAll(Request $request)
    {
        $user = \Auth::user();

        $year = $request->input('year');
        $filter = $request->input('filter');

        $data = $this->getDataAll($year, $filter);

        $zip_file = 'backupSimakZip/'.date('dmY').'/'. uniqid($user->id.'-');
        \Storage::put($zip_file, '');
        $zip = new \ZipArchive();
        $zip->open(storage_path('app/' .$zip_file), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $empty = true;
        foreach ($data as $d) {
            foreach ($d['data'] as $r){
                if($r['file'] !== null){
                    $empty = false;
                    $zip->addFile(storage_path('app/'.$r['file']), $d['kode'].'/bac'.Carbon::createFromFormat('Y-m-d', $r['date'])->format('mY').$d['kode'].'.bac');
                }
            }
        }

        if(!$empty) {
            $zip->close();

            $filename = 'backup-' . $year . '.zip';
            return response()->download(storage_path('app/'.$zip_file), $filename);
        } else {
            return redirect()->route($this->route . '.index' );
        }
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download($id)
    {
        $data = $this->model->find($id);
        $filename = 'bac'.Carbon::parse($data->date)->format('mY').$data->satker->kode.'.bac';

        return \Storage::download($data->file, $filename);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        Permission::access('create-' . $this->permission);

        $validate = [
            'file' => 'required|file|max:10240|mimetypes:application/zip',
            'date' => 'required',
        ];

        $validator = Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $date = explode('-', $request->input('date'));
            $date = Carbon::now()->day(1)->month($date[0])->year($date[1]);
            $user = \Auth::user();
            $model = $this->model->where('date', $date->toDateString())->whereSatkerId($user->id_satker)->first();

            $satker = $user->satker;
            $satkerCode = $satker->kode;
            $dateFormat = $date->format('m-Y');
            $fileLocation = 'backupSimak/' . $satkerCode . '/' . $dateFormat;
            $fileName = uniqid('bak-' . $dateFormat . '-' . $satkerCode.'-');

            $request->file('file')->storeAs($fileLocation, $fileName);
            if($model == null) {
                $model = $this->model->create([
                    'satker_id' => $satker->id,
                    'created_by' => $user->id,
                    'file' => $fileLocation.'/'.$fileName,
                    'date' => $date->toDateString()
                ]);
            } else {
                $model->file = $fileLocation.'/'.$fileName;
                $model->created_by = $user->id;
                $model->save();
            }

            if ($model) {
                $res = [
                    'status'  => 1,
                    'message' => 'Berhasil menambahkan Data ' . $this->title . ' untuk bulan <strong>' . $date->format('F Y') . '</strong>',
                    'date' => Carbon::parse($model->updated_at)->format('j F Y'),
                    'id' => $model->id,
                    'user' => [
                        'name' => $user->name,
                        'nip' => $user->nip ? $user->nip : '' ,
                    ]
                ];
            } else {
                $res = [
                    'status'  => 0,
                    'message' => 'Gagal menambahkan data ' . $this->title
                ];
            }
        } else {
            $messages = $validator->errors()->all('<li>:message</li>');
            $res = [
                'status'  => 2,
                'message' => '<ul class="m--marginless">' . implode('', $messages) . '</ul>'
            ];
        }

        return response()->json($res);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        Permission::access('create-' . $this->permission);

        $data = $this->model->findOrFail($id);

        if($data->user->id_satker != \Auth::user()->id_satker) {
            $res['status'] = 0;
        } else {
            $result = $data->delete();

            $res = [
                'status' => $result ? 1 : 0
            ];
        }

        return response()->json($res);
    }

    /**
     * @param $idSatker
     * @param $limit
     * @return mixed
     */
    private function getData($idSatker, $limit)
    {
        $data = $this->model->with('user.satker')->whereSatkerId($idSatker)->whereBetween('date', [
            Carbon::now()->year($limit['start'])->month($limit['startMonth'])->day(1)->toDateString(),
            Carbon::now()->year($limit['end'])->month($limit['endMonth'])->day(1)->toDateString()
        ])->select('id', 'updated_at',DB::raw('concat(MONTH(date),"-",YEAR(date)) as date'),'file','created_by')
            ->with('user')->get()->keyBy('date');

        return $data;
    }
}
