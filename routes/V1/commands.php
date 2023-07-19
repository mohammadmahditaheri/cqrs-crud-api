<?php

/*
|--------------------------------------------------------------------------
| Command Routes (C in CQRS)
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\V1\Commands\CustomerCommandsController;
use Illuminate\Support\Facades\Route;


Route::name('commands.')->group(function () {
    // create customer
    Route::post('/customers', [CustomerCommandsController::class, 'store'])
        ->name('customers.create');

    // update customer
    Route::put('/customers/{customer}', [CustomerCommandsController::class, 'update'])
        ->whereNumber('customer')
        ->name('customers.update')
        ->middleware(['customer_exists']);

    // delete customer
    Route::delete('customers/{customer}', [CustomerCommandsController::class, 'destroy'])
        ->whereNumber('customer')
        ->name('customers.delete')
        ->middleware(['customer_exists']);
});

