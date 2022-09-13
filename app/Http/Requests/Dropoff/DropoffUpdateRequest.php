<?php

namespace App\Http\Requests\Dropoff;

use Illuminate\Foundation\Http\FormRequest;

class DropoffUpdateRequest extends FormRequest
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
        $id=$this->route('dropoff');
        return [
            
            'name'=>'bail|required|string|max:100',
            'status'=>'bail|required|in:0,1'      
              ];
    }
    public function messages()
    {
        return
        [
            
            
            'name.required' =>'Drop-Off Location is required.',
            'name.string' =>'Drop-Off Location invalid Format.',
            'name.max' =>'Max 100 allowed for Drop-Off Location.',
            'status.required' =>'Status is required.',
        ];
    }
}
