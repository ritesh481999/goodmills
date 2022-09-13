<!DOCTYPE html>
<html>

<head>
    <title>@lang('app_auth.email_subject')<title>
</head>

<body>
    <div>
        <p>
            @lang('app_auth.greeting_email', ['name' => $user->name, 'app_name' => config('app.name')])
        </p>
        <p>
            @lang('app_auth.otp', ['otp' => $otp])
        </p>
        <p>
            @lang('app_auth.otp_valid', ['mins' => config('common.otp_valid_min')])
        </p>
        <p>
            @lang('app_auth.otp_content', ['app_name' => config('app.name')])
        </p>
    </div>
</body>

</html>
