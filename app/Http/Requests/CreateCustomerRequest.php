<?php

namespace App\Http\Requests;

use App\Contracts\Repositories\CustomerRepositoryInterface;
use App\Rules\NameCombinedWithDateOfBirthIsUnique;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Intervention\Validation\Rules\Iban;
use Propaganistas\LaravelPhone\Rules\Phone;

class CreateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param CustomerRepositoryInterface $repository
     * @return array
     */
    public function rules(CustomerRepositoryInterface $repository): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'max:50'
            ],
            'last_name' => [
                'required',
                'string',
                'max:50'
            ],
            'date_of_birth' => [
                'required',
                'date',
                'before:now',
                new NameCombinedWithDateOfBirthIsUnique($repository)
            ],
            'phone_number' => [
                'required',
                /**
                 * phone validation is made possible via
                 * "propaganistas/laravel-phone" which is based
                 * on Google LibPhoneNumber
                 */
                (new Phone)->type('mobile'),
            ],
            'email' => [
                'required',
                'string',
                'max:65',
                'email',
                Rule::unique('customers', 'email')
            ],
            'bank_account_number' => [
                'required',
                'string',
                new Iban(),
            ]
        ];
    }
}
