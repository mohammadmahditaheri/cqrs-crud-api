<?php

namespace App\Commands;

use App\Contracts\Repositories\CustomerRepositoryInterface;

class UpdateCustomerHandler
{
    public function __construct(private CustomerRepositoryInterface $repository)
    {
    }

    /**
     * handle command
     *
     * @param int $customerId
     * @param array $newData
     * @return bool
     */
    public function handle(int $customerId, array $newData): bool
    {
        $command = new UpdateCustomerCommand($customerId, $newData);

        return $command->update($this->repository);
    }
}
