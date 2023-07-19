<?php

namespace App\Http\Controllers\V1\Commands;

use App\Commands\CreateCustomerHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\MutateCustomerRequest;
use App\Traits\Controllers\FormatsCustomerCommandResponses;
use App\Traits\Controllers\FormatsErrorResponses;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class CustomerCommandsController extends Controller
{
    use FormatsErrorResponses,
        FormatsCustomerCommandResponses;

    public function store(MutateCustomerRequest $request, CreateCustomerHandler $handler): Response
    {
        $result = $handler->handle($request->validated());

        if (!$result) {
            throw $this->errorResponse(
                message: 'The requested operation failed',
                code: SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->createdSuccessfully();
    }

    public function update(): Response
    {
        // TODO
        return response(['data' => 'update test']);
    }

    public function delete(): Response
    {
        // TODOs
        return response(['data' => 'delete test']);
    }
}
