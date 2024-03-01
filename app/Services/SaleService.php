<?php
namespace App\Services;

use App\Interfaces\SaleRepositoryInterface;
use App\Models\Sale;

use Illuminate\Support\Collection;

class SaleService
{
    protected $saleRepositoryInterface;
    public function __construct(SaleRepositoryInterface $saleRepositoryInterface)
    {
        $this->saleRepositoryInterface = $saleRepositoryInterface;
    }
    public function getAllSales(): Collection
    {
        return $this->saleRepositoryInterface->getAllSales();
    }
    public function createSale(object $request): Sale
    {
        return $this->saleRepositoryInterface->createSale($request);
    }
    public function getSaleByID(string $id): Object
    {
        return $this->saleRepositoryInterface->getSaleByID($id);
    }
    public function cancelSaleByID(string $id): void
    {
        $this->saleRepositoryInterface->cancelSaleByID($id);
    }
    public function addProductForSale(string $id, object $request): Object
    {
        return $this->saleRepositoryInterface->addProductForSale($id ,$request);
    }
    
}