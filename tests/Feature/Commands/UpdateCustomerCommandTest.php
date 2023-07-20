<?php

namespace Tests\Feature\Commands;

use App\Contracts\Repositories\CustomerRepositoryInterface;
use App\Traits\Controllers\FormatsCustomerCommandResponses;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateCustomerCommandTest extends TestCase
{
    use FormatsCustomerCommandResponses;

    protected array $data = [];
    protected int $customerId;
    const UPDATE_ROUTE = 'commands.customers.update';
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

        // do create the customer
        $this->postJson(route(self::CREATE_ROUTE), $this->data);

        // set customer id
        /**
         * @var CustomerRepositoryInterface $repository
         */
        $repository = resolve(CustomerRepositoryInterface::class);
        $this->customerId = $repository->findByEmail($this->data['email'])->id;
    }

    /**
     * send request to the route with provided payload
     *
     * @param $customerId
     * @param $data
     * @return TestResponse
     */
    private function sendUpdateRequest($customerId, $data): TestResponse
    {
        return $this->putJson(
            route(self::UPDATE_ROUTE, ['customer' => $customerId]),
            $data);
    }

    /**
     * @test
     */
    public function it_can_update_customer_with_same_data(): void
    {
        $response = $this->sendUpdateRequest(
            customerId: $this->customerId,
            data: $this->data
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => self::$updatedMessage
            ]);

        $this->assertDatabaseHas('customers', $this->data);
        $this->assertDatabaseCount('customers', 1);
    }

    /**
     * @test
     */
    public function it_can_update_customer_with_modified_data(): void
    {
        $newData = [
            'first_name' => 'James',
            'last_name' => 'Young',
            'date_of_birth' => '1970-11-05',
            'phone_number' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->email(),
            'bank_account_number' => fake()->iban('NL')
        ];

        $response = $this->sendUpdateRequest(
            customerId: $this->customerId,
            data: $newData
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => self::$updatedMessage
            ]);

        $this->assertDatabaseHas('customers', $newData);
        $this->assertDatabaseCount('customers', 1);
    }

    /**
     * @test
     */
    public function it_cannot_update_customer_without_enough_data(): void
    {
        // first_name missing
        $this->cantUpdateWithoutMissing('first_name');

        // last_name missing
        $this->cantUpdateWithoutMissing('last_name');

        // date_of_birth missing
        $this->cantUpdateWithoutMissing('date_of_birth');

        // phone_number missing
        $this->cantUpdateWithoutMissing('phone_number');

        // email missing
        $this->cantUpdateWithoutMissing('email');

        // bank_account_number missing
        $this->cantUpdateWithoutMissing('bank_account_number');
    }

    /**
     * send request with missing parameter
     */
    private function updateWithMissing(string $missing): TestResponse
    {
        $newData = $this->data;
        unset($newData[$missing]);

        return $this->sendUpdateRequest(
            $this->customerId,
            $newData
        );
    }

    protected function cantUpdateWithoutMissing(string $missing)
    {
        // missing
        $response = $this->updateWithMissing($missing);

        $errorMessage = 'The ' . Str::replace('_', ' ', $missing) . ' field is required.';
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => $errorMessage,
                'errors' => [
                    $missing => [$errorMessage]
                ]
            ]);

        // assert that the customer isn't changed
        $this->assertDatabaseHas('customers', $this->data);
        $this->assertDatabaseCount('customers', 1);
    }
}
