<?php

namespace App\Model\Sewa;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Sewa\SewaBarang
 *
 * @property int $id
 * @property int $id_sewa
 * @property string $id_asset
 * @property int|null $id_category_asset
 * @property float $nilai_perolehan
 * @property int|null $ord
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SewaBarang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SewaBarang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SewaBarang query()
 * @method static \Illuminate\Database\Eloquent\Builder|SewaBarang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaBarang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaBarang whereIdAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaBarang whereIdCategoryAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaBarang whereIdSewa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaBarang whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaBarang whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaBarang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SewaBarang extends Model
{
    protected $fillable = ['id_sewa', 'id_asset', 'id_category_asset', 'nilai_perolehan', 'ord'];
}
