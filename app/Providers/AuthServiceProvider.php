<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model\Penjualan\Penjualan'        => 'App\Policies\Pengelolaan\PenjualanPolicy',
        'App\Model\Sewa\Sewa'                  => 'App\Policies\Pengelolaan\SewaPolicy',
        'App\Model\Bongkaran\Bongkaran'        => 'App\Policies\Pengelolaan\BongkaranPolicy',
        'App\Model\Penghapusan\Penghapusan'    => 'App\Policies\Pengelolaan\PenghapusanPolicy',
        'App\Model\Pengadaan\Usulan\Pengadaan' => 'App\Policies\Pengadaan\PengadaanPolicy',

        'App\Model\Asset\AssetTanah'          => 'App\Policies\Asset\AssetTanahPolicy',
        'App\Model\Asset\AssetAlatBermotor'   => 'App\Policies\Asset\AssetAlatBermotorPolicy',
        'App\Model\Asset\AssetBangunanGedung' => 'App\Policies\Asset\AssetBangunanGedungPolicy',
        'App\Model\Asset\AssetRumahNegara'    => 'App\Policies\Asset\AssetRumahNegaraPolicy',

        'App\Model\LaporBmn\LaporBmn' => 'App\Policies\LaporBmnPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
