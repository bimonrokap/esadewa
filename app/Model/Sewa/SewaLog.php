<?php

namespace App\Model\Sewa;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Sewa\SewaLog
 *
 * @property int $id
 * @property int $id_sewa
 * @property int $id_status
 * @property string|null $keterangan
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Sewa\StatusSewa $status
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|SewaLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SewaLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SewaLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|SewaLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaLog whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaLog whereIdSewa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaLog whereIdStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaLog whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SewaLog extends Model
{
    CONST PERMOHONAN = 1;
    CONST DITERIMA_TK = 2;
    CONST DITOLAK_TK = 3;
    const DITERIMA_ADM = 4;
    const DITOLAK_ADM = 5;
    const PROSES = 6;
    CONST MENUNGGU = 9;
    const SELESAI = 7;
    CONST EDIT = 8;

    protected $fillable = ['id_sewa', 'id_status', 'keterangan', 'created_by'];

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
        return $this->belongsTo('App\Model\Sewa\StatusSewa', 'id_status');
    }
}
