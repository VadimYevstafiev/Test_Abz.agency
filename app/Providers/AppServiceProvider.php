<?php

namespace App\Providers;

use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\UserRepository;
use App\Services\AvatarStorageService;
use App\Services\Contracts\FileStorageServiceContract;
use App\Services\FileStorageService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        UserRepositoryContract::class => UserRepository::class,
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if(config('app.env') === 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }
        $this->app->when(UserRepository::class)
            ->needs(FileStorageServiceContract::class)
            ->give(AvatarStorageService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
