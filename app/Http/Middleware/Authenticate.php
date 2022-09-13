<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    public function handle($request, \Closure $next, ...$guards)
    {
        if (!in_array('api', $guards)) {
            $this->authenticate($request, $guards);
            $user = $request->user();

            if (!$user->is_active) {
                throw new AuthenticationException(
                    'Unauthenticated.',
                    $guards,
                    $this->redirectTo($request)
                );
            } else if (!$user) {
                throw new AuthenticationException(
                    'Unauthenticated.',
                    $guards,
                    $this->redirectTo($request)
                );
            }
        } else if (!auth()->guard('api')->user()) {
            return apiFormatResponse(trans('app_auth.unauthorized'), null, '', false, 401);
        } else if(auth()->guard('api')->user()->is_suspend) {
            return apiFormatResponse(trans('app_auth.suspend_account'), null, '', false, 401);
        }

        return $next($request);
    }

    protected function redirectTo($request)
    {
        if (false === ($request->expectsJson() || $request->ajax() || $request->wantsJson()))
            return route('auth.login');
        return null;
    }
}
