<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminChangePasswordRequest extends FormRequest
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
        return [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6'
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => __('common.reset_password.validation_error.old_password.required'),
            'password.required' => __('common.reset_password.validation_error.password.required'),
            'password.confirmed' => __('common.reset_password.validation_error.password.confirmed'),
            'password.min' => __('common.reset_password.validation_error.password.min'),
        ];
    }
}
