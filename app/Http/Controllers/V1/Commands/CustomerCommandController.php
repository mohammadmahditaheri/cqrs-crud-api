<?php

namespace App\Http\Controllers\V1\Commands;

use App\Commands\CreateCustomerHandler;
use App\Commands\DeleteCustomerHandler;
use App\Commands\UpdateCustomerHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Commands\MutateCustomerRequest;
use App\Traits\Controllers\FormatsCustomerCommandResponses;
use App\Traits\Controllers\FormatsErrorResponses;
use App\Traits\Controllers\FormatsQueryResponses;
use App\Traits\Controllers\ThrowsServerError;
use Illuminate\Http\Response;


/**
 * @group Commands
 *
 * Create, Update and Delete customers
 */
class CustomerCommandController extends Controller
{
    use FormatsCustomerCommandResponses,
        FormatsQueryResponses,
        FormatsErrorResponses,
        ThrowsServerError;

    /**
     * Create customer
     *
     * Store a newly created resource in storage.
     *
     * @header Accept application/json
     * @header Content-Type application/json
     *
     * @response 201 {"message": "Customer created successfully."}
     */
    public function store(
        MutateCustomerRequest $request, CreateCustomerHandler $handler
    ): Response
    {
        $result = $handler->handle($request->validated());

        if (!$result) {
            throw $this->serverError();
        }

        return $this->createdSuccessfully();
    }

    /**
     * Update customer
     *
     * Update the specified resource in storage.
     *
     * @header Accept application/json
     * @header Content-Type application/json
     *
     * @response 200 {"message": "Customer updated successfully."}
     */
    public function update(
        MutateCustomerRequest $request,
        int $customerId,
        UpdateCustomerHandler $handler
    ): Response
    {
        $result = $handler->handle(
            customerId: $customerId,
            newData: $request->validated()
        );

        if (!$result) {
            throw $this->serverError();
        }

        return $this->updatedSuccessfully();
    }

    /**
     * Delete customer
     *
     * Remove the specified resource from storage.
     *
     * @header Accept application/json
     * @header Content-Type application/json
     *
     * @response 200 {"message": "Customer deleted successfully."}
     */
    public function destroy(
        string                $customerId,
        DeleteCustomerHandler $handler
    ): Response
    {
        $result = $handler->handle(
            customerId: $customerId
        );

        if (!$result) {
            throw $this->serverError();
        }

        return $this->deletedSuccessfully();
    }
}
