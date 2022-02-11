<?php
namespace App\Scope\Asset;

trait ScopeFilter
{

    /**
     * @param $query
     * @param $filter
     * @param $data
     * @return mixed
     */
    public function scopeFilter($query, $filter, $data)
    {
        switch ($filter) {
            case 'satker':
                return $query->whereKodeSatker($data);
            break;
            case 'wilayah':
                return $query->whereHas('satker', function ($query) use ($data) {
                    $query->where('id_wilayah', $data);
                });
            break;
            case 'lingkungan':
                return $query->join('satkers', 'kode_satker', '=', 'satkers.kode')->where('satker_type', $data);
            break;
        }
    }
}