<?php

namespace App\Http\Middleware;

use Closure;
use Modules\SystemSettingsModule\Entities\Department;
use Sentinel;
use Config;
use Modules\SystemSettingsModule\Entities\GeneralSettings;

class LoginMiddleware
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
        if(Sentinel::guest()){
            return redirect("login");
        }

        view()->share("currentUser", Sentinel::getUser());
        view()->share("darkMode", Sentinel::getUser()->dark_mode);
        view()->share("generalSettings", GeneralSettings::all()->last());
        view()->share("socialNetworks", Config::get("social"));
        view()->share("departments", Department::get());
        app()->setLocale(Sentinel::getUser()->lang);

        return $next($request);
    }
}
