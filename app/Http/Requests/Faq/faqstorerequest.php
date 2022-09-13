<?php

namespace App\Http\Requests\Faq;

use Illuminate\Foundation\Http\FormRequest;

class faqstorerequest extends FormRequest
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
            'question'=>'bail|required',
            'answer'=>'bail|required',    
              ];
    }
    public function messages()
    {
        return
        [
            'question.required' =>' Faq is required.',
            
            'answer.required' =>'Description is required.',
        ];
    }
}
