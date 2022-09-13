<?php

namespace App\Http\Requests\Variety;

use Illuminate\Foundation\Http\FormRequest;

class VarietyStoreRequest extends FormRequest
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
            'commodity_id'=>'bail|required',
            'name'=>'bail|required|string|max:100|unique:varieties,name,NULL,id,deleted_at,NULL',
            'status'=>'bail|required|in:0,1'      
              ];    
    }
    public function messages()
    {
        return [
            'name.required' => __('common.masters_error.variety.name.required'),
            'name.string' => __('common.masters_error.variety.name.string'),
            'name.max' => __('common.masters_error.variety.name.max'),
            'name.unique' => __('common.masters_error.variety.name.unique'),  'commodity_id.required' => __('common.masters_error.variety.commodity_id.required'),
            'status.required' => __('common.masters_error.variety.status.required'),
        ];
    }
}
