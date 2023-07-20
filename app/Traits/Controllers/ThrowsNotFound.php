<?php

namespace App\Traits\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

trait ThrowsNotFound
{
    use FormatsErrorResponses;

    /**
     * @param string $message
     * @param int $code
     * @throws HttpResponseException
     */
    public function notFound(
        string $message = 'The requested resource does not exist.',
        int $code = Response::HTTP_NOT_FOUND
    )
    {
        throw $this->errorResponse(
            message: $message,
            code: $code
        );
    }


}
