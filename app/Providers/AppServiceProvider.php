<?php

namespace App\Providers;

use App\Modules\Workspace\App\Policies\WorkspacePolicy;
use App\Modules\Workspace\Domain\Models\Workspace;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
   
    public function register(): void
    {
        //
    }


    public function boot(): void
    {

    }
}
