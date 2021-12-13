<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Sistema;
use Illuminate\Support\Facades\Auth;

class OpenSystem
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $sistema = Sistema::findOrFail(1);
        if(Auth::check() && $sistema->estado==1)
        {
            return $next($request);
        }
        
        return back()->with('error','El sistema debe estar abierto para utilizar este recurso.');
    }
}
