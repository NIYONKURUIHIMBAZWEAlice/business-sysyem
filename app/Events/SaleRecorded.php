<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SaleRecorded implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

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