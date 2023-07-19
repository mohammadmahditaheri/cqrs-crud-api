<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->unique()->firstName(),
            'last_name' => fake()->unique()->lastName(),
            'date_of_birth' => fake()->unique()->dateTime(),
            'phone_number' => fake()->e164PhoneNumber(),
            'email' => fake()->unique()->email(),
            'bank_account_number' => fake()->unique()->iban('US'),
        ];
    }
}
