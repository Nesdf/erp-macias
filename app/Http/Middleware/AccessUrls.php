<?php

namespace App\Http\Middleware;

use Closure;

class AccessUrls
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
        # Obtener nombre de la ruta \Request::route()->getName()
        if(!$request->session()->has('admin_puesto')){
            return redirect('/home');
        }
        $id_user = \Auth::user()->id;
        $aliasRoute =  \Request::route()->getName();
        $exist = \App\RoutesAccess::seeRoute($id_user, $aliasRoute);

        if(!$exist){
            return redirect('/home');
        }
        return $next($request);
    }
}
