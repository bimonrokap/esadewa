<?php

namespace App\Model\Penjualan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Penjualan\StatusPenjualan
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $name
 * @property string|null $state
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPenjualan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPenjualan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPenjualan query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPenjualan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPenjualan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPenjualan whereState($value)
 */
class StatusPenjualan extends Model
{
    const PERMOHONAN_SATKER = 1;
    const DITERIMA_TK = 2;
    const DITOLAK_TK = 3;
    const DITERIMA_ADM = 4;
    const DITOLAK_ADM = 5;
    const PROSES = 6;
    const SELESAI = 7;
    CONST EDIT = 8;

    protected $table = "penjualan_statuses";
}
