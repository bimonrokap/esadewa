<?php

namespace App\Model\Sewa;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Sewa\SewaCategory
 *
 * @property int $id
 * @property int $id_sewa
 * @property int $id_category_asset
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SewaCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SewaCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SewaCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|SewaCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaCategory whereIdCategoryAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaCategory whereIdSewa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SewaCategory extends Model
{
    protected $fillable = ['id_sewa', 'id_category_asset'];
}
