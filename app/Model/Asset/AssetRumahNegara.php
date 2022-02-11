<?php

namespace App\Model\Asset;

use App\Scope\Asset\ScopeFilter;
use App\Scope\Asset\ScopeRelationSatker;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Asset\AssetRumahNegara
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AssetRumahNegara satkerOf(\App\Model\Satker $satker)
 * @property int $id
 * @property string|null $kode_barang
 * @property int|null $nup
 * @property string|null $kode_satker
 * @property string|null $nama_satker
 * @property int|null $kib
 * @property string|null $nama_barang
 * @property string|null $kondisi
 * @property string|null $jenis_dokumen
 * @property string|null $kepemilikan
 * @property string|null $jenis_sertifikat
 * @property string|null $merk
 * @property string|null $tgl_perolehan
 * @property string|null $nilai_perolehan_pertama
 * @property string|null $nilai_mutasi
 * @property string|null $nilai_perolehan
 * @property string|null $nilai_penyusutan
 * @property string|null $nilai_buku
 * @property int|null $kuantitas
 * @property int|null $jml_foto
 * @property int|null $luas_bangunan
 * @property int|null $luas_dasar_bangunan
 * @property string|null $alamat
 * @property string|null $jalan
 * @property string|null $kode_kab
 * @property string|null $uraian_kabupaten
 * @property string|null $kode_provinsi
 * @property string|null $status_penggunaan
 * @property string|null $status_pengelolaan
 * @property string|null $no_psp
 * @property string|null $tgl_psp
 * @property int|null $jumlah_kib
 * @property int|null $sbsk
 * @property int|null $optimalisasi
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $filled
 * @property string|null $tanggal_update
 * @property string|null $tgl_rekam_pertama
 * @property-read \App\Model\SatkerType|null $lingkungan
 * @property-read \App\Model\Satker|null $satker
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara assetBy()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara filter($filter, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara generalFilter($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara golongan1()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara golongan1Lainnya()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara golongan1a()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara golongan1b()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara golongan1c()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara golongan2()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara golongan2Lainnya()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara golongan2a()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara golongan2b()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara golongan2c()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereFilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereJalan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereJenisDokumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereJenisSertifikat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereJmlFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereJumlahKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereKepemilikan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereKodeKab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereKodeProvinsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereKuantitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereLuasBangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereLuasDasarBangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereNamaSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereNilaiBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereNilaiMutasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereNilaiPenyusutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereNilaiPerolehanPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereNoPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereNup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereOptimalisasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereSbsk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereStatusPengelolaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereStatusPenggunaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereTanggalUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereTglPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereTglPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereTglRekamPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetRumahNegara whereUraianKabupaten($value)
 */
class AssetRumahNegara extends Model
{
    use ScopeSatker, ScopeFilter, ScopeRelationSatker;
    protected $fillable = ['kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','jenis_dokumen','kepemilikan','jenis_sertifikat','merk','tgl_perolehan','tgl_rekam_pertama','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','jml_foto','luas_bangunan','luas_dasar_bangunan','alamat','jalan','kode_kab','uraian_kabupaten','kode_provinsi','status_penggunaan','status_pengelolaan','no_psp','tgl_psp','jumlah_kib','sbsk','optimalisasi','tanggal_update'];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeGolongan1($query)
    {
        return $query->whereIn('kode_barang', ['4010201001', '4010201004', '4010201007']);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeGolongan1Lainnya($query)
    {
        return $query->whereNotIn('kode_barang', ['4010201001', '4010201004', '4010201007']);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeGolongan1a($query)
    {
        return $query->whereIn('kode_barang', ['4010201001']);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeGolongan1b($query)
    {
        return $query->whereIn('kode_barang', ['4010201004']);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeGolongan1c($query)
    {
        return $query->whereIn('kode_barang', ['4010201007']);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeGolongan2($query)
    {
        return $query->whereIn('kode_barang', ['4010202001', '4010202004', '4010202007']);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeGolongan2Lainnya($query)
    {
        return $query->whereNotIn('kode_barang', ['4010202001', '4010202004', '4010202007']);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeGolongan2a($query)
    {
        return $query->whereIn('kode_barang', ['4010202001']);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeGolongan2b($query)
    {
        return $query->whereIn('kode_barang', ['4010202004']);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeGolongan2c($query)
    {
        return $query->whereIn('kode_barang', ['4010202007']);
    }
}
