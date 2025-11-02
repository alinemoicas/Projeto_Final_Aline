<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Obtém o caminho ao qual o utilizador será redirecionado
     * se não estiver autenticado.
     */
    protected function redirectTo($request): ?string
    {
        // Se a requisição não for API, redireciona para o login
        if (!$request->expectsJson()) {
            return route('login');
        }

        return null;
    }
}