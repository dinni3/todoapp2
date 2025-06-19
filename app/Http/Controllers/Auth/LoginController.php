<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function loggedOut(Request $request)
    {
        return redirect('/login');
    }

    public function login(LoginRequest $request)
    {
        if (auth()->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended($this->redirectTo());
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // 🔁 Role-based redirection
    protected function redirectTo()
{
    if (auth()->user()->role && auth()->user()->role->RoleName === 'Admin') {
        return '/admin/dashboard';
    }
    return '/todo';
}

    protected function authenticated(Request $request, $user)
{
    if ($user->role->RoleName === 'Admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('todo.index');
}
}
