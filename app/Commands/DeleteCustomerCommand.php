<?php

namespace App\Commands;

use App\Contracts\Repositories\CustomerRepositoryInterface;

class DeleteCustomerCommand extends BaseMutateCustomerCommand
{
    protected int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @param CustomerRepositoryInterface $repository
     * @return bool
     */
    public function delete(CustomerRepositoryInterface $repository): bool
    {
        return $repository->delete($this->id);
    }
}
