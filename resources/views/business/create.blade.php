
@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl mb-4">Create Your Business</h1>

    <form action="{{ route('business.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block">Business Name</label>
            <input type="text" name="name" id="name" class="border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label for="phone" class="block">Phone</label>
            <input type="text" name="phone" id="phone" class="border p-2 w-full">
        </div>

        <div class="mb-4">
            <label for="address" class="block">Address</label>
            <textarea name="address" id="address" class="border p-2 w-full"></textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Business</button>
    </form>
</div>
@endsection