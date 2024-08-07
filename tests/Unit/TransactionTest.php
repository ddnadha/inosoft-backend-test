<?php

namespace Tests\Unit;

use App\Models\Vehicle;

use App\Traits\RefreshDatabaseTransactionLess;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class TransactionTest extends TestCase
{
    use WithFaker, RefreshDatabase, RefreshDatabaseTransactionLess {
        RefreshDatabaseTransactionless::refreshTestDatabase insteadof RefreshDatabase;
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_transaction_store()
    {
        $requestJWT = $this->postJson('api/login', [
            'email' => 'didanadha99@gmail.com',
            'password' => '12345678'
        ]);
        $token = $requestJWT->decodeResponseJson()['token'];

        $transaction = $this->getTransacationItemData([
            'name' => $this->faker()->name(),
        ]);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/transaction', $transaction);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'price',
                    'items',
                ]
            ]);

        $this->assertDatabaseHas('transactions', [
            'name' => $transaction['name'],
            'price' => $transaction['price'],
        ]);
    }
    public function test_transaction_store_whitout_auth()
    {
        $transaction = $this->getTransacationItemData([
            'name' => $this->faker()->name(),
        ]);

        $response = $this->postJson('/api/transaction', $transaction);
        $response->assertStatus(401);
    }

    private function getTransacationItemData(array $transaction): array
    {
        $vehicles = Vehicle::factory(10)->create();
        $totalPrice = 0;
        foreach (range(0, rand(1, $vehicles->count())) as $i) {
            $vehicle = $vehicles->random();
            $qty = rand(1, 3);

            $transaction['items'][] = [
                'id' => $vehicle['_id'],
                'price' => $vehicle['price'],
                'qty' => $qty,
            ];
            $totalPrice += $vehicle["price"] * $qty;
        }

        $transaction['price'] = $totalPrice;

        return $transaction;
    }
}
