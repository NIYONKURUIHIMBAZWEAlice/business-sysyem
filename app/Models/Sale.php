<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id', 'worker_id', 'total_amount',
        'payment_method', 'gps_location', 'status'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
