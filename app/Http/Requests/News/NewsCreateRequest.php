<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class NewsCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
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
            'image' => '|file|mimes:jpeg,jpg,png',
            'date_time' => 'bail|required',
            'type' => 'required|in:1,2',
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
                    'title.required' => __('news_error.title.required'),
                    'title.string' => __('news_error.title.string'),
                    'short_description.required' => __('news_error.short_description.required'),
                    'short_description.string' => __('news_error.short_description.string'),
                    'description.required' => __('news_error.description.required'),
                    'image.required' => __('news_error.image.required'),
                    'image.file' => __('news_error.image.file'),
                    'image.mimes' => __('news_error.image.mimes'),
                    'date_time.required' => __('news_error.date_time.required'),
                    'type.required' => __('news_error.type.required'),
                    'type.in' => __('news_error.type.in'),
                    'is_sms.required' => __('news_error.is_sms.required'),
                    'is_sms.in' => __('news_error.is_sms.in'),
                     'is_notification.required' => __('news_error.is_notification.required'),
                    'is_notification.in' => __('news_error.is_notification.in'),
                    'status.required' => __('news_error.status.required'),
                    'status.in' => __('news_error.status.in'),
                ];
    }
}
