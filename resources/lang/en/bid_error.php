<?php

return [

    'date_of_movement' => [
        'required' => 'The Date of movement is required.',
        'date_format' => 'The Date of movement should must be in the Y-m-d format.',
    ],
    'tonnage' => [
        'required' => 'The tonnage field is required.',
        'integer' => 'The tonnage must be an integer.',
    ],
    'commodity_id' => [
        'required' => 'The commodity field is required.',
        'integer' => 'The commodity must be an integer.',
    ],
    'variety_id' => [
        'required' => 'The variety field is required.',
        'integer' => 'The variety must be an integer.',
    ],
    'specification_id' => [
        'required' => 'The specification field is required.',
        'integer' => 'The specification must be an integer.',
    ],
    'delivery_method' => [
        'required' => 'The delivery method field is required.',
        'integer' => 'The delivery method must be an integer.',
    ],
    'delivery_address' => [
        'required_if' => 'The delivery address field is required when delivery method is Ex Exam.',
    ],
    'delivery_location_id' => [
        'required_if' => 'The delivery location  field is required when delivery method is you deliver .',
    ],
    'price' => [
        'required' => 'The Price field is required',
        'regex' => 'The Price should be valid number',
        'max' => 'The :attribute must not be greater than 11 digits',
    ],
    'postal_code' => [
        'required' => 'The Postal code  field is required',
        'integer' => 'The pin code must be an integer.',
        'min' => 'The Postal code must be at least 3 characters.',
        'max' => 'The Postal code must not be greater than 7 characters.',
    ],
    'page' => [
        'required' => 'The page field is required.',
        'integer' => 'The page id must be an integer.',
    ],
    'limit' => [
        'required' => 'The limit  field is required.',
        'integer' => 'The limit must be an integer.',
    ],
    'bid_id' => [
        'required' => 'The bid id  field is required.',
        'integer' => 'The bid id must be an integer.',
        'exists' => 'The selected bid id is invalid.',
    ],
    'status' => [
        'required' => 'The status  field is required.',
        'integer' => 'The status must be an integer.',
    ],
    'tonnage' => [
        'required_if' => 'The tonnage  field is required when status is active.',
        'integer' => 'The tonnage must be an integer.',
    ],
    'from_date' => [
        'before_or_equal' => 'The from date must be a date before or equal to now.',
        'date' => 'The from date is not a valid date.',
    ],
    'to_date' => [
        'before_or_equal' => 'The from date must be a date before or equal to now.',
        'date' => 'The from date is not a valid date.',
    ],
];
