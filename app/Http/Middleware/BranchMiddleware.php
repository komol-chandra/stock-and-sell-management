<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class BranchMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user() && Auth::user()->role_id == 2 && Auth::user()->is_active == 1) {
            return $next($request);
        } else {
            if (Auth::user()->is_active == 0) {
                Auth::logout();
                Session::flash('error', 'Your account has been disabled');
            }
            return redirect()->route('login');
        }
    }
}
