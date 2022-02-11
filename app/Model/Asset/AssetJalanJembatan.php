<?php
namespace App\Model\Asset;

use App\Scope\Asset\ScopeFilter;
use App\Scope\Asset\ScopeRelationSatker;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Asset\AssetJalanJembatan
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AssetJalanJembatan satkerOf(\App\Model\Satker $satker)
 * @property int $id
 * @property string|null $kode_barang
 * @property string|null $nup
 * @property string|null $kode_satker
 * @property string|null $nama_satker
 * @property int|null $kib
 * @property string|null $nama_barang
 * @property string|null $kondisi
 * @property string|null $merk
 * @property string|null $tgl_perolehan
 * @property string|null $nilai_perolehan_pertama
 * @property string|null $nilai_mutasi
 * @property string|null $nilai_perolehan
 * @property string|null $nilai_penyusutan
 * @property string|null $nilai_buku
 * @property int|null $kuantitas
 * @property int|null $luas_bangunan
 * @property int|null $luas_dasar
 * @property int|null $jml_foto
 * @property string|null $status_penggunaan
 * @property string|null $status_pengelolaan
 * @property string|null $no_psp
 * @property string|null $tgl_psp
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $filled
 * @property string|null $tanggal_update
 * @property string|null $tgl_rekam_pertama
 * @property-read \App\Model\SatkerType|null $lingkungan
 * @property-read \App\Model\Satker|null $satker
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan assetBy()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan filter($filter, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan generalFilter($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereFilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereJmlFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereKuantitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereLuasBangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereLuasDasar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereNamaSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereNilaiBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereNilaiMutasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereNilaiPenyusutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereNilaiPerolehanPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereNoPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereNup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereStatusPengelolaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereStatusPenggunaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereTanggalUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereTglPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereTglPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereTglRekamPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetJalanJembatan whereUpdatedAt($value)
 */
class AssetJalanJembatan extends Model
{
    use ScopeSatker, ScopeFilter, ScopeRelationSatker;
    protected $fillable = ['kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','merk','tgl_perolehan','tgl_rekam_pertama','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','luas_bangunan','luas_dasar','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp','tanggal_update'];
}
