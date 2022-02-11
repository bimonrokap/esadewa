<?php

namespace App\Model\Penghapusan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Penghapusan\PenghapusanLog
 *
 * @property int $id
 * @property int $id_penghapusan
 * @property int $id_status
 * @property string|null $keterangan
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Penghapusan\StatusPenghapusan $status
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanLog whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanLog whereIdPenghapusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanLog whereIdStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanLog whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PenghapusanLog extends Model
{
    CONST PERMOHONAN = 1;
    CONST DITERIMA_TK = 2;
    CONST DITOLAK_TK = 3;
    const DITERIMA_ADM = 4;
    const DITOLAK_ADM = 5;
    const PROSES = 6;
    const SELESAI = 7;
    CONST EDIT = 8;

    protected $fillable = ['id_penghapusan', 'id_status', 'keterangan', 'created_by'];

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
        return $this->belongsTo('App\Model\Penghapusan\StatusPenghapusan', 'id_status');
    }
}
