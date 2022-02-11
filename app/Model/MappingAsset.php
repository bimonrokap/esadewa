<?php
namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Faq
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $id_category_asset
 * @property string $mapping_asset
 * @property int|null $id_benda
 * @method static \Illuminate\Database\Eloquent\Builder|MappingAsset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MappingAsset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MappingAsset query()
 * @method static \Illuminate\Database\Eloquent\Builder|MappingAsset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MappingAsset whereIdBenda($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MappingAsset whereIdCategoryAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MappingAsset whereMappingAsset($value)
 */
class MappingAsset extends Model
{
    public $timestamps = false;

    protected $fillable = ['id_category_asset', 'mapping_asset', 'id_benda'];

}
