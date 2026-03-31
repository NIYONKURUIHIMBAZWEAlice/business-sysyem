@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl mb-6">Dashboard for {{ $business->name }}</h1>

    <div class="grid grid-cols-4 gap-4">
        <div class="bg-green-200 p-4 rounded">
            <h2>Total Sales</h2>
            <p class="text-xl font-bold">${{ number_format($totalSales, 2) }}</p>
        </div>
        <div class="bg-red-200 p-4 rounded">
            <h2>Total Purchases</h2>
            <p class="text-xl font-bold">${{ number_format($totalPurchases, 2) }}</p>
        </div>
        <div class="bg-yellow-200 p-4 rounded">
            <h2>Total Expenses</h2>
            <p class="text-xl font-bold">${{ number_format($totalExpenses, 2) }}</p>
        </div>
        <div class="bg-blue-200 p-4 rounded">
            <h2>Profit / Loss</h2>
            <p class="text-xl font-bold">${{ number_format($profit, 2) }}</p>
        </div>
    </div>
</div>

<!-- Pusher JS -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    Pusher.logToConsole = false;

    var pusher = new Pusher('6284f8b34b5de222e225', {
        cluster: 'ap2'
    });

    var channel = pusher.subscribe('sales');

    channel.bind('new.sale', function(data) {
        // Create notification popup
        var notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #22c55e;
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            z-index: 9999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        `;
        notification.innerHTML = '💰 New Sale Recorded!<br>Amount: $' + data.sale.total_amount + '<br>Worker ID: ' + data.sale.worker_id;
        document.body.appendChild(notification);

        // Remove notification after 5 seconds then reload
        setTimeout(function() {
            notification.remove();
            location.reload();
        }, 5000);
    });
</script>