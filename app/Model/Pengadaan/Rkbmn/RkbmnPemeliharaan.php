<?php

namespace App\Model\Pengadaan\Rkbmn;

use App\Scope\Asset\ScopeFilter;
use App\Scope\Asset\ScopeRelationSatker;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Pengadaan\Rkbmn\RkbmnPemeliharaan
 *
 * @property int $id
 * @property int $id_rkbmn
 * @property string|null $eselon1
 * @property string|null $draftuapb
 * @property string|null $apip
 * @property string|null $uapb
 * @property string|null $djkn
 * @property string|null $kode_barang
 * @property string|null $nama_barang
 * @property int|null $nup
 * @property string|null $tgl_perolehan
 * @property string|null $merk
 * @property string|null $kondisi
 * @property string|null $status_penggunaan
 * @property int|null $jumlah
 * @property string|null $pemanfaatan
 * @property string|null $keb_ril
 * @property string|null $nilai_perolehan
 * @property int|null $usulan_satker
 * @property int|null $usulan_es1
 * @property int|null $usulan_pb
 * @property int|null $usulan_apip
 * @property int|null $usulan_final
 * @property string|null $koreksi
 * @property int|null $persetujuan_djkn
 * @property string|null $kode_satker
 * @property string|null $nama_satker
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan query()
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereApip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereDjkn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereDraftuapb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereEselon1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereIdRkbmn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereKebRil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereKoreksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereNamaSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereNup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan wherePemanfaatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan wherePersetujuanDjkn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereStatusPenggunaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereTglPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereUapb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereUsulanApip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereUsulanEs1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereUsulanFinal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereUsulanPb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RkbmnPemeliharaan whereUsulanSatker($value)
 * @mixin \Eloquent
 */
class RkbmnPemeliharaan extends Model
{
    use ScopeSatker, ScopeFilter, ScopeRelationSatker;

    protected $fillable = [
        'id_rkbmn',
        'eselon1',
        'draftuapb',
        'apip',
        'uapb',
        'djkn',
        'kode_barang',
        'nama_barang',
        'nup',
        'tgl_perolehan',
        'merk',
        'kondisi',
        'status_penggunaan',
        'jumlah',
        'pemanfaatan',
        'keb_ril',
        'nilai_perolehan',
        'usulan_satker',
        'usulan_es1',
        'usulan_pb',
        'usulan_apip',
        'usulan_final',
        'koreksi',
        'persetujuan_djkn',
        'kode_satker',
        'nama_satker'
    ];
}
