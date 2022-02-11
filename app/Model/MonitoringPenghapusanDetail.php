<?php

namespace App\Model;

use App\Scope\Asset\ScopeFilter;
use App\Scope\Asset\ScopeRelationSatker;
use App\Scope\ScopeSatker;
use Illuminate\Database\Eloquent\Model;

class MonitoringPenghapusanDetail extends Model
{
    use ScopeSatker, ScopeFilter, ScopeRelationSatker;

    protected $fillable = [
        'id_monitoring_penghapusan',
        'kode_satker',
        'nama_satker',
        'akun',
        'uraian_akun',
        'kode_bidang',
        'uraian_bidang',
        'kode_transaksi',
        'uraian_transaksi',
        'kuantitas',
        'nilai'
    ];
}
