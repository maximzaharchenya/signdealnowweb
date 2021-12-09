<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('manage', 'App\Policies\UserPolicy@canManage');
        Gate::define('inDeal', 'App\Policies\UserPolicy@userInDeal');

        Passport::routes();
    }
}
