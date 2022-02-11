<?php

namespace App\Model\Penjualan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Penjualan\PenjualanLog
 *
 * @property int $id
 * @property int $id_penjualan
 * @property int $id_status
 * @property string|null $keterangan
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Penjualan\StatusPenjualan $status
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanLog whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanLog whereIdPenjualan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanLog whereIdStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanLog whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PenjualanLog extends Model
{
    CONST PERMOHONAN = 1;
    CONST DITERIMA_TK = 2;
    CONST DITOLAK_TK = 3;
    const DITERIMA_ADM = 4;
    const DITOLAK_ADM = 5;
    const PROSES = 6;
    const SELESAI = 7;
    CONST EDIT = 8;

    protected $fillable = ['id_penjualan', 'id_status', 'keterangan', 'created_by'];

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
        return $this->belongsTo('App\Model\Penjualan\StatusPenjualan', 'id_status');
    }
}
