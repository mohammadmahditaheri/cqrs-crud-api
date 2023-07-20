<?php

/*
|--------------------------------------------------------------------------
| Command Routes (C in CQRS)
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\V1\Commands\CustomerCommandController;
use Illuminate\Support\Facades\Route;


Route::name('commands.')->group(function () {
    // create customer
    Route::post('/customers', [CustomerCommandController::class, 'store'])
        ->name('customers.create');

    Route::middleware(['customer_exists'])->group(function () {
        // update customer
        Route::put('/customers/{customer}', [CustomerCommandController::class, 'update'])
            ->whereNumber('customer')
            ->name('customers.update');

        // delete customer
        Route::delete('customers/{customer}', [CustomerCommandController::class, 'destroy'])
            ->whereNumber('customer')
            ->name('customers.delete');
    });

});

