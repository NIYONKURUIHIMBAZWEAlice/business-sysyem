<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SaleRecorded implements ShouldBroadcast
{
    public $sale;

    public function __construct($sale)
    {
        $this->sale = $sale;
    }

    public function broadcastOn()
    {
        return new Channel('sales');
    }

    public function broadcastAs()
    {
        return 'new.sale';
    }
}