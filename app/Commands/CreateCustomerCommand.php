<?php

namespace App\Commands;

use App\Contracts\Repositories\CustomerRepositoryInterface;

class CreateCustomerCommand extends BaseMutateCustomerCommand
{
    /**
     * @param CustomerRepositoryInterface $repository
     * @return bool
     */
    public function create(CustomerRepositoryInterface $repository): bool
    {
        return $repository->create($this->data);
    }
}
