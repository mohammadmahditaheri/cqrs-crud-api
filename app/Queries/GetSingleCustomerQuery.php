<?php

namespace App\Queries;

use App\Contracts\Queries\QueryInterface;
use App\Contracts\Repositories\CustomerRepositoryInterface;

class GetSingleCustomerQuery implements QueryInterface
{
    public function __construct(
        private int $customerId,
        private CustomerRepositoryInterface $repository
    )
    {}

    /**
     * @inheritDoc
     */
    public function query()
    {
        return $this->repository->find($this->customerId);
    }
}
