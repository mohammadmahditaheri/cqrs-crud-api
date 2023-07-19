<?php

namespace App\Commands;

use App\Contracts\Repositories\CustomerRepositoryInterface;

class UpdateCustomerCommand extends BaseMutateCustomerCommand
{
    protected int $id;

    public function __construct(int $id, array $newData)
    {
        $this->id = $id;
        $this->data = $newData;
    }

    /**
     * @param CustomerRepositoryInterface $repository
     * @return bool
     */
    public function update(CustomerRepositoryInterface $repository): bool
    {
        return $repository->update($this->id, $this->data);
    }
}
