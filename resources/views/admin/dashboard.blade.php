@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-6">
    <h2 class="text-2xl font-bold mb-6">Admin Dashboard - User Management</h2>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 shadow-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Email</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Role</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                        <td class="py-2 px-4 border-b">
                            @if ($user->is_active)
                                <span class="text-green-600 font-semibold">Active</span>
                            @else
                                <span class="text-red-600 font-semibold">Inactive</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b">
                            {{ $user->role ?? 'User' }}
                        </td>
                        <td class="py-2 px-4 border-b flex gap-2">
                            @if (!$user->is_admin)
                                @if ($user->is_active)
                                    <form method="POST" action="{{ route('admin.deactivate', $user->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="bg-yellow-500 text-white px-3 py-1 rounded">Deactivate</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.activate', $user->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="bg-green-500 hover:bg-green-700 text-white px-3 py-1 rounded">Activate</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.destroy', $user->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">Delete</button>
                                </form>
                            @else
                                <span class="text-gray-400 italic">Admin</span>
                            @endif
                        </td>
                    </tr>
                    {{-- Show To-Dos --}}
                    <tr>
                        <td colspan="5" class="bg-gray-50 px-4 py-2">
                            <h4 class="font-semibold mb-1">To-Do Tasks:</h4>
                            @if ($user->todos->isEmpty())
                                <p class="text-sm text-gray-600">No tasks available.</p>
                            @else
                                <ul class="list-disc pl-6 text-sm">
                                    @foreach ($user->todos as $todo)
                                        <li>
                                            <strong>{{ $todo->title }}</strong> - {{ $todo->description }} 
                                            <span class="text-gray-500">[{{ $todo->status }}]</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
