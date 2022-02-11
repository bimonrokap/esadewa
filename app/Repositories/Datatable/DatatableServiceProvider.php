<?php

namespace App\Repositories\Datatable;

use Illuminate\Support\ServiceProvider;

class DatatableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('datatable', function()
        {
            return new \App\Repositories\Datatable\DatatableHelper;
        });
    }
}
