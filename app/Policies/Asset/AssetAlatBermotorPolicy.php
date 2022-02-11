<?php

namespace App\Policies\Asset;

use App\Model\Asset\AssetAlatBermotor;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetAlatBermotorPolicy
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
     * @param AssetAlatBermotor $asset
     * @return bool
     */
    public function edit(User $user, AssetAlatBermotor $asset)
    {
        if($user->id_satker != null) {
            return $asset->kode_satker == $user->satker->kode;
        }

        return false;
    }
}
