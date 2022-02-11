<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
class MonitoringPenghapusan extends Model
{
    protected $fillable = ['year', 'file', 'created_by'];

    public function detail()
    {
        return $this->hasMany('App\Model\MonitoringPenghapusanDetail', 'id_monitoring_penghapusan');
    }
}
