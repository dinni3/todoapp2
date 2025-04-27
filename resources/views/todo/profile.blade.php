@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Profile</h1>

    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <label>Nickname:</label>
            <input type="text" name="nickname" value="{{ old('nickname', $user->nickname) }}">
        </div>

        <div>
            <label>Avatar:</label>
            <input type="file" name="avatar">
            @if ($user->avatar)
                <img src="{{ asset('storage/'.$user->avatar) }}" width="100">
            @endif
        </div>

        <div>
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}">
        </div>

        <div>
            <label>Password (leave blank to keep current):</label>
            <input type="password" name="password">
            <input type="password" name="password_confirmation" placeholder="Confirm Password">
        </div>

        <div>
            <label>Phone:</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}">
        </div>

        <div>
            <label>City:</label>
            <input type="text" name="city" value="{{ old('city', $user->city) }}">
        </div>

        <button type="submit">Update Profile</button>
    </form>

    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Are you sure to delete your account?')">Delete Account</button>
    </form>
</div>
@endsection
