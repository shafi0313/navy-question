<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->permission == 1) {
            return $next($request);
        } else {
            Session::flush();
            Auth::logout();

            return redirect()->route('login');
        }

        return $next($request);
    }
}
