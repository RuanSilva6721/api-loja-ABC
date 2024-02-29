<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'amount', 'quantity','product_id'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
