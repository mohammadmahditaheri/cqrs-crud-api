<?php

namespace App\Commands;

use App\Contracts\Repositories\CustomerRepositoryInterface;

class CreateCustomerHandler
{
    public function __construct(private CustomerRepositoryInterface $repository)
    {
    }

    /**
     * handle command
     *
     * @param array $data
     * @return bool
     */
    public function handle(array $data): bool
    {
        $command = new CreateCustomerCommand($data);

        return $command->create($this->repository);
    }
}
