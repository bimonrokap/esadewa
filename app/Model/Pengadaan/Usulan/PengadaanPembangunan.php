<?php

namespace App\Model\Pengadaan\Usulan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Pengadaan\Usulan\PengadaanPembangunan
 *
 * @property int $id
 * @property int $id_pengadaan
 * @property int $jenis_pembangunan
 * @property string $luas_bangunan
 * @property string $biaya_fisik
 * @property string $biaya_perencanaan
 * @property string $biaya_pengawasan
 * @property string $biaya_pengelolaan
 * @property string $pajak_pembangunan
 * @property string $surat_pengajuan
 * @property string $surat_psp
 * @property string $surat_rencana
 * @property string $surat_harga_satuan
 * @property string $surat_analisa
 * @property string $tor
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Pengadaan\Usulan\PengadaanPembangunanBarang[] $barangs
 * @property-read int|null $barangs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Pengadaan\Usulan\PengadaanPembangunanGambar[] $gambar
 * @property-read int|null $gambar_count
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan query()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan whereBiayaFisik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan whereBiayaPengawasan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan whereBiayaPengelolaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan whereBiayaPerencanaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan whereIdPengadaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan whereJenisPembangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan whereLuasBangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan wherePajakPembangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan whereSuratAnalisa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan whereSuratHargaSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan whereSuratPengajuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan whereSuratPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan whereSuratRencana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan whereTor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PengadaanPembangunan extends Model
{

    protected $fillable = [
        'id_pengadaan',
        'jenis_pembangunan',
        'luas_bangunan',
        'biaya_fisik',
        'biaya_perencanaan',
        'biaya_pengawasan',
        'biaya_pengelolaan',
        'pajak_pembangunan',
        'surat_pengajuan',
        'surat_psp',
        'surat_rencana',
        'surat_harga_satuan',
        'surat_analisa',
        'tor',
    ];

    /**
     * @return mixed
     */
    public function barangs()
    {
        return $this->hasMany('App\Model\Pengadaan\Usulan\PengadaanPembangunanBarang', 'id_pengadaan_pembangunan');
    }

    /**
     * @return mixed
     */
    public function gambar()
    {
        return $this->hasMany('App\Model\Pengadaan\Usulan\PengadaanPembangunanGambar', 'id_pengadaan_pembangunan');
    }
}
