<?php

namespace App\Model\Pengadaan\Usulan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Pengadaan\Usulan\PengadaanTanah
 *
 * @property int $id
 * @property int $id_pengadaan
 * @property int $jenis_pengadaan
 * @property string $tor
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \App\Model\CategoryAsset $jenisPengadaan
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Pengadaan\Usulan\PengadaanPenawaran[] $penawaran
 * @property-read int|null $penawaran_count
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanTanah newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanTanah newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanTanah query()
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanTanah whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanTanah whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanTanah whereIdPengadaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanTanah whereJenisPengadaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanTanah whereTor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengadaanTanah whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PengadaanTanah extends Model
{

    protected $fillable = [
        'id_pengadaan',
        'jenis_pengadaan',
        'tanah_type',
        'tor',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penawaran()
    {
        return $this->hasMany('App\Model\Pengadaan\Usulan\PengadaanPenawaran', 'id_pengadaan_tanah');
    }

    public function jenisPengadaan()
    {
        return $this->belongsTo('App\Model\CategoryAsset', 'jenis_pengadaan');
    }
}
