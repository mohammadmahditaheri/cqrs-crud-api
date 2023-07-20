<?php

namespace App\Contracts\Commands;

interface UpdateCustomerHandlerInterface
{
    /**
     * handle command
     *
     * @param int $customerId
     * @param array $newData
     * @return bool
     */
    public function handle(int $customerId, array $newData): bool;
}
