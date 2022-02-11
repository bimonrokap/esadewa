<?php
namespace App\Model\Asset;

use App\Scope\Asset\ScopeFilter;
use App\Scope\Asset\ScopeRelationSatker;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Asset\AssetKonstruksiDalamPengerjaan
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AssetKonstruksiDalamPengerjaan satkerOf(\App\Model\Satker $satker)
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
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan assetBy()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan filter($filter, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan generalFilter($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereFilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereJmlFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereKuantitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereNamaSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereNilaiBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereNilaiMutasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereNilaiPenyusutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereNilaiPerolehanPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereNoPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereNup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereStatusPengelolaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereStatusPenggunaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereTanggalUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereTglPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereTglPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereTglRekamPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetKonstruksiDalamPengerjaan whereUpdatedAt($value)
 */
class AssetKonstruksiDalamPengerjaan extends Model
{
    use ScopeSatker, ScopeFilter, ScopeRelationSatker;
    protected $fillable = ['kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp','tanggal_update'];
}
