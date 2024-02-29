<?php
namespace App\Services;

use App\Models\Sale;
use App\Repositories\SaleRepository;
use Illuminate\Database\Eloquent\Collection;

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
}