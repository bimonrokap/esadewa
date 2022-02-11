<?php

namespace App\Model\Asset;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Asset\AssetPersediaanMasyarakat
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $id_satker
 * @property int $id_barang
 * @property int|null $tahun
 * @property string|null $periode
 * @property int $kuantitas
 * @property float $nilai
 * @property string $kode_kpknl
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $filled
 * @property string|null $tanggal_update
 * @property string|null $tgl_rekam_pertama
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaanMasyarakat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaanMasyarakat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaanMasyarakat query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaanMasyarakat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaanMasyarakat whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaanMasyarakat whereFilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaanMasyarakat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaanMasyarakat whereIdBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaanMasyarakat whereIdSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaanMasyarakat whereKodeKpknl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaanMasyarakat whereKuantitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaanMasyarakat whereNilai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaanMasyarakat wherePeriode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaanMasyarakat whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaanMasyarakat whereTanggalUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaanMasyarakat whereTglRekamPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaanMasyarakat whereUpdatedAt($value)
 */
class AssetPersediaanMasyarakat extends Model
{
    protected $fillable = ['id_barang', 'id_satker', 'tahun', 'periode', 'kuantitas', 'nilai', 'kode_kpknl', 'created_by'];
}
