<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            if (Auth::user()->account_type != 'admin' && Auth::user()->status != '0') {
                return $next($request);
            } else {
                session()->flush();
                return redirect()->route('login');
            }
        }
        return redirect()->route('login');
    }
}
