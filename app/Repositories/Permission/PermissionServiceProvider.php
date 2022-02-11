<?php

namespace App\Repositories\Permission;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('permission', function($expression) {
            return "<?php if (\\Permission::can({$expression})) : ?>";
        });

        Blade::directive('endpermission', function() {
            return "<?php endif; // Permission::can ?>";
        });

        // Call to Entrust::hasRole
        \Blade::directive('role', function($expression) {
            return "<?php if (\\Permission::hasRole({$expression})) : ?>";
        });
        \Blade::directive('endrole', function() {
            return "<?php endif; // Permission::hasRole ?>";
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('permission', function()
        {
            return new \App\Repositories\Permission\PermissionHelper;
        });
    }
}
