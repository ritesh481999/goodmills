@extends('layouts.master')
@section('title', __('common.bid.add_bid_details'))
@section('css')
    <style>
        #month_of_movement.ui-datepicker-calendar {
            display: none;
        }

    </style>
@endsection
@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        @endif

        @if (\Session::has('error'))
            <div class="alert alert-danger">
                <ul>
                    <li>{!! \Session::get('error') !!}</li>
                    }
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">

                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{ __('common.bid.add_bid_details') }}
                            </h3>
                        </div>
                        <div class="back-url-div">
                            <a href="{{ route('bid.index') }}" class="btn btn-brand btn-elevate btn-icon-sm back-url">
                                {{ __('common.back_button') }}
                            </a>
                        </div>
                    </div>

                    <!--begin::Form-->
                    <form class="kt-form" id='addbid' action="{{ route('bid.store') }}" method="POST"
                        enctype="multipart/form-data">
                        <div class="kt-portlet__body">
                            <div class="kt-section kt-section--first">
                                <div class="form-group">

                                    {!! Html::decode(Form::label('bid_name', __('common.bid.bid_name') . '<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
                                    <div class="col-md-6">
                                        <input type="text" name="bid_name" id="bid_name" class="form-control"
                                            placeholder="{{ __('common.bid.bid_name_placeholder') }}"
                                            data-parsley-required="true"
                                            data-parsley-required-message="
                                                                        {{ __('common.bid.bid_name_parsley_validation') }}"
                                            data-parsley-trigger="input blur" data-parsley-maxlength='50'
                                            data-parsley-pattern='{{ config('common.safe_string_pattern') }}'
                                            data-parsley-pattern-message="{{ __('common.bid.bid_name_parsley_pattern_validation') }}"
                                            data-parsley-maxlength-message='{{ __('common.bid.bid_name_parsley_max_validation') }}'>
                                        {!! $errors->first('bid_name', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"
                                        for="publish_on">{{ __('common.bid.publish_on') }}
                                        <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input type="text" name="publish_on" id="publish_on" class="form-control"
                                            placeholder="{{ __('common.bid.publish_on_placeholder') }}" readonly
                                            data-parsley-required="true"
                                            data-parsley-required-message="{{ __('common.bid.publish_on_parsley_validation') }}"
                                            data-parsley-trigger="input blur" />
                                        {!! $errors->first('publish_on', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label"
                                        for="month_of_movement">{{ __('common.bid.month_of_movement') }}<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input type="text" name="month_of_movement" id="month_of_movement"
                                            class="form-control"
                                            placeholder="{{ __('common.bid.month_of_movement_placeholder') }}" readonly
                                            data-parsley-required="true"
                                            data-parsley-required-message="{{ __('common.bid.month_of_movement_parsley_validation') }}"
                                            data-parsley-trigger="input blur" />
                                        {!! $errors->first('month_of_movement', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>

                                </div>
                                @if (!empty($sell_request))
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="country_id">Country<span
                                                class="text-danger">*</span></label>

                                        <div class="col-md-6">
                                            <select name="country_id" id="country_id" class="form-control"
                                                data-parsley-trigger="change blur" data-parsley-required='true'
                                                data-parsley-required-message='{{ __('common.bid.country_parsley_validation') }}'>
                                                <option value="" disabled selected>{{ __('common.bid.select_country') }}
                                                </option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>

                                            {!! $errors->first('commodity_id', '<p class="help-block text-danger">:message</p>') !!}
                                        </div>

                                    </div>
                                @endif

                                <div class="form-group">
                                    <label class="col-md-4 control-label"
                                        for="commodity_id">{{ __('common.bid.commodity') }} <span
                                            class="text-danger">*</span></label>

                                    <div class="col-md-6">
                                        <select name="commodity_id" id="commodity_id" class="form-control"
                                            data-parsley-trigger="change blur" data-parsley-required='true'
                                            data-parsley-required-message='{{ __('common.bid.commodity_parsley_validation') }}'>
                                            <option value="" disabled selected>{{ __('common.bid.select_commodity') }}
                                            </option>
                                            @foreach ($commodity as $commo)
                                                <option value="{{ $commo->id }}">{{ $commo->name }}</option>
                                            @endforeach
                                        </select>

                                        {!! $errors->first('commodity_id', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="variety_id">{{ __('common.bid.variety') }}
                                        <span class="text-danger">*</span></label>

                                    <div class="col-md-6">
                                        <select name="variety_id" id="variety_id" class="form-control"
                                            data-parsley-trigger="blur" data-parsley-required='true'
                                            data-parsley-required-message='{{ __('common.bid.variety_parsley_validation') }}'>
                                            <option value="" disabled selected>{{ __('common.bid.select_variety') }}
                                            </option>
                                        </select>

                                        {!! $errors->first('variety_id', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"
                                        for="specification_id">{{ __('common.bid.specification') }} <span
                                            class="text-danger">*</span></label>

                                    <div class="col-md-6">
                                        <select name="specification_id" id="specification_id" class="form-control"
                                            data-parsley-trigger="blur" data-parsley-required='true'
                                            data-parsley-required-message='{{ __('common.bid.specification_parsley_validation') }}'>
                                            <option value="" disabled selected>
                                                {{ __('common.bid.select_specification') }}
                                            </option>
                                        </select>

                                        {!! $errors->first('specification_id', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="max_tonnage">
                                        {{ __('common.bid.max_tonnage') }} <span class="text-danger">*</span>
                                    </label>

                                    <div class="col-md-6">
                                        <select name="max_tonnage" id="max_tonnage" class="form-control"
                                            data-parsley-trigger="blur" data-parsley-required='true' ,
                                            data-parsley-required-message='{{ __('common.bid.max_tonnage_parsley_validation') }}'>
                                            <option value="" disabled selected>{{ __('common.bid.select_max_tonnage') }}
                                            </option>
                                            @foreach (getTonnages() as $tonnage)
                                                <option value="{{ $tonnage }}">{{ $tonnage }}</option>
                                            @endforeach
                                        </select>

                                        {!! $errors->first('max_tonnage', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>


                                </div>

                                <div class="form-group">

                                    <label class="col-md-4 control-label" for="price">
                                        {{ __('common.bid.price') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="price" id="price" class="form-control"
                                            placeholder="{{ __('common.bid.price_placeholder') }}"
                                            data-parsley-required='true'
                                            data-parsley-required-message='{{ __('common.bid.price_parsley_validation') }}'
                                            data-parsley-type="number" , data-parsley-trigger="blur" data-parsley-nonzero=""
                                            data-parsley-nonzero-message="{{ __('common.bid.price_parsley_valid_validation') }}"
                                            data-parsley-maxlength="11"
                                            data-parsley-maxlength-message="{{ __('common.bid.price_parsley_max_validation') }}" />

                                        {!! $errors->first('price', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>

                                </div>

                                <div class="form-group">

                                    {!! Html::decode(
    Form::label(
        'valid_till',
        __('common.bid.bid_validity') .
            '<span class="text-danger">*

                                    </span>',
        ['class' => 'col-md-4 control-label'],
    ),
) !!}
                                    <div class="col-md-6">

                                        <input type="text" class="form-control" id="valid_till" readonly=""
                                            placeholder="{{ __('common.bid.bid_validity_placeholder') }}"
                                            data-parsley-required='true' data-parsley-trigger="blur"
                                            data-parsley-required-message='{{ __('common.bid.bid_validity_parsley_validation') }}'
                                            name="valid_till">

                                        {!! $errors->first('valid_till', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Html::decode(
    Form::label(
        'bid_location_id',
        __('common.bid.select_bid_location') .
            ' 
                                        <span class="text-danger">*</span>',
        ['class' => 'col-md-4 control-label'],
    ),
) !!}
                                    <div class="col-md-6">
                                        <select class="form-control" id="bid_location_id" name="bid_location_id[]"
                                            multiple="multiple" data-parsley-required='true'
                                            data-parsley-required-message='{{ __('common.bid.bid_location_parsley_validation') }}'
                                            data-parsley-errors-container='#bid-location-error-message'>
                                            @foreach ($bidLocation as $bl)
                                                <option value="{{ $bl->id }}">{{ $bl->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6" id="bid-location-error-message">
                                        {!! $errors->first('bid_location_id', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                </div>
                                @if (empty($sell_request))
                                    <div class="form-group">
                                        <label
                                            class="col-md-4 control-label">{{ __('common.bid.group_or_individual') }}<span
                                                class="mandatory">*</span></label>
                                        <div class="col-md-6">
                                            <div class="custom-control custom-radio custom-control">
                                                <input type="radio" id="group-farmer" name="group_or_individual"
                                                    class="custom-control-input" value="1" checked>
                                                <label class="custom-control-label"
                                                    for="group-farmer">{{ __('common.bid.group_farmers') }}</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control">
                                                <input type="radio" id="individual-farmer" name="group_or_individual"
                                                    class="custom-control-input" value="0">
                                                <label class="custom-control-label"
                                                    for="individual-farmer">{{ __('common.bid.individual_farmers') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" id='group-container'>
                                        {!! Html::decode(Form::label('group_id', __('common.bid.select_farmer_group') . ' <span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
                                        <div class="col-md-6">
                                            <select class="form-control" id="group_id" name="group_id[]"
                                                multiple="multiple" data-parsley-validate-if-empty='true'
                                                data-parsley-trigger="select2:unselect select2:select select2:close"
                                                data-parsley-requiredif='radio,group_or_individual,1'
                                                data-parsley-requiredif-message='{{ __('common.bid.select_farmer_group_parsley_validation') }}'
                                                data-parsley-errors-container='#group_id-error-message'>
                                                @foreach ($farmer_groups as $fg)
                                                    <option value="{{ $fg->id }}">{{ $fg->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6" id="group_id-error-message">
                                            {!! $errors->first('group_id', '<p class="help-block text-danger">:message</p>') !!}
                                        </div>
                                    </div>

                                    <div id='farmer-container' class="form-group hidden">
                                        <select multiple id='farmer_id' data-parsley-trigger="select"
                                            data-parsley-validate-if-empty='true'
                                            data-parsley-requiredif='radio,group_or_individual,0'
                                            data-parsley-requiredif-message='{{ __('common.bid.please_select_farmers_from_below_table') }}'
                                            name="farmer_id[]" class='hidden'>
                                        </select>
                                        <table
                                            class="table table-striped- table-bordered table-hover table-checkable data-table"
                                            id="user_table">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('common.bid.id') }}</th>
                                                    <th>{{ __('common.bid.username') }}</th>
                                                    <th>{{ __('common.bid.action') }}</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                @else
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('farmer', __('common.bid.farmer') . '<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
                                        <div class="col-md-6">
                                            <b>{{ $sell_request->farmer->username }}</b>
                                        </div>
                                    </div>
                                    <input type="hidden" name="group_or_individual" value="0" />
                                    <input type="hidden" name="farmer_id" value="{{ $sell_request->farmer->id }}">
                                @endif
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{ __('common.bid.delivery_method') }}<span
                                            class="mandatory">*</span></label>
                                    <div class="col-md-6">
                                        <div class="custom-control custom-radio custom-control">
                                            <input type="radio" id="delivery-method-a" name="delivery_method"
                                                class="custom-control-input" value="1" checked>
                                            <label class="custom-control-label"
                                                for="delivery-method-a">{{ __('common.bid.ex_farm') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control">
                                            <input type="radio" id="delivery-method-b" name="delivery_method"
                                                class="custom-control-input" value="2">
                                            <label class="custom-control-label"
                                                for="delivery-method-b">{{ __('common.bid.deliver') }}</label>
                                        </div>
                                    </div>
                                    {!! $errors->first('delivery_method', '<p class="help-block text-danger">:message</p>') !!}
                                </div>

                                <div class="form-group hidden" id='drop-off-box'>
                                    <div class="form-group">
                                        <label for='delivery_location_id'
                                            class='col-md-4 control-label'>{{ __('common.bid.delivery_location') }} <span
                                                class="text-danger">*</span>
                                        </label>

                                        <div class="col-md-6">
                                            <select class="form-control" id="delivery_location_id"
                                                name="delivery_location_id"
                                                data-parsley-requiredif='radio,delivery_method,2'
                                                data-parsley-validate-if-empty='true'
                                                data-parsley-requiredif-message='{{ __('common.bid.delivery_location_parsley_validation') }}'
                                                data-parsley-errors-container='#delivery_location_id-error-message'>
                                                <option disabled selected value="">
                                                    {{ __('common.bid.select_delivery_location') }}</option>
                                                @foreach ($deliveryLocations as $bl)
                                                    <option value="{{ $bl->id }}">{{ $bl->name }}</option>
                                                @endforeach
                                            </select>
                                            <div id="delivery_location_id-error-message">
                                                {!! $errors->first('delivery_location_id', '<p class="help-block text-danger">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group">
                                        <label for='postal_code'
                                            class='col-md-4 control-label'>{{ __('common.bid.postal_code') }}
                                        </label>
                                        <div class="col-md-6">

                                            <input type='text' class="form-control" id="postal_code-a" name="postal_code"
                                                data-parsley-validate-if-empty='true' data-parsley-maxlength="7"
                                                data-parsley-maxlength-message="{{ __('common.bid.postal_code_parsley_maxlength_validation') }}"
                                                data-parsley-minlength="3"
                                                data-parsley-minlength-message="{{ __('common.bid.postal_code_parsley_minlength_validation') }}" />
                                        </div>
                                        <div class="col-md-6" id="postal-code-error-message">
                                            {!! $errors->first('postal_code', '<p class="help-block text-danger">:message</p>') !!}
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group" id='postal-box'>
                                    <div class="form-group">
                                        <label for='delivery_address'
                                            class='col-md-4 control-label'>{{ __('common.bid.delivery_address') }}
                                        </label>

                                        <div class="col-md-6">
                                            <input type='text' class="form-control" data-parsley-validate-if-empty='true'
                                                id="delivery_address" name="delivery_address"
                                                placeholder="{{ __('common.bid.delivery_address_placeholder') }}"/>
                                            <div id="delivery-address-error-message">
                                                {!! $errors->first('delivery_address', '<p class="help-block text-danger">:message</p>') !!}
                                            </div>
                                        </div>


                                    </div>
                                    <div class="form-group">
                                        <label for='postal_code'
                                            class='col-md-4 control-label'>{{ __('common.bid.postal_code') }}<span
                                                class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-6">

                                            <input type='text' class="form-control" id="postal_code-b" name="postal_code"
                                                data-parsley-validate-if-empty='true' data-parsley-maxlength="7"
                                                data-parsley-maxlength-message="{{ __('common.bid.postal_code_parsley_maxlength_validation') }}"
                                                data-parsley-minlength="3"
                                                data-parsley-minlength-message="{{ __('common.bid.postal_code_parsley_minlength_validation') }}"
                                                data-parsley-requiredif='radio,delivery_method,1'
                                                data-parsley-requiredif-message='{{ __('common.bid.postal_code_parsley_validation') }}' />
                                        </div>
                                        <div class="col-md-6" id="postal-code-error-message">
                                            {!! $errors->first('postal_code', '<p class="help-block text-danger">:message</p>') !!}
                                        </div>
                                    </div>

                                </div>


                                <!-- <div class="form-group">
                                                                <input type="text" style="display: none;" name="mb_ids" id="user_ids"
                                                                value="" data-parsley-trigger="input"
                                                                data-parsley-required='true'
                                                                data-parsley-required-message='Please select farmer(s)'
                                                                data-parsley-errors-container="#user_ids_errors"
                                                                />
                                                                {!! Html::decode(Form::label('select_user', __('bid.users') . ' <span class="text-danger">*</span>', ['class' => 'col-md-2 control-label'])) !!}
                                                               
                                                                <button type="button" class="btn btn-primary select_user" name="select_user" id="select_user">Add User</button>
                                                                <p class="help-block text-danger" id="user_ids_errors">
                                                                 @if ($errors->has('user_ids'))
    {{ $errors->first('user_ids') }}
    @endif
                                                                </p>
                                                               </div> -->

                                <!-- HERE FARMER TABLE WAS -->

                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{ __('common.status') }} <span
                                            class="mandatory">*</span></label>
                                    <div class="col-md-6">

                                        <div class="custom-control custom-radio custom-control">
                                            <input type="radio" id="active-status" name="status"
                                                class="custom-control-input" value="1" checked>
                                            <label class="custom-control-label"
                                                for="active-status">{{ __('common.active') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control">
                                            <input type="radio" id="inactive-status" name="status"
                                                class="custom-control-input" value="0">
                                            <label class="custom-control-label"
                                                for="inactive-status">{{ __('common.inactive') }}</label>
                                        </div>
                                    </div>
                                    {!! $errors->first('status', '<p class="help-block text-danger">:message</p>') !!}


                                </div>
                            </div>
                        </div>

                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button type="submit" class="btn btn-primary">{{ __('common.submit') }}</button>
                                <button type="reset" class="btn btn-secondary">{{ __('common.clear') }}</button>
                            </div>
                        </div>

                        <input type="hidden" name="sell_request_id" value='{{ $sell_request->id ?? '' }}' />
                        @csrf
                    </form>
                    <!--end::Form-->

                </div>
                <!--en::Portlet-->

            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ asset('assets/plugins/general/moment/min/moment-timezone-with-data.min.js') }}"></script>
    <script>
        $(document).ready(function() {

        })
    </script>
    <script type="text/javascript">
        (function() {

            var date = new Date();
            var year = date.getFullYear(); //get year
            var month = date.getMonth(); //get month
            $('#month_of_movement').datepicker({
                minDate: 0,
                format: 'MM yyyy',
                changeMonth: false,
                stepMonths: 0,
                startView: "months",
                minViewMode: "months",
                startDate: new Date(year, month, '01'), //set it here
                endDate: new Date(year + 3, month, '31'),
                autoClose: true,
            }).on('changeDate', function(e) {
                $(this).parsley().validate();
            }).on('change', function() {
                $('.datepicker').hide();
            });

            window.parsley.addValidator('requiredif', function(value, requirement) {
                const req = requirement.split(',');
                console.log('req', req);
                if (req.length < 3) {
                    console.error('requiredif', 'requirement is invalid');
                    return false;
                }

                const val = $(`[name='${req[1]}']${req[0]=='radio'?':checked':''}`).val();

                console.log('val == req[2]', val, req[2]);
                if (val == req[2]) {
                    if (value === null || value.length < 1) {
                        console.error('requiredif', 'is empty');
                        return false;
                    }
                }

                console.log("value", value);
                return true;
            });

            window.parsley.addValidator('nonzero', function(value, requirement) {
                if (isNaN(value))
                    return false;
                $v = Number(value);
                return !($v <= 0);
            });

            window.Parsley.on('field:error', function() {
                // This global callback will be called for any field that fails validation.
                console.log('Validation failed for: ', this.$element);
            });

            moment.tz.setDefault("{{ config('app.timezone') }}");
            // $('#month_of_movement').datetimepicker({
            // 	autoclose:true,
            // 	format: 'yyyy-mm',
            // 	startDate: moment().format('YYYY-MM-DD'),
            // 	minView: 0
            // });
            initDateAndvalid_till();
            $('#commodity_id').on('change', function() {
                var route = '{{ route('getData', ':id') }}';

                if (this.value != '') {
                    const varietyEl = $('#variety_id');
                    const specificationEl = $('#specification_id');
                    const id = this.value;
                    const url = route.replace(':id', id);

                    varietyEl.find('option.dynamic-opt').remove();
                    specificationEl.find('option.dynamic-opt').remove();


                    $.ajax({
                        url: url,
                        success: function(result) {

                            for (const [key, value] of Object.entries(result['variety'])) {
                                varietyEl.append('<option class="dynamic-opt" value=' + key + '>' +
                                    value + '</option>');
                            }
                            for (const [key, value] of Object.entries(result['specification'])) {
                                specificationEl.append('<option class="dynamic-opt" value=' + key +
                                    '>' + value + '</option>');
                            }

                            varietyEl.val("{{ $sell_request->variety_id ?? '' }}").trigger(
                                'change');
                            specificationEl.val("{{ $sell_request->specification_id ?? '' }}")
                                .trigger('change');
                        }
                    });

                }
            });

            var user_ids = [];
            $('#addbid').parsley();

            $('#bid_location_id').select2({
                placeholder: "Select Location",
                maximumSelectionLength: 3
            }).on('select2:close', function(e) {
                $(e.target).parsley().validate();
            });

            $('#group_id').select2({
                placeholder: "Select Farmer Groups",
            }).on('select2:close', function(e) {
                $(e.target).parsley().validate();
            });

            // $('#select_user').on('click',function(e){
            // 	e.preventDefault();
            // 	e.stopPropagation();
            // 	const el = $('.user_table');
            // 	if(el.hasClass('hidden'))
            // 		el.removeClass('hidden');
            // 	else
            // 		el.addClass('hidden');
            // });

            $("[name='group_or_individual']").on('change', function(e) {

                if (e.target.value == 1) {
                    $('#group-container').removeClass('hidden');
                    $("#farmer-container").addClass('hidden');
                } else {
                    $('#group-container').addClass('hidden');
                    $("#farmer-container").removeClass('hidden');
                }
            })

            $(document).on('change', 'input:checkbox.user-checkedin', function() {
                const user_id = parseInt(this.value);
                const selectUserEl = $('select#farmer_id');

                const optionValues = [];
                selectUserEl.find('option').each(function(index) {
                    optionValues.push(parseInt(this.value));
                });

                if (optionValues.indexOf(parseInt(user_id)) < 0) {
                    selectUserEl.append(`<option value="${user_id}">${user_id}</option>`);
                    optionValues.push(user_id);
                }

                if (this.checked) {
                    const op = selectUserEl.val();
                    op.push(user_id);
                    selectUserEl.val(op).trigger('select');
                } else {
                    const op = selectUserEl.val().filter(o => o != user_id);
                    selectUserEl.val(op).trigger('select');
                }

                // const userIdsEl = document.getElementById('user_ids');
                // if(this.checked){
                // 	if(!user_ids.includes(user_id)){
                // 		user_ids.push(user_id);
                //     }
                // }else{
                // 	const result = user_ids.filter(function(userid){
                // 		return user_id != userid;
                // 	});
                //   	user_ids=result;
                // }
                // userIdsEl.value = user_ids.join(',');
                // $(userIdsEl).trigger('input');
            });


            function initDateAndvalid_till() {
                $('#publish_on').val(moment().format('YYYY-MM-DD'));

                $('#publish_on').datetimepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                    startDate: moment().format('YYYY-MM-DD'),
                    minView: 2 // showing dates only ref: https://stackoverflow.com/questions/19909614/how-to-show-only-date-in-jquery-datetimepicker-addon
                }).on('changeDate', function(e) {
                    updatevalid_till(e.date);
                }).on('hide', function(e) {
                    $(e.target).blur();
                    $(e.target).parsley().validate();
                });


                $('#valid_till').datetimepicker({
                        autoclose: true,
                        format: 'yyyy-mm-dd hh:ii'
                    })
                    .on('change', function(e) {
                        let vdt = new Date(e.target.value);
                    })
                    .on('hide', function(e) {
                        $(e.target).blur();
                        $(e.target).parsley().validate();
                    });

                function updatevalid_till(date) {

                    $("#valid_till").val('');
                    const current = moment();
                    const dt = moment(date);
                    if (current.format('YYYY-MM-DD') == dt.format('YYYY-MM-DD')) {
                        dt.hours(current.hours());
                        dt.minutes(current.minutes() + 1);
                    } else {
                        dt.minutes(1).seconds(0).hours(0);
                    }
                    $('#valid_till').datetimepicker('setStartDate', dt.format('YYYY-MM-DD HH:mm'));
                }


                updatevalid_till(moment());
            }

            $("[name='delivery_method']").on('change', function(e) {
                const boxEl = {
                    drop_off: $('#drop-off-box'),
                    postal: $('#postal-box')
                };
                const inputEl = {
                    drop_off: boxEl.drop_off.find('select#drop_off_location_id'),
                    postal: boxEl.postal.find('input#postal_code')
                };


                if (this.value == 2 && this.checked) {
                    boxEl.drop_off.removeClass('hidden');
                    boxEl.postal.addClass('hidden');
                    // inputEl.drop_off.attr('data-parsley-required','true');
                    // inputEl.postal.attr('data-parsley-required','false');
                } else {
                    inputEl.drop_off.val('').trigger('change');
                    boxEl.drop_off.addClass('hidden');
                    // inputEl.drop_off.attr('data-parsley-required','false');

                    inputEl.postal.val('').trigger('input');
                    boxEl.postal.removeClass('hidden');
                    // inputEl.postal.attr('data-parsley-required','true');
                }
                // $('#addbid').parsley().refresh();
            });

            @if ($sell_request)
                $('#select_user').trigger('click');
                user_ids.push("{{ $sell_request->farmer->mb_id }}");
                $('#user_ids').val(user_ids.join(',')).trigger('input');
                $('#month_of_movement').val("{{ date('F Y', strtotime($sell_request->date_of_movement)) }}");
                $('#commodity_id').val("{{ $sell_request->commodity_id ?? '' }}").trigger('change');
                $('#country_id').val("{{ $sell_request->country_id ?? '' }}").trigger('change').prop('disabled', true);
                $('#max_tonnage').val("{{ $sell_request->tonnage ?? '' }}").trigger('change');
                $("[name='delivery_method'][value='{{ $sell_request->delivery_method }}']").prop('checked',true).trigger('change');
            
            
                @if ($sell_request->delivery_method == 2)
                    console.log("{{ $sell_request->delivery_location_id }}");
                    $("#delivery_location_id").val("{{ $sell_request->delivery_location_id }}").trigger('change');
                    $("input#postal_code-a").val("{{ $sell_request->postal_code ?? '' }}").trigger('input');
                @elseif($sell_request->delivery_method == 1)
                    $("input#postal_code-b").val("{{ $sell_request->postal_code ?? '' }}").trigger('input');
                    $("input#delivery_address").val("{{ $sell_request->delivery_address }}").trigger('input');
                @endif
            @endif

            $('#user_table').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [1, "desc"]
                ],
                ajax: {
                    url:'{{ route("bid.create", ["sell_request_id"=>$sell_request->id ?? null, "fetch_farmers"=>1]) }}'
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'username',
                        name: 'username',
                        sortable: true, 
                        searchable: true
                    },
                    {
                        data: null,
                        render: function(row) {
                            let checked = '';
                            const user_ids = $('select#farmer_id').val();

                            if (user_ids.includes(row.id.toString()))
                                checked = 'checked="true"';
                            return `<input ${checked} class="user-checkedin" type="checkbox" value="${row.id}">`
                        },
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        })();
    </script>


@endsection
