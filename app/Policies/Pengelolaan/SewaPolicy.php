<?php

namespace App\Policies\Pengelolaan;

use App\Model\Sewa\Sewa;
use App\Model\Sewa\StatusSewa;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SewaPolicy
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

    public function before($user, $ability)
    {

        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param Sewa $sewa
     * @return bool
     */
    public function view(User $user, Sewa $sewa)
    {
        if($user->isAdminSatker() || $user->isSatker()) {
            return $sewa->user->id_satker == $user->id_satker;
        } else if($user->isAdminTingkatBanding() || $user->isTingkatBanding()) {
            return $sewa->user->satker->id_wilayah == $user->id_wilayah;
        }

        return true;
    }

    /**
     * @param User $user
     * @param Sewa $sewa
     * @return bool
     */
    public function edit(User $user, Sewa $sewa)
    {
        return in_array($sewa->id_sewa_status, [StatusSewa::PERMOHONAN_SATKER, StatusSewa::DITOLAK_TK]) && $sewa->id_satker == $user->id_satker && ($user->isSatker() || $user->isAdminSatker());
    }

    /**
     * @param User $user
     * @param \App\Model\Sewa\Sewa $sewa
     * @return bool
     */
    public function verifTk(User $user, Sewa $sewa)
    {
        $idWilayah = null;
        if(isset($sewa->id_wilayah)) {
            $idWilayah = $sewa->id_wilayah;
        } else {
            $idWilayah = $sewa->user->satker->id_wilayah;
        }

        return in_array($sewa->id_sewa_status, [StatusSewa::PERMOHONAN_SATKER, StatusSewa::DITOLAK_ADM]) && ($user->isTingkatBanding() || $user->isAdminTingkatBanding()) && $idWilayah == $user->id_wilayah;
    }

    /**
     * @param User $user
     * @param \App\Model\Sewa\Sewa $sewa
     * @return bool
     */
    public function verifKepalaAdm(User $user, Sewa $sewa)
    {
        return in_array($sewa->id_sewa_status, [StatusSewa::DITERIMA_TK]) && ($user->isPusat() || $user->isAdminPusat());
    }

    /**
     * @param User $user
     * @param \App\Model\Sewa\Sewa $sewa
     * @return bool
     */
    public function dispoKepalaSub(User $user, Sewa $sewa)
    {
        return in_array($sewa->id_sewa_status, [StatusSewa::DITERIMA_ADM]) && ($user->isPusat() || $user->isAdminPusat());
    }

    /**
     * @param User $user
     * @param \App\Model\Sewa\Sewa $sewa
     * @return bool
     */
    public function selesai(User $user, Sewa $sewa)
    {
        return in_array($sewa->id_sewa_status, [StatusSewa::PROSES]) && ($user->isPusat() || $user->isAdminPusat());
    }

    /**
     * @param User $user
     * @param \App\Model\Sewa\Sewa $sewa
     * @return bool
     */
    public function tindakLanjut(User $user, Sewa $sewa)
    {
        return in_array($sewa->id_sewa_status, [StatusSewa::MENUNGGU]) && $sewa->id_satker == $user->id_satker && ($user->isSatker() || $user->isAdminSatker());
    }
}
