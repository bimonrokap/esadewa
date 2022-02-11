<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Wilayah
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|Wilayah newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wilayah newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wilayah query()
 * @method static \Illuminate\Database\Eloquent\Builder|Wilayah whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wilayah whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wilayah whereName($value)
 */
class Wilayah extends Model
{
    protected $fillable = ['code', 'name'];
}
