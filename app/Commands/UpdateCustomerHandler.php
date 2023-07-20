<?php

namespace App\Commands;

use App\Contracts\Commands\UpdateCustomerHandlerInterface;
use App\Contracts\Repositories\CustomerRepositoryInterface;

class UpdateCustomerHandler implements UpdateCustomerHandlerInterface
{
    public function __construct(private CustomerRepositoryInterface $repository)
    {
    }

    /**
     * @inheritDoc
     */
    public function handle(int $customerId, array $newData): bool
    {
        $command = new UpdateCustomerCommand($customerId, $newData);

        return $command->update($this->repository);
    }
}
