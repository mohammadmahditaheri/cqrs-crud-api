<?php

namespace App\Rules;

use App\Contracts\Repositories\CustomerRepositoryInterface;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class NameCombinedWithDateOfBirthIsUnique implements ValidationRule
{
    const ERROR_MESSAGE = 'The date of birth combined with first name and last name has already been taken.';

    public function __construct(private CustomerRepositoryInterface $repository)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->violatesTheRule()) {
            throw new HttpResponseException(
                response([
                    'message' => self::ERROR_MESSAGE,
                    "errors" => [
                        'date_of_birth' => [self::ERROR_MESSAGE]
                    ]
                ], Response::HTTP_UNPROCESSABLE_ENTITY)
            );
        }
    }

    /**
     * asserts if the request input violates the rule
     *
     * @return bool
     */
    private function violatesTheRule(): bool
    {
        return request()->has(['first_name', 'last_name', 'date_of_birth']) &&
            request()->input('first_name') !== null &&
            request()->input('last_name') !== null &&
            request()->input('date_of_birth') !== null &&
            $this->repository->customerWithNameAndBirthExists(
                request()->input('first_name'),
                request()->input('last_name'),
                request()->input('date_of_birth')
            ) &&
            $this->isNotUpdatingTheSameCustomer();
    }

    private function isNotUpdatingTheSameCustomer(): bool
    {
        if (!request()->routeIs('commands.customers.update')) {
            return true;
        }

        $currentCustomer = $this->repository->find(request()->route('customer'));
        $customerWithSameNameAndBirth = $this->repository->findCustomerByNameAndBirth(
            request()->input('first_name'),
            request()->input('last_name'),
            request()->input('date_of_birth')
        );

        if (
            !$currentCustomer ||
            !$customerWithSameNameAndBirth ||
            $currentCustomer->id != $customerWithSameNameAndBirth->id
        ) {
            return true;
        }

        return false;
    }
}
