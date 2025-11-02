<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        if (!$userRole || !in_array(strtolower($userRole), $roles)) {
            abort(403, 'Acesso negado: não tem permissão para visualizar esta página.');
        }

        return $next($request);
    }
}
