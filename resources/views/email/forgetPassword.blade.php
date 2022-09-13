<!DOCTYPE html>
<html>
    <title>{{trans('forgetPassword.otp_expire_msg')}}<title>
    <head></head>
    <body>
        <div>
            <p>{{  str_replace(['#NAME'],[$user->name],trans('forgetPassword.welcome_email'))  }}</p>
            <p>{{  str_replace(['#OTP'],[$otp],trans('forgetPassword.greeting_email'))  }}</p>
            <p>{{  str_replace(['#VALID_TIME'],[config('common.otp_valid_min')],trans('forgetPassword.otp_expire_msg'))  }}</p>
        </div>
    </body>
</html>