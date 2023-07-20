<?php

namespace App\Traits\Controllers;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

trait FormatsCustomerCommandResponses
{
    use FormatsCommandResponse;

    public static string $createdMessage = 'Customer created successfully.';
    public static string $updatedMessage = 'Customer updated successfully.';
    public static string $deletedMessage = 'Customer deleted successfully.';

    /**
     * Formats successful create response
     */
    protected function createdSuccessfully(): Response
    {
        return $this->successfulCommandResponse(
            message: self::$createdMessage,
            code: SymfonyResponse::HTTP_CREATED
        );
    }

    /**
     * Formats successful update response
     */
    protected function updatedSuccessfully(): Response
    {
        return $this->successfulCommandResponse(
            message: self::$updatedMessage
        );
    }

    /**
     * Formats successful delete response
     */
    protected function deletedSuccessfully(): Response
    {
        return $this->successfulCommandResponse(
            message: self::$deletedMessage,
            code: SymfonyResponse::HTTP_NO_CONTENT
        );
    }
}
