<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;


class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     * @OA\Get(
     *      path="/api/products",
     *      operationId="getAllProducts",
     *      tags={"products"},
     *      summary="Buscar a lista de produtos",
     *      description="Retorna a lista de produtos em formato json",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *      ),
     * )
     */
    public function getAllProducts():JsonResponse
    { 
        try {
            $products = $this->productService->getAllProducts();
            return response()->json($products, 200);
        } catch (Exception $e) {
            return response()->json(['errors' => ['main' => $e->getMessage()]], 500);
        }
    }

}
