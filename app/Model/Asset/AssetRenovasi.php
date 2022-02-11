<?php

namespace App\Model\Asset;

use App\Scope\Asset\ScopeFilter;
use App\Scope\Asset\ScopeRelationSatker;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Asset\AssetRenovasi
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AssetRenovasi satkerOf(\App\Model\Satker $satker)
 * @property int $id
 * @property string|null $kode_barang
 * @property int|null $nup
 * @property string|null $kode_satker
 * @property string|null $nama_satker
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
 * @property string|null $status_penggunaan
 * @property string|null $status_pengelolaan
 * @property int|null $jml_foto
 * @property string|null $kode_kpknl
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $filled
 * @property string|null $tanggal_update
 * @property string|null $tgl_rekam_pertama
 * @property-read \App\Model\SatkerType|null $lingkungan
 * @property-read \App\Model\Satker|null $satker
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi assetBy()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi filter($filter, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi generalFilter($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereFilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereJmlFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereKodeKpknl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereKuantitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereNamaSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereNilaiBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereNilaiMutasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereNilaiPenyusutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereNilaiPerolehanPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereNup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereStatusPengelolaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereStatusPenggunaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereTanggalUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereTglPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereTglRekamPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRenovasi whereUpdatedAt($value)
 */
class AssetRenovasi extends Model
{
    use ScopeSatker, ScopeFilter, ScopeRelationSatker;
    protected $fillable = ['kode_barang','nup','kode_satker','nama_satker','nama_barang','kondisi','merk','tgl_perolehan','tgl_rekam_pertama','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','status_penggunaan','status_pengelolaan','jml_foto','kode_kpknl','tanggal_update'];
}
