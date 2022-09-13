<?php

return [

    'name' => [
        'required' => "Das Namensfeld ist erforderlich",
        'string' => "Der Name muss eine Zeichenkette sein.",
        'max' => "Der Name darf nicht länger als 100 Zeichen sein.",
    ],
    'email' => [
        'required' => "Das Namensfeld ist erforderlich.",
        'unique'=> "Der Name muss eine gültige E-Mail-Adresse sein.",
        'unique' => "Der Name ist bereits vergeben.",
    ],
    'password' => [
        'required' => "Das Namensfeld ist erforderlich.",
        'string' => "Der Name muss eine Zeichenkette sein.",
        'min' => "Der Name muss mindestens 6 Zeichen lang sein.",
        'max' => "Der Name darf nicht länger als 12 Zeichen sein.",
    ],
    'role_id' => [
        'required' => "Das Feld Rolle ist erforderlich.",
        'in' => "Die ausgewählte Rolle ist ungültig.",
    ],
    'countries' => [
        'required' =>"Das Namensfeld ist erforderlich.",
        'array' => "Der Name muss ein Array sein.",
    ],
    'is_active' => [
        'required' => "Das aktive Feld ist erforderlich.",
        'required' => "Die Auswahl ist aktiv ist ungültig.",
    ],
    
   

 
];