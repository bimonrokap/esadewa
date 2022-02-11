<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Faq
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $type 1
 * @property int|null $value
 * @property string|null $year
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MasterUsulan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterUsulan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterUsulan query()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterUsulan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterUsulan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterUsulan whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterUsulan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterUsulan whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterUsulan whereYear($value)
 */
class MasterUsulan extends Model
{
    protected $fillable = ['type', 'value', 'year'];
}
