<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function (User $user){
            foreach ($user->roles()->get() as $role){
                if($role->name == "admin"){
                    return Response::allow();
                }
            }
            return Response::deny();
        });

        Gate::define('teacher', function (User $user){
            foreach ($user->roles()->get() as $role){
                if($role->name == "teacher"){
                    return Response::allow();
                }
            }
            return Response::deny();
        });

        Gate::define('user', function (User $user){
            foreach ($user->roles()->get() as $role){
                if($role->name == "user"){
                    return Response::allow();
                }
            }
            return Response::deny();
        });
    }
}
