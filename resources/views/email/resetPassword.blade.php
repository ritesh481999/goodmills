@component('mail::message')
# Hello {{ucfirst($user->name)}}   

Your Account has been created you can change your password by clicking on below reset password link.

@component('mail::button', ['url' =>  route('auth.reset.password',['token' => $token->token ]) ])
Reset Password
@endcomponent

Regards,  <br>
GoodMills
@endcomponent


