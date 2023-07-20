<?php

namespace Tests\Feature\Commands;

use App\Traits\Controllers\FormatsCustomerCommandResponses;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use function fake;
use function route;

class CreateCustomerCommandTest extends TestCase
{
    use FormatsCustomerCommandResponses;

    protected array $data = [];
    const CREATE_ROUTE = 'commands.customers.create';

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
    private function sendCreateRequest($data): TestResponse
    {
        return $this->postJson(route(self::CREATE_ROUTE), $data);
    }

    /**
     * @test
     */
    public function it_can_create_customer_through_store_api_command(): void
    {
        $response = $this->sendCreateRequest($this->data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => self::$createdMessage
            ]);

        $this->assertDatabaseHas('customers', $this->data);
        $this->assertDatabaseCount('customers', 1);
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
        $this->sendCreateRequest($this->data);

        // try for another customer with the same email
        $response = $this->sendCreateRequest($secondData);

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
        $this->sendCreateRequest($this->data);

        // try for another customer with the same name and birthdate
        $response = $this->sendCreateRequest($secondData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'The date of birth combined with first name and last name has already been taken.',
                "errors" => [
                    'date_of_birth' => ['The date of birth combined with first name and last name has already been taken.']
                ]
            ]);
    }

    /**
     * @test
     */
    public function it_cannot_create_customer_without_enough_data()
    {
        // first_name
        $this->cantCreateWithoutMissing('first_name');

        // last_name
        $this->cantCreateWithoutMissing('last_name');

        // date_of_birth
        $this->cantCreateWithoutMissing('date_of_birth');

        // phone_number
        $this->cantCreateWithoutMissing('phone_number');

        // email
        $this->cantCreateWithoutMissing('email');

        // bank_account_number
        $this->cantCreateWithoutMissing('bank_account_number');
    }

    /**
     * handle testing create with missing data
     */
    protected function cantCreateWithoutMissing(string $missing)
    {
        // missing
        $response = $this->createWithMissing($missing);

        $errorMessage = 'The ' . Str::replace('_', ' ', $missing) . ' field is required.';

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => $errorMessage,
                'errors' => [
                    $missing => [$errorMessage]
                ]
            ]);

        // assert that the database isn't changed
        $this->assertDatabaseEmpty('customers');
    }

    /**
     * Send create request with incomplete data
     */
    private function createWithMissing(string $missing): TestResponse
    {
        $incompleteData = $this->data;
        unset($incompleteData[$missing]);

        return $this->sendCreateRequest($incompleteData);
    }
}
