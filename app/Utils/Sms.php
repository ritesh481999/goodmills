<?php

namespace App\Utils;

use Twilio\Rest\Client;
use Log;

class Sms
{
    private $client;
    private $from;
    private $lastErrorMessage = null;
    
    public function __construct() {
        $account_sid = env("TWILIO_ACCOUNT_SID");
        $auth_token = env("TWILIO_AUTH_TOKEN");
        $this->from = env("TWILIO_NUMBER");
        $this->client = new Client($account_sid, $auth_token);
    }

    public function send(string $message, string $recipient)
    {
        $res = true;
        try {
            // throw new \Exception("SMS is turned off.", 1);
            $r = $this->client->messages->create($recipient,
            ['from' => $this->from, 'body' => $message] );
        }catch(\Exception $e) {
            $res = false;
            $this->lastErrorMessage = $e->getMessage();
            Log::channel(config('logging.default'))
            ->error('SMS sending failed: '.$this->lastErrorMessage);
        }
        
        return $res;
    }

    public function getLastErrorMessage() {
        return $this->lastErrorMessage;
    }
}
