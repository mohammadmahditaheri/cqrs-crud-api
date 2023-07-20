<?php

namespace App\Http\Controllers\V1\Queries;

use App\Contracts\Queries\QueryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Queries\FetchCustomersRequest;
use App\Http\Resources\CustomerResource;
use App\Traits\Controllers\FormatsQueryResponses;
use Illuminate\Http\Response;

class GetCustomerListController extends Controller
{
    use FormatsQueryResponses;

    public function __construct(private QueryInterface $queryHandler)
    {}

    /**
     * Display a listing of the resource.
     */
    public function __invoke(FetchCustomersRequest $request): Response
    {
        return $this->successResponseForPaginated(
            data: $this->queryHandler->query($request->validated('perPage')), apiResourceClass: CustomerResource::class
        );
    }
}
