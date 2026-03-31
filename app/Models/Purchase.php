<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id', 'supplier_name', 'amount', 'notes'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
