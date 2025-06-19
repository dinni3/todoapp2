<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
    if (!auth()->check()) {
        abort(403, 'Unauthorized - not logged in');
    }

    // Compare the RoleName from the relationship
    if (!auth()->user()->role || strtolower(auth()->user()->role->RoleName) !== strtolower($role)) {
        abort(403, 'Unauthorized - role mismatch');
    }

    return $next($request);
    }
}
