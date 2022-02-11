<?php

namespace App\Model\Penjualan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Penjualan\PenjualanBarang
 *
 * @property int $id
 * @property int $id_penjualan
 * @property string $id_asset
 * @property int|null $id_category_asset
 * @property float $nilai_perolehan
 * @property int|null $ord
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanBarang joinAsset()
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanBarang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanBarang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanBarang query()
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanBarang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanBarang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanBarang whereIdAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanBarang whereIdCategoryAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanBarang whereIdPenjualan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanBarang whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanBarang whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanBarang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PenjualanBarang extends Model
{
    protected $fillable = ['id_penjualan', 'id_asset', 'id_category_asset', 'nilai_perolehan', 'ord'];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeJoinAsset($query)
    {
        return $query->join('view_barang', function ($join) {
            $join
                ->on('view_barang.id_asset', '=', "penjualan_barangs.id_asset")
                ->on('view_barang.category', '=', 'penjualan_barangs.id_category_asset');
        })->join('category_assets', 'category_assets.id', '=', 'penjualan_barangs.id_category_asset');
    }
}
