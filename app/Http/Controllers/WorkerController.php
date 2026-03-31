<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WorkerController extends Controller
{
    public function index()
    {
        $business = Auth::user()->business;
        $workers = $business->workers()->get();
        return view('workers.index', compact('workers'));
    }

    public function create()
    {
        return view('workers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:workers,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $business = Auth::user()->business;

        Worker::create([
            'business_id' => $business->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'cashier',
            'is_active' => true,
        ]);

        return redirect()->route('workers.index')->with('success', 'Worker added successfully!');
    }

    public function edit(Worker $worker)
    {
        return view('workers.edit', compact('worker'));
    }

    public function update(Request $request, Worker $worker)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:workers,email,' . $worker->id,
        ]);

        $worker->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role ?? $worker->role,
        ]);

        return redirect()->route('workers.index')->with('success', 'Worker updated successfully!');
    }

    public function destroy(Worker $worker)
    {
        $worker->delete();
        return redirect()->route('workers.index')->with('success', 'Worker deleted!');
    }

    public function toggleStatus(Worker $worker)
    {
        $worker->is_active = !$worker->is_active;
        $worker->save();

        return redirect()->route('workers.index')->with('success', 'Worker status updated!');
    }
}