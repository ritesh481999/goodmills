<?php

namespace App\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;

class CountryMasterEditRequest extends FormRequest
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
            'name'=>'bail|required|string|max:100',
            'language' =>'bail|required|string',
            'direction' =>'bail|required',
            'duration' => 'bail|required|numeric',
            'status'=>'bail|required|in:0,1',
            'abbreviation' => 'bail|required|unique:country_masters,abbreviation,NULL,id,deleted_at,NULL',
            'time_zone' => 'bail|required|'    
              ];
    }


    public function messages()
    {
        return [
            'name.required' => __('common.masters_error.country.name.required'),
            'name.string' => __('common.masters_error.country.name.string'),
            'name.max' => __('common.masters_error.country.name.max'),
            'name.unique' => __('common.masters_error.country.name.unique'),  
            'language.required' => __('common.masters_error.country.language.required'),
            'language.string' => __('common.masters_error.country.language.string'),
            'direction.required' => __('common.masters_error.country.direction.required'),
            'duration.required' => __('common.masters_error.country.duration.required'),
            'duration.numeric' => __('common.masters_error.country.duration.numeric'),
            'status.required' => __('common.masters_error.country.status.required'),
            'abbreviation.required' => __('common.masters_error.country.abbreviation.required'),
            'abbreviation.unique' => __('common.masters_error.country.abbreviation.unique'),
            'time_zone.required' => __('common.masters_error.country.time_zone.required'),
        ];
    }
}
