<?php

namespace App\Model\Bongkaran;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Bongkaran\StatusBongkaran
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $state
 * @method static \Illuminate\Database\Eloquent\Builder|StatusBongkaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusBongkaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusBongkaran query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusBongkaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusBongkaran whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusBongkaran whereState($value)
 * @mixin \Eloquent
 */
class StatusBongkaran extends Model
{
    const PERMOHONAN_SATKER = 1;
    const DITERIMA_TK = 2;
    const DITOLAK_TK = 3;
    const DITERIMA_ADM = 4;
    const DITOLAK_ADM = 5;
    const PROSES = 6;
    const MENUNGGU = 9;
    const SELESAI = 7;

    protected $table = "bongkaran_statuses";
}
