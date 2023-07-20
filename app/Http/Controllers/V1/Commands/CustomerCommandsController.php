<?php

namespace App\Http\Controllers\V1\Commands;

use App\Commands\CreateCustomerHandler;
use App\Commands\UpdateCustomerHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\MutateCustomerRequest;
use App\Traits\Controllers\FormatsCustomerCommandResponses;
use App\Traits\Controllers\FormatsErrorResponses;
use App\Traits\Controllers\ThrowsServerError;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

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

    public function delete(): Response
    {
        // TODOs
        return response(['data' => 'delete test']);
    }
}
