<?php

namespace App\Http\Requests\FarmerSellBid;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\CommodityMaster;
use App\Models\DeliveryLocation;
use App\Models\SpecificationMaster;
use App\Models\Variety;

class SellRequest extends FormRequest
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
            'month_of_movement' => 'required|date_format:Y-m',
            'commodity_id' => 'required|exists:'.(new CommodityMaster)->getTable().',id',
            'specification_id' => 'required|exists:'.(new SpecificationMaster)->getTable().',id',
            'variety_id' => 'required|exists:'.(new Variety)->getTable().',id',
            'delivery_method' => 'required|in:1,2',
            'drop_off_location_id' => 'required_if:delivery_method,2|nullable|exists:'.(new DeliveryLocation)->getTable().',id',
            'postal_code' => 'nullable|alpha_num|min:5|max:8',
            'tonnage' => 'required|integer|in:'.implode(',', config('common.tonnage'))
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
    */
    public function attributes()
    {
        return [
            'commodity_id' => 'commodity',
            'specification_id' => 'specification',
            'variety_id' => 'variety',
            'drop_off_location_id' => 'drop_off_location'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
    */
    public function messages()
    {
        return [
            'drop_off_location_id.required_if' => 'A drop of location is required',
            'month_of_movement.date_format'  => 'A month of movement is required and should be valid format',
            'tonnage.integer' => 'The tonnage is invalid',
            'postal_code.required_if' => 'The postal code is required.'
        ];
    }
}
