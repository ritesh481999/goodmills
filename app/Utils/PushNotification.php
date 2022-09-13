<?php

namespace App\Utils;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Farmer;

class PushNotification
{   
    const URL = "https://fcm.googleapis.com/fcm/send"; 

    private $headers = [];

    public function __construct() {
        $this->headers = [
            'Content-Type: application/json',
            'Authorization: key='. env("FCM_SERVER_KEY")
        ];
    }

    private function sendToIOS($tokenArr,$title,$body,array $data = null)
	{
		$registrationIds = $tokenArr;
		
		$notification = array('title' =>$title , 'body'=>$body, 'sound' => 'default', 'badge' =>'1');

        $payload = array('registration_ids' => $registrationIds, 'notification'=>$notification,'priority'=>'high','data'=> $data);
        
		return $this->dispatchRequest($payload);
	}

	private function sendToAndroid($apnsArr,$title,$body,array $data = null)
	{
		$registrationIds = $apnsArr;
		// prep the bundle
		$bundle = array
		(
			'message' 	=> $body,
			'title'		=> $title,
			'subtitle'	=> '',
			'vibrate'	=> 1,
			'sound'		=> 1,
			'largeIcon'	=> 'large_icon',
			'smallIcon'	=> 'small_icon',
			'addition_data' => $data
		);

		$payload = array
		(
			'registration_ids' => $registrationIds,
			'data'	=> $bundle,
		);
			 
		return $this->dispatchRequest($payload);
	}

    private function dispatchRequest(array $payload) {
        $ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, self::URL );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $this->headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $payload ) );
        $result = curl_exec($ch );
        
        if ($result === FALSE){
            $errorMsg = 'Push notification failed: ' . curl_error($ch);
            Log::channel(config('logging.default'))
            ->error($errorMsg);
        }
		
		curl_close( $ch );
		return $result;
    }

	public function send($mb_ids,$title,$body,$data = null)
	{
		$items = Farmer::select('fcm_token','device_type')->whereIn('mb_id',$mb_ids)->get();
		$tokenArr = array();
        $apnsArr = array();

        foreach ($items as $item) {
            if($item->fcm_token != null)
            {
                if($item->device_type == 2)
                    array_push($tokenArr,$item->fcm_token);
                if($item->device_type == 1)
                    array_push($apnsArr,$item->fcm_token);
            }
        }

        if(!empty($tokenArr)){
        	$this->sendToIOS($tokenArr,$title,$body,$data);
        }
        if(!empty($apnsArr)){
        	$this->sendToAndroid($apnsArr,$title,$body,$data);
        }
	}

}
