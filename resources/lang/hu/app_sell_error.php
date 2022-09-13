<?php

return [

    'date_of_movement' => [
        'required' => "A mozgás dátuma szükséges.",
        'date_format' => "A mozgás dátumát Y-m-d formátumban kell megadni.",
    ],
    'tonnage' => [
        'required' => "A tonnatartalom mező kitöltése kötelező.",
        'integer' => "A tonnatartalomnak egész számnak kell lennie.",
    ],
    'commodity_id' => [
        'required' => "Az árumező kitöltése kötelező.",
        'integer' => "Az árunak egész számnak kell lennie",
    ],
    'variety_id' => [
        'required' => "A fajta mező kitöltése kötelező.",
        'integer' => "A fajtának egész számnak kell lennie.",
    ],
    'specification_id' => [
        'required' => "A specifikáció mező kitöltése kötelező.",
        'integer' => "A megadásnak egész számnak kell lennie.",
    ],
    'delivery_method' => [
        'required' => "A kézbesítési mód mező kitöltése kötelező.",
        'integer' => "A szállítási módnak egész számnak kell lennie.",
    ],
    'delivery_address' => [
        'required_if' => "A szállítási cím mező kitöltése kötelező, ha a szállítási mód Ex Exam.",
    ],
    'delivery_location_id' => [
        'required_if' => "A kézbesítés helye mező akkor kötelező, ha a kézbesítés módja Ön szállítja .",
    ],
    'postal_code' => [
        'required_if' => "A pin kód mezőt akkor kell kitölteni, ha a szállítási módot Ön szállítja.",
        'integer' => "A pin-kódnak egész számnak kell lennie.",
    ],
    'page' => [
        'required' => "Az oldal mező kitöltése kötelező.",
        'integer' => "Az oldal azonosítójának egész számnak kell lennie.",
    ],
    'limit' => [
        'required' => "A határérték mező kitöltése kötelező.",
        'integer' => "A határértéknek egész számnak kell lennie.",
    ],
    'bid_id' => [
        'required' => "Az ajánlati azonosító mező kitöltése kötelező.",
        'integer' => "Az ajánlati azonosítónak egész számnak kell lennie.",
        'exists' => "A kiválasztott ajánlati azonosító érvénytelen.",
    ],
    'status' => [
        'required' => "A státusz mező kitöltése kötelező.",
        'integer' => "Az állapotnak egész számnak kell lennie.",
    ],
    'tonnage' => [
        'required_if' => "Az űrtartalom mező akkor kötelező, ha a státusz aktív.",
        'integer' => "A tonnatartalomnak egész számnak kell lennie.",
    ],
    'from_date' => [
        'before_or_equal' => "A dátumnak a mostanit megelőző vagy azzal megegyező dátumnak kell lennie.",
        'date' => "A dátum nem érvényes dátum.",
    ],
    'to_date' => [
        'before_or_equal' => "A dátumnak a mostanit megelőző vagy azzal megegyező dátumnak kell lennie.",
        'date' => "A dátum nem érvényes dátum.",
    ],
];
