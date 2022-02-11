<?php

namespace App\Model\Pengadaan\Usulan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Pengadaan\Usulan\PengadaanRenovasiFoto
 *
 * @property int $id
 * @property int $id_pengadaan_renovasi
 * @property string $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasiFoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasiFoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasiFoto query()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasiFoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasiFoto whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasiFoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasiFoto whereIdPengadaanRenovasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasiFoto whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PengadaanRenovasiFoto extends Model
{
    protected $fillable = ['id_pengadaan_renovasi', 'foto'];

    /**
     * @param $id
     * @param null $file
     * @param bool $asset
     * @return string
     */
    static function imageLocation($id, $file = null, $asset = false)
    {
        if($asset) {
            return asset("file/pengadaan/".$id."/foto" . (!is_null($file) ? '/'.$file : ''));
        }
        return public_path("file/pengadaan/".$id."/foto" . (!is_null($file) ? '/'.$file : ''));
    }
}
