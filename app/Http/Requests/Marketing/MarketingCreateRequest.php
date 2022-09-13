<?php

namespace App\Http\Requests\Marketing;

use Illuminate\Foundation\Http\FormRequest;

class MarketingCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            '*' => 'bail',
            'title' => 'required|string',
            'short_description' => 'required|string',
            'description' => 'required|present',
            'image' => 'file|mimes:jpeg,jpg,png',
            'publish_on' => 'bail|required',
            'is_sms' => 'required|in:0,1',
            'is_notification' => 'required|in:0,1',
            'status' => 'required|in:0,1'
        ];

        return $rules;
    }


    public function messages()
    {
            
        return
                [   
                    'title.required' => __('marketing_error.title.required'),
                    'title.string' => __('marketing_error.title.string'),
                    'short_description.required' => __('marketing_error.short_description.required'),
                    'short_description.string' => __('marketing_error.short_description.string'),
                    'description.required' => __('marketing_error.description.required'),
                    'image.required' => __('marketing_error.image.required'),
                    'image.file' => __('marketing_error.image.file'),
                    'image.mimes' => __('marketing_error.image.mimes'),
                    'publish_on.required' => __('marketing_error.publish_on.required'),
                    'is_sms.required' => __('marketing_error.is_sms.required'),
                    'is_sms.in' => __('marketing_error.is_sms.in'),
                     'is_notification.required' => __('marketing_error.is_notification.required'),
                    'is_notification.in' => __('marketing_error.is_notification.in'),
                    'status.required' => __('marketing_error.status.required'),
                    'status.in' => __('marketing_error.status.in'),
                ];
    }
}
