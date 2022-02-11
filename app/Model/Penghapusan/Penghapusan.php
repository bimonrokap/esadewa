<?php

namespace App\Model\Penghapusan;

use App\Scope\ScopeSatker;
use App\Scope\ScopeUsulanBy;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Penghapusan\Penghapusan
 *
 * @property int $id
 * @property string $letter_number
 * @property string $letter_date
 * @property string $perihal
 * @property int $penandatangan_surat
 * @property int|null $id_letter_number_penjualan
 * @property string|null $letter_number_penjualan
 * @property string|null $letter_date_penjualan
 * @property string|null $perihal_penjualan
 * @property string|null $surat_izin_penjualan
 * @property string|null $nilai_perolehan
 * @property string|null $surat_keterangan
 * @property string|null $total_limit
 * @property string $total_terjual
 * @property string $risalah_lelang_number
 * @property string $risalah_lelang_date
 * @property string $penandatangan_risalah
 * @property string $nomor_berita_acara
 * @property string $tanggal_berita_acara
 * @property string $surat_pengajuan_satker
 * @property string|null $daftar_barang
 * @property string|null $daftar_barang_rusak
 * @property string $risalah_lelang
 * @property string $surat_berita_acara
 * @property string|null $dokumen_lainnya
 * @property int|null $penghapusan_type
 * @property int $id_penghapusan_status
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Penghapusan\PenghapusanBarang[] $barangs
 * @property-read int|null $barangs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Penghapusan\PenghapusanLog[] $log
 * @property-read int|null $log_count
 * @property-read \App\Model\PenandatanganSurat $penandatanganSurat
 * @property-read \App\Model\PenandatanganSurat|null $penandatanganSuratBanding
 * @property-read \App\Model\Penjualan\Penjualan|null $penjualan
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan usulanBy()
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereDaftarBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereDaftarBarangRusak($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereDokumenLainnya($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereIdLetterNumberPenjualan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereIdPenghapusanStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereKeteranganVerifadm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereKeteranganVeriftk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereLetterDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereLetterDateBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereLetterDatePenjualan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereLetterDatePersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereLetterNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereLetterNumberBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereLetterNumberPenjualan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereLetterNumberPersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereNomorBeritaAcara($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan wherePenandatanganRisalah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan wherePenandatanganSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan wherePenandatanganSuratBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan wherePenghapusanType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan wherePerihal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan wherePerihalBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan wherePerihalPenjualan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan wherePerihalPersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereRisalahLelang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereRisalahLelangDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereRisalahLelangNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereSuratBeritaAcara($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereSuratIzinPenjualan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereSuratKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereSuratPengajuanSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereSuratPenghantarBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereSuratPersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereTanggalBeritaAcara($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereTotalLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereTotalTerjual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penghapusan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Penghapusan extends Model
{
    use ScopeSatker;

    CONST MEBELAIR = 1;
    CONST NON_MEBELAIR = 2;

    use ScopeUsulanBy;

    protected $fillable = [
        'letter_number',
        'letter_date',
        'perihal',
        'penandatangan_surat',
        'id_letter_number_penjualan',
        'letter_number_penjualan',
        'letter_date_penjualan',
        'perihal_penjualan',
        'surat_izin_penjualan',
        'nilai_perolehan',
        'surat_keterangan',
        'total_limit',
        'total_terjual',
        'risalah_lelang_number',
        'risalah_lelang_date',
        'penandatangan_risalah',
        'nomor_berita_acara',
        'tanggal_berita_acara',
        'surat_pengajuan_satker',
        'daftar_barang',
        'daftar_barang_rusak',
        'risalah_lelang',
        'surat_berita_acara',
        'dokumen_lainnya',
        'penghapusan_type',
        'id_penghapusan_status',
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
        if($asset) {
            return asset("file/penghapusan/".$id."/doc" . (!is_null($file) ? '/'.$file : ''));
        }
        return public_path("file/penghapusan/".$id."/doc" . (!is_null($file) ? '/'.$file : ''));
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
    public function penjualan()
    {
        return $this->belongsTo('App\Model\Penjualan\Penjualan', 'id_letter_number_penjualan');
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
     * @return mixed
     */
    public function barangs()
    {
        return $this->hasMany('App\Model\Penghapusan\PenghapusanBarang', 'id_penghapusan');
    }

    /**
     * @return mixed
     */
    public function log()
    {
        return $this->hasMany('App\Model\Penghapusan\PenghapusanLog', 'id_penghapusan');
    }
}
