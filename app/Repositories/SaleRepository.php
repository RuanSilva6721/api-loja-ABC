<?php
namespace App\Repositories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;

class SaleRepository
{
    public function getAllSales(): Collection
    {
        $sales = Sale::where('cancel', false)->with('productSales.product')->get();

        $payload = $sales->map(function ($sale) {
            return [
                'sales_id' => $sale->id,
                'amount' => $sale->amount,
                'products' => $sale->productSales->map(function ($productSale) {
                    return [
                        'product_id' => $productSale->product_id,
                        'name' => $productSale->product->name,
                        'price' => $productSale->product->price,
                        'amount' => $productSale->amount
                    ];
                })
            ];
        });
        return $payload;
    }
}