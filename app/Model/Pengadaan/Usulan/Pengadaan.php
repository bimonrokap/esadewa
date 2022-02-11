<?php

namespace App\Model\Pengadaan\Usulan;

use App\Scope\ScopeUsulanBy;
use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    CONST PENGADAAN = 1;
    CONST PEMBANGUNAN = 2;
    CONST RENOVASI = 3;

    use ScopeUsulanBy;

    protected $fillable = [
        'letter_number',
        'letter_date',
        'perihal',
        'penandatangan_surat',

        'id_rkbmn_uraian',
        'id_pengadaan_type',
        'id_pengadaan_status',
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
            return asset("file/pengadaan/".$id."/doc" . (!is_null($file) ? '/'.$file : ''));
        }
        return public_path("file/pengadaan/".$id."/doc" . (!is_null($file) ? '/'.$file : ''));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tanah()
    {
        return $this->hasOne('App\Model\Pengadaan\Usulan\PengadaanTanah', 'id_pengadaan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pembangunan()
    {
        return $this->hasOne('App\Model\Pengadaan\Usulan\PengadaanPembangunan', 'id_pengadaan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function renovasi()
    {
        return $this->hasOne('App\Model\Pengadaan\Usulan\PengadaanRenovasi', 'id_pengadaan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rkbmnUraian()
    {
        return $this->belongsTo('App\Model\Pengadaan\Rkbmn\RkbmnPengadaan', 'id_rkbmn_uraian');
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
    public function log()
    {
        return $this->hasMany('App\Model\Pengadaan\Usulan\PengadaanLog', 'id_pengadaan');
    }
}
