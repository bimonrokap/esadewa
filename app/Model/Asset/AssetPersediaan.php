<?php

namespace App\Model\Asset;

use App\Model\Satker;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Asset\AssetPersediaan
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AssetPersediaan satkerOf(\App\Model\Satker $satker)
 * @property int $id
 * @property int $kuantitas
 * @property float $nilai
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $filled
 * @property string|null $tanggal_update
 * @property string|null $kode_satker
 * @property string|null $kode_barang
 * @property string|null $nama_satker
 * @property string|null $nama_barang
 * @property string|null $tgl_rekam_pertama
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaan query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaan whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaan whereFilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaan whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaan whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaan whereKuantitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaan whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaan whereNamaSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaan whereNilai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaan whereTanggalUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaan whereTglRekamPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetPersediaan whereUpdatedAt($value)
 */
class AssetPersediaan extends Model
{
    protected $fillable = ['id_barang', 'id_satker', 'tahun', 'periode', 'kuantitas', 'nilai', 'created_by'];
}
