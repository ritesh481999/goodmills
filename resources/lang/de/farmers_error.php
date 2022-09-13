<?php

return [

    'name' => [
        'required' => "Das Namensfeld ist erforderlich.",
        'string' => "Der Name muss eine Zeichenkette sein.",
    ],
    'username' => [
        'required' => "Das Feld für den Benutzernamen ist erforderlich.",
        'max' => "Der Benutzername darf nicht länger als 100 Zeichen sein.",
        'unique' => "Der Nutzername ist bereits vergeben",
    ],
    'email' => [
        'required' => "Das E-Mail-Feld ist erforderlich.",
        'unique' => "Die E-Mail ist bereits vergeben.",
    ],
    'company_name' => [
        'required' => "Das Feld Firmenname ist erforderlich.",
        'max' => "Der Firmenname darf nicht länger als 100 Zeichen sein.",

    ],
    'pin' => [
        'required' => "Das Feld Pin ist erforderlich.",
        'min' => "Der Pin muss mindestens 6 Zeichen lang sein.",
        'max' => "Die Pin darf nicht länger als 12 Zeichen sein.",

    ],
    'dialing_code' => [
        'required' => "Das Feld für die Vorwahl ist erforderlich.",
        'regex' => "Ungültiges Format",
    ],
    'phone' => [
        'required' => "Das Feld Telefon ist erforderlich",
        'integer' => "Das Telefon muss ganzzahlig sein",
        'digits_between' => "Die Telefonnummer muss zwischen 2 und 20 Ziffern haben."
    ],
    'address' => [
        'required' => "Das Adressfeld ist obligatorisch.",
        'min' => "Die Adresse muss mindestens 2 Zeichen lang sein.",
        'max' => "Die Adresse darf nicht länger als 30 Zeichen sein.",
    ],
    'user_type' => [
        'required' => "Das Feld Benutzertyp ist erforderlich.",
    ],
    'others' => [
        'required_if' => "Das Feld ist erforderlich.",
    ],
    'status' => [
        'required' => "Das Feld Status ist erforderlich.",
    ],
    'reason' => [
        'required_if' => "Das Feld Grund ist erforderlich",
    ],

    'is_news_sms' => [
        'required' => "Das Feld Neue SMS ist erforderlich.",
    ],

    'is_marketing_sms' => [
        'required' => "Das Feld Marketing SMS ist erforderlich.",
    ],

    'is_bids_received_sms' => [
        'required' => "Das Feld Angebots-SMS ist erforderlich.",
    ],

    'is_news_notification' => [
        'required' => "Das Feld News Notification ist erforderlich.",
    ],

    'is_marketing_notification' => [
        'required' => "Das Feld Marketingbenachrichtigung ist erforderlich.",
    ],

    'is_bids_received_notification' => [
        'required' => "Das Feld Angebot ist erforderlich.",
    ],
];
