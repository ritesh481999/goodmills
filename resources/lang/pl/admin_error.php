<?php

return [

    'name' => [
        'required' => 'The name field is required .',
        'string' => 'The name must be a string.',
        'max' => 'The name may not be greater than 100 characters.',
    ],
    'email' => [
        'required' => 'The name field is required.',
        'unique'=> 'The name must be a valid email address.',
        'unique' => 'The name has already been taken.',
    ],
    'password' => [
        'required' => 'The name field is required .',
        'string' => 'The name must be a string.',
        'min' => 'The name must be at least 6 characters.',
        'max' => 'The name may not be greater than 12 characters.',
    ],
    'role_id' => [
        'required' => 'The role  field is required.',
        'in' => 'The selected role is invalid.',
    ],
    'countries' => [
        'required' => 'The name  field is required.',
        'array' => 'The name  must be an array.',
    ],
    'is_active' => [
        'required' => 'The active  field is required.',
        'required' => 'The selection is active is invalid.',
    ],
    
   

 
];