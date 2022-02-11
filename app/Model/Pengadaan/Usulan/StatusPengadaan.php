<?php

namespace App\Model\Pengadaan\Usulan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Pengadaan\Usulan\StatusPengadaan
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $state
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPengadaan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPengadaan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPengadaan query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPengadaan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPengadaan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPengadaan whereState($value)
 * @mixin \Eloquent
 */
class StatusPengadaan extends Model
{
    const PERMOHONAN_SATKER = 1;
    const DITERIMA_TK = 2;
    const DITOLAK_TK = 3;
    const DITERIMA_ADM = 4;
    const DITOLAK_ADM = 5;
    const PROSES = 6;
    const SELESAI = 7;
    CONST EDIT = 8;

    protected $table = "pengadaan_statuses";
}
