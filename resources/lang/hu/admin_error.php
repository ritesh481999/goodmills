<?php

return [

    'name' => [
        'required' => "A név mező kitöltése kötelező.",
        'string' => "A névnek egy karakterláncnak kell lennie.",
        'max' => "A név nem lehet 100 karakternél hosszabb.",
    ],
    'email' => [
        'required' => "A név mező kitöltése kötelező.",
        'unique'=> "A névnek érvényes e-mail címnek kell lennie.",
        'unique' => "A név már foglalt.",
    ],
    'password' => [
        'required' => "A név mező kitöltése kötelező.",
        'string' => "A névnek egy karakterláncnak kell lennie.",
        'min' => "A névnek legalább 6 karakterből kell állnia.",
        'max' => "A név nem lehet 12 karakternél hosszabb.",
    ],
    'role_id' => [
        'required' => "A szerep mező kitöltése kötelező.",
        'in' => "A kiválasztott szerepkör érvénytelen.",
    ],
    'countries' => [
        'required' => "A név mező kitöltése kötelező.",
        'array' => "A névnek tömbnek kell lennie.",
    ],
    'is_active' => [
        'required' => "Az aktív mező kitöltése kötelező.",
        'required' => "A kiválasztás aktív érvénytelen.",
    ],
    
   

 
];