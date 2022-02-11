<?php

namespace App\Model\Penghapusan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Penghapusan\PenghapusanBarang
 *
 * @property int $id
 * @property int $id_penghapusan
 * @property string $id_asset
 * @property int|null $id_category_asset
 * @property float $nilai_perolehan
 * @property int|null $ord
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanBarang joinAsset()
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanBarang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanBarang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanBarang query()
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanBarang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanBarang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanBarang whereIdAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanBarang whereIdCategoryAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanBarang whereIdPenghapusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanBarang whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanBarang whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenghapusanBarang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PenghapusanBarang extends Model
{
    protected $fillable = ['id_penghapusan', 'id_asset', 'id_category_asset', 'nilai_perolehan', 'ord'];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeJoinAsset($query)
    {
        return $query->join('view_barang', function ($join) {
            $join
                ->on('view_barang.id_asset', '=', "penghapusan_barangs.id_asset")
                ->on('view_barang.category', '=', 'penghapusan_barangs.id_category_asset');
        })->join('category_assets', 'category_assets.id', '=', 'penghapusan_barangs.id_category_asset');
    }
}
