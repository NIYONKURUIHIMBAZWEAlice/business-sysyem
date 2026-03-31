<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'business_id', 'name'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'category_id');
    }
}
