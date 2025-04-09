<?php

namespace App\Modules\Pivot\App\Providers;

use Illuminate\Support\ServiceProvider;

class PivotServiceProvider extends ServiceProvider
{
    public function register(): void { }


    public function boot(): void
    {
        if($this->app->runningInConsole()){

            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations");

        }
    }
}
