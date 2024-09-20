<?php

namespace App\Providers;

use App\Interfaces\RequestsUploadRepositoryInterface;
use App\Repositories\RequestsUploadRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RequestsUploadRepositoryInterface::class,RequestsUploadRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
