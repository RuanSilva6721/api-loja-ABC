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
        $salesIds = \App\Models\Sale::factory(10)->create()->pluck('id')->toArray();
        $productIds = \App\Models\Product::factory(10)->create()->pluck('id')->toArray();
    
        return [
            'sales_id' => $this->faker->randomElement($salesIds),
            'product_id' => $this->faker->randomElement($productIds)
        ];
    }
}
