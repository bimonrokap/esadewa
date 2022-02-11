<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\AssetImage
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $id_asset
 * @property string $variable
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|AssetVariable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetVariable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetVariable query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetVariable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetVariable whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetVariable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetVariable whereIdAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetVariable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetVariable whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetVariable whereVariable($value)
 */
class AssetVariable extends Model
{
    protected $fillable = ['id_asset', 'variable', 'value', 'created_by'];
}
