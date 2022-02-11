<?php
namespace App\Model\Asset;

use App\Scope\Asset\ScopeFilter;
use App\Scope\Asset\ScopeRelationSatker;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AssetAirIrigasi
 *
 * @package App\Model\Asset
 * @author Rizki Abriansyah <risky.moe@gmail.com>
 * @property int $id
 * @property string|null $kode_barang
 * @property string|null $nup
 * @property string|null $kode_satker
 * @property string|null $nama_satker
 * @property string|null $kib
 * @property string|null $nama_barang
 * @property string|null $kondisi
 * @property string|null $merk
 * @property string|null $tgl_perolehan
 * @property string|null $nilai_perolehan_pertama
 * @property int|null $nilai_mutasi
 * @property int|null $nilai_perolehan
 * @property int|null $nilai_penyusutan
 * @property int|null $nilai_buku
 * @property int|null $kuantitas
 * @property int|null $luas_bangunan
 * @property int|null $luas_dasar
 * @property int|null $jml_foto
 * @property string|null $status_penggunaan
 * @property string|null $status_pengelolaan
 * @property string|null $no_psp
 * @property string|null $tgl_psp
 * @property int|null $jml_kib
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $filled
 * @property string|null $tanggal_update
 * @property string|null $tgl_rekam_pertama
 * @property-read \App\Model\SatkerType|null $lingkungan
 * @property-read \App\Model\Satker|null $satker
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi assetBy()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi filter($filter, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi generalFilter($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi satkerOf(\App\Model\Satker $satker)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereFilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereJmlFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereJmlKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereKuantitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereLuasBangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereLuasDasar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereNamaSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereNilaiBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereNilaiMutasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereNilaiPenyusutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereNilaiPerolehanPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereNoPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereNup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereStatusPengelolaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereStatusPenggunaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereTanggalUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereTglPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereTglPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereTglRekamPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAirIrigasi whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AssetAirIrigasi extends Model
{
    use ScopeSatker, ScopeFilter, ScopeRelationSatker;
    protected $fillable = ['kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','merk','tgl_perolehan','tgl_rekam_pertama','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','luas_bangunan','luas_dasar','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp','jml_kib','tanggal_update','jalan'];
}
