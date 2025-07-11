
@extends('layouts.app')
@section('content')
<div class="container">
<br>
   <div class="row justify-content-center">
      <div class="col-md-6">
          <h2>Todos List</h2>
      </div>
<div class="col-md-6">
    <div class="float-right">
        @if(auth()->user()->hasPermission('Create'))
            <a href="{{ route('todo.create') }}" class="btn btn-primary" ><i class="fas fa-plus"></i> Add Todo</a>
        @endif
    </div>
</div>
<br>
<div class="col-md-12">
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
@endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
          <th width="5%">#</th>
          <th>Task Name</th>
          <th width="10%"><center>Task Status</center></th>
          <th width="14%"><center>Action</center></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($todos as $todo)
            <tr>
                <th>{{ $todo->id }}</th>
                <td>{{ $todo->title }}</td>
                <td><center>{{ $todo->status }}</center></td>
                <td>
                    <div class = "action_btn">
                        @if(auth()->user()->hasPermission('Update'))
                            <a href="{{ route('todo.edit', $todo->id) }}" class="btn btn-warning">Edit</a>
                        @endif
                    </div>
                    <div class="action_btn margin-left-10">
                        @if(auth()->user()->hasPermission('Delete'))
                            <form action="{{ route('todo.destroy', $todo->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        @endif
                    </div>
</td>
</tr>
@empty
<tr>
    <td colspan="4"><center>No data found</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
@endsection