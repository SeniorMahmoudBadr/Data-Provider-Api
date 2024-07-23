<?php

namespace Database\Factories;

use App\Models\DataProviderY;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataProviderYFactory extends Factory
{
    protected $model = DataProviderY::class;

    public function definition()
    {
        return [
            'balance' => $this->faker->randomFloat(2, 100, 1000),
            'currency' => $this->faker->randomElement(['AED', 'USD', 'EUR']),
            'email' => $this->faker->unique()->safeEmail,
            'status' => $this->faker->randomElement([100, 200, 300]),
            'created_at' => $this->faker->date('Y-m-d'),
            'id' => $this->faker->uuid,
        ];
    }
}
