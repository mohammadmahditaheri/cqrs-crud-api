<?php

namespace App\Providers\Queries;

use App\Contracts\Queries\QueryInterface;
use App\Contracts\Repositories\CustomerRepositoryInterface;
use App\Http\Controllers\V1\Queries\GetCustomerListController;
use App\Http\Controllers\V1\Queries\ShowCustomerController;
use App\Queries\GetCustomersListQuery;
use App\Queries\GetSingleCustomerQuery;
use Illuminate\Support\ServiceProvider;

class GetCustomerQueryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // ShowCustomerController
        $this->app->when(ShowCustomerController::class)
            ->needs(QueryInterface::class)
            ->give(function () {
                return $this->app->make(GetSingleCustomerQuery::class, [
                    'customerId' => request()->route('customer'),
                    'repository' => resolve(CustomerRepositoryInterface::class)
                ]);
            });

        // GetCustomerListController
        $this->app->when(GetCustomerListController::class)
            ->needs(QueryInterface::class)
            ->give(function () {
                return $this->app->make(GetCustomersListQuery::class, [
                    'repository' => resolve(CustomerRepositoryInterface::class)
                ]);
            });
    }
}
