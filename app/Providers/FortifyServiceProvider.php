<?php

namespace App\Providers;

use Laravel\Fortify\Contracts\LoginResponse;
use App\Actions\Fortify\CustomLoginResponse;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LoginResponse::class, CustomLoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();
        
            if ($user && Hash::check($user->salt . $request->password, $user->password)) {
                // Generate and store MFA code
                $code = rand(100000, 999999);
                $user->mfa_code = $code;
                $user->mfa_expires_at = now()->addMinutes(10);
                $user->save();
        
                // Send code to user's email
                Mail::raw("Your MFA code is: $code", function ($message) use ($user) {
                    $message->to($user->email)->subject('Your MFA Code');
                });
        
                // Save user ID in session for MFA
                session(['mfa_user_id' => $user->id]);
        
                // Don't return the user yet — login happens after MFA
                return null;
            }
        
            return null; // Login fails
        });
        
        

        Fortify::loginView(function () {
            return view('auth.login');
       });
       Fortify::registerView(function () {
        return view('auth.registration');
    });
    Fortify::confirmPasswordView(function () {
        return view('auth.confirm-password');
    });
    Fortify::twoFactorChallengeView(function () {
        return view('auth.two-factor-challenge');
     });
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(3)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(3)->by($request->session()->get('login.id'));
        });
    }
}
