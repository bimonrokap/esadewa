<?php

namespace App\Model\Bongkaran;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Bongkaran\BongkaranCategory
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranCategory query()
 * @mixin \Eloquent
 */
class BongkaranCategory extends Model
{
    protected $fillable = ['id_bongkaran', 'id_category_asset'];
}
