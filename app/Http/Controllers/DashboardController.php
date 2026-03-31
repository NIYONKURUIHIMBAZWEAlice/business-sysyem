<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to access the dashboard.');
        }

        $business = $user->businesses()->first();

        if(!$business) {
            return redirect()->route('business.create')->with('warning', 'Please create your business first.');
        }

        $totalSales = $business->sales()->sum('total_amount');
        $totalPurchases = $business->purchases()->sum('amount');
        $totalExpenses = $business->expenses()->sum('amount');
        $profit = $totalSales - $totalPurchases - $totalExpenses;

        return view('dashboard', compact('business', 'totalSales', 'totalPurchases', 'totalExpenses', 'profit'));
    }
}