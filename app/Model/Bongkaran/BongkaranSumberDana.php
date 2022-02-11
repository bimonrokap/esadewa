<?php

namespace App\Model\Bongkaran;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Bongkaran\BongkaranSumberDana
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranSumberDana newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranSumberDana newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranSumberDana query()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranSumberDana whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranSumberDana whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranSumberDana whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranSumberDana whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BongkaranSumberDana extends Model
{
    const DIPA = 1;
    const NON_DIPA = 2;
}
