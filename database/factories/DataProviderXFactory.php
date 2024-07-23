<?php

namespace Database\Factories;

use App\Models\DataProviderX;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataProviderXFactory extends Factory
{
    protected $model = DataProviderX::class;
    public function definition()
    {
        return [
            'parentAmount' => $this->faker->randomFloat(2, 100, 1000),
            'Currency' => $this->faker->randomElement(['USD', 'EUR', 'GBP']),
            'parentEmail' => $this->faker->unique()->safeEmail,
            'statusCode' => $this->faker->randomElement([1, 2, 3]),
            'registerationDate' => $this->faker->date('Y-m-d'),
            'parentIdentification' => $this->faker->uuid,
        ];
    }
}
