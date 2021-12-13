<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;

use Closure;
use Route;
use Auth;

class VerificacionPermisos
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
        //Se verifica que la ruta solicitada está en las permitidas
        //var_dump($request->route()->getName());

        $accion = $request->route()->getAction();
		
        if(count(Auth::user()->rol->accesos()->where('ruta_nombre', '=', $accion['as'])) ){
            return $next($request);
        }      
        // return back()->with('error','No tienes permiso para acceder a esta recurso.');

        return redirect()->route('sistema.error-permiso');
        

    }
}

