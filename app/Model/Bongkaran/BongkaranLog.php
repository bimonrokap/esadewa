<?php

namespace App\Model\Bongkaran;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Bongkaran\BongkaranLog
 *
 * @property int $id
 * @property int $id_bongkaran
 * @property int $id_status
 * @property string|null $keterangan
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Bongkaran\StatusBongkaran $status
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranLog whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranLog whereIdBongkaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranLog whereIdStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranLog whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BongkaranLog extends Model
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

    protected $fillable = ['id_bongkaran', 'id_status', 'keterangan', 'created_by'];

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
        return $this->belongsTo('App\Model\Bongkaran\StatusBongkaran', 'id_status');
    }
}
