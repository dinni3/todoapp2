<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\Request;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // If MFA is pending, redirect to MFA screen instead of login
        if (session()->has('mfa_user_id')) {
            return redirect('/mfa');
        }

        return redirect()->intended('/todo'); // or your post-login route
    }
}
