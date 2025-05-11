<?php

namespace App\Modules\PersonalArea\App\Providers;

use App\Modules\PersonalArea\App\Policies\PersonalAreaPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;

class PersonalAreaServiceProvider extends ServiceProvider
{
    public function register(): void { }


    public function boot(): void
    {
        Gate::policy(PersonalArea::class, PersonalAreaPolicy::class);

        if($this->app->runningInConsole()){

            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations");

        }
    }
}
