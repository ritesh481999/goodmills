<?php

return [

    'country_id' => [
        'required' => "Az ország azonosító mező kitöltése kötelező.",
        'integer' => "Az ország azonosítójának egész számnak kell lennie.",
    ],
    'news_id' => [
        'required' => "A hírazonosító mező kötelező.",
        'integer' => "A hír azonosítójának egész számnak kell lennie.",
    ],
    'page' => [
        'required' => "Az oldal mező kitöltése kötelező.",
        'integer' => "Az oldal azonosítójának egész számnak kell lennie.",
    ],
    'limit' => [
        'required' => "A határérték mező kitöltése kötelező.",
        'integer' => "A határértéknek egész számnak kell lennie.",
    ],

];
