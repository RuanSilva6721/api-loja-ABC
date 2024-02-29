<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SaleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_sales()
    {
        $response = $this->get('/api/sales');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'amount', 'products'],
            ]);
    }

    public function test_can_create_sale()
    {
        $product1 = Product::factory()->create();
        $product2 = Product::factory()->create();

        $data = [
            'amount' => 12,
            'products' => [
                ['id' => $product1->id, 'quantity' => 2],
                ['id' => $product2->id, 'quantity' => 1],
            ],
        ];

        $response = $this->postJson('/api/sales', $data);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Venda criada com sucesso',
            ]);
    }


    public function test_can_show_sale()
    {
        $sale = Sale::factory()->create();

        $response = $this->get("/api/sales/{$sale->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $sale->id,
            ]);
    }

    public function test_can_cancel_sale()
    {
        $sale = Sale::factory()->create();

        $response = $this->delete("/api/sales/{$sale->id}");

        $response->assertStatus(204);

        $this->assertNull(Sale::find($sale->id));
    }

    public function test_cannot_create_sale_with_invalid_product()
    {
        $data = [
            'products' => [
                ['id' => 999], 
            ],
        ];

        $response = $this->postJson('/api/sales', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['products.0.id']);
    }

    public function test_cannot_create_sale_without_products()
    {
        
        $data = [
            'products' => [],
        ];

        $response = $this->postJson('/api/sales', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['products']);
    }

    public function test_cannot_show_invalid_sale()
    {
        $response = $this->get("/api/sales/999");

        $response->assertStatus(404);
    }

    public function test_cannot_cancel_invalid_sale()
    {
        $response = $this->delete("/api/sales/999");

        $response->assertStatus(404);
    }

    public function test_cannot_cancel_already_cancelled_sale()
    {
        $sale = Sale::factory()->create(['cancelled_at' => now()]);

        $response = $this->delete("/api/sales/{$sale->id}");

        $response->assertStatus(422)
            ->assertJson(['message' => 'Sale is already cancelled.']);
    }
}
