<?php

namespace App\Model\Penjualan;

use App\Scope\ScopeUsulanBy;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Penjualan\Penjualan
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Penjualan\Penjualan usulanBy()
 * @property int $id
 * @property string $letter_number
 * @property string $letter_date
 * @property string $perihal
 * @property int $penandatangan_surat
 * @property int $total_limit
 * @property string $surat_pengajuan_satker
 * @property string $sk_panitia_penghapusan
 * @property string $ba_hasil
 * @property string $daftar_penghentian
 * @property string $surat_pernyataan_tanggung
 * @property string $sk_penetapan_status
 * @property string|null $backup_simak
 * @property int $id_penjualan_status
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
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Penjualan\PenjualanBarang[] $barangs
 * @property-read int|null $barangs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Penjualan\PenjualanFoto[] $foto
 * @property-read int|null $foto_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Penjualan\PenjualanLog[] $log
 * @property-read int|null $log_count
 * @property-read \App\Model\PenandatanganSurat $penandatanganSurat
 * @property-read \App\Model\PenandatanganSurat|null $penandatanganSuratBanding
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereBaHasil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereBackupSimak($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereDaftarPenghentian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereIdPenjualanStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereKeteranganVerifadm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereKeteranganVeriftk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereLetterDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereLetterDateBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereLetterDatePersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereLetterNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereLetterNumberBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereLetterNumberPersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan wherePenandatanganSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan wherePenandatanganSuratBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan wherePerihal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan wherePerihalBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan wherePerihalPersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereSkPanitiaPenghapusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereSkPenetapanStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereSuratPengajuanSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereSuratPenghantarBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereSuratPernyataanTanggung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereSuratPersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereTotalLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penjualan whereUpdatedAt($value)
 */
class Penjualan extends Model
{
    use ScopeUsulanBy;

    protected $fillable = ['letter_number', 'letter_date', 'perihal', 'penandatangan_surat', 'total_limit', 'surat_pengajuan_satker', 'sk_panitia_penghapusan','ba_hasil','daftar_penghentian','surat_pernyataan_tanggung','sk_penetapan_status','backup_simak','id_penjualan_status', 'created_by'];

    /**
     * @param $id
     * @param null $file
     * @param bool $asset
     * @return string
     */
    static function docLocation($id, $file = null, $asset = false)
    {
        if($asset) {
            return asset("file/penjualan/".$id."/doc" . (!is_null($file) ? '/'.$file : ''));
        }
        return public_path("file/penjualan/".$id."/doc" . (!is_null($file) ? '/'.$file : ''));
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
        return $this->hasMany('App\Model\Penjualan\PenjualanFoto', 'id_penjualan');
    }

    /**
     * @return mixed
     */
    public function barangs()
    {
        return $this->hasMany('App\Model\Penjualan\PenjualanBarang', 'id_penjualan');
    }

    /**
     * @return mixed
     */
    public function log()
    {
        return $this->hasMany('App\Model\Penjualan\PenjualanLog', 'id_penjualan');
    }
}
