<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\Request;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
      $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect('/admin');
        }

        return redirect()->intended('/todo'); // or your post-login route
    }
}
