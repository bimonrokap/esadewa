<?php

namespace App\Providers;

use App\Model\CategoryAsset;
use App\Model\Config;
use App\Model\Menu;
use App\Model\Role;
use App\Repositories\Permission\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ComposerServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('template.admin.toolbar',
            function ($view) {
                $user = Auth::user();

                $listLingkungan = ["PN" => "Peradilan Umum", "PA" => "Peradilan Agama", "PM" => "Peradilan Militer", "PT" => "Peradilan Tata Usaha", "PMT" => "Peradilan Militer & Tata Usaha"];
                if(in_array($user->id_role, [Role::ADMIN_SATKER, Role::SATKER]) ) {
                    $titleUser = $user->satker->name . ' ('.$user->role->name.')';
                } else if(in_array($user->id_role, [Role::ADMIN_TINGKAT_BANDING, Role::TINGKAT_BANDING]) ) {
                    $titleUser = $user->wilayah->name . ' - ' . $listLingkungan[$user->lingkungan] . ' ('.$user->role->name.')';
                } else if(in_array($user->id_role, [Role::ADMIN_KORWIL, Role::KORWIL]) ) {
                    $titleUser = $user->wilayah->name . ' ('.$user->role->name.')';
                } else if(in_array($user->id_role, [Role::ADMIN_ESELON, Role::ESELON]) ) {
                    $titleUser = $listLingkungan[$user->lingkungan] . ' ('.$user->role->name.')';
                } else {
                    $titleUser = $user->role->name;
                }

                $view->with(['user' => $user, 'titleUser' => $titleUser]);
            }
        );
        View::composer('template.admin.leftmenu',
            function ($view) {
                $curRoute = explode('.', \Request::route()->getName());
                $curRoute = array_slice($curRoute, 0, 3);

                $aboutApps = Config::where('name', 'about_apps')->first();
                $view->with(['menus' => self::generateMenuAsset(), 'addon' => self::generateMenu('left'), 'curRoute' => $curRoute, 'aboutApps' => $aboutApps]);
            }
        );
        View::composer('template.admin.horizontalmenu',
            function ($view) {
                $canCreateBackupSimak = Permission::can('create-simak') && !Auth::user()->isSuperAdmin();

                $view->with(['menus' => self::generateMenu(), 'canCreateBackupSimak' => $canCreateBackupSimak]);
            }
        );
        View::composer('components.form.modalLaporBmn',
            function ($view) {
                $data['uuid'] = Str::uuid();

                $view->with($data);
            }
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * @return array
     */
    private function generateMenu($position = 'top')
    {
        if(Auth::check()) {
            $user = Auth::user();

            $permission = $user->role()->with(['permission' => function ($query) {
                $query->select('menu_id')->where('permission_group_id', 1);
            }])->get()->map(function ($value) {
                return $value->permission->pluck('menu_id');;
            })->flatten()->toArray();

            $menus = Menu::select(['id', 'id_parent', 'route', 'icon', 'name', 'title', 'weight', 'type'])
                ->with('allChildren')
                ->whereWeight(0)
                ->whereActive(1)
                ->wherePosition($position)
                ->orderBy('weight')
                ->orderBy('order')
                ->get()
                ->toArray();

            $menu = $menus;
            if(!$user->isSuperAdmin()) {
                foreach ($menu as $key => $row) {
                    if(empty($row['all_children'])) {
                        if(!in_array($row['id'], $permission)) {
                            unset($menu[ $key ]);
                        }
                    } else {
                        foreach ($row['all_children'] as $kChild => $child) {
                            if(!in_array($child['id'], $permission)) {
                                unset($menu[ $key ]['all_children'][ $kChild ]);
                            }
                        }
                        if(empty($menu[ $key ]['all_children'])) {
                            unset($menu[ $key ]);
                        }
                    }
                }
            }

            return $menu;
        }
    }

    /**
     * @return array
     */
    private function generateMenuAsset()
    {
        $menus = CategoryAsset::whereActive(1)->get()->toArray();

        return $menus;
    }
}
