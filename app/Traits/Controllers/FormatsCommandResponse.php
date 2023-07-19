<?php

namespace App\Traits\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

trait FormatsCommandResponse
{
    /**
     * formats successful command response with proper message and status code
     *
     * @param string $message
     * @param int $code
     * @return Response
     */
    protected function successfulCommandResponse(
        string $message,
        int $code = SymfonyResponse::HTTP_OK,
    ): Response
    {
        return response([
            'message' => $message
        ], $code);
    }
}
