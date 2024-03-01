<?php

namespace App\Providers;

use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\SaleRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\SaleRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
