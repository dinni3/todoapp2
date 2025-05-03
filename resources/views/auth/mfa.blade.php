@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Enter the MFA Code</h3>
    <form method="POST" action="/mfa">
        @csrf
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" name="code" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Verify</button>
    </form>
</div>
@endsection
