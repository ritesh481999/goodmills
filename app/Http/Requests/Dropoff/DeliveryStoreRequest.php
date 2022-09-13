<?php

namespace App\Http\Requests\Dropoff;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'bail|required|string|max:100|unique:delivery_locations,name,NULL,id,deleted_at,NULL',
            'status' => 'bail|required|in:0,1'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('common.masters_error.delivery_location.name.required'),
            'name.string' => __('common.masters_error.delivery_location.name.string'),
            'name.max' => __('common.masters_error.delivery_location.name.max'),
            'name.unique' => __('common.masters_error.delivery_location.name.unique'),
            'status.required' => __('common.masters_error.delivery_location.status.required'),
        ];
    }
}
