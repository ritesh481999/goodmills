<?php

return [

    'country_id' => [
        'required' => 'The country id  field is required.',
    ], 
    'is_news_sms' => [
        'required' => 'The news sms  field is required.',
        'in'=>'The selected news sms is invalid.',
    ], 
    'is_marketing_sms' => [
        'required' => 'The marketing sms  field is required.',
        'in'=>'The selected marketing sms is invalid.',
    ], 
    'is_bids_received_sms' => [
        'required' => 'The bids received sms  field is required.',
        'in'=>'The selected  bids received sms is invalid.',
    ], 
    'is_news_notification' => [
        'required' => 'The news notification  field is required.',
        'in'=>'The selected is news notification is invalid.',
    ], 
    'is_marketing_notification' => [
        'required' => 'The is marketing notification  field is required.',
        'in'=>'The selected marketing notification is invalid.',
    ], 
    'is_bids_received_notification' => [
        'required' => 'The is bids received notification  field is required.',
        'in'=>'The selected bids received notification is invalid.',
    ], 

];
