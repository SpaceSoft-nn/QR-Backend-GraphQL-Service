<?php

namespace App\Modules\Workspace\App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Modules\Workspace\Domain\Models\Workspace;
use App\Modules\Workspace\App\Policies\WorkspacePolicy;

class WorkspaceServiceProvider extends ServiceProvider
{


    public function register(): void
    {

    }

    public function boot(): void
    {

        Gate::policy(Workspace::class, WorkspacePolicy::class);
        if($this->app->runningInConsole()){
            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations");
        }
    }
}
