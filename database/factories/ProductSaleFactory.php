<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductSale>
 */
class ProductSaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $salesIds = \App\Models\Sale::pluck('id')->toArray();
        $productIds = \App\Models\Product::pluck('id')->toArray();
    
        return [
            'sales_id' => $this->faker->randomElement($salesIds),
            'product_id' => $this->faker->randomElement($productIds),
            'quantity' => $this->faker->randomFloat(1, 100)
        ];
    }
}
