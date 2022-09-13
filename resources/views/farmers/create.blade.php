
@extends('layouts.master')
@section('title',__('common.farmers.add_farmer_page_title'))
@section('content')


    <div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{__('common.farmers.add_farmer_details')}}
                        </h3>
                    </div>
                    <div class="back-url-div">
                        <a href="{{ URL::previous() }}" class="btn btn-brand btn-elevate btn-icon-sm back-url">
                            {{__('common.back_button')}}
                        </a>
                    </div>
                </div>

                <!--begin::Form-->
                {!! Form::open(['route' => 'farmer.store', 'class' => 'form-horizontal', 'method' => 'POST', 'id' => 'addFarmer']) !!}
                <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('name', __('common.farmers.full_name').'<span class="text-danger">*</span>',
                                         ['class' => 'control-label'])) !!}
                                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 
                                        __('common.farmers.farmer_name_placeholder'), 'data-parsley-required' => 'true', 
                                        'data-parsley-required-message' => __('common.farmers.farmer_name_parsley_validation'), 
                                        'data-parsley-maxlength' => '100', 'data-parsley-maxlength-message' => 
                                        __('common.farmers.farmer_name_parsley_max_validation'), 'data-parsley-trigger' => 'input',
                                         'data-parsley-pattern' => config('common.safe_string_pattern'), 'data-parsley-pattern-message' => 
                                         __('common.farmers.farmer_name_parsley_pattern_message'), 'data-parsley-trigger' => 'blur']) !!}
                                    {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                         
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('username', __('common.farmers.username').'<span class="text-danger">*</span>',
                            
                                         ['class' => 'control-label'])) !!}
                                    {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 
                                        __('common.farmers.farmer_username_placeholder'), 'data-parsley-required' => 'true',
                                         'data-parsley-required-message' => __('common.farmers.farmer_username_parsley_validation'),
                                          'data-parsley-maxlength' => '100', 'data-parsley-maxlength-message' =>
                                           __('common.farmers.farmer_username_parsley_max_validation'), 'data-parsley-trigger' =>
                                            'input', 'data-parsley-trigger' => 'blur']) !!}
                                    {!! $errors->first('username', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('company_name',__('common.farmers.company_name').'<span class="text-danger">*
                                    </span>', ['class' => 'control-label'])) !!}
                                    {!! Form::text('company_name', null, ['class' => 'form-control', 'placeholder' => 
                                        __('common.farmers.company_name_placeholder'), 'data-parsley-required' => 'true', 
                                        'data-parsley-required-message' => __('common.farmers.company_name_parsley_validation'),
                                         'data-parsley-maxlength' => '100', 'data-parsley-maxlength-message' => 
                                         __('common.farmers.company_name_parsley_max_validation'), 'data-parsley-trigger' => 'input', 
                                         'data-parsley-trigger' => 'blur']) !!}
                                    {!! $errors->first('company_name', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('Email', __('common.farmers.email').'<span class="text-danger">*</span>',
                                         ['class' => 'control-label'])) !!}
                                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 
                                        __('common.farmers.email_placeholder'), 'data-parsley-required' => 'true',
                                         'data-parsley-required-message' => __('common.farmers.email_parsley_validation'), 
                                         'data-parsley-maxlength' => '100', 'data-parsley-maxlength-message' => 
                                         ('common.farmers.email_parsley_max_validation'), 'data-parsley-trigger' => 'input', 
                                         'data-parsley-trigger' => 'blur']) !!}
                                    {!! $errors->first('email', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('Registration Number', __('common.farmers.registration_number').
                                        '<span>(optional)</span>', ['class' => 'control-label'])) !!}
                                    {!! Form::text('registration_number', null, ['class' => 'form-control', 'placeholder' =>
                                         __('common.farmers.registration_placeholder'), 'data-parsley-maxlength' => '12', 
                                         'data-parsley-maxlength-message' => __('common.farmers.registration_parsley_max_validation'),
                                          'data-parsley-trigger' => 'input', 'data-parsley-trigger' => 'blur']) !!}
                                    {!! $errors->first('registration_number', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('SAP Business Partner ID',__('common.farmers.sap_business_partner_id').
                                        '<span>(optional)</span>', ['class' => 'control-label'])) !!}
                                    {!! Form::text('business_partner_id', null, ['class' => 'form-control', 'placeholder' => 
                                        __('common.farmers.sap_business_partner_id_placeholder'),  'data-parsley-maxlength' => '20',
                                         'data-parsley-maxlength-message' => __('common.farmers.sap_business_partner_id_max_validation'), 
                                         'data-parsley-trigger' => 'input', 'data-parsley-trigger' => 'blur']) !!}
                                </div>
                            </div>
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('PIN', __('common.farmers.pin').'<span class="text-danger">*</span>',
                                         ['class' => 
                                        'control-label'])) !!}
                                    <input type="password" class="form-control" name="pin" id="pin"
                                        placeholder="{{__('common.farmers.pin_placeholder')}}" data-parsley-maxlength="12"
                                        data-parsley-maxlength-message="{{__('common.farmers.pin_parsley_max_validation')}}"
                                        data-parsley-minlength="6"
                                        data-parsley-minlength-message="{{__('common.farmers.pin_parsley_min_validation')}}"
                                        data-parsley-required='true' data-parsley-required-message="{{__('common.farmers.pin_parsley_validation')}}"
                                        data-parsley-trigger='input' />
                                    {!! $errors->first('pin', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('Dialling Code', __('common.farmers.dialling_code').'
                                                <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('dialing_code', null, ['class' => 'form-control', 'placeholder' => '+ 91',
                                                 'data-parsley-required' => 'true', 'data-parsley-required-message' => 
                                                 __('common.farmers.dailling_code_parsley_validation'), 'data-parsley-trigger' => 'keyup',
                                             "data-parsley-pattern"=>"/^\+(\d{1}\-)?(\d{1,3})$/"]) !!}
                                            {!! $errors->first('dialing_code', '<p class="help-block text-danger">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('Phone',__('common.farmers.phone'). '<span class="text-danger">*

                                            </span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 
                                                __('common.farmers.phone_placeholder'), 'data-parsley-required' => 'true', 
                                                'data-parsley-required-message' => __('common.farmers.phone_parsley_validation'), 
                                                'data-parsley-trigger' => 'keyup',
                                            "data-parsley-pattern"=>"^[\d\+\-\.\(\)\/\s]*$", 'data-parsley-minlength' => '2', 
                                            'data-parsley-maxlength' => '20']) !!}
                                            {!! $errors->first('phone', '<p class="help-block text-danger">:message</p>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('Address', __('common.farmers.address').'<span class="text-danger">*</span>', 
                                        ['class' => 'control-label'])) !!}
                                    {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => 
                                        __('common.farmers.address_placeholder'), 'data-parsley-required' => 'true',
                                         'data-parsley-required-message' => __('common.farmers.address_parsley_validation'), 
                                         'data-parsley-maxlength' => '100', 'data-parsley-maxlength-message' => 
                                         __('common.farmers.address_parsley_max_validation'), 'data-parsley-trigger' => 'input',
                                          'data-parsley-trigger' => 'blur']) !!}
                                    {!! $errors->first('address', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                          
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                       {{__('common.farmers.user_type')}}
                                        <span class="mandatory">*</span>
                                    </label>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    {!! Form::radio('user_type', 'producer', true, ['class' => 'custom-control-input', 'id' =>
                                                         'producer']) !!}
                                                    <label class="custom-control-label" for="producer">
                                                        {{__('common.farmers.producer')}}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    {!! Form::radio('user_type', 'trader', false, ['class' => 
                                                        'custom-control-input', 'id' => 'trader']) !!}
                                                    <label class="custom-control-label" for="trader">
                                                        {{__('common.farmers.traders')}}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    {!! Form::radio('user_type', 'others', false, 
                                                        ['class' => 'custom-control-input', 'id' => 'others']) !!}
                                                    <label class="custom-control-label" for="others">
                                                        {{__('common.farmers.others')}}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                {!! Form::text('others', null, ['class' => 'form-control', 'style' => 'display:none;', 
                                                    'id' => 'othersInputField', 'data-parsley-required' => 'true']) !!}
                                                <label class="form-check-label" for="others">
                                                </la-bel>
                                                {!! $errors->first('others', '<p class="help-block text-danger">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {!! $errors->first('user_type', '<p class="help-block text-danger">:message</p>') !!}
                            </div>
                         
                            <div class="col-md-6">
                                <h3 class="text-center"> {{__('common.sms')}}</h3>
                                <div class="row">


                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label class="control-label">{{__('common.news')}}<span class="mandatory">*</span></label>

                                            <div class="col-md-2">

                                                <div class="custom-control custom-radio custom-control">
                                                    <input type="radio" id="is_news_sms_enable" name="is_news_sms"
                                                        class="custom-control-input" value="1" checked>
                                                    <label class="custom-control-label" for="is_news_sms">{{__('common.active')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-radio custom-control">
                                                    <input type="radio" id="is_news_sms_disable" name="is_news_sms"
                                                        class="custom-control-input" value="0">
                                                    <label class="custom-control-label"
                                                        for="is_news_sms_disable">{{__('common.inactive')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        {!! $errors->first('is_news_sms', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">{{__('common.marketing')}}<span
                                                    class="mandatory">*</span></label>

                                            <div class="col-md-2">

                                                <div class="custom-control custom-radio custom-control">
                                                    <input type="radio" id="is_marketing_sms_enable" name="is_marketing_sms"
                                                        class="custom-control-input" value="1" checked>
                                                    <label class="custom-control-label"
                                                        for="is_marketing_sms_enable">{{__('common.active')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-radio custom-control">
                                                    <input type="radio" id="is_marketing_sms_disable"
                                                        name="is_marketing_sms" class="custom-control-input" value="0">
                                                    <label class="custom-control-label"
                                                        for="is_marketing_sms_disable">{{__('common.inactive')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        {!! $errors->first('is_marketing_sms', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                  
                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label class="control-label">{{__('common.bids')}}<span class="mandatory">*</span></label>

                                            <div class="col-md-2">

                                                <div class="custom-control custom-radio custom-control">
                                                    <input type="radio" id="is_bids_sms_enable" name="is_bids_received_sms"
                                                        class="custom-control-input" value="1" checked>
                                                    <label class="custom-control-label"
                                                        for="is_bids_sms_enable">{{__('common.active')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-radio custom-control">
                                                    <input type="radio" id="is_bids_sms_disable" name="is_bids_received_sms"
                                                        class="custom-control-input" value="0">
                                                    <label class="custom-control-label"
                                                        for="is_bids_sms_disable">{{__('common.inactive')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        {!! $errors->first('is_bids_sms', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                </div>


                            </div>
                           
                            <div class="col-md-6">
                                <h3 class="text-center">{{__('common.notification')}}</h3>
                                <div class="row">
                                 

                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label class="control-label">{{__('common.news')}}<span
                                                    class="mandatory">*</span></label>

                                            <div class="col-md-2">

                                                <div class="custom-control custom-radio custom-control">
                                                    <input type="radio" id="is_news_notification_enable"
                                                        name="is_news_notification" class="custom-control-input" value="1"
                                                        checked>
                                                    <label class="custom-control-label"
                                                        for="is_news_notification">{{__('common.active')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-radio custom-control">
                                                    <input type="radio" id="is_news_notification_disable"
                                                        name="is_notification_sms" class="custom-control-input" value="0">
                                                    <label class="custom-control-label"
                                                        for="is_news_notification_disable">{{__('common.inactive')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        {!! $errors->first('is_news_notification', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                   
                                  
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">{{__('common.marketing')}}<span
                                                    class="mandatory">*</span></label>

                                            <div class="col-md-2">

                                                <div class="custom-control custom-radio custom-control">
                                                    <input type="radio" id="is_marketing_notification_enable"
                                                        name="is_marketing_notification" class="custom-control-input"
                                                        value="1" checked>
                                                    <label class="custom-control-label"
                                                        for="is_marketing_notification_enable">{{__('common.active')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-radio custom-control">
                                                    <input type="radio" id="is_marketing_notification_disable"
                                                        name="is_marketing_notification" class="custom-control-input"
                                                        value="0">
                                                    <label class="custom-control-label"
                                                        for="is_marketing_notification_disable">{{__('common.inactive')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        {!! $errors->first('is_marketing_notification', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                   
                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label class="control-label">{{__('common.bids')}}<span
                                                    class="mandatory">*</span></label>

                                            <div class="col-md-2">

                                                <div class="custom-control custom-radio custom-control">
                                                    <input type="radio" id="is_bids_notification_enable"
                                                        name="is_bids_received_notification" class="custom-control-input"
                                                        value="1" checked>
                                                    <label class="custom-control-label"
                                                        for="is_bids_notification_enable">{{__('common.active')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-radio custom-control">
                                                    <input type="radio" id="is_bids_notification_disable"
                                                        name="is_bids_received_notification" class="custom-control-input"
                                                        value="0">
                                                    <label class="custom-control-label"
                                                        for="is_bids_notification_disable">{{__('common.inactive')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        {!! $errors->first('is_bids_notification', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                </div>


                            </div>
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{__('common.status')}}
                                        <span class="mandatory">*</span>
                                    </label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" value="1"
                                                    id="status_enable" checked>
                                                <label class="form-check-label" for="status_enable">
                                                    {{__('common.active')}}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" value="0"
                                                    id="status_disable">
                                                <label class="form-check-label" for="status_disable">
                                                    {{__('common.inactive')}}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="reason" class="form-control" style="display:none"
                                                id="reasonInputField" placeholder={{__('common.farmers.others_placeholder')}}
                                                data-parsley-required='true'
                                                data-parsley-required-message = 'Please enter valid reason' >

                                            <label class="form-check-label" for="reason">
                                            </label>
                                            {!! $errors->first('reason', '<p class="help-block text-danger">:message</p>') !!}
                                        </div>
                                    </div>
                                </div>
                                {!! $errors->first('status', '<p class="help-block text-danger">:message</p>') !!}
                            </div>

                            




                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-check-label">
                                    </label>
                                    <div class="col-md-6" style="margin-top: 0.5rem">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_suspend" value="1"
                                                id="is_suspend">
                                            <label class="form-check-label" for="is_suspend">
                                                {{__('common.farmers.suspend_account')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                  
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button type="submit" id="send_form" class="btn btn-brand">
                                        {{__('common.submit')}}
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                        {{__('common.clear')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
  
@endsection

@section('script')

    <script>
        $(document).ready(function() {
   
            //parsley validate the form
            $('#addFarmer').parsley({
                excluded: 'input[type=button], input[type=submit], input[type=reset], input[type=hidden], input:hidden'
            });



            $('#send_form').click(function() {
                $('#img_err').css('display', 'none').html('');
            });

            $('form').on('reset', function() {
                let form = $(this);
                setTimeout(function() {
                    form.find('input:file').trigger('change');
                }, 100);
            });

            $("input:radio[name=user_type]").change(function() {
                if ($(this).val() == "others") {
                    $('#othersInputField').val('')
                    $('#othersInputField').slideDown('slow');
                } else {
                    $('#othersInputField').slideUp('slow');
                }
            });

            $("input:radio[name=status]").change(function() {
                if ($(this).val() == 0) {
                    $('#reasonInputField').val('')
                    $('#reasonInputField').slideDown('slow');
                } else {
                    $('#reasonInputField').slideUp('slow');
                }
            });



        });
    </script>
@endsection
