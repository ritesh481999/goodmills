<?php

return [

    'name' => [
        'required' => 'The name field is required.',
        'string' => 'The name must be a string.',
        'max' => 'The name may not be greater than 100 characters.',
        'unique' => 'The name has already been taken.',
    ],
    'farmer_ids' => [
        'required' => 'The farmer ids field is required.',
    ],
    'status' => [
        'required' => 'The status  field is required.',
    ],
    
 
];