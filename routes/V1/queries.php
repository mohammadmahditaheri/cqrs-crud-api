<?php


use App\Http\Controllers\V1\Queries\GetCustomerListController;
use App\Http\Controllers\V1\Queries\ShowCustomerController;
use Illuminate\Support\Facades\Route;

Route::name('queries.')->group(function () {
    // get customers
    Route::get('/customers', GetCustomerListController::class)
        ->name('customers.index');

    // get customer by id
    Route::get('/customers/{customer}', ShowCustomerController::class)
        ->whereNumber('customer')
        ->middleware('customer_exists')
        ->name('customers.show');
});
