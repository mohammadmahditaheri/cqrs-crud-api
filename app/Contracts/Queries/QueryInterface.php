<?php

namespace App\Contracts\Queries;

interface QueryInterface
{
    /**
     * returns a listing or single resource
     */
    public function query();
}
