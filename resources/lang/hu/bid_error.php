<?php

return [

    'date_of_movement' => [
        'required' => "A költözés dátuma kötelező.",
        'date_format' => "A mozgás dátumának Y-h-d formátumban kell lennie.",
    ],
    'tonnage' => [
        'required' => "Az űrtartalom mező megadása kötelező.",
        'integer' => "Az űrtartalomnak egész számnak kell lennie.",
    ],
    'commodity_id' => [
        'required' => "Az árucikk mező kitöltése kötelező.",
        'integer' => "Az árunak egész számnak kell lennie.",
    ],
    'variety_id' => [
        'required' => "A fajtamező kitöltése kötelező.",
        'integer' => "A fajtának egész számnak kell lennie.",
    ],
    'specification_id' => [
        'required' => "A specifikációs mező kitöltése kötelező.",
        'integer' => "A specifikációnak egész számnak kell lennie.",
    ],
    'delivery_method' => [
        'required' => "A szállítási mód mező kitöltése kötelező.",
        'integer' => "A szállítási módnak egész számnak kell lennie.",
    ],
    'delivery_address' => [
        'required_if' => "A szállítási cím mező kitöltése kötelező, ha a szállítási mód Exam.",
    ],
    'delivery_location_id' => [
        'required_if' => "A szállítási hely mező kitöltése kötelező, ha a szállítási módot Ön szállítja.",
    ],
    'postal_code' => [
        'required_if' => "A PIN kód mező kitöltése kötelező, ha a szállítási módot Ön szállítja.",
        'integer' => "A PIN-kódnak egész számnak kell lennie.",
    ],
    'page' => [
        'required' => "Az oldal mező kitöltése kötelező.",
        'integer' => "Az oldalazonosítónak egész számnak kell lennie.",
    ],
    'limit' => [
        'required' => "A limit mező kitöltése kötelező.",
        'integer' => "A korlátnak egész számnak kell lennie.",
    ],
    'bid_id' => [
        'required' => "Az ajánlatazonosító mező kitöltése kötelező.",
        'integer' => "Az ajánlati azonosítónak egész számnak kell lennie.",
        'exists' => "A kiválasztott ajánlati azonosító érvénytelen.",
    ],
    'status' => [
        'required' => "Az állapot mező kitöltése kötelező.",
        'integer' => "Az állapotnak egész számnak kell lennie.",
    ],
    'tonnage' => [
        'required_if' => "Az űrtartalom mezőt akkor kell megadni, ha az állapot aktív.",
        'integer' => "Az űrtartalomnak egész számnak kell lennie.",
    ],
    'from_date' => [
        'before_or_equal' => "A kezdési dátumnak a most előtti dátumnak vagy azzal egyenlőnek kell lennie.",
        'date' => "A kezdő dátum nem érvényes dátum.",
    ],
    'to_date' => [
        'before_or_equal' => "A kezdési dátumnak a most előtti dátumnak vagy azzal egyenlőnek kell lennie.",
        'date' => "A kezdő dátum nem érvényes dátum.",
    ],
];
