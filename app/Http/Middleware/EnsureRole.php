<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role = 'user')
    {
        if(($role == 'admin' && !$request->user()->is_admin) || ($role == 'user' && $request->user()->is_admin))
        {
            return response()->returnResult(status: 'no', message: 'Forbidden', response_code: Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
