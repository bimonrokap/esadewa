<?php

namespace App\Policies\Pengadaan;

use App\Model\Pengadaan\Usulan\Pengadaan;
use App\Model\Pengadaan\Usulan\StatusPengadaan;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PengadaanPolicy
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
     * @param Pengadaan $pengadaan
     * @return bool
     */
    public function view(User $user, Pengadaan $pengadaan)
    {
        if($user->isAdminSatker() || $user->isSatker()) {
            return $pengadaan->user->id_satker == $user->id_satker;
        } else if($user->isAdminTingkatBanding() || $user->isTingkatBanding()) {
            return $pengadaan->user->satker->id_wilayah == $user->id_wilayah;
        }

        return true;
    }

    /**
     * @param User $user
     * @param Pengadaan $pengadaan
     * @return bool
     */
    public function edit(User $user, Pengadaan $pengadaan)
    {
        return in_array($pengadaan->id_pengadaan_status, [StatusPengadaan::PERMOHONAN_SATKER, StatusPengadaan::DITOLAK_TK]) && $pengadaan->id_satker == $user->id_satker && ($user->isSatker() || $user->isAdminSatker());
    }

    /**
     * @param User $user
     * @param \App\Model\Pengadaan\Usulan\Pengadaan $pengadaan
     * @return bool
     */
    public function verifTk(User $user, Pengadaan $pengadaan)
    {
        $idWilayah = null;
        if(isset($pengadaan->id_wilayah)) {
            $idWilayah = $pengadaan->id_wilayah;
        } else {
            $idWilayah = $pengadaan->user->satker->id_wilayah;
        }

        return in_array($pengadaan->id_pengadaan_status, [StatusPengadaan::PERMOHONAN_SATKER, StatusPengadaan::DITOLAK_ADM]) && ($user->isTingkatBanding() || $user->isAdminTingkatBanding()) && $idWilayah == $user->id_wilayah;
    }

    /**
     * @param User $user
     * @param \App\Model\Pengadaan\Usulan\Pengadaan $pengadaan
     * @return bool
     */
    public function verifKepalaAdm(User $user, Pengadaan $pengadaan)
    {
        return in_array($pengadaan->id_pengadaan_status, [StatusPengadaan::DITERIMA_TK]) && ($user->isPusat() || $user->isAdminPusat());
    }

    /**
     * @param User $user
     * @param \App\Model\Pengadaan\Usulan\Pengadaan $pengadaan
     * @return bool
     */
    public function dispoKepalaSub(User $user, Pengadaan $pengadaan)
    {
        return in_array($pengadaan->id_pengadaan_status, [StatusPengadaan::DITERIMA_ADM]) && ($user->isPusat() || $user->isAdminPusat());
    }

    /**
     * @param User $user
     * @param \App\Model\Pengadaan\Usulan\Pengadaan $pengadaan
     * @return bool
     */
    public function selesai(User $user, Pengadaan $pengadaan)
    {
        return in_array($pengadaan->id_pengadaan_status, [StatusPengadaan::PROSES]) && ($user->isPusat() || $user->isAdminPusat());
    }
}
