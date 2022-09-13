<?php

namespace App\Http\Middleware;

use Closure;

class TimeZone
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
        $time_zone = $request->header('time-zone') ?? '';

        if($time_zone){ 
            date_default_timezone_set($time_zone) ; 
            return $next($request);
        } else {
           // return $next($request);
            return apiFormatResponse('Pass the timezone', null, '', false, 406);
        }
    }
}
