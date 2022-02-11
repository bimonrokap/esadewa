<?php

namespace App\Model\Sewa;

use App\Scope\ScopeUsulanBy;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Sewa\Sewa
 *
 * @property int $id
 * @property string $letter_number
 * @property string $letter_date
 * @property string $perihal
 * @property int $penandatangan_surat
 * @property string $no_surat_persetujuan
 * @property string $tanggal_surat_persetujuan
 * @property string $perihal_surat_persetujuan
 * @property int $penandatangan_persetujuan
 * @property int $periode
 * @property float $nilai_sewa
 * @property string $identitas_penyewa
 * @property string $lokasi
 * @property float|null $luas_asset
 * @property string|null $surat_pengajuan_satker
 * @property string|null $surat_rekomendasi
 * @property int|null $id_sewa_status
 * @property string|null $keterangan_veriftk
 * @property string|null $letter_number_banding
 * @property string|null $letter_date_banding
 * @property string|null $perihal_banding
 * @property int|null $penandatangan_surat_banding
 * @property string|null $surat_penghantar_banding
 * @property string|null $keterangan_verifadm
 * @property string|null $letter_number_persetujuan
 * @property string|null $letter_date_persetujuan
 * @property string|null $perihal_persetujuan
 * @property string|null $surat_persetujuan
 * @property string|null $tanggal_pembayaran
 * @property string|null $akun_pembayaran
 * @property string|null $nomor_ntb
 * @property string|null $nomor_ntpn
 * @property string|null $jumlah_pembayaran
 * @property string|null $bukti_pembayaran
 * @property string|null $nomor_perjanjian
 * @property string|null $tanggal_perjanjian
 * @property int|null $periode_perjanjian
 * @property string|null $tanggal_jatuh_tempo
 * @property string|null $nilai_perjanjian_sewa
 * @property string|null $surat_perjanjian_sewa
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Sewa\SewaBarang[] $barangs
 * @property-read int|null $barangs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\CategoryAsset[] $category
 * @property-read int|null $category_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Sewa\SewaFoto[] $foto
 * @property-read int|null $foto_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Sewa\SewaLog[] $log
 * @property-read int|null $log_count
 * @property-read \App\Model\PenandatanganSurat $penandatanganPersetujuan
 * @property-read \App\Model\PenandatanganSurat $penandatanganSurat
 * @property-read \App\Model\PenandatanganSurat|null $penandatanganSuratBanding
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa usulanBy()
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereAkunPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereBuktiPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereIdSewaStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereIdentitasPenyewa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereJumlahPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereKeteranganVerifadm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereKeteranganVeriftk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereLetterDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereLetterDateBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereLetterDatePersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereLetterNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereLetterNumberBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereLetterNumberPersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereLokasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereLuasAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereNilaiPerjanjianSewa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereNilaiSewa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereNoSuratPersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereNomorNtb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereNomorNtpn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereNomorPerjanjian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa wherePenandatanganPersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa wherePenandatanganSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa wherePenandatanganSuratBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa wherePerihal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa wherePerihalBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa wherePerihalPersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa wherePerihalSuratPersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa wherePeriode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa wherePeriodePerjanjian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereSuratPengajuanSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereSuratPenghantarBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereSuratPerjanjianSewa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereSuratPersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereSuratRekomendasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereTanggalJatuhTempo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereTanggalPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereTanggalPerjanjian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereTanggalSuratPersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sewa whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Sewa extends Model
{
    use ScopeUsulanBy;

    protected $fillable = [
        'letter_number',
        'letter_date',
        'perihal',
        'penandatangan_surat',
        'no_surat_persetujuan',
        'tanggal_surat_persetujuan',
        'perihal_surat_persetujuan',
        'penandatangan_persetujuan',
        'periode',
        'nilai_sewa',
        'identitas_penyewa',
        'lokasi',
        'luas_asset',
        'surat_pengajuan_satker',
        'surat_rekomendasi',
        'id_sewa_status',
        'created_by'
    ];

    /**
     * @param $id
     * @param null $file
     * @param bool $asset
     * @return string
     */
    static function docLocation($id, $file = null, $asset = false)
    {
        if ($asset) {
            return asset("file/sewa/" . $id . "/doc" . (!is_null($file) ? '/' . $file : ''));
        }
        return public_path("file/sewa/" . $id . "/doc" . (!is_null($file) ? '/' . $file : ''));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penandatanganSurat()
    {
        return $this->belongsTo('App\Model\PenandatanganSurat', 'penandatangan_surat');
    }

    public function category()
    {
        return $this->belongsToMany('App\Model\CategoryAsset', 'sewa_categories', 'id_sewa', 'id_category_asset');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penandatanganSuratBanding()
    {
        return $this->belongsTo('App\Model\PenandatanganSurat', 'penandatangan_surat_banding');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foto()
    {
        return $this->hasMany('App\Model\Sewa\SewaFoto', 'id_sewa');
    }

    /**
     * @return mixed
     */
    public function barangs()
    {
        return $this->hasMany('App\Model\Sewa\SewaBarang', 'id_sewa');
    }

    /**
     * @return mixed
     */
    public function log()
    {
        return $this->hasMany('App\Model\Sewa\SewaLog', 'id_sewa');
    }
}
