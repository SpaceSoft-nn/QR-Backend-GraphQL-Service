<?php

namespace App\Modules\Subscription\App\Providers;

use App\Modules\Subscription\App\Data\Policies\SubscriptionPolicy;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class SubscriptionServiceProvider extends ServiceProvider
{
    public function register(): void { }


    public function boot(): void
    {
        Gate::policy(SubscriptionPlan::class, SubscriptionPolicy::class);
        if($this->app->runningInConsole()){

            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations");
            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations" . "/Tariff");

        }
    }
}
