<?php

namespace App\Providers;

use App\Interfaces\FilesRepositoryInterface;
use App\Interfaces\RequestUploadRepositoryInterface;
use App\Repositories\FilesRepository;
use App\Repositories\RequestUploadRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RequestUploadRepositoryInterface::class,RequestUploadRepository::class);
        $this->app->bind(FilesRepositoryInterface::class, FilesRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
