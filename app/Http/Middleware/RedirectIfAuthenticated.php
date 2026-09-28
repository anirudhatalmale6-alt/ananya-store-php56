<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * Sends an already-authenticated visitor away from the guest-only screens
     * (login / register / password reset) to their own home screen.
     *
     * The Laravel 5.4 skeleton ships this pointing at "/home", a route this
     * application does not define — that produced a 404. Administrators are
     * sent to the Admin Dashboard, everyone else to their account dashboard.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string|null              $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();

            if ($user && $user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('customer.dashboard');
        }

        return $next($request);
    }
}
