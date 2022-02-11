<?php

namespace App\Model\Pengadaan\Usulan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Pengadaan\Usulan\PengadaanPenawaranFoto
 *
 * @property int $id
 * @property int $id_pengadaan_penawaran
 * @property string $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaranFoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaranFoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaranFoto query()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaranFoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaranFoto whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaranFoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaranFoto whereIdPengadaanPenawaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaranFoto whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PengadaanPenawaranFoto extends Model
{
    protected $fillable = ['id_pengadaan_penawaran', 'foto'];

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
