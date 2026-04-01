<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BossOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'boss') {
            return $next($request);
        }

        return redirect()->route('sales.create')->with('error', 'Access denied. Workers cannot view this page.');
    }
}