<?php

namespace App\Providers;

use App\Exceptions\Handler;
use App\Repositories\ReviewRepository;
use App\Repositories\ReviewRepositoryInterface;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->app->bind(ExceptionHandler::class, Handler::class);
    }

    public function boot(): void
    {
        //
    }
}
