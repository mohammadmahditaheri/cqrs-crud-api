<?php

namespace App\Http\Controllers\V1\Queries;

use App\Contracts\Queries\QueryInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Traits\Controllers\FormatsQueryResponses;
use Illuminate\Http\Response;


/**
 * @group Queries
 */
class ShowCustomerController extends Controller
{
    use FormatsQueryResponses;

    public function __construct(private QueryInterface $queryHandler)
    {
    }

    /**
     * Get customer
     *
     * Display the specified customer by id.
     *
     * @header Accept application/json
     */
    public function __invoke(string $id): Response
    {
        return $this->successfulQueryResponse(
            data: $this->queryHandler->query(),
            apiResourceClass: CustomerResource::class
        );
    }
}
