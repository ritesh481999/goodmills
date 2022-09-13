<?php

return [

    'date_of_movement' => [
        'required' => "Das Datum der Bewegung ist erforderlich.",
        'date_format' => "Das Datum der Verbringung muss im Format J-M-D angegeben werden.",
    ],
    'tonnage' => [
        'required' => "Das Feld Tonnage ist erforderlich.",
        'integer' => "Die Tonnage muss eine ganze Zahl sein.",
    ],
    'commodity_id' => [
        'required' => "Das Warenfeld ist erforderlich.",
        'integer' => "Die Ware muss eine ganze Zahl sein.",
    ],
    'variety_id' => [
        'required' => "Das Feld Sorte ist erforderlich.",
        'integer' => "Die Sorte muss eine ganze Zahl sein.",
    ],
    'specification_id' => [
        'required' => "Das Feld Spezifikation ist erforderlich.",
        'integer' => "Die Angabe muss eine ganze Zahl sein.",
    ],
    'delivery_method' => [
        'required' => "Das Feld Liefermethode ist erforderlich.",
        'integer' => "Die Liefermethode muss eine ganze Zahl sein.",
    ],
    'delivery_address' => [
        'required_if' => "Das Feld für die Lieferadresse ist erforderlich, wenn die Zustellungsart Ex Exam ist.",
    ],
    'delivery_location_id' => [
        'required_if' => "Das Feld Lieferort ist erforderlich, wenn die Liefermethode Sie liefern ist.",
    ],
    'postal_code' => [
        'required_if' => 'Das Feld für den Pin-Code ist erforderlich, wenn die Zustellmethode "Sie liefern" ist.',
        'integer' => "Der Pin-Code muss eine ganze Zahl sein.",
    ],
    'page' => [
        'required' => "Das Feld Seite ist erforderlich.",
        'integer' => "Die Seiten-ID muss eine ganze Zahl sein.",
    ],
    'limit' => [
        'required' => "Das Feld Limit ist erforderlich.",
        'integer' => "Der Grenzwert muss eine ganze Zahl sein.",
    ],
    'bid_id' => [
        'required' => "Das Feld Angebots-ID ist erforderlich.",
        'integer' => "Die Angebots-ID muss eine ganze Zahl sein.",
        'exists' => "Die ausgewählte Angebots-ID ist ungültig..",
    ],
    'status' => [
        'required' => "Das Statusfeld ist obligatorisch.",
        'integer' => "Der Status muss eine ganze Zahl sein.",
    ],
    'tonnage' => [
        'required_if' =>"Das Feld Tonnage ist erforderlich, wenn der Status aktiv ist.",
        'integer' => "Die Tonnage muss eine ganze Zahl sein.",
    ],
    'from_date' => [
        'before_or_equal' => "Das Von-Datum muss ein Datum sein, das vor oder gleich dem Jetzt-Datum liegt.",
        'date' => "Das von-Datum ist kein gültiges Datum.",
    ],
    'to_date' => [
        'before_or_equal' => "Das Von-Datum muss ein Datum sein, das vor oder gleich dem Jetzt-Datum liegt.",
        'date' => "Das von-Datum ist kein gültiges Datum.",
    ],
];
