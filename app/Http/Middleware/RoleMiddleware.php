<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   
     public function handle($request, Closure $next, ...$roles)
     {
         if (Auth::check() && in_array(Auth::user()->role, $roles)) {
             return $next($request);
         }
 
         return redirect('/home')->with('error', 'No tienes permisos para acceder a esta página.');
     }
}