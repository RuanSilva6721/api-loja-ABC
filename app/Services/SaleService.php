<?php
namespace App\Services;

use App\Models\Sale;
use App\Repositories\SaleRepository;
use Illuminate\Support\Collection;

class SaleService
{
    protected $SaleRepository;
    public function __construct(SaleRepository $SaleRepository)
    {
        $this->SaleRepository = $SaleRepository;
    }
    public function getAllSales(): Collection
    {
        return $this->SaleRepository->getAllSales();
    }
    public function createSale(object $request): Sale
    {
        return $this->SaleRepository->createSale($request);
    }
    public function getSaleByID(string $id): Object
    {
        return $this->SaleRepository->getSaleByID($id);
    }
    public function cancelSaleByID(string $id): void
    {
        $this->SaleRepository->cancelSaleByID($id);
    }
    
}