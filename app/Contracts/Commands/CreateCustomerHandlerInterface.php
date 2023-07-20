<?php

namespace App\Contracts\Commands;

interface CreateCustomerHandlerInterface
{
    /**
     * handle command
     *
     * @param array $data
     * @return bool
     */
    public function handle(array $data): bool;
}
