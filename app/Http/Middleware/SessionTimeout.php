<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Si el usuario no está autenticado o la sesión ha expirado
        if (Auth::check() && Session::has('last_activity') && (time() - Session::get('last_activity') > config('session.lifetime') * 60)) {
            Auth::logout();
            Session::flush();
            return redirect()->route('login')->with('message', 'Su sesión ha expirado debido a inactividad.');
        }

        // Actualiza la marca de tiempo de la última actividad
        Session::put('last_activity', time());

        return $next($request);
    }
}