<?php
namespace App\Http\Controllers\Admin\Asset;

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
use App\Model\Asset\AssetPeralatanKhususTik;
use App\Model\Asset\AssetPeralatanNonTik;
use App\Model\Asset\AssetRenovasi;
use App\Model\Asset\AssetRumahNegara;
use App\Model\Asset\AssetTakBerwujud;
use App\Model\Asset\AssetTanah;
use App\Model\Asset\AssetTetapLainnya;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Common\Exception\UnsupportedTypeException;
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Illuminate\Http\Request;

class ExportController extends Controller
{

    /**
     * @param $slug
     * @throws \Box\Spout\Common\Exception\InvalidArgumentException
     * @throws \Box\Spout\Writer\Exception\WriterNotOpenedException
     */
    public function export(Request $request, $slug)
    {
        switch ($slug) {
            case 'bermotor': $model = new AssetAlatBermotor();$con = new AlatAngkutanController();$filename='Alat Angkutan Bermotor'; break;
            case 'tanah': $model = new AssetTanah();$con = new TanahController();$filename='Tanah'; break;
            case 'peralatannontik': $model = new AssetPeralatanNonTik();$con = new PeralatanNonTikController();$filename='Peralatan Non TIK'; break;
            case 'peralatantik': $model = new AssetPeralatanKhususTik();$con = new PeralatanKhususTikController();$filename='Peralatan Khusus TIK'; break;
            case 'alatberat': $model = new AssetAlatBerat();$con = new AlatBeratController();$filename='Alat Berat'; break;
            case 'bangunangedung': $model = new AssetBangunanGedung();$con = new BangunanGedungController();$filename='Bangunan Gedung'; break;
            case 'rumahnegara': $model = new AssetRumahNegara();$con = new RumahNegaraController();$filename='Rumah Negara'; break;
            case 'jalanjembatan': $model = new AssetJalanJembatan();$con = new JalanJembatanController();$filename='Jalan Jembatan'; break;
            case 'airirigasi': $model = new AssetAirIrigasi();$con = new AirIrigasiController();$filename='Bangunan Air & Irigrasi'; break;
            case 'instalasijaringan': $model = new AssetInstalasiJaringan();$con = new InstalasiJaringanController();$filename='Instalasi Jaringan'; break;
            case 'tetaplainnya': $model = new AssetTetapLainnya();$con = new TetapLainnyaController();$filename='Tetap Lainnya'; break;
            case 'takberwujud': $model = new AssetTakBerwujud();$con = new TakBerwujudController();$filename='Tak Berwujud'; break;
            case 'renovasi': $model = new AssetRenovasi();$con = new RenovasiController();$filename='Renovasi'; break;
            case 'konstruksi': $model = new AssetKonstruksiDalamPengerjaan();$con = new KonstruksiDalamPengerjaanController();$filename='Konstruksi Dalam Pengerjaan'; break;
        }

        try {
            $writer = WriterFactory::create(Type::XLSX);
            $writer->openToBrowser('Asset '.$filename . ".xlsx");

            $filter = [
                'lingkungan' => $request->input('lingkungan'),
                'wilayah' => $request->input('wilayah'),
                'psp' => $request->input('psp'),
                'kondisiSelect' => $request->input('kondisiSelect'),
                'sertifikat' => $request->input('sertifikat'),
                'kendaraan_type' => $request->input('kendaraan_type'),
            ];

            $data = $model->assetBy()->generalFilter($filter)->select($model->getFillable());

            foreach($request->all() as $k => $r) {
                if(substr($k, 0, 2) == 'f_') {
                    $data->where(substr($k, 2), 'like', '%' . $r . '%');
                }
            }

            $data = $data->get()->toArray();
            $header = $con->tableHeader;
            array_unshift($header, 'No');

            foreach ($data as $k => $row) {
                array_unshift($data[$k], ($k+1));
            }
            array_unshift($data, $header);

            $writer->addRows($data);
            $writer->close();
        } catch (UnsupportedTypeException $e) {

        } catch (IOException $e) {

        }

        exit;
    }
}
