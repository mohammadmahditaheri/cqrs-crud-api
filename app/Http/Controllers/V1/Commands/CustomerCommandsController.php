<?php

namespace App\Http\Controllers\V1\Commands;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerCommandsController extends Controller
{
    public function store()
    {
        // TODO
        return response(['data' => 'store test']);
    }

    public function update()
    {
        // TODO
        return response(['data' => 'update test']);
    }

    public function delete()
    {
        // TODOs
        return response(['data' => 'delete test']);
    }
}
