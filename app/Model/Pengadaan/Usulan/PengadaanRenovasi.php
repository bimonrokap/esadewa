<?php

namespace App\Model\Pengadaan\Usulan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Pengadaan\Usulan\PengadaanRenovasi
 *
 * @property int $id
 * @property int $id_pengadaan
 * @property int $jenis_pekerjaan
 * @property int $jenis_barang
 * @property string $luas_bangunan
 * @property string $luas_bangunan_rencana
 * @property int $tingkat_kerusakan
 * @property string $biaya_fisik
 * @property string $biaya_perencanaan
 * @property string $biaya_pengawasan
 * @property string $biaya_pengelolaan
 * @property string $pajak_pembangunan
 * @property string $surat_pengajuan
 * @property string $surat_psp
 * @property string $surat_harga
 * @property string $analisa_kerusakan
 * @property string $analisa_pu
 * @property string $tor
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Pengadaan\Usulan\PengadaanRenovasiFoto[] $foto
 * @property-read int|null $foto_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Pengadaan\Usulan\PengadaanRenovasiGambar[] $gambarEksisting
 * @property-read int|null $gambar_eksisting_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Pengadaan\Usulan\PengadaanRenovasiGambar[] $gambarRencana
 * @property-read int|null $gambar_rencana_count
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi query()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereAnalisaKerusakan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereAnalisaPu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereBiayaFisik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereBiayaPengawasan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereBiayaPengelolaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereBiayaPerencanaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereIdPengadaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereJenisBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereJenisPekerjaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereLuasBangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereLuasBangunanRencana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi wherePajakPembangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereSuratHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereSuratPengajuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereSuratPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereTingkatKerusakan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereTor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasi whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PengadaanRenovasi extends Model
{

    protected $fillable = [
        'id_pengadaan',
        'jenis_pekerjaan',
        'jenis_barang',
        'luas_bangunan',
        'luas_bangunan_rencana',
        'tingkat_kerusakan',
        'biaya_fisik',
        'biaya_perencanaan',
        'biaya_pengawasan',
        'biaya_pengelolaan',
        'pajak_pembangunan',
        'surat_pengajuan',
        'surat_psp',
        'surat_harga',
        'analisa_kerusakan',
        'analisa_pu',
        'tor'
    ];

    public function foto()
    {
        return $this->hasMany('App\Model\Pengadaan\Usulan\PengadaanRenovasiFoto', 'id_pengadaan_renovasi');
    }

    /**
     * @return mixed
     */
    public function gambarEksisting()
    {
        return $this->hasMany('App\Model\Pengadaan\Usulan\PengadaanRenovasiGambar', 'id_pengadaan_renovasi')->where('type', 1);
    }

    /**
     * @return mixed
     */
    public function gambarRencana()
    {
        return $this->hasMany('App\Model\Pengadaan\Usulan\PengadaanRenovasiGambar', 'id_pengadaan_renovasi')->where('type', 2);
    }
}
