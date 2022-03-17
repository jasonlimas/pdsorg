<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LeaderPermission
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
        // If logged in user's role_id is 2, which is Team Leader, then allow access
        if (!auth()->check() || auth()->user()->role_id != 2) {
            abort(403, 'Sorry, you are not authorized to access this page.');
        }

        return $next($request);
    }
}
