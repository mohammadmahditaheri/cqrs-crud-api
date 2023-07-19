<?php


use App\Http\Controllers\V1\Queries\GetCustomersListController;
use Illuminate\Support\Facades\Route;

Route::name('queries.')->group(function () {
    // get customers
    Route::get('/customers', GetCustomersListController::class)
        ->name('customers.index');

    // get customer by id
    Route::get('/customers/{customer}', \App\Http\Controllers\V1\Queries\ShowCustomerController::class)
        ->whereNumber('customer')
        ->name('customers.show');
});
