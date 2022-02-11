<?php

namespace App\Model\Sewa;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Sewa\StatusSewa
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $name
 * @property string|null $state
 * @method static \Illuminate\Database\Eloquent\Builder|StatusSewa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusSewa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusSewa query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusSewa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusSewa whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusSewa whereState($value)
 */
class StatusSewa extends Model
{
    const PERMOHONAN_SATKER = 1;
    const DITERIMA_TK = 2;
    const DITOLAK_TK = 3;
    const DITERIMA_ADM = 4;
    const DITOLAK_ADM = 5;
    const PROSES = 6;
    const MENUNGGU = 9;
    const SELESAI = 7;

    protected $table = "sewa_statuses";
}
