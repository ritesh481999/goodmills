<?php

return [

    'title' => [
        'required' => 'The title field is required.',
        'string' => 'The title must be a string.',
    ],
    'short_description' => [
        'required' => 'The Short description field is required.',
        'string' => 'The Short description must be a string.'
    ],
    'description' => [
        'required' => 'The description field is required.',
    ],
    'image' => [
        'required' => 'The image field is required.',
        'file' => 'The image field is required.',
        'mimes' => 'Invalid file format.',
    ],
    'date_time' => [
        'required' => 'The Date Time field is required.',
    ],
    'type' => [
        'required' => 'The type field is required.',
        'in'=>'The type is invalid.',
    ],
    'is_sms' => [
        'required' => 'The Sms field is required.',
        'in'=>'The Sms Field is invalid.',
    ],
    'is_notification' => [
        'required' => 'The Notification  field is required.',
        'in'=>'The Notificaion is invalid.',
    ],
    'status' => [
        'required' => 'The status  field is required.',
        'in'=>'The status is invalid.',
    ],
];
