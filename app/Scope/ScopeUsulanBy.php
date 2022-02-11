<?php
namespace App\Scope;

use App\Model\TingkatBanding;
use Illuminate\Support\Facades\Auth;

trait ScopeUsulanBy
{

    public function scopeUsulanBy($query)
    {
        $user = Auth::user();

        if($user->isTingkatBanding() || $user->isAdminTingkatBanding() || $user->isKorwil() || $user->isAdminKorwil() || $user->isEselon() || $user->isAdminEselon()) {
            if($user->isKorwil() || $user->isAdminKorwil() || $user->isTingkatBanding() || $user->isAdminTingkatBanding()) {
                if($user->isTingkatBanding() || $user->isAdminTingkatBanding()) {
                    $tingkatBanding = TingkatBanding::join('satkers', 'satkers.id', 'id_satker')
                        ->where('tingkat_bandings.lingkungan', $user->lingkungan)
                        ->where('tingkat_bandings.id_wilayah', $user->id_wilayah)->select('satkers.kode')->get()
                        ->pluck('kode')->all();

                    if(!empty($tingkatBanding)) {
                        $query->whereIn('s.kode', $tingkatBanding);
                    } else {
                        $query->where('s.id_wilayah', $user->id_wilayah);
                    }
                } else {
                    $query->where('s.id_wilayah', $user->id_wilayah);
                }
            }

            if($user->isEselon() || $user->isAdminEselon() || $user->isTingkatBanding() || $user->isAdminTingkatBanding()) {
                $lingkungan = $user->lingkungan;

                if($lingkungan == 'PMT') {
                    $query = $query->where(function ($query){
                        return $query->whereSatkerType('PM')->orWhere('satker_type', 'PT');
                    });
                } else {
                    $query = $query->whereSatkerType($lingkungan);
                }
            }
        } else if($user->isSatker() || $user->isAdminSatker()) {
            $query->where('id_satker', $user->id_satker);
        }

        return $query;
    }

}