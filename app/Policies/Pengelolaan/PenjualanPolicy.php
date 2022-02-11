<?php

namespace App\Policies\Pengelolaan;

use App\Model\Penjualan\Penjualan;
use App\Model\Penjualan\StatusPenjualan;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PenjualanPolicy
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
     * @param Penjualan $penjualan
     * @return bool
     */
    public function view(User $user, Penjualan $penjualan)
    {
        if($user->isAdminSatker() || $user->isSatker()) {
            return $penjualan->user->id_satker == $user->id_satker;
        } else if($user->isAdminTingkatBanding() || $user->isTingkatBanding()) {
            return $penjualan->user->satker->id_wilayah == $user->id_wilayah;
        }

        return true;
    }

    /**
     * @param User $user
     * @param Penjualan $penjualan
     * @return bool
     */
    public function edit(User $user, Penjualan $penjualan)
    {
        return in_array($penjualan->id_penjualan_status, [StatusPenjualan::PERMOHONAN_SATKER, StatusPenjualan::DITOLAK_TK]) && $penjualan->id_satker == $user->id_satker && ($user->isSatker() || $user->isAdminSatker());
    }

    /**
     * @param User $user
     * @param \App\Model\Penjualan\Penjualan $penjualan
     * @return bool
     */
    public function verifTk(User $user, Penjualan $penjualan)
    {
        $idWilayah = null;
        if(isset($penjualan->id_wilayah)) {
            $idWilayah = $penjualan->id_wilayah;
        } else {
            $idWilayah = $penjualan->user->satker->id_wilayah;
        }

        return in_array($penjualan->id_penjualan_status, [StatusPenjualan::PERMOHONAN_SATKER, StatusPenjualan::DITOLAK_ADM]) && ($user->isTingkatBanding() || $user->isAdminTingkatBanding()) && $idWilayah == $user->id_wilayah;
    }

    /**
     * @param User $user
     * @param \App\Model\Penjualan\Penjualan $penjualan
     * @return bool
     */
    public function verifKepalaAdm(User $user, Penjualan $penjualan)
    {
        return in_array($penjualan->id_penjualan_status, [StatusPenjualan::DITERIMA_TK]) && ($user->isPusat() || $user->isAdminPusat());
    }

    /**
     * @param User $user
     * @param \App\Model\Penjualan\Penjualan $penjualan
     * @return bool
     */
    public function dispoKepalaSub(User $user, Penjualan $penjualan)
    {
        return in_array($penjualan->id_penjualan_status, [StatusPenjualan::DITERIMA_ADM]) && ($user->isPusat() || $user->isAdminPusat());
    }

    /**
     * @param User $user
     * @param \App\Model\Penjualan\Penjualan $penjualan
     * @return bool
     */
    public function selesai(User $user, Penjualan $penjualan)
    {
        return in_array($penjualan->id_penjualan_status, [StatusPenjualan::PROSES]) && ($user->isPusat() || $user->isAdminPusat());
    }
}
