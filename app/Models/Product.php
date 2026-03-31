<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id', 'name', 'price', 'stock_quantity'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
