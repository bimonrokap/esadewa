<?php

namespace App\Model\Pengadaan\Usulan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Pengadaan\Usulan\PengadaanPembangunanGambar
 *
 * @property int $id
 * @property int $id_pengadaan_pembangunan
 * @property string $file
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanGambar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanGambar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanGambar query()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanGambar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanGambar whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanGambar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanGambar whereIdPengadaanPembangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanGambar whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PengadaanPembangunanGambar extends Model
{
    protected $fillable = ['id_pengadaan_pembangunan', 'file'];

    /**
     * @param $id
     * @param null $file
     * @param bool $asset
     * @return string
     */
    static function imageLocation($id, $file = null, $asset = false)
    {
        if($asset) {
            return asset("file/pengadaan/".$id."/gambar" . (!is_null($file) ? '/'.$file : ''));
        }
        return public_path("file/pengadaan/".$id."/gambar" . (!is_null($file) ? '/'.$file : ''));
    }
}
