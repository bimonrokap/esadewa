<?php
/**
 * Created by PhpStorm.
 * User: Alice
 * Date: 20/08/2018
 * Time: 1:41
 */

namespace App\Scope;
use App\Model\TingkatBanding;
use App\Model\Wilayah;
use App\Repositories\Permission\Permission;
use Illuminate\Support\Facades\DB;

trait ScopeSatker
{
    /**
     * @param $query
     * @param $filter
     * @return mixed
     */
    public function scopeGeneralFilter($query, $filter)
    {
        if(!is_null($filter)){
            if(is_array($filter)){
                foreach ($filter as $k => $r) {
                    $value = $r;
                    if ($value != '') {
                        $name = $k;
                        $this->searchFilter($query, $name, $value);
                    }
                }
            } else {
                $filter = json_decode($filter);
                foreach ($filter as $r) {
                    $value = $r->value;
                    if ($value != '') {
                        $name = $r->name;
                        $this->searchFilter($query, $name, $value);
                    }
                }
            }
        }

        return $query;
    }

    /**
     * @param $query
     * @param $name
     * @param $value
     */
    private function searchFilter($query, $name, $value)
    {
        switch ($name) {
            case 'lingkungan':
                $query->whereHas('satker', function ($query) use ($value){
                    return $query->whereSatkerType($value);
                });
                break;
            case 'wilayah':
                $wilayah = Wilayah::findOrFail($value);
                $query->where(DB::raw('SUBSTRING(kode_satker, 6, 4)'), $wilayah->code);
                break;
            case 'wilayah_kode':
                $wilayah = Wilayah::findOrFail($value);
                $query->where(DB::raw('SUBSTRING(kode, 6, 4)'), $wilayah->code);
                break;
            case 'sertifikat':
                if($value == 'Sudah') {
                    $query->whereJenisDokumen('Sertifikat');
                } else {
                    $query->where(function ($query){
                        return $query->whereJenisDokumen('NULL')->orWhere('jenis_dokumen', null)
                            ->orWhere('jenis_dokumen', '!=', 'Sertifikat');
                    });
                }
                break;
            case 'kendaraan_type':
                if($value == 'Roda 4') {
                    $query->roda4();
                } else if($value == 'Roda 2') {
                    $query->roda2();
                } else {
                    $query->lainnya();
                }
                break;
            case 'kondisiSelect':
                $query->whereKondisi($value);
                break;
            case 'djkn':
                $query->where('djkn', $value);
                break;
            case 'anggaran':
                $query->where('is_anggaran', $value);
                break;
            case 'psp':
                if($value == 'Sudah') {
                    $query->where(function ($query){
                        return $query->whereNotNull('no_psp')->where('no_psp', '!=', 'NULL')->where('no_psp', '!=', '-');
                    });
                } else {
                    $query->where(function ($query){
                        return $query->where('no_psp', null)->orWhere('no_psp', 'NULL')->orWhere('no_psp', '-');
                    });
                }
                break;
        }
    }

    /**
     * @param $query
     * @param string $kodeSatker
     * @param bool $satkerRelation
     * @return mixed
     */
    public function scopeAssetBy($query, $kodeSatker = 'kode_satker', $satkerRelation = false)
    {
        $user = \Auth::user();
        if(Permission::can('view-all-asset')) {

        } else if (Permission::can('view-all-lingkungan-asset') || Permission::can('view-all-wilayah-asset')) {
            if(Permission::can('view-all-lingkungan-asset')) {
                $lingkungan = $user->lingkungan;

                if($satkerRelation) {
                    if($lingkungan == 'PMT') {
                        $query = $query->where(function ($query){
                            return $query->whereSatkerType('PM')->orWhere('satker_type', 'PT');
                        });
                    } else {
                        $query = $query->whereSatkerType($lingkungan);
                    }
                } else {
                    $query = $query->whereHas('satker', function ($query) use ($lingkungan){
                        if($lingkungan == 'PMT') {
                            return $query->where(function ($query){
                                return $query->whereSatkerType('PM')->orWhere('satker_type', 'PT');
                            });
                        } else {
                            return $query->whereSatkerType($lingkungan);
                        }
                    });
                }
            }

            if(Permission::can('view-all-wilayah-asset')) {
                $wilayah = null;
                if($user->isTingkatBanding() || $user->isAdminTingkatBanding()) {
                    $tingkatBanding = TingkatBanding::join('satkers', 'satkers.id', 'id_satker')
                        ->where('tingkat_bandings.lingkungan', $user->lingkungan)
                        ->where('tingkat_bandings.id_wilayah', $user->id_wilayah)->select('satkers.kode')->get()
                        ->pluck('kode')->all();

                    if(!empty($tingkatBanding)) {
                        $query->whereIn($kodeSatker, $tingkatBanding);
                    } else {
                        $wilayah = $user->wilayah;
                    }
                } else {
                    $wilayah = $user->wilayah;
                }

                if($wilayah != null) {
                    $query = $query->where(DB::raw('SUBSTRING('.$kodeSatker.', 6, 4)'), $wilayah->code);
                }
            }

            return $query;
        } else if (Permission::can('view-all-satker-asset')) {
            $satker = $user->satker;
            return $query->where($kodeSatker, $satker->kode);
        }
    }
}