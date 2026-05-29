<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RequirePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user has recently confirmed password (within 3 hours)
        if (!Session::has('password_confirmed_at') || 
            now()->diffInMinutes(Session::get('password_confirmed_at')) > 180) {
            
            // Store the intended URL
            Session::put('url.intended', $request->fullUrl());
            
            // Redirect to password confirmation
            return redirect()->route('password.confirm');
        }

        return $next($request);
    }
}
