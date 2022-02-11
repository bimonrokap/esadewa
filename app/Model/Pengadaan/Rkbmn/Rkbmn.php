<?php

namespace App\Model\Pengadaan\Rkbmn;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Pengadaan\Rkbmn\Rkbmn
 *
 * @property int $id
 * @property string $year
 * @property string $file
 * @property int $type
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Pengadaan\Rkbmn\RkbmnPengadaan[] $detail
 * @property-read int|null $detail_count
 * @method static \Illuminate\Database\Eloquent\Builder|Rkbmn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rkbmn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rkbmn query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rkbmn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rkbmn whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rkbmn whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rkbmn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rkbmn whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rkbmn whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rkbmn whereYear($value)
 * @mixin \Eloquent
 */
class Rkbmn extends Model
{
    protected $fillable = ['type', 'year', 'file', 'created_by'];

    public function detail()
    {
        if($this->type == 2) {
            return $this->hasMany('App\Model\Pengadaan\Rkbmn\RkbmnPemeliharaan', 'id_rkbmn');
        } else {
            return $this->hasMany('App\Model\Pengadaan\Rkbmn\RkbmnPengadaan', 'id_rkbmn');
        }
    }
}
