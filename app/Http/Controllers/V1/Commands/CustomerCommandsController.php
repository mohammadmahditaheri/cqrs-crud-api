<?php

namespace App\Http\Controllers\V1\Commands;

use App\Commands\CreateCustomerHandler;
use App\Commands\DeleteCustomerHandler;
use App\Commands\UpdateCustomerHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Commands\MutateCustomerRequest;
use App\Traits\Controllers\FormatsCustomerCommandResponses;
use App\Traits\Controllers\FormatsErrorResponses;
use App\Traits\Controllers\ThrowsServerError;
use Illuminate\Http\Response;

class CustomerCommandsController extends Controller
{
    use FormatsErrorResponses,
        FormatsCustomerCommandResponses,
        ThrowsServerError;

    /**
     * store a new customer in repository
     */
    public function store(MutateCustomerRequest $request, CreateCustomerHandler $handler): Response
    {
        $result = $handler->handle($request->validated());

        if (!$result) {
            throw $this->serverError();
        }

        return $this->createdSuccessfully();
    }

    /**
     * update an existing resource in repository
     */
    public function update(int $customerId, MutateCustomerRequest $request, UpdateCustomerHandler $handler): Response
    {
        $result = $handler->handle($customerId, $request->validated());

        if (!$result) {
            throw $this->serverError();
        }

        return $this->updatedSuccessfully();
    }

    /**
     * Remove the specified resource from storage.
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
