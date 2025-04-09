<?php

namespace App\Modules\Organization\App\Providers;

use App\Modules\Organization\App\Repositories\OrganizationRepository;
use App\Modules\Organization\Domain\Interface\Repositories\IRepository;
use Illuminate\Support\ServiceProvider;

class OrganizationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // $this->app->bind(IRepository::class, OrganizationRepository::class);
    }

    public function boot(): void
    {
        if($this->app->runningInConsole()){

            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations");

        }
    }
}
