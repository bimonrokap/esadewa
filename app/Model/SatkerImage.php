<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\SatkerImage
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $kode_satker
 * @property string $file
 * @property string|null $caption
 * @property int|null $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerImage whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerImage whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerImage whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerImage whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerImage whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerImage whereUpdatedAt($value)
 */
class SatkerImage extends Model
{
    protected $fillable = ['kode_satker', 'file', 'caption', 'created_by', 'order'];
}
