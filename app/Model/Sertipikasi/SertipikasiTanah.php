<?php

namespace App\Model\Sertipikasi;

use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

class SertipikasiTanah extends Model
{
    use ScopeSatker;

    protected $fillable = ['id_tanah', 'id_satker', 'jumlah_anggaran', 'status', 'created_by'];

    public function detail()
    {
        return $this->hasMany('App\Model\Sertipikasi\SertipikasiTanahDetail', 'id_sertipikasi_tanah');
    }
}
