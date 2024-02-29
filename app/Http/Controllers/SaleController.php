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
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request):JsonResponse
    {
        $request->validate($this->rules, $this->messages);
        try {
             $sale = $this->saleService->createSale($request);
            
            return response()->json(['message' => 'Venda criada com sucesso', 'sale' => $sale], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function show(Request $request, $id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|string|exists:sales,id',
        ], [
            'id.exists' => 'O ID da venda não é válido.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $sale = $this->saleService->getSaleByID($id);
            return response()->json($sale, 200);
        } catch (Exception $e) {
            return response()->json(['errors' => ['main' => $e->getMessage()]], 500);
        }
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|string|exists:sales,id',
        ], [
            'id.exists' => 'O ID da venda não é válido.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            $this->saleService->cancelSaleByID($id);
            return response()->json(['message' => 'Venda cancelada com sucesso'], 204);
        } catch (Exception $e) {
            return response()->json(['errors' => ['main' => $e->getMessage()]], 500);
        }
    }
}
