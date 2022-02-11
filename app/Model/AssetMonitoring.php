<?php

namespace App\Model;

use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\AssetMonitoring
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $name
 * @property string $data
 * @property string|null $type
 * @property int|null $start
 * @property int|null $end
 * @property int|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AssetMonitoring assetBy()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetMonitoring generalFilter($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetMonitoring newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetMonitoring newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetMonitoring query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetMonitoring satkerOf(\App\Model\Satker $satker)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetMonitoring whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetMonitoring whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetMonitoring whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetMonitoring whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetMonitoring whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetMonitoring whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetMonitoring whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetMonitoring whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetMonitoring whereValue($value)
 */
class AssetMonitoring extends Model
{
    use ScopeSatker;
    protected $fillable = ['name', 'data', 'type', 'value', 'start', 'end'];
}
