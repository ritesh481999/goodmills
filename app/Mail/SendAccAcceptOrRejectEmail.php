<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAccAcceptOrRejectEmail extends Mailable
{
    public $farmer;
    public $body;
    public $subject;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($farmer, $body,$subject)
    {
        $this->farmer = $farmer;
        $this->body = $body;
        $this->subject = $subject;
    }

    public function build()
    {
        return $this->markdown('email.AccountAcceptOrRejectEmail')->subject($this->subject);
    }
}
