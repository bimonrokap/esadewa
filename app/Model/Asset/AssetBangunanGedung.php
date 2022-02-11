<?php

namespace App\Model\Asset;

use App\Scope\Asset\ScopeFilter;
use App\Scope\Asset\ScopeRelationSatker;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Asset\AssetBangunanGedung
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AssetBangunanGedung satkerOf(\App\Model\Satker $satker)
 * @property int $id
 * @property string|null $kode_barang
 * @property string|null $nup
 * @property string|null $kode_satker
 * @property string|null $nama_satker
 * @property string|null $kib
 * @property string|null $nama_barang
 * @property string|null $kondisi
 * @property string|null $dokumen
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
 * @property int|null $luas_bangunan
 * @property int|null $luas_dasar_bangunan
 * @property int|null $jumlah_lantai
 * @property int|null $jml_foto
 * @property string|null $jalan
 * @property string|null $kode_kab
 * @property string|null $uraian_kabupaten
 * @property string|null $kode_provinsi
 * @property string|null $status_penggunaan
 * @property string|null $status_pengelolaan
 * @property string|null $no_psp
 * @property string|null $tgl_psp
 * @property int|null $jml_kib
 * @property string|null $kode_pos
 * @property int|null $sbsk
 * @property int|null $optimalisasi
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $filled
 * @property string|null $tanggal_update
 * @property string|null $prototype
 * @property string|null $tgl_rekam_pertama
 * @property-read \App\Model\SatkerType|null $lingkungan
 * @property-read \App\Model\Satker|null $satker
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung assetBy()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung filter($filter, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung generalFilter($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung kantor()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung prototype()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereDokumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereFilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereJalan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereJenisSertifikat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereJmlFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereJmlKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereJumlahLantai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereKepemilikan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereKodeKab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereKodePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereKodeProvinsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereKuantitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereLuasBangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereLuasDasarBangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereNamaSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereNilaiBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereNilaiMutasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereNilaiPenyusutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereNilaiPerolehanPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereNoPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereNup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereOptimalisasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung wherePrototype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereSbsk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereStatusPengelolaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereStatusPenggunaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereTanggalUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereTglPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereTglPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereTglRekamPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung whereUraianKabupaten($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetBangunanGedung zitting()
 */
class AssetBangunanGedung extends Model
{
    use ScopeSatker, ScopeFilter, ScopeRelationSatker;
    protected $fillable = ['kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','dokumen','kepemilikan','jenis_sertifikat','merk','tgl_perolehan','tgl_rekam_pertama','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','luas_bangunan','luas_dasar_bangunan','jumlah_lantai','jml_foto','jalan','kode_kab','uraian_kabupaten','kode_provinsi','status_penggunaan','status_pengelolaan','no_psp','tgl_psp','jml_kib','kode_pos','sbsk','optimalisasi','tanggal_update'];

    public function scopePrototype($query)
    {
        $query->wherePrototype('1');
    }

    public function scopeKantor($query)
    {
        $query->whereKodeBarang('4010101001');
    }

    public function scopeZitting($query)
    {
        $query->whereKodeBarang('4010124001');
    }
}
