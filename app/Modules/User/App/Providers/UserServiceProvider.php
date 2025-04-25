<?php

namespace App\Modules\User\App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\App\Policies\UserPolicy;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {

        Gate::policy(User::class, UserPolicy::class);

        if($this->app->runningInConsole()){



            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations");

        }
    }
}
