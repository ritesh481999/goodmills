<?php

namespace App\Http\Requests\Bid;

use Illuminate\Foundation\Http\FormRequest;

class BidUpdateRequest extends FormRequest
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
    { $id=$this->route('bid');
        return [
            'bid_name'=>'bail|required|string|max:50|unique:bids,bid_name,'.$id.',id,deleted_at,NULL',
            'bid_date'=>'bail|required',
            'commodity_id'=>'bail|required|exists:'.(new CommodityMaster)->getTable().',id',
            'variety_id'=>'bail|required||exists:'.(new Variety)->getTable().',id',
            'specification_id'=>'bail|required||exists:'.(new SpecificationMaster)->getTable().',id',
            'max_tonnage'=>'bail|required',
            'price'=>'bail|required|regex:/^\d+(\.\d{1,2})?$/',
            'validity'=>'bail|required',
            'bid_location_id'=>'bail|required|array|min:1|max:3',
            'status'=>'bail|required|in:0,1',
            'user_ids'=>'bail|required',
        ];
    }
     public function messages()
    {
        return [
            'bid_name.required'=>'Bid Name Is required',
            'bid_name.max'=>'Max 50 Char allowed for Bid name',
            'bid_name.unique'=>'Name already taken Bid name',

            'bid_date.required'=>'Bid date is Required',
            'commodity_id.required'=>'Commodity is Required',
            'variety_id.required'=>'Variety is Required',
            'specification_id.required'=>'Specifiaction is Required',
            'max_tonnage.required'=>'Max Tonnage is Required',
            'price.required'=>'Price is Required',
            'price.regex'=>'Invalid format for price',
            'validity.required'=>'Validity is Required',
            'bid_location_id.required'=>'Bid Location is Required',
            'status.required'=>'is Required',
            'user_ids.required'=>'Please Select Users',
        ];
    }
}
