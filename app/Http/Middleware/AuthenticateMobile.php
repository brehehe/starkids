<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateMobile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->is('mobile/*')) {
                return redirect()->route('mobile.login');
            }

            if ($request->is('admin/*')) {
                return redirect()->route('admin.login');
            }

            return redirect('/login'); // default
        }

        return $next($request);
    }
}
