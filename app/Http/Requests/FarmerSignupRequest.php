<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FarmerSignupRequest extends FormRequest
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
            'name' => 'required',
            'username' => 'required|max:50',
            'email' => 'required|max:50',
            'company_name' => 'required',
            'pin' => 'required|digits:6|numeric',
            'phone' => 'required|regex:/^(\+\d{1,3}[- ]?)?\d{10}$/',
            'address' => 'required',
            'location_id' => 'required',
            'user_type' => 'required',
        ];
    }
}
