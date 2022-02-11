<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Config
 *
 * @property int $id
 * @property string $name
 * @property string|null $value
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $type
 * @property int|null $active
 * @method static \Illuminate\Database\Eloquent\Builder|Config newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Config newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Config query()
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereValue($value)
 * @mixin \Eloquent
 */
class Config extends Model
{
    protected $fillable = ['name', 'value', 'type', 'active'];
}
