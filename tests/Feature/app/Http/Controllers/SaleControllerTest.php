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

   
}
