<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest; // ✅ Import LoginRequest

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/todo';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function loggedOut(Request $request)
    {
        return redirect('/login');
    }

    // ✅ Override 'login' method to inject LoginRequest validation
    public function login(LoginRequest $request)
    {
        if (auth()->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended($this->redirectPath());
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
