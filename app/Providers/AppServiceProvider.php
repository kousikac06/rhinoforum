<?php

namespace App\Providers;

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
        $this->app->bind(
            \App\Repositories\User\UserRepository::class,
            \App\Repositories\User\UserRepositoryEloquent::class
        );
        $this->app->bind(
            \App\Repositories\Post\PostRepository::class,
            \App\Repositories\Post\PostRepositoryEloquent::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
