<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'sales_id'];
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function sales()
    {
        return $this->belongsToMany(Sale::class);
    }
}
