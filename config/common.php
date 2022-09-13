<?php

return [
    'api_max_result_set' => 100,
    'api_version' => 'v1',
    'user_role' => [
        'SUPERADMIN' => 1,
        'ADMIN' => 2
    ], 
    'notification_user_type' => [
        'ADMIN' => 1,
        'FARMER' => 2
    ],
    'notification_item_type' => [
        'news'=> 1 ,
        'marketing'=> 2 ,
        'bids'=> 3 ,
        'selling_request'=> 4 ,
        'account_activation'=>5 ,
        'account_rejection'=> 6 ,
        'bid_accecpt_by_farmer'=> 7 ,
        'bid_reject_by_farmer'=> 8 ,
        'country_request_by_farmer'=> 9 ,
        'farmer_delete'=> 10 ,
        'counter_offer' => 11,

    ],
    'item_type' => [
        'news'=> 1 ,
        'marketing'=> 2 ,
        'bids'=> 3 ,
        'selling_request'=> 4 ,
        'account_activation'=>5 ,
        'account_rejection'=> 6 ,
        'bid'=> 7 ,
        'bid'=> 8 ,
        'farmer'=> 9 ,
    ],
    'podcast_audio_mimetypes' => [
        'mp3', 'm4a', 'wav', 'wma', 'amr', 'aa', 'aax'
    ],
    'tonnage' => [
        25, 50, 75,100,125,150,175,200,
        225,250,275,300,325,350,375,400,425,450,475,500,
        1000,
        10000
    ],
    'TWILIO_ACCOUNT_SID'=> 'AC5af9c829f47d6a734c371fbc4c8997ce',
    'TWILIO_AUTH_TOKEN'=> '444501d0923a2633ff432a4514be9591',
    'TWILIO_NUMBER'=> '+13157582880',
    "TWILIO_MSG_SERVICE_ID" => 'MGc1ecb7f065123291191b28b9fe2adfbe',
    'guest_token' => '8aVE4RiuGcV9q97Yt4hTI30aJZqmhW2hXbJ5k33ed9AGyha4Wadvv852HFQrGCiI',
    'safe_string_pattern' => '/(?=.*[A-Za-z])/',
    'client_url' => 'http://84.9.115.70/',
    'country_code' => '+44',
    'default_language' => 'en',
    'default_country_id' => 1,
    'otp_valid_min' => 2,
    'block_login_attempt_time' => 15,
    'fcm_server_key' => 'AAAA1qZAc3o:APA91bGHCAWM18vQ2eqot__hq76yfioxJj8zw0q993bsc5IrakIKCm9WdHxyyuDIzX_7SbKs1YEefzKndGyztbXOAvxF3RVIrnODwdlueiUENBW2ScSeQ_VxhqH5n5gUESaFAZ6WrbEs',
    // 'superAdminEmail' => superAdminEmail(),
    'superAdminEmail' => 'amresh@webol.co.uk',
];
