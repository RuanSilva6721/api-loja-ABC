<?php
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function getAllProducts(): Collection
    {
        return Product::all();
    }
}