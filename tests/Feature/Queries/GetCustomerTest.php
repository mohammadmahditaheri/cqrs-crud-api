<?php

namespace Tests\Feature\Queries;

use App\Models\Customer;
use App\Traits\Controllers\ThrowsCustomerNotFound;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class GetCustomerTest extends TestCase
{
    use ThrowsCustomerNotFound;

    const SHOW_ROUTE = 'queries.customers.show';
    const MAX_CUSTOMER_ID = 4;

    public function setUp(): void
    {
        parent::setUp();

        // insert some customers
        DB::table('customers')->insert([
            [
                'id' => 1,
                'first_name' => 'Jimmy',
                'last_name' => 'Hessel',
                'date_of_birth' => '2015-10-12',
                'phone_number' => '+12017699743',
                'email' => 'jarrell.shanahan@bogan.com',
                'bank_account_number' => 'US29724634721327400272934186'
            ],
            [
                'id' => 2,
                'first_name' => 'Audra',
                'last_name' => 'Kerluke',
                'date_of_birth' => '1991-10-02',
                'phone_number' => '+16605529995',
                'email' => 'vicenta.price@quigley.biz',
                'bank_account_number' => 'US25466678273173825102836661'
            ],
            [
                'id' => 3,
                'first_name' => 'Kailey',
                'last_name' => 'Prohaska',
                'date_of_birth' => '1987-01-04',
                'phone_number' => '+12062130333',
                'email' => 'carroll.pink@gmail.com',
                'bank_account_number' => 'US97179622742498778964241988'
            ],
            [
                'id' => 4,
                'first_name' => 'Gage',
                'last_name' => 'Konopelski',
                'date_of_birth' => '2012-06-01',
                'phone_number' => '+17343813880',
                'email' => 'pleannon@hotmail.com',
                'bank_account_number' => 'US34263532179738251617818933'
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_can_show_a_single_customer(): void
    {
        $response = $this->getJson(
            route(self::SHOW_ROUTE, ['customer' => '2'])
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    'id' => 2,
                    'first_name' => 'Audra',
                    'last_name' => 'Kerluke',
                    'date_of_birth' => '1991-10-02',
                    'phone_number' => '+16605529995',
                    'email' => 'vicenta.price@quigley.biz',
                    'bank_account_number' => 'US25466678273173825102836661'
                ]
            ]);
    }

    /**
     * @test
     */
    public function it_cannot_show_nonexistent_customer(): void
    {
        $response = $this->getJson(
            route(self::SHOW_ROUTE, ['customer' => '5'])
        );

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                'message' => self::$customerNotFound
            ]);
    }
}
