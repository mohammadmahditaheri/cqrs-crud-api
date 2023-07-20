<?php

namespace App\Providers\Commands;

use App\Commands\UpdateCustomerHandler;
use App\Contracts\Commands\UpdateCustomerHandlerInterface;
use Illuminate\Support\ServiceProvider;

class UpdateCustomerCommandProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UpdateCustomerHandlerInterface::class,
            UpdateCustomerHandler::class
        );
    }
}
