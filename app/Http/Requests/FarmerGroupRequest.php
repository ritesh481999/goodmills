<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Models\FarmerGroup;
use Illuminate\Validation\Rule;

class FarmerGroupRequest extends FormRequest
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
            'name' => 'required|string|max:100|unique:' . (new FarmerGroup)->getTable() . ',name',
            'farmer_ids' => 'required',
            'status' => 'required|in:0,1'
        ];

        if ($this->id)
            $rules['name'] .= ',' . $this->id;

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => __('farmers_group_error.name.required'),
            'name.string' => __('farmers_group_error.name.string'),
            'name.max' => __('farmers_group_error.name.max'),
            'name.unique' => __('farmers_group_error.name.unique'),
            'farmer_ids.required' => __('farmers_group_error.farmer_ids.required'),
            'status.required' => __('farmers_group_error.status.required'),

        ];
    }
}
