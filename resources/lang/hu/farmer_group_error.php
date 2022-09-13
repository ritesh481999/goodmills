<?php

return [

    'name' => [
        'required' => "A név mező kitöltése kötelező.",
        'string' => "A névnek egy karakterláncnak kell lennie.",
        'max' => "A név nem lehet 100 karakternél hosszabb.",
        'unique' => "A név már foglalt.",
    ],
    'farmer_ids' => [
        'required' => "A mezőgazdasági termelői azonosító mező kitöltése kötelező.",
    ],
    'status' => [
        'required' => "A státusz mező kitöltése kötelező.",
    ],

];