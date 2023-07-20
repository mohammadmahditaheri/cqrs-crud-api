<?php

namespace Tests\Feature\Commands;

use App\Contracts\Repositories\CustomerRepositoryInterface;
use App\Traits\Controllers\FormatsCustomerCommandResponses;
use App\Traits\Controllers\ThrowsCustomerNotFound;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DeleteCustomerCommandTest extends TestCase
{
    use FormatsCustomerCommandResponses,
        ThrowsCustomerNotFound;

    protected array $data = [];
    protected int $customerId;
    const DELETE_ROUTE = 'commands.customers.delete';
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
     * sends the delete request
     */
    protected function sendDeleteRequest(int $customerId): TestResponse
    {
        return $this->deleteJson(
            route(self::DELETE_ROUTE, ['customer' => $customerId])
        );
    }

    /**
     * @test
     */
    public function it_can_delete_a_customer_from_database(): void
    {
        $response = $this->sendDeleteRequest($this->customerId);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => self::$deletedMessage
            ]);

        // assert that the customer is removed form the database
        $this->assertDatabaseEmpty('customers');
    }

    /**
     * @test
     */
    public function it_cannot_delete_a_nonexistent_customer(): void
    {
        $response = $this->sendDeleteRequest($this->customerId + 10);

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                'message' => self::$customerNotFound
            ]);

        $this->assertDatabaseIsNotChanged();
    }

    /**
     * asserts that the database is not changed
     */
    protected function assertDatabaseIsNotChanged()
    {
        $this->assertDatabaseHas('customers', $this->data);
        $this->assertDatabaseCount('customers', 1);
    }
}
