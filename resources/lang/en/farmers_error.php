<?php

return [

    'name' => [
        'required' => 'The name field is required.',
        'string' => 'The name must be a string.',
    ],
    'username' => [
        'required' => 'The username field is required.',
        'max' => 'The username may not be greater than 100 characters.',
        'unique' => 'The username has already been taken.',
        'alpha_dash' => 'The username field does not allowed extra space'
    ],
    'email' => [
        'required' => 'The email field is required.',
        'unique' => 'The email has already been taken.',
    ],
    'company_name' => [
        'required' => 'The company name field is required.',
        'max' => 'The company name may not be greater than 100 characters.',

    ],
    'pin' => [
        'required' => 'The pin field is required.',
        'min' => 'The pin must be at least 6 characters.',
        'max' => 'The pin must may not be greater than 12 characters.',

    ],
    'dialing_code' => [
        'required' => 'The dialing code field is required.',
        'regex' => 'Invalid format',
    ],
    'phone' => [
        'required' => 'The phone field is required.',
        'integer' => 'The phone must be integer',
        'digits_between' => 'The phone must be between 2 and 20 digits.'
    ],
    'address' => [
        'required' => 'The address  field is required.',
        'min' => 'The address must be at least 2 characters.',
        'max' => 'The address may not be greater than 30 characters.',
    ],
    'user_type' => [
        'required' => 'The user type  field is required.',
    ],
    'others' => [
        'required_if' => 'The field is required.',
    ],
    'status' => [
        'required' => 'The status  field is required.',
    ],
    'reason' => [
        'required_if' => 'The reason  field is required.',
    ],

    'is_news_sms' => [
        'required' => 'The New SMS field is required.',
    ],

    'is_marketing_sms' => [
        'required' => 'The Marketing SMS  field is required.',
    ],

    'is_bids_received_sms' => [
        'required' => 'The Bid SMS  field is required.',
    ],

    'is_news_notification' => [
        'required' => 'The News Notification  field is required.',
    ],

    'is_marketing_notification' => [
        'required' => 'The Marketing Notification  field is required.',
    ],

    'is_bids_received_notification' => [
        'required' => 'The Bid  field is required.',
    ],
];
