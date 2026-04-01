<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessNotification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'business_id',
        'title',
        'message',
        'is_read',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}