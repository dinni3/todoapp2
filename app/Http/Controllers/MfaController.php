<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MfaController extends Controller
{
    public function show()
    {
        if (!session()->has('mfa_user_id')) {
            return redirect('/login');
        }

        return view('auth.mfa');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric'
        ]);

        $user = User::find(session('mfa_user_id'));

        if (!$user || $user->mfa_code != $request->code || now()->gt($user->mfa_expires_at)) {
            return back()->withErrors(['code' => 'Invalid or expired code.']);
        }

        // Clear MFA data
        $user->mfa_code = null;
        $user->mfa_expires_at = null;
        $user->save();

        session()->forget('mfa_user_id');

        // Login user
        Auth::login($user);

        return redirect('/todo'); // or your intended route
    }
}

