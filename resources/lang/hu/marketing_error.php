<?php

return [

    'title' => [
        'required' => "A cím mező kitöltése kötelező.",
        'string' => "A címnek egy karakterláncnak kell lennie.",
    ],
    'short_description' => [
        'required' => "A Rövid leírás mező kitöltése kötelező.",
        'string' => "A rövid leírásnak egy karakterláncnak kell lennie."
    ],
    'description' => [
        'required' => "A leírás mező kitöltése kötelező.",
    ],
    'image' => [
        'required' => "A képmező kitöltése kötelező.",
        'file' => "A képmező kitöltése kötelező.",
        'mimes' => "Érvénytelen fájlformátum.",
    ],
    'publish_on' => [
        'required' => "A Dátum és idő mező kitöltése kötelező.",
    ],
    'is_sms' => [
        'required' => "Az SMS mező kitöltése kötelező.",
        'in'=>"Az SMS mező érvénytelen.",
    ],
    'is_notification' => [
        'required' => "Az Értesítés mező kitöltése kötelező.",
        'in'=>"A bejelentés érvénytelen.",
    ],
    'status' => [
        'required' => "A státusz mező kitöltése kötelező.",
        'in'=>"A státusz érvénytelen.",
    ],
];