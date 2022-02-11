<?php

namespace App\Model\Sewa;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Sewa\SewaFoto
 *
 * @property int $id
 * @property int $id_sewa
 * @property string $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SewaFoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SewaFoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SewaFoto query()
 * @method static \Illuminate\Database\Eloquent\Builder|SewaFoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaFoto whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaFoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaFoto whereIdSewa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SewaFoto whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SewaFoto extends Model
{
    protected $fillable = ['id_sewa', 'foto'];

    /**
     * @param $id
     * @param null $file
     * @param bool $asset
     * @return string
     */
    static function imageLocation($id, $file = null, $asset = false)
    {
        if($asset) {
            return asset("file/sewa/".$id."/foto" . (!is_null($file) ? '/'.$file : ''));
        }
        return public_path("file/sewa/".$id."/foto" . (!is_null($file) ? '/'.$file : ''));
    }
}
