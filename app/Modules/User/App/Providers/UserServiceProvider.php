<?php

namespace App\Modules\User\App\Providers;

use App\Modules\User\Domain\Interface\Service\IUserService;
use App\Modules\User\Domain\Services\UserService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Привязка интерфейса IUserService к его реализации UserService
        // $this->app->bind(IUserService::class, UserService::class);
    }

    public function boot(): void
    {
        if($this->app->runningInConsole()){

            //меняем стандартьный путь laravel к папке Factories P.S Если будет ещё модель может быть проблема
            // Factory::guessFactoryNamesUsing(function (string $modelName) {
            //     return 'App\\Modules\\' . class_basename($modelName) . '\\Domain\\Factories\\' . class_basename($modelName) . 'Factory';
            // });

            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations");

        }
    }
}
