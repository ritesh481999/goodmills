<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class forgetPasswordEmail extends Mailable
{
    public $user;
    public $otp;
    use Queueable, SerializesModels;

    public function __construct($user, $otp)
    {
        $this->user = $user;
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->markdown('email.forgetPassword')->subject(__('messages.forget_password_subject'));
    }
}
