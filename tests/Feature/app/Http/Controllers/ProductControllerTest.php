<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_list_products(): void
    {
        $this->assertDatabaseMissing('products', []);
        $response = $this->get('/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'name', 'price', 'description'],
            ]);
    }
    public function test_access_with_wrong_method(): void
    {
        $this->post('/api/products')->assertStatus(405);
        $this->put('/api/products')->assertStatus(405);
        $this->delete('/api/products')->assertStatus(405);
    }
    public function test_cannot_show_product(): void
    {

        $product = Product::factory()->create();

        $response = $this->get("/api/products/{$product->id}");

        $response->assertStatus(404);
    }
}
