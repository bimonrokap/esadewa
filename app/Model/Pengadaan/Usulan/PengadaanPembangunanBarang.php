<?php

namespace App\Model\Pengadaan\Usulan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Pengadaan\Usulan\PengadaanPembangunanBarang
 *
 * @property int $id
 * @property int $id_pengadaan_pembangunan
 * @property string $id_asset
 * @property int|null $id_category_asset
 * @property float $nilai_perolehan
 * @property int|null $ord
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanBarang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanBarang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanBarang query()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanBarang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanBarang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanBarang whereIdAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanBarang whereIdCategoryAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanBarang whereIdPengadaanPembangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanBarang whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanBarang whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanPembangunanBarang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PengadaanPembangunanBarang extends Model
{
    protected $fillable = ['id_pengadaan_pembangunan', 'id_asset', 'id_category_asset', 'nilai_perolehan', 'ord'];

}
