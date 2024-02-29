<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price', 'description'];
    public function productSales()
    {
        return $this->hasMany(ProductSale::class, 'product_id');
    }


}
