<?php

namespace App\Utils;
use Illuminate\Auth\AuthenticationException;

class Error {

    public static function error(string $message)
    {
        abort(400, $message);
    }

    // public static function warning(string $message)
    // {
    //     abort(409, $message);
    // }

    // public static function forbidden(string $message = 'Forbidded!')
    // {
    //     abort(403, $message);
    // }

    public static function authFail()
    {
        throw new AuthenticationException('Unauthenticated');
    }
}