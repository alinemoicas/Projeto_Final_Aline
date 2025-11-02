<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Redirecciona o utilizador autenticado conforme o seu papel.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                // 🔁 Redireccionamento conforme o tipo de utilizador
                if ($user->role === 'admin') {
                    return redirect()->route('dashboard');
                } elseif ($user->role === 'gestor') {
                    return redirect()->route('gestor.tarefas.new');
                } elseif ($user->role === 'funcionario') {
                    return redirect()->route('funcionarios.perfil.show');
                } else {
                    return redirect('/'); // fallback
                }
            }
        }

        return $next($request);
    }
}
