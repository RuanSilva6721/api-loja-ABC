<?php
namespace App\Interfaces;

use App\Models\Product;
use App\Models\ProductSale;
use App\Models\Sale;
use Illuminate\Support\Collection;
use PhpParser\Node\Expr\Cast\Object_;

interface SaleRepositoryInterface
{
    public function getAllSales(): Collection;
    
    public function createSale(object $request): Sale;
    public function getSaleByID(string $id): Object;

    public function cancelSaleByID(string $id):void;

    public function addProductForSale(string $id, object $request): Object;
      
}