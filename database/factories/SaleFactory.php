<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productIds = \App\Models\Product::factory(10)->create()->pluck('id')->toArray();
        return [
            'id' => $this->faker->uuid,
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'quantity' => $this->faker->numberBetween(1, 10),
            'product_id' => $this->faker->randomElement($productIds),
        ];
    }
}
