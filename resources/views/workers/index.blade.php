
@extends('layouts.app')

@section('content')
<div class="container mx-auto">

    <h1 class="text-2xl mb-4">Workers</h1>

    <a href="{{ route('workers.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Worker</a>

    <table class="table-auto w-full mt-4 border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($workers as $worker)
            <tr class="border">
                <td class="p-2">{{ $worker->name }}</td>
                <td>{{ $worker->email }}</td>
                <td>{{ $worker->role }}</td>
                <td>
                    @if($worker->is_active)
                        <span class="text-green-600">Active</span>
                    @else
                        <span class="text-red-600">Inactive</span>
                    @endif
                </td>

                <td>
                    <a href="{{ route('workers.edit', $worker->id) }}" class="text-blue-500">Edit</a> |

                    <a href="{{ route('workers.toggleStatus', $worker->id) }}" class="text-yellow-500">Toggle</a> |

                    <form action="{{ route('workers.destroy', $worker->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection