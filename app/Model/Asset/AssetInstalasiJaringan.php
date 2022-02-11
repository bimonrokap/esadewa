<?php
namespace App\Model\Asset;

use App\Scope\Asset\ScopeFilter;
use App\Scope\Asset\ScopeRelationSatker;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Asset\AssetInstalasiJaringan
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AssetInstalasiJaringan satkerOf(\App\Model\Satker $satker)
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
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan assetBy()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan filter($filter, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan generalFilter($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereFilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereJmlFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereKuantitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereNamaSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereNilaiBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereNilaiMutasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereNilaiPenyusutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereNilaiPerolehanPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereNoPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereNup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereStatusPengelolaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereStatusPenggunaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereTanggalUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereTglPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereTglPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereTglRekamPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetInstalasiJaringan whereUpdatedAt($value)
 */
class AssetInstalasiJaringan extends Model
{
    use ScopeSatker, ScopeFilter, ScopeRelationSatker;
    protected $fillable = ['kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','merk','tgl_perolehan','tgl_rekam_pertama','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp','tanggal_update','jalan'];
}
