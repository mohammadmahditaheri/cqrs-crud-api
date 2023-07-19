<?php

namespace Tests\Feature\Commands;

use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use function fake;
use function route;

class CreateCustomerCommandTest extends TestCase
{
    protected array $data = [];

    public function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'first_name' => 'John',
            'last_name' => 'Smith',
            'date_of_birth' => '2001-10-01',
            'phone_number' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->email(),
            'bank_account_number' => fake()->iban('NL')
        ];
    }

    /**
     * send request to the route with provided payload
     *
     * @param $data
     * @return TestResponse
     */
    private function sendPostJson($data): TestResponse
    {
        return $this->postJson(route('commands.customers.create'), $data);
    }

    /**
     * @test
     */
    public function it_can_create_customer_through_store_api_command(): void
    {
        $response = $this->sendPostJson($this->data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => 'Customer created successfully.'
            ]);

        $this->assertDatabaseHas('customers', $this->data);
        $this->assertDatabaseCount('customers', 1);
    }

    /**
     * @test
     */
    public function it_cannot_create_customer_without_first_name()
    {
        $this->data['first_name'] = null;

        $response = $this->sendPostJson($this->data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'The first name field is required.',
                'errors' => [
                    'first_name' => ['The first name field is required.']
                ]
            ]);
    }

    /**
     * @test
     */
    public function it_cannot_create_customer_without_last_name()
    {
        $this->data['last_name'] = null;

        $response = $this->sendPostJson($this->data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'The last name field is required.',
                'errors' => [
                    'last_name' => ['The last name field is required.']
                ]
            ]);
    }

    /**
     * @test
     */
    public function it_cannot_create_customer_without_date_of_birth()
    {
        $this->data['date_of_birth'] = null;

        $response = $this->sendPostJson($this->data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'The date of birth field is required.',
                'errors' => [
                    'date_of_birth' => ['The date of birth field is required.']
                ]
            ]);
    }

    /**
     * @test
     */
    public function it_cannot_create_customer_without_phone_number()
    {
        $this->data['phone_number'] = null;

        $response = $this->sendPostJson($this->data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'The phone number field is required.',
                'errors' => [
                    'phone_number' => ['The phone number field is required.']
                ]
            ]);
    }

    /**
     * @test
     */
    public function it_cannot_create_customer_without_email()
    {
        $this->data['email'] = null;

        $response = $this->sendPostJson($this->data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'The email field is required.',
                'errors' => [
                    'email' => ['The email field is required.']
                ]
            ]);
    }

    /**
     * @test
     */
    public function it_cannot_create_customer_without_bank_account_number()
    {
        $this->data['bank_account_number'] = null;

        $response = $this->sendPostJson($this->data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'The bank account number field is required.',
                'errors' => [
                    'bank_account_number' => ['The bank account number field is required.']
                ]
            ]);
    }

    /**
     * @test
     */
    public function it_cannot_create_customer_with_repetitive_email()
    {
        $secondData = [
            'first_name' => 'Johnny',
            'last_name' => 'Depp',
            'date_of_birth' => '2001-10-01',
            'phone_number' => fake()->unique()->e164PhoneNumber(),
            'email' => $this->data['email'],
            'bank_account_number' => fake()->iban('NL')
        ];

        // first customer with the email
        $this->sendPostJson($this->data);

        // try for another customer with the same email
        $response = $this->sendPostJson($secondData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'The email has already been taken.',
                'errors' => [
                    'email' => ['The email has already been taken.']
                ]
            ]);
    }

    /**
     * @test
     */
    public function it_cannot_create_customer_with_same_name_and_birth_date()
    {
        // same first_name, last_name and date_of_birth
        $secondData = [
            'first_name' => $this->data['first_name'],
            'last_name' => $this->data['last_name'],
            'date_of_birth' => $this->data['date_of_birth'],
            'phone_number' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->email(),
            'bank_account_number' => fake()->iban('NL')
        ];

        // first customer
        $this->sendPostJson($this->data);

        // try for another customer with the same name and birth date
        $response = $this->sendPostJson($secondData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'The date of birth combined with first name and last name has already been taken.',
                "errors" => [
                    'date_of_birth' => ['The date of birth combined with first name and last name has already been taken.']
                ]
            ]);
    }
}
