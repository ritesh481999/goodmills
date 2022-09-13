<?php

return [

    'title' => [
        'required' => "Das Feld Titel ist erforderlich.",
        'string' => "Der Titel muss eine Zeichenkette sein.",
    ],
    'short_description' => [
        'required' => "Das Feld Kurzbeschreibung ist erforderlich.",
        'string' => "Das Feld Kurzbeschreibung ist erforderlich."
    ],
    'description' => [
        'required' => "Das Feld Beschreibung ist erforderlich.",
    ],
    'image' => [
        'required' => "Das Bildfeld ist erforderlich.",
        'file' => "Das Bildfeld ist erforderlich.",
        'mimes' => "Ungültiges Dateiformat.",
    ],
    'publish_on' => [
        'required' => "Das Feld Datum Uhrzeit ist erforderlich.",
    ],
    'is_sms' => [
        'required' => "Das Feld SMS ist erforderlich.",
        'in'=>"Das SMS-Feld ist ungültig.",
    ],
    'is_notification' => [
        'required' => "Das Feld Benachrichtigung ist erforderlich.",
        'in'=>"Die Benachrichtigung ist ungültig.",
    ],
    'status' => [
        'required' => "Das Statusfeld ist obligatorisch.",
        'in'=>"Der Status ist ungültig",
    ],
];