<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['basket', 'order']),
            'location' => $this->faker->city,
            'number' => $this->faker->randomNumber(1, 30),
            'payment' => $this->faker->randomElement(['online', 'receiving']),
            'status' => $this->faker->randomElement(['expected', 'paid'])
        ];
    }
}
