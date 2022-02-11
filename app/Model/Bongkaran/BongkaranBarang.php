<?php

namespace App\Model\Bongkaran;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Bongkaran\BongkaranBarang
 *
 * @property int $id
 * @property int $id_bongkaran
 * @property string $id_asset
 * @property int $id_category_asset
 * @property float $nilai_perolehan
 * @property int $ord
 * @property float|null $luas_bangunan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Bongkaran\BongkaranBarangUraian[] $uraian
 * @property-read int|null $uraian_count
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarang joinAsset()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarang query()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarang whereIdAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarang whereIdBongkaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarang whereIdCategoryAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarang whereLuasBangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarang whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarang whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BongkaranBarang extends Model
{
    protected $fillable = ['id_bongkaran', 'id_asset', 'id_category_asset', 'nilai_perolehan', 'ord', 'luas_bangunan'];

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

    public function uraian()
    {
        return $this->hasMany('App\Model\Bongkaran\BongkaranBarangUraian', 'id_bongkaran_barang');
    }
}
