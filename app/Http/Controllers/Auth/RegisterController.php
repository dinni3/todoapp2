<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/todo';

    public function __construct()
    {
        $this->middleware('guest');
    }

    // ❌ No need for 'validator()' function anymore because RegisterRequest will handle it

    // ✅ Update to use RegisterRequest
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // ✅ Override 'register' method to inject RegisterRequest validation
    public function register(RegisterRequest $request)
    {
        $this->guard()->login($user = $this->create($request->validated()));

        return redirect($this->redirectPath());
    }
}
