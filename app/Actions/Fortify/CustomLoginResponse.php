<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\Request;

class CustomLoginResponse implements LoginResponseContract
{
public function toResponse($request)
{
    // If MFA is required, redirect to MFA page
    if (session()->has('mfa_user_id')) {
        return redirect()->route('mfa.form');
    }

    $user = auth()->user();
    // Support both string and object role
    if ($user && (
        (isset($user->role) && $user->role === 'admin') ||
        (is_object($user->role) && isset($user->role->RoleName) && strtolower($user->role->RoleName) === 'admin')
    )) {
        return redirect('/admin');
    }
    return redirect()->intended('/todo');
}
};
