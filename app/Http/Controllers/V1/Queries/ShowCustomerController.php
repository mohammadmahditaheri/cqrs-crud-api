<?php

namespace App\Http\Controllers\V1\Queries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShowCustomerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        // TODO
        return response(['data' => 'show test']);
    }
}