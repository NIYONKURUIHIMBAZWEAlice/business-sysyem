<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('sales', function () {
    return true;
});
