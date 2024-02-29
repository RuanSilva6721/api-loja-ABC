<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Product;
use App\Models\ProductSale;
use App\Models\Sale;
use App\Services\SaleService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    protected $saleService;

    protected $rules = [
        'amount' => 'required|integer',
        'products' => 'required|array',
        'products.*.id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
    ];
    protected $messages =  [
        'amount.required' => 'O campo amount é obrigatório.',
        'amount.integer' => 'O campo amount deve ser um número.',

        'products.required' => 'O campo products é obrigatório.',
        'products.array' => 'O campo products deve ser um array.',

        'products.*.id.required' => 'Cada produto deve ter um ID.',
        'products.*.id.exists' => 'O ID de algum dos produtos não é válido.',

        'products.*.quantity.required' => 'Cada produto deve ter uma quantidade especificada.',
        'products.*.quantity.integer' => 'A quantidade de cada produto deve ser um número inteiro.',
        'products.*.quantity.min' => 'A quantidade de cada produto deve ser no mínimo 1.',
    ];

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }
    public function index():JsonResponse
    {
        try {
            $products = $this->saleService->getAllSales();
            return response()->json($products, 200);
        } catch (Exception $e) {
            return response()->json(['errors' => ['main' => $e->getMessage()]], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate($this->rules, $this->messages);
        try {
             $sale = $this->saleService->createSale($request);
            
            return response()->json(['message' => 'Venda criada com sucesso', 'sale' => $sale], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

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
