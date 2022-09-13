<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class APILanguageSwitcher
{
    public function handle($request, \Closure $next)
    {

        $language = $request->header('language') ?? '';

        if($language){
            App::setLocale($language);
            return $next($request);
        } else {
            return apiFormatResponse('Pass the language', null, '', false, 406);
        }
    
    }
}
