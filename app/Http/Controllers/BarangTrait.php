<?php
/**
 * Created by PhpStorm.
 * User: Alice
 * Date: 24/08/2018
 * Time: 20:26
 */

namespace App\Http\Controllers;

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
use Illuminate\Http\Request;

trait BarangTrait
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function _getTable(Request $request, $param)
    {
        $data['config'] = $this->config;

        $categoryObject = $request->input('categoryObject');
        $category = $request->input('categoryBarang');

        $param = array_merge($param, ['categoryObject' => $categoryObject, 'addParam' => $request->input('addParam')]);
        switch ($category) {
            case 1:
                $data['tableLayout'] = 'admin.asset.persediaan.table';
                $data['tableRoute'] = route('admin.asset.persediaan.table', $param);
                break;
            case 3:
                $controller = new TanahController();
                return $controller->viewTable($param);
                break;
            case 4:
                $controller = new AlatAngkutanController();
                return $controller->viewTable($param);
                break;
            case 5:
                $controller = new PeralatanNonTikController();
                return $controller->viewTable($param);
                break;
            case 6:
                $controller = new PeralatanKhususTikController();
                return $controller->viewTable($param);
                break;
            case 7:
                $controller = new AlatBeratController();
                return $controller->viewTable($param);
                break;
            case 9:
                $controller = new BangunanGedungController();
                return $controller->viewTable($param);
                break;
            case 10:
                $controller = new RumahNegaraController();
                return $controller->viewTable($param);
                break;
            case 11:
                $controller = new JalanJembatanController();
                return $controller->viewTable($param);
                break;
            case 12:
                $controller = new AirIrigasiController();
                return $controller->viewTable($param);
                break;
            case 13:
                $controller = new InstalasiJaringanController();
                return $controller->viewTable($param);
                break;
            case 14:
                $controller = new TetapLainnyaController();
                return $controller->viewTable($param);
                break;
            case 15:
                $controller = new TakBerwujudController();
                return $controller->viewTable($param);
                break;
            case 16:
                $controller = new RenovasiController();
                return $controller->viewTable($param);
                break;
            case 17:
                $controller = new KonstruksiDalamPengerjaanController();
                return $controller->viewTable($param);
                break;
        }

        return view('template.usulan.table-container', $data);
    }
}