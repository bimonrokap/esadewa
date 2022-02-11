<?php

namespace App\Policies;

use App\Model\LaporBmn\LaporBmn;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LaporBmnPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param User $user
     * @param LaporBmn $laporBmn
     * @return bool
     */
    public function view(User $user, LaporBmn $laporBmn)
    {
        if($user->isTingkatBanding() || $user->isAdminTingkatBanding() || $user->isKorwil() || $user->isAdminKorwil()) {
            return $laporBmn->user->id_wilayah == $user->id_wilayah;
        } else if($user->isSatker() || $user->isAdminSatker()) {
            return $laporBmn->user->id_satker == $user->id_satker;
        } else if($user->isSuperAdmin() || $user->isPusat() || $user->isAdminPusat()) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @param LaporBmn $laporBmn
     * @return bool
     */
    public function delete(User $user, LaporBmn $laporBmn)
    {
        if($user->isTingkatBanding() || $user->isAdminTingkatBanding() || $user->isKorwil() || $user->isAdminKorwil()) {
            return $laporBmn->user->id_wilayah == $user->id_wilayah && $laporBmn->status == 1;
        } else if($user->isSatker() || $user->isAdminSatker()) {
            return $laporBmn->user->id_satker == $user->id_satker && $laporBmn->status == 1;
        }

        return false;
    }
}
