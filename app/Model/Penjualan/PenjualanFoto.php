<?php

namespace App\Model\Penjualan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Penjualan\PenjualanFoto
 *
 * @property int $id
 * @property int $id_penjualan
 * @property string $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanFoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanFoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanFoto query()
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanFoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanFoto whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanFoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanFoto whereIdPenjualan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PenjualanFoto whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PenjualanFoto extends Model
{
    protected $fillable = ['id_penjualan', 'foto'];

    /**
     * @param $id
     * @param null $file
     * @param bool $asset
     * @return string
     */
    static function imageLocation($id, $file = null, $asset = false)
    {
        if($asset) {
            return asset("file/penjualan/".$id."/foto" . (!is_null($file) ? '/'.$file : ''));
        }
        return public_path("file/penjualan/".$id."/foto" . (!is_null($file) ? '/'.$file : ''));
    }
}
