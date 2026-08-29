<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorAuth
{
    protected array $except = [
        '2fa.ativar',
        '2fa.ativar.confirmar',
        '2fa.verificar',
        '2fa.verificar.codigo',
        '2fa.desativar',
        'login',
        'logout',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        $route = $request->route()?->getName();

        if ($route && in_array($route, $this->except)) {
            return $next($request);
        }

        if ($user->two_factor_confirmed_at && ! session('2fa_verificado')) {
            return redirect()->route('2fa.verificar');
        }

        if ($user->role === 'admin' && ! $user->two_factor_confirmed_at) {
            return redirect()->route('2fa.ativar');
        }

        return $next($request);
    }
}
