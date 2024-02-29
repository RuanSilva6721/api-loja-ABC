<?php
namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductSale;
use App\Models\Sale;
use Illuminate\Support\Collection;
use PhpParser\Node\Expr\Cast\Object_;

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
                        'amount' => $productSale->quantity
                    ];
                })
            ];
        });
        return $payload;
    }
    public function createSale(object $request): Sale
    {
        $sale = new Sale();
            $sale->amount = $request->amount;
            $sale->cancel = false; 
            $sale->save();

            foreach ($request->products as $product) {
                $productModel = Product::findOrFail($product['id']);

                $productSale = new ProductSale();
                $productSale->product_id = $product['id'];
                $productSale->sales_id = $sale->id;
                $productSale->quantity = $product['quantity'];
                $productSale->save();
            }
        return $sale;
    }
}