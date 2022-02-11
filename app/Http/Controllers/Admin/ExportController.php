<?php
namespace App\Http\Controllers\Admin;

use App\Exports\KelengkapanExport;
use App\Http\Controllers\Admin\Monitoring\Kelengkapan\KelengkapanController;
use App\Http\Controllers\Admin\Monitoring\Kelengkapan\SatkerController;
use App\Http\Controllers\Controller;
use App\Model\AssetMonitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $excelData =  [
            [null, 'No', 'Kategori Aset', 'Kelengkapan Data Aset', null, null, 'Total'],
            [null, null, null, 'Belum Lengkap', 'Kurang Lengkap', 'Lengkap'],
        ];

        $assetMonitoring = AssetMonitoring::select('*', DB::raw('CONCAT(data, "_", type) as identity'))->get();
        if($request->has('satker')) {
            $con = new SatkerController();
            $data = $con->generateCategory($assetMonitoring, $request->input('satker'));
        } else {
            $con = new KelengkapanController();
            $data = $con->generateCategory($assetMonitoring);
        }

        $i = 1;$totLow=0;$totMid=0;$totHigh=0;$tot=0;
        foreach ($data as $k => $row){
            $excelData[] = [null, $i++, $k, (string)$row['low'], (string)$row['mid'], (string)$row['high'], (string)$row['total']];
            $totLow += $row['low'];$totMid += $row['mid'];$totHigh += $row['high'];$tot += $row['total'];
        }
        $excelData[] = [null, 'Total', null, (string)$totLow, (string)$totMid, (string)$totHigh, (string)$tot];

        return Excel::download(new KelengkapanExport($excelData), 'Kelengkapan-Aset.xlsx');
    }
}
