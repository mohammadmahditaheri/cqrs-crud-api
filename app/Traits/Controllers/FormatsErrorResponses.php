<?php

namespace App\Traits\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

trait FormatsErrorResponses
{
    /**
     * formats error command response with proper message and status code
     *
     * @param string $message
     * @param int $code
     * @throws HttpResponseException
     */
    protected function errorResponse(
        string $message,
        int $code = SymfonyResponse::HTTP_NOT_FOUND
    ): HttpResponseException
    {
        throw new HttpResponseException(
            response([
                'message' => $message
            ], $code)
        );
    }
}
