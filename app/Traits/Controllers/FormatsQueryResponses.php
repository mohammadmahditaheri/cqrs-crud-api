<?php

namespace App\Traits\Controllers;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

trait FormatsQueryResponses
{
    /**
     * formats a success query response for single data
     */
    public function successfulQueryResponse(
        $data,
        string $apiResourceClass = null,
        int $code = SymfonyResponse::HTTP_OK
    ): Response
    {
        return response([
            'data' => $apiResourceClass
                ? new $apiResourceClass($data)
                : $data,
        ], $code);
    }

    /**
     * formats a success query response with paginated data
     */
    protected function successResponseForPaginated(
        $data,
        $apiResourceClass,
        $code = SymfonyResponse::HTTP_OK,
    ): Response
    {
        return response(
            $apiResourceClass::collection($data)
                ->response()
                ->getData(true),
            $code
        );
    }
}
