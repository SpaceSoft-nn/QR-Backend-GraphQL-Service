<?php

namespace App\Modules\Drivers\App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use App\Modules\Drivers\Common\Config\TochkaBank\TochkaBankQrCreateConfig;

class DriversServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {

        $this->app->scoped(TochkaBankQrCreateConfig::class, function (Application $app) {
            //создаём стандартный config
            return TochkaBankQrCreateConfig::make();
        });

        // if($this->app->runningInConsole()){


        //     $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations");

        // }
    }
}
