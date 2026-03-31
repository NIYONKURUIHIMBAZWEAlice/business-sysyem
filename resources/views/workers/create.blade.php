
@extends('layouts.app')

@section('content')
<div class="container mx-auto">

    <h1 class="text-2xl mb-4">Add Worker</h1>

    <form action="{{ route('workers.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label>Name</label>
            <input type="text" name="name" class="border w-full p-2" required>
        </div>

        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email" class="border w-full p-2" required>
        </div>

        <div class="mb-4">
            <label>Password</label>
            <input type="password" name="password" class="border w-full p-2" required>
        </div>

        <div class="mb-4">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="border w-full p-2" required>
        </div>

        <div class="mb-4">
            <label>Role</label>
            <select name="role" class="border w-full p-2">
                <option value="cashier">Cashier</option>
                <option value="manager">Manager</option>
            </select>
        </div>

        <button class="bg-green-500 text-white px-4 py-2 rounded">Save</button>

    </form>

</div>
@endsection