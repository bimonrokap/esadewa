<?php

namespace App\Model\Asset;

use App\Scope\Asset\ScopeFilter;
use App\Scope\Asset\ScopeRelationSatker;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Asset\AssetPeralatanNonTik
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AssetPeralatanNonTik satkerOf(\App\Model\Satker $satker)
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
 * @property int|null $jumlah_kib
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $filled
 * @property string|null $tanggal_update
 * @property string|null $tgl_rekam_pertama
 * @property-read \App\Model\SatkerType|null $lingkungan
 * @property-read \App\Model\Satker|null $satker
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik assetBy()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik filter($filter, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik generalFilter($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereFilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereJmlFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereJumlahKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereKuantitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereNamaSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereNilaiBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereNilaiMutasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereNilaiPenyusutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereNilaiPerolehanPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereNoPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereNup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereStatusPengelolaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereStatusPenggunaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereTanggalUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereTglPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereTglPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereTglRekamPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPeralatanNonTik whereUpdatedAt($value)
 */
class AssetPeralatanNonTik extends Model
{
    use ScopeSatker, ScopeFilter, ScopeRelationSatker;

    protected $fillable = ['kode_barang','nup','kode_satker','nama_satker','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp','jumlah_kib','tanggal_update'];
}
