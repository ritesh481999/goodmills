<?php

namespace App\Http\Traits;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

trait SMSTrait
{
    // private $client;
    // private $from;
    // private $lastErrorMessage = null;

    // public function __construct()
    // {
    // }
    
    public function sendSMS(string $message, $phoneNumber)
    {
        $account_sid =  config('common.TWILIO_ACCOUNT_SID') ; 
        $auth_token = config('common.TWILIO_AUTH_TOKEN');
        $rom = config('common.TWILIO_NUMBER');
        $client = new Client($account_sid, $auth_token);
        $res = true;

        try {
            $client->messages->create(
                $phoneNumber,
                [ "messagingServiceSid" => config('common.TWILIO_MSG_SERVICE_ID'),'body' => $message]
            );
            Log::info("Send successfully - " . $phoneNumber);
            //Log::info(json_encode($client));
           
        } catch (\Exception $e) {
            $res = false;
            $astErrorMessage = $e->getMessage();

            Log::channel(config('logging.default'))
                ->error('SMS sending failed: ' . $astErrorMessage);
        }

        return $res;
    }
}
