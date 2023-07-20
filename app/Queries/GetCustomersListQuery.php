<?php

namespace App\Queries;

use App\Contracts\Queries\QueryInterface;
use App\Contracts\Repositories\CustomerRepositoryInterface;

class GetCustomersListQuery implements QueryInterface
{
    public function __construct(
        private CustomerRepositoryInterface $repository
    )
    {}

    public function query(int $perPage = null)
    {
        return $this->repository->get($perPage);
    }
}
