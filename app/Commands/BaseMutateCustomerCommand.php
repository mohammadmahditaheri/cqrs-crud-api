<?php

namespace App\Commands;

use App\Contracts\Repositories\CustomerRepositoryInterface;

class BaseMutateCustomerCommand
{
    public function __construct(
        protected array $data
    )
    {
    }
}
