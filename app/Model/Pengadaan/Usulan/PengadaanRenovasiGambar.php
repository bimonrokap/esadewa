<?php

namespace App\Model\Pengadaan\Usulan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Pengadaan\Usulan\PengadaanRenovasiGambar
 *
 * @property int $id
 * @property int $id_pengadaan_renovasi
 * @property string $file
 * @property int $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasiGambar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasiGambar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasiGambar query()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasiGambar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasiGambar whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasiGambar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasiGambar whereIdPengadaanRenovasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasiGambar whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanRenovasiGambar whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PengadaanRenovasiGambar extends Model
{
    protected $fillable = ['id_pengadaan_renovasi', 'file', 'type'];

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
