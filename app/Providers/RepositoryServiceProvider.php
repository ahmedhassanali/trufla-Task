<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\BaseRepositoryInterface;
use App\Repositories\Eloquent\OrderProductRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\OrderProductRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseRepositoryInterface::class,BaseRepository::class);
        $this->app->bind(OrderRepositoryInterface::class,OrderRepository::class);
        $this->app->bind(ProductRepositoryInterface::class,ProductRepository::class);
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
       
    }
}
