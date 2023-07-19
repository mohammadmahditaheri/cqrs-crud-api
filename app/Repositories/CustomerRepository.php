<?php

namespace App\Repositories;

use App\Contracts\Repositories\CustomerRepositoryInterface;
use App\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function get(int $perPage = 9): mixed
    {
        return Customer::latest()->paginate($perPage)->get();
    }

    /**
     * @inheritDoc
     */
    public function find(int $customerId): mixed
    {
        return Customer::where('id', $customerId)->first();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): bool
    {
        return (bool) Customer::create($data);
    }

    /**
     * @inheritDoc
     */
    public function update(int $customerId, array $newData): bool
    {
        /**
         * @var Customer $customer
         */
        $customer = $this->find($customerId);
        if (!$customer) {
            return false;
        }

        return $customer->update($newData);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $customerId): bool
    {
        /**
         * @var Customer $customer
         */
        $customer = $this->find($customerId);
        if (!$customer) {
            return false;
        }

        return (bool) $customer->delete();
    }

    /**
     * @inheritDoc
     */
    public function customerWithNameAndBirthExists(string $firstName, string $lastName, string $dateOfBirth): bool
    {
        return (bool) Customer::where('first_name', $firstName)
            ->where('last_name', $lastName)
            ->where('date_of_birth', $dateOfBirth)
            ->exists();
    }
}
