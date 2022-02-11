<?php

namespace App\Policies\Asset;

use App\Model\Asset\AssetRumahNegara;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetRumahNegaraPolicy
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
     * @param AssetRumahNegara $asset
     * @return bool
     */
    public function edit(User $user, AssetRumahNegara $asset)
    {
        if($user->id_satker != null) {
            return $asset->kode_satker == $user->satker->kode;
        }

        return false;
    }
}
