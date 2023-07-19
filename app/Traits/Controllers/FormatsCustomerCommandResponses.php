<?php

namespace App\Traits\Controllers;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

trait FormatsCustomerCommandResponses
{
    use FormatsCommandResponse;

    private string $createdMessage = 'Customer created successfully.';
    private string $updatedMessage = 'Customer updated successfully.';
    private string $deletedMessage = 'Customer deleted successfully.';

    /**
     * Formats successful create response
     */
    protected function createdSuccessfully(): Response
    {
        return $this->successfulCommandResponse(
            message: $this->createdMessage,
            code: SymfonyResponse::HTTP_CREATED
        );
    }

    /**
     * Formats successful update response
     */
    protected function updatedSuccessfully(): Response
    {
        return $this->successfulCommandResponse(
            message: $this->updatedMessage
        );
    }

    /**
     * Formats successful delete response
     */
    protected function deletedSuccessfully(): Response
    {
        return $this->successfulCommandResponse(
            message: $this->deletedMessage,
            code: SymfonyResponse::HTTP_NO_CONTENT
        );
    }
}
