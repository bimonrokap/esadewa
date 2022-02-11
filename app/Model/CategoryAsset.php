<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\CategoryAsset
 *
 * @property int $id
 * @property string $name
 * @property string|null $table_name
 * @property string $icon
 * @property string|null $route
 * @property string|null $url
 * @property int|null $order
 * @property int|null $active
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryAsset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryAsset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryAsset query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryAsset whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryAsset whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryAsset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryAsset whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryAsset whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryAsset whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryAsset whereTableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryAsset whereUrl($value)
 * @mixin \Eloquent
 */
class CategoryAsset extends Model
{

    static function penjualan()
    {
        return self::whereIn('id', [5,6,7,14,15])->get()->toArray();
    }

    static function sewaJenis()
    {
        return self::whereIn('id', [4,9,3])->get();
    }

    static function sewa()
    {
        return self::whereIn('id', [9,3])->get()->toArray();
    }

    static function bongkaran()
    {
        return self::whereIn('id', [9,10,11,12,13])->get()->toArray();
    }

    static function penghapusan()
    {
        return self::whereIn('id', [3,9,10,5,6,15,4])->get()->toArray();
    }

    static function pengadaan()
    {
        return self::whereIn('id', [3])->get()->toArray();
    }

}
