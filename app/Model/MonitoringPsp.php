<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MonitoringPsp extends Model
{

    protected $fillable = [
        'kode_satker',
        'id_category_asset',
        'total_unit',
        'total_nilai',
        'total_unit_psp',
        'total_nilai_psp',
        'total_unit_belum_psp',
        'total_nilai_belum_psp'
    ];

}
