<?php

namespace App\Policies\Pengelolaan;

use App\Model\Bongkaran\Bongkaran;
use App\Model\Bongkaran\StatusBongkaran;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BongkaranPolicy
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
     * @param Bongkaran $bongkaran
     * @return bool
     */
    public function view(User $user, Bongkaran $bongkaran)
    {
        if($user->isAdminSatker() || $user->isSatker()) {
            return $bongkaran->user->id_satker == $user->id_satker;
        } else if($user->isAdminTingkatBanding() || $user->isTingkatBanding()) {
            return $bongkaran->user->satker->id_wilayah == $user->id_wilayah;
        }

        return true;
    }

    /**
     * @param User $user
     * @param Bongkaran $bongkaran
     * @return bool
     */
    public function edit(User $user, Bongkaran $bongkaran)
    {
        return in_array($bongkaran->id_bongkaran_status, [StatusBongkaran::PERMOHONAN_SATKER, StatusBongkaran::DITOLAK_TK]) && $bongkaran->id_satker == $user->id_satker && ($user->isSatker() || $user->isAdminSatker());
    }

    /**
     * @param User $user
     * @param \App\Model\Bongkaran\Bongkaran $bongkaran
     * @return bool
     */
    public function verifTk(User $user, Bongkaran $bongkaran)
    {
        $idWilayah = null;
        if(isset($bongkaran->id_wilayah)) {
            $idWilayah = $bongkaran->id_wilayah;
        } else {
            $idWilayah = $bongkaran->user->satker->id_wilayah;
        }

        return in_array($bongkaran->id_bongkaran_status, [StatusBongkaran::PERMOHONAN_SATKER, StatusBongkaran::DITOLAK_ADM]) && ($user->isTingkatBanding() || $user->isAdminTingkatBanding()) && $idWilayah == $user->id_wilayah;
    }

    /**
     * @param User $user
     * @param \App\Model\Bongkaran\Bongkaran $bongkaran
     * @return bool
     */
    public function verifKepalaAdm(User $user, Bongkaran $bongkaran)
    {
        return in_array($bongkaran->id_bongkaran_status, [StatusBongkaran::DITERIMA_TK]) && ($user->isPusat() || $user->isAdminPusat());
    }

    /**
     * @param User $user
     * @param \App\Model\Bongkaran\Bongkaran $bongkaran
     * @return bool
     */
    public function dispoKepalaSub(User $user, Bongkaran $bongkaran)
    {
        return in_array($bongkaran->id_bongkaran_status, [StatusBongkaran::DITERIMA_ADM]) && ($user->isPusat() || $user->isAdminPusat());
    }

    /**
     * @param User $user
     * @param \App\Model\Bongkaran\Bongkaran $bongkaran
     * @return bool
     */
    public function selesai(User $user, Bongkaran $bongkaran)
    {
        return in_array($bongkaran->id_bongkaran_status, [StatusBongkaran::PROSES]) && ($user->isPusat() || $user->isAdminPusat());
    }

    /**
     * @param User $user
     * @param \App\Model\Bongkaran\Bongkaran $bongkaran
     * @return bool
     */
    public function tindakLanjut(User $user, Bongkaran $bongkaran)
    {
        return in_array($bongkaran->id_bongkaran_status, [StatusBongkaran::MENUNGGU]) && $bongkaran->id_satker == $user->id_satker && ($user->isSatker() || $user->isAdminSatker());
    }
}
