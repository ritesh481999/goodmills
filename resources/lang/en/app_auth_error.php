<?php

return [

    'username' => [
        'required' => 'The username field is required.',
    ],
    'pin' => [
        'required' => 'The pin field is required.',
        'integer' => 'The pin must be an integers.',
        'digits' => 'The pin must be 6 digits.',
        'numeric' => 'The pin must be a number.',
    ],
    'fcm_token' => [
        'required' => 'The fcm token field is required.',
    ],
    'device_token' => [
        'required' => 'The device token field is required.',
    ],
    'device_type' => [
        'required' => 'The device type field is required.',
    ],
    'forgot_token' => [
        'required' => 'The forgot token field is required.',
    ],
    'otp' => [
        'required' => 'The otp field is required.',
        'digits' => 'The otp must be 6 digits.',
    ],
    'reset_token' => [
        'required' => 'The reset token field is required.',
    ],
    'current_pin' => [
        'required' => 'The current pin field is required.',
        'digits' => 'The current pin be 6 digits.',
    ],
    'confirm_pin' => [
        'required' => 'The confirm pin field is required.',
        'same' => 'New PIN and Confirm PIN must be same.',
    ],
    'name' => [
        'required' => 'The name field is required.',
        'min' => 'The name must be at least 2 characters.',
        'max' => 'The name may not be greater than 30 characters.',
    ],
    'username' => [
        'required' => 'The username field is required.',
        'min' => 'The username must be at least 2 characters.',
        'max' => 'The username may not be greater than 20 characters.',
        'alpha_num' => 'The username may only contain letters and numbers.',
        'unique' => 'The username has already been takens.',
    ],
    'email' => [
        'required' => 'The email field is required.',
        'min' => 'The email must be at least 2 characters.',
        'max' => 'The email may not be greater than 30 characters.',
        'unique' => 'The email has already been takens.',
    ],
    'company_name' => [
        'required' => 'The company name field is required.',
        'min' => 'The company name must be at least 2 characters.',
        'max' => 'The company name may not be greater than 30 characters.',
    ],
    'registration_number' => [
        'alpha_num' => 'The registration number may only contain letters and numbers.',
        'max' => 'The registration number may not be greater than 12 characters.',
    ],
    'dialing_code' => [
        'required' => 'The dialing code field is required.',
        'regex' => 'The enter correct dialing code.',
    ],
    'phone' => [
        'required' => 'The phone  field is required.',
        'integer' => 'The phone must be an integer.',
        'digits_between' => 'The phone must be between 2 and 20 digits.',
    ],
    'address' => [
        'required' => 'The address  field is required.',
        'min' => 'The address must be at least 2 characters.',
        'max' => 'The address may not be greater than 30 characters.',
    ],
    'country_id' => [
        'required' => 'The country id  field is required.',
    ],
    'user_type' => [
        'required' => 'The user type  field is required.',
        'min' => 'The user type must be at least 2 characters.',
        'max' => 'The user type may not be greater than 30 characters.',
    ],
    'scheduled_deleted_date' => [
        'required' => 'The scheduled deleted date  field is required.',
        'date' => 'The scheduled deleted date is not a valid date.',
        'date_format' => 'The scheduled deleted date does not match the format Y-m-d.',
    ],

];
