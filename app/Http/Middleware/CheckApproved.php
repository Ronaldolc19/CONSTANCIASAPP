<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
//use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;  

class CheckApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Si el usuario NO está aprobado, impedir acceso
        if (!Auth::user()->is_approved) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Tu cuenta aún no ha sido aprobada por el administrador.');
        }

        return $next($request);
    }
}
