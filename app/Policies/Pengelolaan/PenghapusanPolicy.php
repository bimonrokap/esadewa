<?php

namespace App\Policies\Pengelolaan;

use App\Model\Penghapusan\Penghapusan;
use App\Model\Penghapusan\StatusPenghapusan;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PenghapusanPolicy
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
     * @param Penghapusan $penghapusan
     * @return bool
     */
    public function view(User $user, Penghapusan $penghapusan)
    {
        if($user->isAdminSatker() || $user->isSatker()) {
            return $penghapusan->user->id_satker == $user->id_satker;
        } else if($user->isAdminTingkatBanding() || $user->isTingkatBanding()) {
            return $penghapusan->user->satker->id_wilayah == $user->id_wilayah;
        }

        return true;
    }

    /**
     * @param User $user
     * @param Penghapusan $penghapusan
     * @return bool
     */
    public function edit(User $user, Penghapusan $penghapusan)
    {
        return in_array($penghapusan->id_penghapusan_status, [StatusPenghapusan::PERMOHONAN_SATKER, StatusPenghapusan::DITOLAK_TK]) && $penghapusan->id_satker == $user->id_satker && ($user->isSatker() || $user->isAdminSatker());
    }

    /**
     * @param User $user
     * @param \App\Model\Penghapusan\Penghapusan $penghapusan
     * @return bool
     */
    public function verifTk(User $user, Penghapusan $penghapusan)
    {
        $idWilayah = null;
        if(isset($penghapusan->id_wilayah)) {
            $idWilayah = $penghapusan->id_wilayah;
        } else {
            $idWilayah = $penghapusan->user->satker->id_wilayah;
        }

        return in_array($penghapusan->id_penghapusan_status, [StatusPenghapusan::PERMOHONAN_SATKER, StatusPenghapusan::DITOLAK_ADM]) && ($user->isTingkatBanding() || $user->isAdminTingkatBanding()) && $idWilayah == $user->id_wilayah;
    }

    /**
     * @param User $user
     * @param \App\Model\Penghapusan\Penghapusan $penghapusan
     * @return bool
     */
    public function verifKepalaAdm(User $user, Penghapusan $penghapusan)
    {
        return in_array($penghapusan->id_penghapusan_status, [StatusPenghapusan::DITERIMA_TK]) && ($user->isPusat() || $user->isAdminPusat());
    }

    /**
     * @param User $user
     * @param \App\Model\Penghapusan\Penghapusan $penghapusan
     * @return bool
     */
    public function dispoKepalaSub(User $user, Penghapusan $penghapusan)
    {
        return in_array($penghapusan->id_penghapusan_status, [StatusPenghapusan::DITERIMA_ADM]) && ($user->isPusat() || $user->isAdminPusat());
    }

    /**
     * @param User $user
     * @param \App\Model\Penghapusan\Penghapusan $penghapusan
     * @return bool
     */
    public function selesai(User $user, Penghapusan $penghapusan)
    {
        return in_array($penghapusan->id_penghapusan_status, [StatusPenghapusan::PROSES]) && ($user->isPusat() || $user->isAdminPusat());
    }
}
