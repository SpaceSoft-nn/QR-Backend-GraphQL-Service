<?php

namespace App\Modules\PersonalArea\App\Providers;

use Illuminate\Support\ServiceProvider;

class PersonalAreaServiceProvider extends ServiceProvider
{
    public function register(): void { }


    public function boot(): void
    {
        if($this->app->runningInConsole()){

            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations");

        }
    }
}
