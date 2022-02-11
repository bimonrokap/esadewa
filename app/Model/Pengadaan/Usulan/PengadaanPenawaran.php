<?php

namespace App\Model\Pengadaan\Usulan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Pengadaan\PengadaanTanah
 *
 * @property int $id
 * @property int $id_pengadaan_tanah
 * @property string $harga_penawaran
 * @property string $ktp
 * @property string $sertifikat
 * @property string $pajak
 * @property string $pernyataan
 * @property string $surat_harga
 * @property string $penawaran
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Pengadaan\Usulan\PengadaanPenawaranFoto[] $foto
 * @property-read int|null $foto_count
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaran query()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaran whereHargaPenawaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaran whereIdPengadaanTanah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaran whereKtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaran wherePajak($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaran wherePenawaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaran wherePernyataan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaran whereSertifikat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaran whereSuratHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPenawaran whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PengadaanPenawaran extends Model
{

    protected $fillable = [
        'id_pengadaan_tanah',
        'harga_penawaran',
        'luas_tanah',
        'ktp',
        'sertifikat',
        'pajak',
        'pernyataan',
        'surat_harga',
        'penawaran',
    ];

    public function foto()
    {
        return $this->hasMany('App\Model\Pengadaan\Usulan\PengadaanPenawaranFoto', 'id_pengadaan_penawaran');
    }

    /**
     * @param $id
     * @param null $file
     * @param bool $asset
     * @return string
     */
    static function docLocation($id, $file = null, $asset = false)
    {
        if($asset) {
            return asset("file/pengadaan/".$id."/doc" . (!is_null($file) ? '/'.$file : ''));
        }
        return public_path("file/pengadaan/".$id."/doc" . (!is_null($file) ? '/'.$file : ''));
    }
}
