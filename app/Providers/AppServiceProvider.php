<?php

namespace App\Providers;

use App\Domain\Repository\Movie\MovieRepositoryInterface;
use App\Infrastructure\Repository\Movie\EloquentMovieRepository;
use App\Infrastructure\Repository\Movie\NullMovieRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MovieRepositoryInterface::class, EloquentMovieRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
