<?php

return [

    'username' => [
        'required' => "Das Feld für den Benutzernamen ist erforderlich.",
    ],
    'pin' => [
        'required' =>"Das Feld Pin ist erforderlich.",
        'integer' =>  "Der Pin muss eine ganze Zahl sein.",
        'digits' => "Die Pin muss 6-stellig sein.",
        'numeric' => "Der Pin muss eine Nummer sein.",
    ],
    'fcm_token' => [
        'required' => "Das Feld fcm-Token ist erforderlich.",
    ],
    'device_token' => [
        'required' => "Das Feld Gerätetoken ist erforderlich.",
    ],
    'device_type' => [
        'required' => "Das Feld Gerätetyp ist erforderlich.",
    ],
    'forgot_token' => [
        'required' => "Das Feld für den vergessenen Token ist erforderlich.",
    ],
    'otp' => [
        'required' => "Das Feld otp ist erforderlich.",
        'digits' => "Die Rufnummer muss 6-stellig sein.",
    ],
    'reset_token' => [
        'required' => "Das Feld Reset-Token ist erforderlich.",
    ],
    'current_pin' => [
        'required' => "Das Feld für den aktuellen Pin ist erforderlich.",
        'digits' => "Der aktuelle Pin ist 6-stellig.",
    ],
    'confirm_pin' => [
        'required' => "Das Feld Pin bestätigen ist erforderlich",
        'same' => "Der Bestätigungsstift und der Stift müssen übereinstimmen.",
    ],
    'name' => [
        'required' => "Das Namensfeld ist erforderlich.",
        'min' => "Der Name muss mindestens 2 Zeichen lang sein.",
        'max' => "Der Name darf nicht länger als 30 Zeichen sein.",
    ],
    'username' => [
        'required' => "Das Feld für den Benutzernamen ist erforderlich.",
        'min' => "Der Benutzername muss mindestens 2 Zeichen lang sein.",
        'max' => "Der Benutzername darf nicht länger als 20 Zeichen sein.",
        'alpha_num' => "Der Benutzername darf nur Buchstaben und Zahlen enthalten.",
        'unique' => "Der Benutzername ist bereits vergeben.",
    ],
    'email' => [
        'required' => "Das E-Mail-Feld ist erforderlich.",
        'min' => "Die E-Mail muss mindestens 2 Zeichen lang sein.",
        'max' => "Die E-Mail darf nicht länger als 30 Zeichen sein.",
        'unique' => "Die E-Mail wurde bereits entgegengenommen.",
    ],
    'company_name' => [
        'required' => "Das Feld Firmenname ist erforderlich.",
        'min' => "Der Firmenname muss aus mindestens 2 Zeichen bestehen.",
        'max' => "Der Firmenname darf nicht länger als 30 Zeichen sein.",
    ],
    'registration_number' => [
        'alpha_num' => "Die Zulassungsnummer darf nur Buchstaben und Zahlen enthalten.",
        'max' => "Die Registrierungsnummer darf nicht länger als 12 Zeichen sein.",
    ],
    'dialing_code' => [
        'required' => "Das Feld für die Vorwahl ist erforderlich.",
        'regex' => "Die richtige Vorwahl eingeben.",
    ],
    'phone' => [
        'required' => "Das Feld Telefon ist erforderlich.",
        'integer' => "Das Telefon muss eine ganze Zahl sein.",
        'digits_between' => "Die Telefonnummer muss zwischen 2 und 20 Ziffern haben.",
    ],
    'address' => [
        'required' => "Das Adressfeld ist obligatorisch.",
        'min' => "Die Adresse muss mindestens 2 Zeichen lang sein.",
        'max' => "Die Adresse darf nicht länger als 30 Zeichen sein.",
    ],
    'country_id' => [
        'required' => "Das Feld country id ist erforderlich.",
    ],
    'user_type' => [
        'required' => "Das Feld Benutzertyp ist erforderlich.",
        'min' => "Der Benutzertyp muss mindestens 2 Zeichen lang sein.",
        'max' => "Der Benutzertyp darf nicht länger als 30 Zeichen sein.",
    ],
    'scheduled_deleted_date' => [
        'required' => "Das Feld geplantes Löschdatum ist erforderlich.",
        'date' => "Das geplante Löschdatum ist kein gültiges Datum.",
        'date_format' => "Das geplante Löschdatum stimmt nicht mit dem Format J-M-T überein.",
    ],
 
];
