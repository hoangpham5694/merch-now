<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
         $this->app->bind(\App\Repositories\ColorRepository::class, \App\Repositories\ColorRepositoryEloquent::class);
         $this->app->bind(\App\Repositories\ShirtRepository::class, \App\Repositories\ShirtRepositoryEloquent::class);
         $this->app->bind(\App\Repositories\AccountRepository::class, \App\Repositories\AccountRepositoryEloquent::class);
         $this->app->bind(\App\Repositories\VpsRepository::class, \App\Repositories\VpsRepositoryEloquent::class);
    }
}
