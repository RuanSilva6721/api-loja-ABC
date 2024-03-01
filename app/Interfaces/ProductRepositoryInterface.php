<?php
namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function getAllProducts(): Collection;
}