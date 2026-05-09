<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class AdminMiddleware
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
        if (Auth::check()) {
            $user = Auth::user();

            $roleName = null;

            if (!empty($user->role_id)) {
                $roleName = Role::find($user->role_id)->name ?? null;
            } elseif (is_string($user->role) && $user->role !== '') {
                $roleName = $user->role;
            }

            if ($roleName === 'admin') {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized. Admin access only.');
    }
}
