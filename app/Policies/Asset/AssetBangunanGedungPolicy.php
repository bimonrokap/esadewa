<?php

namespace App\Policies\Asset;

use App\Model\Asset\AssetBangunanGedung;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetBangunanGedungPolicy
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
     * @param AssetBangunanGedung $asset
     * @return bool
     */
    public function edit(User $user, AssetBangunanGedung $asset)
    {
        if($user->id_satker != null) {
            return $asset->kode_satker == $user->satker->kode;
        }

        return false;
    }
}
