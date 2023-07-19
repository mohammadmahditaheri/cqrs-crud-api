<?php

namespace App\Commands;

use App\Contracts\Repositories\CustomerRepositoryInterface;

class CreateCustomerCommand
{
    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $dateOfBirth,
        private string $phoneNumber,
        private string $email,
        private string $bankAccountNumber
    )
    {}

    /**
     * @param CustomerRepositoryInterface $repository
     * @return bool
     */
    public function create(CustomerRepositoryInterface $repository): bool
    {
        return $repository->create([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'date_of_birth' => $this->dateOfBirth,
            'phone_number' => $this->phoneNumber,
            'email' => $this->email,
            'bank_account_number' => $this->bankAccountNumber
        ]);
    }
}
