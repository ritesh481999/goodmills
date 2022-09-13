<?php

namespace App\Http\Requests\Bid;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CommodityMaster;
use App\Models\SpecificationMaster;
use App\Models\Variety;
use App\Models\Farmer;
use App\Models\DeliveryLocation;

class BidStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'group_or_individual' => 'required|in:1,0',
            'bid_name'=>'bail|required|string|max:50',
            'publish_on'=>'bail|required',
            'month_of_movement'=>'bail|required',
            'commodity_id'=>'bail|required|exists:'.(new CommodityMaster)->getTable().',id',
            'variety_id'=>'bail|required||exists:'.(new Variety)->getTable().',id',
            'specification_id'=>'bail|required||exists:'.(new SpecificationMaster)->getTable().',id',
            'max_tonnage'=>'bail|required',
            'price'=>'bail|required|max:11|between:0,99.99',
            'valid_till'=>'bail|required',
            'bid_location_id'=>'bail|required|array|min:1|max:3',
            'status'=>'bail|required|in:0,1',
            'delivery_method' => 'bail|required|in:1,2',
            'delivery_location_id' => 'required_if:delivery_method,2|nullable|exists:'.(new DeliveryLocation)->getTable().',id',
            'postal_code' => 'bail|required_if:delivery_method,1|nullable|min:3|max:7',
            'delivery_address' => 'nullable|max:50'
        ];

        if(!request()->filled('sell_request_id')){
            $rules['group_id']= 'bail|required_if:group_or_individual,1|array|min:1';
            $rules['farmer_id']= 'bail|required_if:group_or_individual,0|array|min:1';
        }
        return $rules;
    }
     public function messages()
    {
        return  [
            'bid_name.required' => __('bid_error.bid_name.required'),
            'bid_name.string' => __('bid_error.bid_name.string'),
            'bid_name.max' => __('bid_error.bid_name.max'),
            'publish_on.required' => __('bid_error.publish_on.required'),
            'month_of_movement.required' => __('bid_error.month_of_movement.required'),
            'commodity_id.required' => __('bid_error.commodity_id.required'),
            'variety_id.required' => __('bid_error.variety_id.required'),
            'specification_id.required' => __('bid_error.specification_id.required'),
            'max_tonnage.required' => __('bid_error.max_tonnage.required'),
            'price.required' => __('bid_error.price.required'),
            'price.max' => __('bid_error.price.max'),
            'price.regex' => __('bid_error.price.regex'),
            'valid_till.required' => __('bid_error.valid_till.required'),
            'bid_location_id.required' => __('bid_error.bid_location_id.required'),
            'status.required' => __('bid_error.status.required'),
            'delivery_method.required' => __('bid_error.delivery_method.required'),
            'delivery_location_id.*' => __('bid_error.delivery_location_id.required_if'),
            'postal_code.required_if' => __('bid_error.postal_code.required_if'),
            'postal_code.min' => __('bid_error.postal_code.min'),
            'postal_code.max' => __('bid_error.postal_code.max'),
            'delivery_address.required_if' => __('bid_error.delivery_address.required_if'),
            'delivery_address.min' => __('bid_error.delivery_address.min'),
            'delivery_address.max' => __('bid_error.delivery_address.max'),
            'group_or_individual.required' => __('bid_error.group_or_individual.required'),
            'group_id.required_if' => __('bid_error.group_id.required_if'),
            'farmer_id.required_if' => __('bid_error.farmer_id.required_if'),
        ];
    }
    
    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
    */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // if(!$validator->errors()->has('mb_ids'))
            // {
            //     $mb_ids = explode(',',request()->mb_ids);
            //     if(Farmer::whereIn('mb_id', $mb_ids)->count() <> sizeof($mb_ids))
            //         $validator->errors()->add('mb_ids', 'Invalid farmer selected.');
            // }       
        });
    }
}
