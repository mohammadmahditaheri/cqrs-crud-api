<?php

namespace App\Contracts\Repositories;

use App\Models\Customer;

interface CustomerRepositoryInterface
{
    /**
     * @param int $perPage
     * @return mixed
     */
    public function get(int $perPage = 9): mixed;

    /**
     * @param int $customerId
     * @return mixed
     */
    public function find(int $customerId): mixed;

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool;

    /**
     * @param int $customerId
     * @param array $newData
     * @return bool
     */
    public function update(int $customerId, array $newData): bool;

    /**
     * @param int $customerId
     * @return bool
     */
    public function delete(int $customerId): bool;

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $dateOfBirth
     * @return bool
     */
    public function customerWithNameAndBirthExists(
        string $firstName,
        string $lastName,
        string $dateOfBirth
    ): bool;
}
