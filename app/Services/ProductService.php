<?php
namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    protected $productRepositoryInterface;
    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }
    public function getAllProducts(): Collection
    {
        return $this->productRepositoryInterface->getAllProducts();
    }
}