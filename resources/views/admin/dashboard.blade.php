@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-6">
    <h2 class="text-2xl font-bold mb-6">Admin Dashboard - User Management</h2>

    @if (session('success'))
        <div class="alert alert-success mb-4">
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
                                <span class="text-success fw-semibold">Active</span>
                            @else
                                <span class="text-danger fw-semibold">Inactive</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b">
                            {{ $user->role?->RoleName ?? 'User' }}
                        </td>
                        <td class="py-2 px-4 border-b d-flex gap-2">
                            @if (!$user->is_admin)
                                @if(auth()->user()->hasPermission('Activate'))
                                    @if ($user->is_active)
                                        <form method="POST" action="{{ route('admin.deactivate', $user->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-warning btn-sm">Deactivate</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.activate', $user->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-success btn-sm">Activate</button>
                                        </form>
                                    @endif
                                @endif
                                @if(auth()->user()->hasPermission('Delete'))
                                    <form method="POST" action="{{ route('admin.destroy', $user->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                @endif
                            @else
                                <span class="text-muted fst-italic">Admin</span>
                            @endif
                        </td>
                    </tr>
                    {{-- Show To-Dos and Create Task Form --}}
                    <tr>
                        <td colspan="5" class="bg-light px-4 py-2">
                            <h4 class="fw-semibold mb-1">To-Do Tasks:</h4>
                            @if ($user->todos->isEmpty())
                                <p class="text-muted small">No tasks available.</p>
                            @else
                                <ul class="list-unstyled ps-3 small">
                                    @foreach ($user->todos as $todo)
                                        <li>
                                            <strong>{{ $todo->title }}</strong> - {{ $todo->description }} 
                                            <span class="text-secondary">[{{ $todo->status }}]</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            {{-- Inline Create Task Form --}}
                            @if(auth()->user()->role?->RoleName === 'Admin')
                                <form method="POST" action="{{ route('admin.tasks.store', $user->id) }}" class="mt-3 row g-2 align-items-center">
                                    @csrf
                                    <div class="col-auto">
                                        <input type="text" name="title" placeholder="Task Title" required class="form-control form-control-sm" />
                                    </div>
                                    <div class="col-auto">
                                        <input type="text" name="description" placeholder="Description" class="form-control form-control-sm" />
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary btn-sm">Add Task</button>
                                    </div>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection