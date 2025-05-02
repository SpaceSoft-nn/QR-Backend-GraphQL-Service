<?php

namespace App\Modules\Drivers\App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use App\Modules\Drivers\Common\Config\TochkaBank\TochkaBankQrCreateConfig;
use App\Modules\Drivers\Domain\Services\Adapter\TochkaBankServiceAdapter;
use App\Modules\Drivers\Domain\Services\TochkaBankService;

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

        // $this->app->bind(TochkaBankServiceAdapter::class, TochkaBankService::class);


    }
}
