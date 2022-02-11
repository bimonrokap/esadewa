<?php
namespace App\Model\Asset;

use App\Scope\Asset\ScopeFilter;
use App\Scope\Asset\ScopeRelationSatker;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Asset\AssetAlatBerat
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AssetAlatBerat satkerOf(\App\Model\Satker $satker)
 * @property int $id
 * @property string|null $kode_barang
 * @property string|null $nup
 * @property string|null $kode_satker
 * @property string|null $nama_satker
 * @property string|null $nama_barang
 * @property string|null $kondisi
 * @property string|null $merk
 * @property string|null $tgl_perolehan
 * @property int|null $nilai_perolehan_pertama
 * @property int|null $nilai_mutasi
 * @property int|null $nilai_perolehan
 * @property int|null $nilai_penyusutan
 * @property int|null $nilai_buku
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
 * @property string|null $kib
 * @property-read \App\Model\SatkerType|null $lingkungan
 * @property-read \App\Model\Satker|null $satker
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat assetBy()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat filter($filter, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat generalFilter($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereFilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereJmlFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereJumlahKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereKuantitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereNamaSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereNilaiBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereNilaiMutasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereNilaiPenyusutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereNilaiPerolehanPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereNoPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereNup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereStatusPengelolaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereStatusPenggunaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereTanggalUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereTglPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereTglPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereTglRekamPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBerat whereUpdatedAt($value)
 */
class AssetAlatBerat extends Model
{
    use ScopeSatker, ScopeFilter, ScopeRelationSatker;
    protected $fillable = ['kode_barang','nup', 'kode_satker','nama_satker','nama_barang','kib', 'kondisi','merk','tgl_perolehan','tgl_rekam_pertama', 'nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp', 'jumlah_kib','tanggal_update'];
}
