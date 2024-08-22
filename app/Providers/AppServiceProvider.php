<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('faPlusBit', '<i class="fa-solid fa-plus fa-beat fa-lg"></i>');

        $this->registerPolicies();
        Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });
    }
}
