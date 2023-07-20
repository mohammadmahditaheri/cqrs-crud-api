<?php

namespace App\Commands;

use App\Contracts\Repositories\CustomerRepositoryInterface;

class DeleteCustomerHandler
{
    public function __construct(private CustomerRepositoryInterface $repository)
    {
    }

    /**
     * handle command
     *
     * @param int $customerId
     * @return bool
     */
    public function handle(int $customerId): bool
    {
        $command = new DeleteCustomerCommand($customerId);

        return $command->delete($this->repository);
    }
}
