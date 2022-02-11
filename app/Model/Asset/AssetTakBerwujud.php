<?php
namespace App\Model\Asset;

use App\Scope\Asset\ScopeFilter;
use App\Scope\Asset\ScopeRelationSatker;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Asset\AssetTakBerwujud
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AssetTakBerwujud satkerOf(\App\Model\Satker $satker)
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
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud assetBy()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud filter($filter, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud generalFilter($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereFilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereJmlFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereKuantitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereNamaSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereNilaiBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereNilaiMutasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereNilaiPenyusutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereNilaiPerolehanPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereNoPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereNup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereStatusPengelolaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereStatusPenggunaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereTanggalUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereTglPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereTglPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereTglRekamPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTakBerwujud whereUpdatedAt($value)
 */
class AssetTakBerwujud extends Model
{
    use ScopeSatker, ScopeFilter, ScopeRelationSatker;
    protected $fillable = ['kode_barang','nup','kode_satker','nama_satker','nama_barang','kib','kondisi','merk','tgl_perolehan','tgl_rekam_pertama','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp','tanggal_update'];
}
