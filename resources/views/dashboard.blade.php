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

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    Pusher.logToConsole = false;

    var pusher = new Pusher('6284f8b34b5de222e225', {
        cluster: 'ap2'
    });

    var channel = pusher.subscribe('sales');

    channel.bind('new.sale', function(data) {
        var sale = data.sale;

        // Build products list
        var productsList = '';
        if (sale.items && sale.items.length > 0) {
            sale.items.forEach(function(item) {
                productsList += '• ' + item.product.name;
                if (item.product.description) {
                    productsList += ' (' + item.product.description + ')';
                }
                productsList += ' x' + item.quantity + ' @ $' + item.price + '<br>';
            });
        }

        var paymentIcon = sale.payment_method === 'cash' ? '💵 Cash' : '📱 Mobile Money';

        // Create notification popup
        var notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #16a34a;
            color: white;
            padding: 20px 28px;
            border-radius: 10px;
            font-size: 15px;
            z-index: 9999;
            box-shadow: 0 4px 16px rgba(0,0,0,0.25);
            max-width: 340px;
            line-height: 1.8;
        `;
        notification.innerHTML = `
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                <strong style="font-size:17px">💰 New Sale Recorded!</strong>
                <span onclick="this.parentElement.parentElement.remove()" style="cursor:pointer;font-size:20px;margin-left:16px">✕</span>
            </div>
            <strong>Products:</strong><br>${productsList}<br>
            <strong>Total:</strong> $${sale.total_amount}<br>
            <strong>Payment:</strong> ${paymentIcon}<br>
            <strong>Worker ID:</strong> ${sale.worker_id}<br><br>
            <small style="opacity:0.8">Click ✕ to dismiss</small>
        `;
        document.body.appendChild(notification);

        // Auto remove after 30 seconds
        setTimeout(function() {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 30000);
    });
</script>