<?php

namespace App\Http\Requests\Commodity;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class CommodityEditRequest extends FormRequest
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
        return [
            'name' => 'required|string|unique:commodity_masters,name,'.$this->route('id').',id,deleted_at,NULL',
            'status' => 'required|in:0,1'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('common.masters_error.commodity.name.required'),
            'name.string' => __('common.masters_error.commodity.name.string'),
            'name.max' => __('common.masters_error.commodity.name.max'),
            'name.unique' => __('common.masters_error.commodity.name.unique'),
            'status.required' => __('common.masters_error.commodity.name.required'),
        ];
    }
}
