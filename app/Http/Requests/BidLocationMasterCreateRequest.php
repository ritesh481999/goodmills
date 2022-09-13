<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Models\BidLocationMaster;
use Illuminate\Validation\Rule;

class BidLocationMasterCreateRequest extends FormRequest
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
            'name' => 'required|string|max:100|unique:'.(new BidLocationMaster)->getTable().',name',
            'status' => 'required|in:0,1'
        ];

        if($this->route()->getName() == 'bid_location.update')
            $rules['name'].=','.$this->route('id');
        
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => __('bid_location_error.name.required'),
            'name.string' => __('bid_location_error.name.string'),
            'name.max' => __('bid_location_error.name.max'),
            'name.unique' => __('bid_location_error.name.unique'),
            'status.required' => __('bid_location_error.status.required'),

        ];
    }
}
