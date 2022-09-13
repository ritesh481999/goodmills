<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LanguageSwitcher
{
    public function handle($request, \Closure $next)
    {
        if (auth()->user()->selected_country_id) {
            App::setLocale(Auth::user()->selected_country->language);
            date_default_timezone_set(Auth::user()->selected_country->time_zone);
        }

        Session::put('locale', Config::get('common.default_language'));

        return $next($request);
    }
}
