<?php

namespace App\Commands;

use App\Contracts\Commands\CreateCustomerHandlerInterface;
use App\Contracts\Repositories\CustomerRepositoryInterface;

class CreateCustomerHandler implements CreateCustomerHandlerInterface
{
    public function __construct(private CustomerRepositoryInterface $repository)
    {
    }

    /**
     * @inheritDoc
     */
    public function handle(array $data): bool
    {
        $command = new CreateCustomerCommand($data);

        return $command->create($this->repository);
    }
}
