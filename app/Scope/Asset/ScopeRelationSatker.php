<?php
namespace App\Scope\Asset;

trait ScopeRelationSatker
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function satker()
    {
        return $this->belongsTo('App\Model\Satker', 'kode_satker', 'kode');
    }

    /**
     * @return mixed
     */
    public function lingkungan()
    {
        return $this->belongsTo('App\Model\SatkerType', 'kode_satker', 'kode');
    }
}