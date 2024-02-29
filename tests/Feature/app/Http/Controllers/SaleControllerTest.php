<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSale;
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
        Product::factory(100)->create();
        ProductSale::factory(15)->create();

        $response = $this->get("/api/sales/{$sale->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'sales_id',
                    'amount',
                    'products',
                ],
            ]);
    }

    public function test_can_cancel_sale()
    {
        $product = Product::factory()->create();
        $sale = Sale::factory()->create();
        $productSale = ProductSale::factory()->create();

        $response = $this->delete("/api/sales/{$sale->id}");

        $response->assertStatus(204);

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
        $response = $this->get("/api/sales/545654654654564564566565465445664645646545646546544654654654654654654646454654654566464646464");

        $response->assertStatus(422);
    }

    public function test_cannot_cancel_invalid_sale()
    {
        $response = $this->delete("/api/sales/4456");

        $response->assertStatus(422);
    }

}
