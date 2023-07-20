<?php

namespace App\Providers\Commands;

use App\Commands\CreateCustomerHandler;
use App\Contracts\Commands\CreateCustomerHandlerInterface;
use Illuminate\Support\ServiceProvider;

class CreateCustomerCommandProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            CreateCustomerHandlerInterface::class,
            CreateCustomerHandler::class
        );
    }
}
