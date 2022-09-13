<?php

return [

    'date_of_movement' => [
        'required' => "Das Datum der Bewegung ist erforderlich.",
        'date_format' => "Das Bewegungsdatum muss im Format J-M-T vorliegen.",
    ],
    'tonnage' => [
        'required' => "Das Tonnage-Feld ist erforderlich.",
        'integer' => "Die Tonnage muss eine Ganzzahl sein.",
    ],
    'commodity_id' => [
        'required' => "Das Warenfeld ist erforderlich.",
        'integer' => "Die Ware muss eine ganze Zahl sein.",
    ],
    'variety_id' => [
        'required' => "Das Sortenfeld ist erforderlich.",
        'integer' => "Die Sorte muss eine ganze Zahl sein.",
    ],
    'specification_id' => [
        'required' => "Das Spezifikationsfeld ist erforderlich.",
        'integer' => "Die Angabe muss eine ganze Zahl sein.",
    ],
    'delivery_method' => [
        'required' => "Das Feld Liefermethode ist erforderlich.",
        'integer' => "Die Übermittlungsmethode muss eine Ganzzahl sein.",
    ],
    'delivery_address' => [
        'required_if' => "Das Lieferadressenfeld ist erforderlich, wenn die Liefermethode Ex-Prüfung ist.",
    ],
    'delivery_location_id' => [
        'required_if' => "Das Feld Lieferort ist erforderlich, wenn die Liefermethode Sie liefern ist.",
    ],
    'postal_code' => [
        'required_if' => "Das PIN-Code-Feld ist erforderlich, wenn die Liefermethode Sie liefern ist.",
        'integer' => "Der PIN-Code muss eine ganze Zahl sein.",
    ],
    'page' => [
        'required' => "Das Seitenfeld ist erforderlich.",
        'integer' => "Die Seiten-ID muss eine Ganzzahl sein.",
    ],
    'limit' => [
        'required' => "Das Limit-Feld ist erforderlich.",
        'integer' => "Der Grenzwert muss eine Ganzzahl sein.",
    ],
    'bid_id' => [
        'required' => "Das Feld für die Gebots-ID ist erforderlich.",
        'integer' => "Die Gebots-ID muss eine Ganzzahl sein.",
        'exists' => "Die ausgewählte Gebots-ID ist ungültig.",
    ],
    'status' => [
        'required' => "Das Statusfeld ist erforderlich.",
        'integer' => "Der Status muss eine ganze Zahl sein.",
    ],
    'tonnage' => [
        'required_if' => "Das Mengenfeld ist erforderlich, wenn der Status aktiv ist.",
        'integer' => "Die Tonnage muss eine Ganzzahl sein.",
    ],
    'from_date' => [
        'before_or_equal' => "Das Von-Datum muss ein Datum vor oder gleich jetzt sein.",
        'date' => 'Das Von-Datum ist kein gültiges Datum.',
    ],
    'to_date' => [
        'before_or_equal' => "Das Von-Datum muss ein Datum vor oder gleich jetzt sein.",
        'date' => "Das Von-Datum ist kein gültiges Datum.",
    ],
];
