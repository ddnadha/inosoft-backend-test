<?php

namespace Tests\Unit;

use App\Traits\RefreshDatabaseTransactionLess;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class VehicleTest extends TestCase
{
    use WithFaker, RefreshDatabase, RefreshDatabaseTransactionLess {
        RefreshDatabaseTransactionless::refreshTestDatabase insteadof RefreshDatabase;
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_vehicle_store()
    {
        $requestJWT = $this->postJson('api/login', [
            'email' => 'didanadha99@gmail.com',
            'password' => '12345678'
        ]);
        $token = $requestJWT->decodeResponseJson()['token'];

        $vehicleData = [
            "manufactured_at" => $this->faker()->year(),
            "color" => $this->faker()->colorName(),
            "price" => $this->faker()->numberBetween(50, 900) * 100000,
            "stock" => $this->faker()->numberBetween(10, 250),
            "type" => $this->faker()->randomElement(['motorcycle', 'car'])
        ];
        $vehicleData['detailedInfo'] = $this->getDetailedInfo($vehicleData['type']);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/vehicle', $vehicleData);
        $response->assertStatus(201)
            ->assertJsonStructure([
                'manufactured_at',
                'color',
                'price',
                'type',
                'detailedInfo',
            ]);

        $this->assertDatabaseHas('vehicles', [
            'manufactured_at' => $vehicleData['manufactured_at'],
            'color' => $vehicleData['color'],
            'price' => $vehicleData['price'],
            'type' => $vehicleData['type'],
        ]);
    }


    private function getDetailedInfo($type)
    {

        if ($type === 'motorcycle') {
            return [
                'engine_capacity' => $this->faker->numberBetween(100, 1000) . 'cc',
                'suspension_type' => $this->faker->word(),
                'transmission_type' => $this->faker->randomElement(['manual', 'auto']),
            ];
        } else {
            return [
                'engine_capacity' => $this->faker->numberBetween(1000, 5000) . 'cc',
                'passenger_capacity' => $this->faker->numberBetween(2, 8),
                'type' => $this->faker->randomElement(['Sedan', 'SUV', 'MPV']),
            ];
        }
    }
}
