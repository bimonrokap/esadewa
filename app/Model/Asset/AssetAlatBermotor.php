<?php

namespace App\Model\Asset;

use App\Scope\Asset\ScopeFilter;
use App\Scope\Asset\ScopeRelationSatker;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Model\Asset\AssetAlatBermotor
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $kode_satker
 * @property string|null $kode_barang
 * @property string $nup
 * @property string|null $nama_satker
 * @property string|null $kib
 * @property string|null $nama_barang
 * @property string|null $kondisi
 * @property string|null $merk
 * @property string|null $tgl_perolehan
 * @property float|null $nilai_perolehan_pertama
 * @property float|null $nilai_mutasi
 * @property float|null $nilai_perolehan
 * @property float|null $nilai_penyusutan
 * @property float|null $nilai_buku
 * @property string|null $tgl_rekam_pertama
 * @property float|null $kuantitas
 * @property string|null $jml_foto
 * @property string|null $status_penggunaan
 * @property string|null $status_pengelolaan
 * @property string|null $no_psp
 * @property string|null $tgl_psp
 * @property string|null $no_bpkb
 * @property string|null $no_polisi
 * @property string|null $pemakai
 * @property float|null $jumlah_kib
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $filled
 * @property string|null $tanggal_update
 * @property-read \App\Model\SatkerType|null $lingkungan
 * @property-read \App\Model\Satker|null $satker
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor assetBy()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor filter($filter, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor generalFilter($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor lainnya()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor roda2()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor roda2bermotor()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor roda2lainnya()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor roda4()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor roda4jeep()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor roda4mini()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor roda4sedan()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor roda4wagon()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor satkerOf(\App\Model\Satker $satker)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereFilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereJmlFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereJumlahKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereKib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereKodeSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereKuantitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereNamaSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereNilaiBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereNilaiMutasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereNilaiPenyusutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereNilaiPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereNilaiPerolehanPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereNoBpkb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereNoPolisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereNoPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereNup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor wherePemakai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereStatusPengelolaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereStatusPenggunaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereTanggalUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereTglPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereTglPsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereTglRekamPertama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetAlatBermotor whereUpdatedAt($value)
 */
class AssetAlatBermotor extends Model
{
    use ScopeSatker, ScopeFilter, ScopeRelationSatker;

    protected $fillable = ['kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp','no_bpkb','no_polisi','pemakai','jumlah_kib','tanggal_update'];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRoda2($query)
    {
        return $query->whereIn(DB::raw('substr(kode_barang, 5, 3)'), ['104']);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRoda2bermotor($query)
    {
        return $query->whereIn('kode_barang', ['3020104001', '3020104002', '3020104004']);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRoda2lainnya($query)
    {
        return $query->whereIn('kode_barang', ['3020104999']);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRoda4($query)
    {
        return $query->whereIn(DB::raw('substr(kode_barang, 5, 3)'), ['101', '102', '103', '106', '199']);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeLainnya($query)
    {
        return $query->whereNotIn(DB::raw('substr(kode_barang, 5, 3)'), ['101', '102', '103', '104', '106', '199']);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRoda4sedan($query)
    {
        return $query->whereIn('kode_barang', ['3020101001']);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRoda4mini($query)
    {
        return $query->whereIn('kode_barang', ['3020102003']);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRoda4wagon($query)
    {
        return $query->whereIn('kode_barang', ['3020101003']);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRoda4jeep($query)
    {
        return $query->whereIn('kode_barang', ['3020101002']);
    }
}
