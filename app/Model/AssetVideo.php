<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\AssetImage
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $id_asset
 * @property int $id_category
 * @property string $file
 * @property string|null $caption
 * @property int|null $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|AssetImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetImage whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetImage whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetImage whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetImage whereIdAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetImage whereIdCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetImage whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetImage whereUpdatedAt($value)
 */
class AssetVideo extends Model
{
    protected $fillable = ['id_asset', 'id_category', 'file', 'caption', 'created_by', 'order'];
}
