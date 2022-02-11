<?php

namespace App\Model;

use App\Scope\NonDipa;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Satker
 *
 * @property int $id
 * @property int $id_wilayah
 * @property string|null $kode
 * @property string $name
 * @property string|null $type
 * @property string|null $city
 * @property string|null $dirjen
 * @property string|null $kpknl
 * @property string|null $kanwil
 * @property string|null $satker_type
 * @property string|null $tanggal_update
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\SatkerType|null $lingkungan
 * @property-read \App\Model\Wilayah $wilayah
 * @method static \Illuminate\Database\Eloquent\Builder|Satker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Satker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Satker query()
 * @method static \Illuminate\Database\Eloquent\Builder|Satker whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Satker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Satker whereDirjen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Satker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Satker whereIdWilayah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Satker whereKanwil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Satker whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Satker whereKpknl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Satker whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Satker whereSatkerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Satker whereTanggalUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Satker whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Satker whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Satker extends Model
{
    use ScopeSatker;

    protected $fillable = ['kode', 'name', 'id_wilayah', 'type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wilayah()
    {
        return $this->belongsTo('App\Model\Wilayah', 'id_wilayah');
    }

    /**
     * @return mixed
     */
    public function lingkungan()
    {
        return $this->belongsTo('App\Model\SatkerType', 'kode', 'kode');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new NonDipa);
    }
}
