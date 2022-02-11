<?php
namespace App\Repositories\Permission;

use Illuminate\Support\Facades\Auth;

class PermissionHelper {

    private $data;
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();

        if($this->user){
            $this->data = $this->user->role()->with(['permission' => function($query){
                $query->select('name');
            }])->get()->map(function($value){
                return $value->permission->pluck('name');
            })->flatten();
        }

    }

    /**
     * Return true if permission accept
     *
     * @param $param
     * @param bool|false $exception
     * @return bool
     */
    public function can($param, $exception = false)
    {
        return $this->checked($param, $exception);
    }

    /**
     * Access permission and return Exception
     *
     * @param $param
     * @param bool|false $exception
     */
    public function access($param, $exception = false)
    {
        if(!$this->checked($param, $exception)){
            dd('denied');
            //throw new PermissionDeniedException;
        }
    }

    public function hasRole($role, $exception = false){
//        return $role == $this->user->role->slug;
    }

    /**
     * Logic for checking parameter
     *
     * @param $param
     * @param $exception
     * @return bool
     */
    private function checked($param, $exception)
    {
        if($this->user && $this->user->isSuperAdmin()){
            return true;
        }

        if (is_string($param))
        {
            return $this->checking($param);
        } else
        {
            foreach ($param as $value)
            {
                $data = $this->checking($value);
                if ($exception)
                {
                    if (!$data)
                    {
                        return false;
                    }
                } else
                {
                    if ($data)
                    {
                        return true;
                    }
                }
            }

            return $exception ? true : false;
        }
    }

    /**
     * Checking permission to database
     *
     * @param $param
     * @return bool
     */
    private function checking($param)
    {
        $data = $this->data->contains($param);

        return $data;
    }
}