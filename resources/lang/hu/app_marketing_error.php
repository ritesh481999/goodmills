<?php

return [

    'country_id' => [
        'required' => "Az országazonosító mező kitöltése kötelező.",
        'integer' => "Az országazonosítónak egész számnak kell lennie.",
    ],
    'marketing_id' => [
        'required' => "A marketingazonosító mező kitöltése kötelező.",
        'integer' => "A marketingazonosítónak egész számnak kell lennie.",
    ],
    'page' => [
        'required' => "'Az oldal mező kitöltése kötelező.",
        'integer' => "Az oldalazonosítónak egész számnak kell lennie.",
    ],
    'limit' => [
        'required' => "A limit mező kitöltése kötelező.",
        'integer' => "A korlátnak egész számnak kell lennie.",
    ],

];
