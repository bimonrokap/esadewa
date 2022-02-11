<?php

namespace App\Policies\Asset;

use App\Model\Asset\AssetTanah;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetTanahPolicy
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
     * @param AssetTanah $asset
     * @return bool
     */
    public function edit(User $user, AssetTanah $asset)
    {
        if($user->id_satker != null) {
            return $asset->kode_satker == $user->satker->kode;
        }

        return false;
    }
}
