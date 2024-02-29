<?php
namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    protected $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function getAllProducts(): Collection
    {
        return $this->productRepository->getAllProducts();
    }
}