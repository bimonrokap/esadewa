<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\PenandatanganSurat
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PenandatanganSurat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PenandatanganSurat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PenandatanganSurat query()
 * @method static \Illuminate\Database\Eloquent\Builder|PenandatanganSurat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenandatanganSurat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenandatanganSurat whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenandatanganSurat whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PenandatanganSurat extends Model
{

    protected $fillable = ['id', 'name'];

}
