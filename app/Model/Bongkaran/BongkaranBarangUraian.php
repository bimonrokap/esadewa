<?php

namespace App\Model\Bongkaran;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Bongkaran\BongkaranBarangUraian
 *
 * @property int $id
 * @property int $id_bongkaran_barang
 * @property string $uraian
 * @property string $jumlah
 * @property string|null $satuan
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarangUraian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarangUraian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarangUraian query()
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarangUraian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarangUraian whereIdBongkaranBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarangUraian whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarangUraian whereSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BongkaranBarangUraian whereUraian($value)
 * @mixin \Eloquent
 */
class BongkaranBarangUraian extends Model
{
    public $timestamps = false;

    protected $fillable = ['id_bongkaran_barang', 'uraian', 'jumlah', 'satuan'];
}
