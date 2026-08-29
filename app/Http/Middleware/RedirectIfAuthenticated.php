<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $redirectTo = match (Auth::user()->role) {
                    'profissional' => route('profissional.dashboard', absolute: false),
                    default => route('dashboard', absolute: false),
                };

                return redirect($redirectTo);
            }
        }

        return $next($request);
    }
}
