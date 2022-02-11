<?php

namespace App\Model\Asset;

use App\Scope\Asset\ScopeFilter;
use App\Scope\Asset\ScopeRelationSatker;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Asset\AssetPeralatanKhususTik
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AssetPeralatanKhususTik satkerOf(\App\Model\Satker $satker)
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
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik assetBy()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik filter($filter, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik generalFilter($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereFilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereJmlFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereKuantitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereNamaSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereNilaiBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereNilaiMutasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereNilaiPenyusutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereNilaiPerolehanPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereNoPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereNup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereStatusPengelolaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereStatusPenggunaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereTanggalUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereTglPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereTglPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereTglRekamPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanKhususTik whereUpdatedAt($value)
 */
class AssetPeralatanKhususTik extends Model
{
    use ScopeSatker, ScopeFilter, ScopeRelationSatker;

    protected $fillable = ['kode_barang','nup','kode_satker','nama_satker','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp','tanggal_update'];
}
