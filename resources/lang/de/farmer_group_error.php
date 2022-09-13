<?php

return [

    'name' => [
        'required' => "Das Namensfeld ist erforderlich.",
        'string' => "Der Name muss eine Zeichenkette sein.",
        'max' => "Der Name darf nicht länger als 100 Zeichen sein.",
        'unique' => "Der Name ist bereits vergeben",
    ],
    'farmer_ids' => [
        'required' => "Das Feld Landwirt-IDs ist erforderlich.",
    ],
    'status' => [
        'required' => "Das Feld Status ist erforderlich.",
    ],

];