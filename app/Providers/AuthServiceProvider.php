<?php

namespace App\Providers;

use App\Permission;
use App\User;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Post' => 'App\Policies\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();

        //
        //门面控制权限
        /*$gate->define('show-post',function ($user,$post){
            return $user->owns($post);
            //return $user->id == $post->user_id;
        });*/

        //获取数据库的权限
        foreach ($this->getPermissions() as $permission) {
            $gate->define($permission->name, function (User $user) use ($permission) {
                return $user->hasRole($permission->roles);
            });
        }

    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected function getPermissions()
    {
        return Permission::with('roles')->get();  //拿到所有的permission和roles
    }

}
