<?php

namespace App\Model\Pengadaan\Rkbmn;

use App\Scope\Asset\ScopeFilter;
use App\Scope\Asset\ScopeRelationSatker;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Pengadaan\Rkbmn\RkbmnPengadaan
 *
 * @property int $id
 * @property int $id_rkbmn
 * @property string|null $eselon1
 * @property string|null $draftuapb
 * @property string|null $apip
 * @property string|null $uapb
 * @property string|null $djkn
 * @property string|null $no_pengadaan
 * @property string|null $no_output
 * @property string|null $kode_barang
 * @property string|null $nama_barang
 * @property string|null $kategori
 * @property string|null $sbsk_usulan
 * @property string|null $jml_eksisting
 * @property string|null $luas_eksisting
 * @property string|null $sbsk_eksisting
 * @property string|null $optimalisasi
 * @property string|null $kebutuhan_ril
 * @property int|null $kpb_unit
 * @property string|null $kpb_luas
 * @property int|null $eselon_unit
 * @property string|null $eselon_luas
 * @property int|null $pengguna_unit
 * @property string|null $pengguna_luas
 * @property int|null $apip_unit
 * @property string|null $apip_luas
 * @property int|null $final_unit
 * @property string|null $final_luas
 * @property string|null $koreksi
 * @property int|null $persetujuan_unit
 * @property string|null $persetujuan_luas
 * @property string|null $tahun_anggaran
 * @property string|null $kode_tiket
 * @property string|null $kode_satker
 * @property string|null $nama_satker
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan query()
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereApip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereApipLuas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereApipUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereDjkn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereDraftuapb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereEselon1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereEselonLuas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereEselonUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereFinalLuas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereFinalUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereIdRkbmn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereJmlEksisting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereKebutuhanRil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereKodeTiket($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereKoreksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereKpbLuas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereKpbUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereLuasEksisting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereNamaSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereNoOutput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereNoPengadaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereOptimalisasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan wherePenggunaLuas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan wherePenggunaUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan wherePersetujuanLuas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan wherePersetujuanUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereSbskEksisting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereSbskUsulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereTahunAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereUapb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPengadaan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RkbmnPengadaan extends Model
{
    use ScopeSatker, ScopeFilter, ScopeRelationSatker;

    protected $fillable = [
        'id_rkbmn',
        'eselon1',
        'draftuapb',
        'apip',
        'uapb',
        'djkn',
        'no_pengadaan',
        'no_output',
        'kode_barang',
        'nama_barang',
        'kategori',
        'sbsk_usulan',
        'jml_eksisting',
        'luas_eksisting',
        'sbsk_eksisting',
        'optimalisasi',
        'kebutuhan_ril',
        'kpb_unit',
        'kpb_luas',
        'eselon_unit',
        'eselon_luas',
        'pengguna_unit',
        'pengguna_luas',
        'apip_unit',
        'apip_luas',
        'final_unit',
        'final_luas',
        'koreksi',
        'persetujuan_unit',
        'persetujuan_luas',
        'tahun_anggaran',
        'kode_tiket',
        'kode_satker',
        'nama_satker'
    ];
}
