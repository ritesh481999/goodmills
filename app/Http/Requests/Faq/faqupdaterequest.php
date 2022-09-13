<?php

namespace App\Http\Requests\Faq;

use Illuminate\Foundation\Http\FormRequest;

class faqupdaterequest extends FormRequest
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
            'faq'=>'bail|required',
            'description'=>'bail|required',
            'status'=>'bail|required|in:0,1'      
              ];

    }
    public function messages()
    {
        
 return
        [
            'faq.required' =>' Faq is required.',
            
            'description.required' =>'Description is required.',
            
            'status.required' =>'Status is required.',
        ];
    }
}
