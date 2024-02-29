<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Sale;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

        return response()->json($payload, 200);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
