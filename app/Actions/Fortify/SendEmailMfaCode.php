<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\EmailMfaCode;

class SendEmailMfaCode
{
    public function handle(Request $request, $next)
    {
        $user = Auth::user();

        if ($user) {
            // Generate and store code
            $code = rand(100000, 999999);
            $user->mfa_code = $code;
            $user->mfa_expires_at = now()->addMinutes(10);
            $user->save();

            // Send code via notification
            $user->notify(new EmailMfaCode($code));

            // Store user ID in session for MFA
            session(['mfa_user_id' => $user->id]);

            // Log out the user until MFA is complete
            Auth::logout();

            // Redirect to MFA challenge
            return redirect()->route('mfa.show');
        }

        return $next($request);
    }
}
