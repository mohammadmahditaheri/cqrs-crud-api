<?php

namespace App\Commands;

use App\Contracts\Commands\DeleteCustomerHandlerInterface;
use App\Contracts\Repositories\CustomerRepositoryInterface;

class DeleteCustomerHandler implements DeleteCustomerHandlerInterface
{
    public function __construct(private CustomerRepositoryInterface $repository)
    {
    }

    /**
     * @inheritDoc
     */
    public function handle(int $customerId): bool
    {
        $command = new DeleteCustomerCommand($customerId);

        return $command->delete($this->repository);
    }
}
