<?php

namespace App\Traits\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

trait ThrowsServerError
{
    use FormatsErrorResponses;

    /**
     * @param string $message
     * @param int $code
     * @throws HttpResponseException
     */
    public function serverError(
        string $message = 'The requested operation failed',
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR
    )
    {
        throw $this->errorResponse(
            message: $message,
            code: $code
        );
    }


}
