<?php

namespace App\Model\Bongkaran;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Bongkaran\BongkaranFoto
 *
 * @property int $id
 * @property int $id_bongkaran
 * @property string $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranFoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranFoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranFoto query()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranFoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranFoto whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranFoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranFoto whereIdBongkaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranFoto whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BongkaranFoto extends Model
{
    protected $fillable = ['id_bongkaran', 'foto'];

    /**
     * @param $id
     * @param null $file
     * @param bool $asset
     * @return string
     */
    static function imageLocation($id, $file = null, $asset = false)
    {
        if($asset) {
            return asset("file/bongkaran/".$id."/foto" . (!is_null($file) ? '/'.$file : ''));
        }
        return public_path("file/bongkaran/".$id."/foto" . (!is_null($file) ? '/'.$file : ''));
    }
}
