<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $vehicleData = [
            "manufactured_at" => $this->faker->year(),
            "color" => $this->faker->colorName(),
            "price" => $this->faker->numberBetween(50, 900) * 100000,
            "type" => $this->faker->randomElement(['motorcycle', 'car'])
        ];
        $vehicleData['detailedInfo'] = (object) $this->getDetailedInfo($vehicleData['type']);
        return $vehicleData;
    }

    private function getDetailedInfo($type): array
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
