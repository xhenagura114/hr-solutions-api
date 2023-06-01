<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class PermissionsMiddleware
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
        $routeName = $request->route()->getName();

        if (!empty($routeName) && Sentinel::hasAccess($routeName)) {
            return $next($request);
        }


        if(Sentinel::hasAccess($routeName) === false && Sentinel::hasAccess(["module.self-service.feed", "module.self-service.home"])){
            return redirect()->route('module.self-service.feed');
        }

        abort(404);
    }
}
