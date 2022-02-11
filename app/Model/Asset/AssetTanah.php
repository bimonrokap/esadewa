<?php

namespace App\Model\Asset;

use App\Scope\Asset\ScopeFilter;
use App\Scope\Asset\ScopeRelationSatker;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Asset\AssetTanah
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AssetTanah satkerOf(\App\Model\Satker $satker)
 * @property int $id
 * @property int|null $nup
 * @property int|null $kib
 * @property string|null $kondisi
 * @property string|null $jenis_dokumen
 * @property string|null $kepemilikan
 * @property string|null $jenis_sertifikat
 * @property string|null $merk
 * @property string|null $tgl_perolehan
 * @property string|null $tgl_rekam_pertama
 * @property float|null $nilai_perolehan_pertama
 * @property float|null $nilai_mutasi
 * @property float|null $nilai_perolehan
 * @property float|null $nilai_penyusutan
 * @property float|null $nilai_buku
 * @property float|null $kuantitasi
 * @property float|null $luas_tanah_seluruhnya
 * @property float|null $luas_tanah_untuk_bangunan
 * @property float|null $luas_tanah_untuk_sarana
 * @property float|null $luas_lahan_kosong
 * @property int|null $jml_foto
 * @property string|null $status_penggunaan
 * @property string|null $status_pengelolaan
 * @property string|null $no_psp
 * @property string|null $tgl_psp
 * @property string|null $alamat
 * @property string|null $rt
 * @property string|null $kelurahan
 * @property string|null $kecamatan
 * @property string|null $kabupaten
 * @property string|null $kode_kabupaten
 * @property string|null $provinsi
 * @property string|null $kode_provinsi
 * @property string|null $kode_pos
 * @property string|null $alamat_lainnya
 * @property int|null $jml_kib
 * @property int|null $sbsk
 * @property float|null $optimalisasi
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $kode_barang
 * @property string|null $kode_satker
 * @property string|null $nama_satker
 * @property string|null $nama_barang
 * @property int|null $filled
 * @property string|null $tanggal_update
 * @property-read \App\Model\SatkerType|null $lingkungan
 * @property-read \App\Model\Satker|null $satker
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah assetBy()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah filter($filter, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah generalFilter($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah kantor()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah nonSertifikat()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah rumahNegara()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah sertifikat()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereAlamatLainnya($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereFilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereJenisDokumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereJenisSertifikat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereJmlFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereJmlKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereKabupaten($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereKecamatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereKelurahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereKepemilikan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereKodeKabupaten($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereKodePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereKodeProvinsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereKuantitasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereLuasLahanKosong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereLuasTanahSeluruhnya($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereLuasTanahUntukBangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereLuasTanahUntukSarana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereNamaSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereNilaiBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereNilaiMutasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereNilaiPenyusutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereNilaiPerolehanPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereNoPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereNup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereOptimalisasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereProvinsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereRt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereSbsk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereStatusPengelolaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereStatusPenggunaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereTanggalUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereTglPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereTglPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereTglRekamPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetTanah whereUpdatedAt($value)
 */
class AssetTanah extends Model
{
    use ScopeSatker, ScopeFilter, ScopeRelationSatker;

    protected $fillable = [
        'kode_barang',
        'nup',
        'kode_satker',
        'nama_satker',
        'kib',
        'nama_barang',
        'kondisi',
        'jenis_dokumen',
        'kepemilikan',
        'jenis_sertifikat',
        'merk',
        'tgl_perolehan',
        'tgl_rekam_pertama',
        'nilai_perolehan_pertama',
        'nilai_mutasi',
        'nilai_perolehan',
        'nilai_penyusutan',
        'nilai_buku',
        'kuantitasi',
        'luas_tanah_seluruhnya',
        'luas_tanah_untuk_bangunan',
        'luas_tanah_untuk_sarana',
        'luas_lahan_kosong',
        'jml_foto',
        'status_penggunaan',
        'status_pengelolaan',
        'no_psp',
        'tgl_psp',
        'alamat',
        'rt',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'kode_kabupaten',
        'provinsi',
        'kode_provinsi',
        'kode_pos',
        'alamat_lainnya',
        'jml_kib',
        'sbsk',
        'optimalisasi',
        'tanggal_update'
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeSertifikat($query)
    {
        return $query->where('jenis_dokumen', 'Sertifikat');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNonSertifikat($query)
    {
        return $query->where('jenis_dokumen', '!=', 'Sertifikat');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeKantor($query)
    {
        return $query->whereKodeBarang('2010104001');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRumahNegara($query)
    {
        return $query->whereIn('kode_barang', ['2010101001', '2010101002', '2010101003']);
    }
}
