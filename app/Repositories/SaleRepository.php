<?php
namespace App\Repositories;

use App\Interfaces\SaleRepositoryInterface;
use App\Models\Product;
use App\Models\ProductSale;
use App\Models\Sale;
use Illuminate\Support\Collection;
use PhpParser\Node\Expr\Cast\Object_;

class SaleRepository implements SaleRepositoryInterface
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
    public function getSaleByID(string $id): Object
    {
        $sales = Sale::where('cancel', false)->where('id', $id)->with('productSales.product')->get();

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
    public function cancelSaleByID(string $id):void
    {
        $sale = Sale::where('cancel', false)->where('id', $id)->first();
        $sale->cancel = true;
        $sale->save();
   
    }
    public function addProductForSale(string $id, object $request): Object
    {
        $sales = Sale::where('id', $id)
            ->where('cancel', false)
            ->with('productSales.product')
            ->firstOrFail();

        foreach ($request->products as $product) {
            $productData = Product::findOrFail($product['id']);
            $sales->productSales()->create([
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'price' => $productData->price,
            ]);
        }

        $sales->save();
        return $sales;
    }
    
    
}