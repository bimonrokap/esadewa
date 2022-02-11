<?php

namespace App\Model\Bongkaran;

use App\Scope\ScopeUsulanBy;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Bongkaran
 *
 * @property int $id
 * @property string $letter_number
 * @property string $letter_date
 * @property string $perihal
 * @property int $penandatangan_surat
 * @property int $sumber_dana
 * @property float $nilai_taksiran
 * @property string $surat_pengajuan_satker
 * @property string $penetapan_status_penggunaan
 * @property string $kib_bangunan
 * @property string $sk_panitia_bongkaran
 * @property string|null $dokumen_penganggaran
 * @property string $penetapan_nilai_taksiran
 * @property int $id_bongkaran_status
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
 * @property string|null $luas_bangunan_verif
 * @property string|null $nilai_taksiran_verif
 * @property string|null $surat_persetujuan
 * @property int|null $hasil_bongkaran
 * @property string|null $nomor_izin_pemusnahan
 * @property string|null $tanggal_izin_pemusnahan
 * @property string|null $perihal_pemusnahan
 * @property string|null $nomor_berita_acara_pemusnahan
 * @property string|null $tanggal_berita_acara_pemusnahan
 * @property string|null $dokumen_persetujuan_pemusnahan
 * @property string|null $dokumen_berita_acara_pemusnahan
 * @property string|null $nomor_risalah_lelang
 * @property string|null $tanggal_risalah_lelang
 * @property string|null $penandatangan_risalah_lelang
 * @property string|null $nomor_berita_acara
 * @property string|null $tanggal_berita_acara
 * @property string|null $nilai_limit
 * @property string|null $nilai_terjual
 * @property string|null $dokumen_risalah_lelang
 * @property string|null $dokumen_berita_acara
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Bongkaran\BongkaranBarang[] $barangs
 * @property-read int|null $barangs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Bongkaran\BongkaranFoto[] $foto
 * @property-read int|null $foto_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Bongkaran\BongkaranLog[] $log
 * @property-read int|null $log_count
 * @property-read \App\Model\PenandatanganSurat $penandatanganSurat
 * @property-read \App\Model\PenandatanganSurat|null $penandatanganSuratBanding
 * @property-read \App\Model\Bongkaran\BongkaranSumberDana $sumberDana
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran usulanBy()
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereDokumenBeritaAcara($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereDokumenBeritaAcaraPemusnahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereDokumenPenganggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereDokumenPersetujuanPemusnahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereDokumenRisalahLelang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereHasilBongkaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereIdBongkaranStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereKeteranganVerifadm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereKeteranganVeriftk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereKibBangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereLetterDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereLetterDateBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereLetterDatePersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereLetterNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereLetterNumberBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereLetterNumberPersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereLuasBangunanVerif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereNilaiLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereNilaiTaksiran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereNilaiTaksiranVerif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereNilaiTerjual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereNomorBeritaAcara($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereNomorBeritaAcaraPemusnahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereNomorIzinPemusnahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereNomorRisalahLelang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran wherePenandatanganRisalahLelang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran wherePenandatanganSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran wherePenandatanganSuratBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran wherePenetapanNilaiTaksiran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran wherePenetapanStatusPenggunaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran wherePerihal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran wherePerihalBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran wherePerihalPemusnahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran wherePerihalPersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereSkPanitiaBongkaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereSumberDana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereSuratPengajuanSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereSuratPenghantarBanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereSuratPersetujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereTanggalBeritaAcara($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereTanggalBeritaAcaraPemusnahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereTanggalIzinPemusnahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereTanggalRisalahLelang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bongkaran whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Bongkaran extends Model
{
    use ScopeUsulanBy;

    protected $fillable = [
        'letter_number',
        'letter_date',
        'perihal',
        'penandatangan_surat',
        'sumber_dana',
        'nilai_taksiran',
        'surat_pengajuan_satker',
        'penetapan_status_penggunaan',
        'kib_bangunan',
        'sk_panitia_bongkaran',
        'dokumen_penganggaran',
        'penetapan_nilai_taksiran',
        'id_bongkaran_status',
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
            return asset("file/bongkaran/" . $id . "/doc" . (!is_null($file) ? '/' . $file : ''));
        }
        return public_path("file/bongkaran/" . $id . "/doc" . (!is_null($file) ? '/' . $file : ''));
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
    public function sumberDana()
    {
        return $this->belongsTo('App\Model\Bongkaran\BongkaranSumberDana', 'sumber_dana');
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
        return $this->hasMany('App\Model\Bongkaran\BongkaranFoto', 'id_bongkaran');
    }

    /**
     * @return mixed
     */
    public function barangs()
    {
        return $this->hasMany('App\Model\Bongkaran\BongkaranBarang', 'id_bongkaran');
    }

    /**
     * @return mixed
     */
    public function log()
    {
        return $this->hasMany('App\Model\Bongkaran\BongkaranLog', 'id_bongkaran');
    }
}
