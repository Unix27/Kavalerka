<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Permissions
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
//        $roles = array_slice(func_get_args(), 2);
//        foreach($roles as $role){
//            if ($request->user()->hasRole($role)){
//                return $next($request);
//            }
//        }


        $user = Auth::user();
        $input = $request->all();


        if ($request->hasHeader('X-Header-Name')) {
            //
        }

        return [$request->path()];
//
//        auth()->user()->role->permissions()->where('url')

        return redirect('404');


//        if (Auth::user()->hasRole($role)) {
//            return $next($request);
//        }else{
//            return redirect('404');
//        }
    }
}
