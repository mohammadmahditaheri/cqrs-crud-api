<?php

namespace App\Providers;

use App\Providers\Commands\CreateCustomerCommandProvider;
use App\Providers\Commands\DeleteCustomerCommandProvider;
use App\Providers\Commands\UpdateCustomerCommandProvider;
use App\Providers\Queries\GetCustomerQueryProvider;
use App\Providers\Repositories\CustomerRepositoryProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(CustomerRepositoryProvider::class);

        // query providers
        $this->app->register(GetCustomerQueryProvider::class);

        // command providers
        $this->app->register(CreateCustomerCommandProvider::class);
        $this->app->register(UpdateCustomerCommandProvider::class);
        $this->app->register(DeleteCustomerCommandProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
