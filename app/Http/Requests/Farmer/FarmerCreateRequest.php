<?php

namespace App\Http\Requests\Farmer;

use App\Models\Farmer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FarmerCreateRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:100',
            'username' => 'required|alpha_dash|string|max:100|unique:' . (new Farmer)->getTable() . ',username',
            'company_name' => 'required|string|max:100',
            'registration_number' => "max:12",
            'business_partner_id' => "max:20",
            'email' =>  'required|email|unique:' . (new Farmer)->getTable() . ',email',
            'pin' =>   'required|string|min:6|max:12',
            'dialing_code' => 'required|regex:/^\+(\d{1}\-)?(\d{1,3})$/',
            'phone' => 'required|integer|digits_between:2,20',
            'address' => 'required|min:2|max:30',
            'user_type' => 'required|string|in:producer,trader,others',
            'others' => 'sometimes|nullable|required_if:user_type,others|string',
            'status' => 'required|in:1,0',
            'reason' => 'sometimes|nullable|required_if:status,0|string',
            'is_news_sms' => 'required|in:1,0',
            'is_marketing_sms' => 'required|in:1,0',
            'is_bids_received_sms' => 'required|in:1,0',
            'is_news_notification' => 'required|in:1,0',
            'is_marketing_notification' => 'required|in:1,0',
            'is_bids_received_notification' => 'required|in:1,0',
        ];

        if ($this->id) {
            $rules['username'] .= ',' . $this->id;
            $rules['email'] .= ',' . $this->id;
            $rules['pin'] = str_replace('required', 'nullable', $rules['pin']);
        }

        return $rules;
    }


    public function messages()
    {
        return
                [   
                    'name.required' => __('farmers_error.name.required'),
                    'name.string' => __('farmers_error.name.string'),
                    'username.required' => __('farmers_error.username.required'),
                    'username.max' => __('farmers_error.username.max'),
                    'username.unique' => __('farmers_error.username.unique'),
                    'username.alpha_dash' => __('farmers_error.username.alpha_dash'),
                    'company_name.required' => __('farmers_error.company_name.required'), 'company_name.max' => __('farmers_error.company_name.max'),
                    'email.required' => __('farmers_error.email.required'),
                    'email.unique' => __('farmers_error.email.unique'),
                    'pin.required' => __('farmers_error.pin.required'),
                    'pin.min' => __('farmers_error.pin.min'),
                    'pin.max' => __('farmers_error.pin.max'),
                    'dialing_code.required' => __('farmers_error.dialing_code.required'),'dialing_code.regex' => __('farmers_error.dialing_code.regex'),
                    'phone.required' =>  __('farmers_error.phone.required'),
                    'phone.integer' => __('farmers_error.phone.integer'),
                    'phone.digits_between' => __('farmers_error.phone.digits_between'),
                    'address.required' => __('farmers_error.address.required'),
                    'address.min' => __('farmers_error.address.min'),
                    'address.max' => __('farmers_error.address.max'),
                    'user_type.required' => __('farmers_error.user_type.required'),
                    'others.required_if' => __('farmers_error.others.required_if'), 
                    'status.required' => __('farmers_error.status.required'),
                    'reason.required_if' => __('farmers_error.reason.required_if'),
                    'is_news_sms.required' => __('farmers_error.is_news_sms.required'),
                    'is_marketing_sms.required' => __('farmers_error.is_marketing_sms.required'),
                    'is_bids_received_sms.required' => __('farmers_error.is_bids_received_sms.required'),
                    'is_news_notification.required' => __('farmers_error.is_news_notification.required'),
                    'is_marketing_notification.required' => __('farmers_error.is_marketing_notification.required'),
                    'is_bids_received_notification.required' => __('farmers_error.is_bids_received_notification.required'),
                ];
    }
}
