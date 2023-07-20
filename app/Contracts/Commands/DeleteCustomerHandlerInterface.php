<?php

namespace App\Contracts\Commands;

interface DeleteCustomerHandlerInterface
{
    /**
     * handle command
     *
     * @param int $customerId
     * @return bool
     */
    public function handle(int $customerId): bool;
}
