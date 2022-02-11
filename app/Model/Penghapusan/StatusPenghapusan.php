<?php

namespace App\Model\Penghapusan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Penghapusan\StatusPenghapusan
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $state
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPenghapusan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPenghapusan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPenghapusan query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPenghapusan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPenghapusan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPenghapusan whereState($value)
 * @mixin \Eloquent
 */
class StatusPenghapusan extends Model
{
    const PERMOHONAN_SATKER = 1;
    const DITERIMA_TK = 2;
    const DITOLAK_TK = 3;
    const DITERIMA_ADM = 4;
    const DITOLAK_ADM = 5;
    const PROSES = 6;
    const SELESAI = 7;
    CONST EDIT = 8;

    protected $table = "penghapusan_statuses";
}
