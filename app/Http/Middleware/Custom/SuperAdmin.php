<?php

namespace App\Http\Middleware\Custom;

use Closure;
use App\Helpers\Qs;
use Illuminate\Support\Facades\Auth;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        // Allow both super_admin and admin users
        if (!Qs::userIsSuperAdmin() && !Qs::userIsAdmin()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
