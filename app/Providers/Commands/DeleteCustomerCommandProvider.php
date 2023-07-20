<?php

namespace App\Providers\Commands;

use App\Commands\DeleteCustomerHandler;
use App\Contracts\Commands\DeleteCustomerHandlerInterface;
use Illuminate\Support\ServiceProvider;

class DeleteCustomerCommandProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            DeleteCustomerHandlerInterface::class,
            DeleteCustomerHandler::class
        );
    }
}
