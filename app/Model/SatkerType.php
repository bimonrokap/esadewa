<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Satker
 *
 * @mixin \Eloquent
 * @property-read \App\Model\Wilayah $wilayah
 * @property int $id
 * @property int $id_wilayah
 * @property string $name
 * @property string|null $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $kode
 * @property string $satker_type
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerType query()
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerType whereIdWilayah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerType whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerType whereSatkerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerType whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SatkerType whereUpdatedAt($value)
 */
class SatkerType extends Model
{
    protected $table = 'view_satker_w_jenis';
}
