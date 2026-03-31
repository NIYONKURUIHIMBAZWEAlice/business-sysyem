
@extends('layouts.app')

@section('content')
<div class="container mx-auto">

    <h1 class="text-2xl mb-4">Edit Worker</h1>

    <form action="{{ route('workers.update', $worker->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label>Name</label>
            <input type="text" name="name" value="{{ $worker->name }}" class="border w-full p-2" required>
        </div>

        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email" value="{{ $worker->email }}" class="border w-full p-2" required>
        </div>

        <div class="mb-4">
            <label>Role</label>
            <select name="role" class="border w-full p-2">
                <option value="cashier" {{ $worker->role == 'cashier' ? 'selected' : '' }}>Cashier</option>
                <option value="manager" {{ $worker->role == 'manager' ? 'selected' : '' }}>Manager</option>
            </select>
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>

    </form>

</div>
@endsection