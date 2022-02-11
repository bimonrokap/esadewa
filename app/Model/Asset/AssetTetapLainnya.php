<?php
namespace App\Model\Asset;

use App\Scope\Asset\ScopeFilter;
use App\Scope\Asset\ScopeRelationSatker;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Asset\AssetTetapLainnya
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AssetTetapLainnya satkerOf(\App\Model\Satker $satker)
 * @property int $id
 * @property string|null $kode_barang
 * @property int|null $nup
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
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya assetBy()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya filter($filter, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya generalFilter($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereFilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereJmlFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereKuantitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereNamaSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereNilaiBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereNilaiMutasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereNilaiPenyusutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereNilaiPerolehanPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereNoPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereNup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereStatusPengelolaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereStatusPenggunaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereTanggalUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereTglPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereTglPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereTglRekamPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTetapLainnya whereUpdatedAt($value)
 */
class AssetTetapLainnya extends Model
{
    use ScopeSatker, ScopeFilter, ScopeRelationSatker;
    protected $fillable = ['kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp','tanggal_update','tgl_rekam_pertama'];
}
