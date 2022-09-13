<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Models\CommodityMaster;
use App\Models\SpecificationMaster;
use Illuminate\Validation\Rule;

class SpecificationMasterCreateRequest extends FormRequest
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
            'name' => 'required|string|max:100||unique:'.(new SpecificationMaster)->getTable().',name',
            'commodity_id' => 'required|integer|exists:'.(new CommodityMaster)->getTable().',id',
            'status' => 'required|in:0,1'
        ];

        if($this->route()->getName() == 'specification.update')
            $rules['name'].=','.$this->route('id');
        
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => __('common.masters_error.specification.name.required'),
            'name.string' => __('common.masters_error.specification.name.string'),
            'name.max' => __('common.masters_error.specification.name.max'),
            'name.unique' => __('common.masters_error.specification.name.unique'),  'commodity_id.required' => __('common.masters_error.specification.commodity_id.required'),
            'commodity_id.integer' => __('common.masters_error.specification.commodity_id.string'),
            'commodity_id.exists' => __('common.masters_error.specification.commodity_id.exists'),
            'status.required' => __('common.masters_error.specification.status.required'),
        ];
    }
}
