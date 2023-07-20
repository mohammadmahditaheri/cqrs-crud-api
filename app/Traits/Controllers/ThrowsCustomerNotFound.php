<?php

namespace App\Traits\Controllers;

trait ThrowsCustomerNotFound
{
    use ThrowsNotFound;

    public static string $customerNotFound = 'The requested customer does not exist';

    /**
     * customer not found response
     */
    public function customerNotFound()
    {
        throw $this->notFound(
            message: self::$customerNotFound,
        );
    }


}
