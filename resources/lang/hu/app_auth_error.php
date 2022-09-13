<?php

return [

    'username' => [
        'required' => "A felhasználónév mező kitöltése kötelező.",
    ],
    'pin' => [
        'required' => "A pin mező kitöltése kötelező.",
        'integer' => "A csapnak egész számnak kell lennie.",
        'digits' => "A PIN-kódnak 6 számjegyűnek kell lennie.",
        'numeric' =>  "A tűnek egy számnak kell lennie.",
    ],
    'fcm_token' => [
        'required' => "Az fcm token mező kitöltése kötelező.",
    ],
    'device_token' => [
        'required' => "Az eszközjelző mező kitöltése kötelező.",
    ],
    'device_type' => [
        'required' => "Az eszköz típusa mező kitöltése kötelező.",
    ],
    'forgot_token' => [
        'required' => "Az elfelejtett jogkivonat mező szükséges.",
    ],
    'otp' => [
        'required' => "Az otp mező kitöltése kötelező.",
        'digits' => "Az otp-nek 6 számjegyűnek kell lennie.",
    ],
    'reset_token' => [
        'required' => "A visszaállítási jogkivonat mező szükséges.",
    ],
    'current_pin' => [
        'required' => "Az aktuális pin mező kitöltése kötelező.",
        'digits' => "Az áramtű 6 számjegyű.",
    ],
    'confirm_pin' => [
        'required' => "A PIN-kód megerősítése mező kitöltése kötelező.",
        'same' => "A megerősítő csapnak és a csapnak meg kell egyeznie.",
    ],
    'name' => [
        'required' => "A név mező kitöltése kötelező.",
        'min' => "A névnek legalább 2 karakterből kell állnia.",
        'max' => "A név nem lehet 30 karakternél hosszabb.",
    ],
    'username' => [
        'required' => "A felhasználónév mező kitöltése kötelező.",
        'min' => "A felhasználónévnek legalább 2 karakterből kell állnia.",
        'max' => "A felhasználónév nem lehet 20 karakternél hosszabb.",
        'alpha_num' => "A felhasználónév csak betűket és számokat tartalmazhat.",
        'unique' => "A felhasználónév már megvan.",
    ],
    'email' => [
        'required' => "Az e-mail mező kitöltése kötelező.",
        'min' => "Az e-mailnek legalább 2 karakterből kell állnia.",
        'max' => "Az e-mail nem lehet 30 karakternél hosszabb.",
        'unique' => "Az e-mail már el lett foglalva.",
    ],
    'company_name' => [
        'required' => "A cégnév mező kitöltése kötelező.",
        'min' => "A cégnévnek legalább 2 karakterből kell állnia.",
        'max' => "A cégnév nem lehet 30 karakternél hosszabb.",
    ],
    'registration_number' => [
        'alpha_num' => "A nyilvántartási szám csak betűket és számokat tartalmazhat.",
        'max' => "A nyilvántartási szám nem lehet 12 karakternél hosszabb.",
    ],
    'dialing_code' => [
        'required' => "A tárcsázási kód mező kitöltése kötelező.",
        'regex' => "A helyes tárcsázási kód megadása.",
    ],
    'phone' => [
        'required' => "A telefon mező kitöltése kötelező.",
        'integer' => "A telefonszámnak egész számnak kell lennie.",
        'digits_between' => "A telefonszámnak 2 és 20 számjegy között kell lennie.",
    ],
    'address' => [
        'required' => "A cím mező kitöltése kötelező.",
        'min' => "A címnek legalább 2 karakterből kell állnia.",
        'max' => "A cím nem lehet 30 karakternél hosszabb.",
    ],
    'country_id' => [
        'required' => "Az ország azonosító mező kitöltése kötelező.",
    ],
    'user_type' => [
        'required' => "A felhasználói típus mező kitöltése kötelező.",
        'min' => "A felhasználó típusának legalább 2 karakterből kell állnia.",
        'max' => "A felhasználó típusa nem lehet 30 karakternél hosszabb.",
    ],
    'scheduled_deleted_date' => [
        'required' => "A tervezett törlési dátum mező kitöltése kötelező.",
        'date' => "A tervezett törlési dátum nem érvényes dátum.",
        'date_format' => "A tervezett törlési dátum nem felel meg a Y-m-d formátumnak.",
    ],

];
