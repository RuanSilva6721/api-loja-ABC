<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Sale extends Model
{
    use HasFactory;
    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'amount', 'cancel'];
    public function productSales()
    {
        return $this->hasMany(ProductSale::class, 'sales_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }


}
