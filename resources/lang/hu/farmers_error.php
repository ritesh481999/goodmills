<?php

return [

    'name' => [
        'required' => "A név mező kitöltése kötelező.",
        'string' => "A névnek egy karakterláncnak kell lennie.",
    ],
    'username' => [
        'required' => "A felhasználónév mező kitöltése kötelező.",
        'max' => "A felhasználónév nem lehet 100 karakternél hosszabb.",
        'unique' => "A felhasználónév már foglalt.",
    ],
    'email' => [
        'required' => "Az e-mail mező kitöltése kötelező.",
        'unique' => "Az e-mail már el lett foglalva.",
    ],
    'company_name' => [
        'required' => "A cégnév mező kitöltése kötelező.",
        'max' => "A cégnév nem lehet 100 karakternél hosszabb.",

    ],
    'pin' => [
        'required' => "A pin mező kitöltése kötelező.",
        'min' => "A PIN-kódnak legalább 6 karakterből kell állnia.",
        'max' => "A pin nem lehet 12 karakternél hosszabb.",

    ],
    'dialing_code' => [
        'required' => "A tárcsázási kód mező kitöltése kötelező.",
        'regex' => "Érvénytelen formátum",
    ],
    'phone' => [
        'required' => "A telefon mező kitöltése kötelező.",
        'integer' => "A telefonnak egésznek kell lennie",
        'digits_between' => "A telefonszámnak 2 és 20 számjegy között kell lennie."
    ],
    'address' => [
        'required' => "A cím mező kitöltése kötelező.",
        'min' => "A címnek legalább 2 karakterből kell állnia.",
        'max' => "A cím nem lehet 30 karakternél hosszabb.",
    ],
    'user_type' => [
        'required' => "A felhasználói típus mező kitöltése kötelező.",
    ],
    'others' => [
        'required_if' => "A mező kitöltése kötelező.",
    ],
    'status' => [
        'required' => "A státusz mező kitöltése kötelező.",
    ],
    'reason' => [
        'required_if' => "Az ok mező kitöltése kötelező.",
    ],

    'is_news_sms' => [
        'required' => "Az Új SMS mező kitöltése kötelező.",
    ],

    'is_marketing_sms' => [
        'required' => "A Marketing SMS mező kitöltése kötelező.",
    ],

    'is_bids_received_sms' => [
        'required' => "Az Ajánlat SMS mező kitöltése kötelező.",
    ],

    'is_news_notification' => [
        'required' => "A Hírek értesítése mező kitöltése kötelező.",
    ],

    'is_marketing_notification' => [
        'required' => "A Marketing értesítés mező kitöltése kötelező.",
    ],

    'is_bids_received_notification' => [
        'required' => "Az Ajánlat mező kitöltése kötelező.",
    ],
];
