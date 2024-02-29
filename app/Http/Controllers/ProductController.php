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
    
    public function index():JsonResponse
    { 
        try {
            $products = $this->productService->getAllProducts();
            return response()->json($products, 200);
        } catch (Exception $e) {
            return response()->json(['errors' => ['main' => $e->getMessage()]], 500);
        }
    }

}
