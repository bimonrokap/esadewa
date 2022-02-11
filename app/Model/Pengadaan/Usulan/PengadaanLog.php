<?php

namespace App\Model\Pengadaan\Usulan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Pengadaan\Usulan\PengadaanLog
 *
 * @property int $id
 * @property int $id_pengadaan
 * @property int $id_status
 * @property string|null $keterangan
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Pengadaan\Usulan\StatusPengadaan $status
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanLog whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanLog whereIdPengadaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanLog whereIdStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanLog whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PengadaanLog extends Model
{
    CONST PERMOHONAN = 1;
    CONST DITERIMA_TK = 2;
    CONST DITOLAK_TK = 3;
    const DITERIMA_ADM = 4;
    const DITOLAK_ADM = 5;
    const PROSES = 6;
    const SELESAI = 7;
    CONST EDIT = 8;

    protected $fillable = ['id_pengadaan', 'id_status', 'keterangan', 'created_by'];

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
    public function status()
    {
        return $this->belongsTo('App\Model\Pengadaan\Usulan\StatusPengadaan', 'id_status');
    }
}
