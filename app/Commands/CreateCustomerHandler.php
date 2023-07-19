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
     * @param array $params
     * @return bool
     */
    public function handle(array $params): bool
    {
        $command = new CreateCustomerCommand(
            firstName: $params['first_name'],
            lastName: $params['last_name'],
            dateOfBirth: $params['date_of_birth'],
            phoneNumber: $params['phone_number'],
            email: $params['email'],
            bankAccountNumber: $params['bank_account_number']
        );

        return $command->create($this->repository);
    }
}
