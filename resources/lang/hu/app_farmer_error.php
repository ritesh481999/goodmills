<?php

return [

    'country_id' => [
        'required' => "Az ország azonosító mező kitöltése kötelező.",
    ], 
    'is_news_sms' => [
        'required' => "A hír sms mező kitöltése kötelező.",
        'in'=>"A kiválasztott hír sms érvénytelen.",
    ], 
    'is_marketing_sms' => [
        'required' => "A marketing sms mező kitöltése kötelező.",
        'in'=>"56A kiválasztott marketing sms érvénytelen.",
    ], 
    'is_bids_received_sms' => [
        'required' => "A kapott ajánlatok sms mező kitöltése kötelező.",
        'in'=>"A kiválasztott ajánlatok fogadott sms érvénytelen.",
    ], 
    'is_news_notification' => [
        'required' => "A hírértesítés mező kitöltése kötelező.",
        'in'=>"A kiválasztott hír értesítés érvénytelen.",
    ], 
    'is_marketing_notification' => [
        'required' => "Az is marketing értesítés mező kitöltése kötelező.",
        'in'=>"A kiválasztott marketing értesítés érvénytelen.",
    ], 
    'is_bids_received_notification' => [
        'required' => "Az is bids received notification mező kitöltése kötelező.",
        'in'=>"A kiválasztott ajánlatokról kapott értesítés érvénytelen.",
    ], 

];
