@extends('layouts.master')
@section('title', __('common.marketing_module.marketing_title'))

@section('css')
    <link rel="stylesheet" href="{{ asset('image-uploader/src/image-uploader.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                           {{__('common.marketing_module.add_marketing_details')}}
                        </h3>
                    </div>
                    <div class="back-url-div">
                        <a href="{{ URL::previous() }}" class="btn btn-brand btn-elevate btn-icon-sm back-url">
                            {{__('common.back_button')}}
                        </a>
                    </div>
                </div>

                <!--begin::Form-->
                {!! Form::open(['route' => 'marketing.store', 'class' => 'form-horizontal', 'method' =>
                     'POST', 'enctype' => 'multipart/form-data', 'id' => 'addMarketing']) !!}
                <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('title', __('common.title') .
                                         '<span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                                    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' =>
                                         __('common.marketing_module.marketing_title_placeholder'), 
                                         'data-parsley-required' => 'true', 'data-parsley-required-message' =>  
                                         __('common.marketing_module.marketing_title_parsley_validation'), 
                                         'data-parsley-maxlength' => '100', 'data-parsley-maxlength-message' =>
                                          __('common.marketing_module.marketing_title_parsley_max_validation'), 
                                          'data-parsley-trigger' => 'input', 'data-parsley-pattern' => 
                                          config('common.marketing_module.safe_string_pattern'), 
                                          'data-parsley-pattern-message'
                                           => __('common.marketing_module.marketing_title_parsley_va
                                           lid_validation'), 
                                           'data-parsley-trigger' => 'blur']) !!}
                                    {!! $errors->first('title', '<p class="help-block text-danger">
                                        :message</p>') !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('short_description',
                                        __('common.short_description').'<span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                                    {!! Form::text('short_description', null, ['class' => 'form-control', 'placeholder' =>__('common.marketing_module.marketing_short_description_placeholder'), 
                                        'data-parsley-required' => 'true', 'data-parsley-required-message' => 
                                        __('common.marketing_module.marketing_short_description_parsley_validation'), 
                                        'data-parsley-maxlength' => '100', 
                                        'data-parsley-maxlength-message' => __('common.marketing_module.marketing_
                                        short_de
                                        scription_parsley_max_validation'), 'data-parsley-trigger' => 'input',
                                         'data-parsley-trigger' => 'blur']) !!}
                                    {!! $errors->first('short_description', '<p class="help-block text-danger">
                                        :message</p>') !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('description', __('common.long_description').'<span class="text-danger">*</span>', ['class' => 
                                        'control-label'])) !!}
                                    {!! Form::textarea('description', null, ['class' => 'form-control', 
                                        'placeholder' => __('common.marketing_module.marketing_long_description_placeholder'), 
                                        'data-parsley-required' => 'true', 'data-parsley-required-message' =>  
                                        __('common.marketing_module.marketing_long_description_parsley_validation')]) !!}
                                    {!! $errors->first('description', '<p class="help-block text-danger">:
                                        message</p>') !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                       {{ __('common.image')}}
                                    </label>
                                    <img src="" id="imgPreview" />
                                    <input type="file" class="form-control" name="image" id="image" accept="image/*"
                                        onchange="imageView(this, 'imgPreview', 'img_err')" 
                                        data-parsley-fileextension='jpeg,jpg,png'>
                                </div>
                                <p id="img_err" class="p-0 help-block text-danger"></p>
                                {!! $errors->first('image', '<p class="help-block text-danger">:message</p>') !!}
                            </div>

                            <div class="input-field col-md-12">
                                <div class="form-group">
                                    <label class="active">
                                      {{  __('common.upload_files')}}
                                    </label>
                                    <div class="input-images-1" style="padding-top: .5rem;"></div>
                                </div>
                                {!! $errors->first('marketing_files', '<p class="help-block text-danger">:message</p>') !!}
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                       {{ __('common.publish_on')}}
                                        <span class="mandatory">*</span>
                                    </label>

                                    <input type="text" class="form-control date-time-picker" id="date_time" readonly=""
                                        placeholder="Select date &amp; time" data-parsley-required='true'
                                        data-parsley-trigger="blur" data-parsley-required-message="{{__('common.marketing_module
                                            .publish_on_parsley_validation')}}"
                                        name="publish_on">

                                    {!! $errors->first('date_time', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                               {{ __('common.sms_notification')}}
                                                <span class="mandatory">*</span>
                                            </label>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_sms" value="1" checked
                                                    id="sms_enable">
                                                <label class="form-check-label" for="sms_enable">
                                                 {{   __('common.yes')}}
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_sms" value="0"
                                                    id="sms_disable">
                                                <label class="form-check-label" for="sms_disable">
                                                    {{__('common.no')}}
                                                </label>
                                            </div>
                                        </div>
                                        {!! $errors->first('is_sms', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                               {{ __('common.push_notification')}}
                                                <span class="mandatory">*</span>
                                            </label>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_notification"
                                                    value="1" id="is_notification_enable" checked>
                                                <label class="form-check-label" for="is_notification_enable">
                                                 {{   __('common.yes')}}
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_notification"
                                                    value="0" id="is_notification_disable">
                                                <label class="form-check-label" for="is_notification_disable">
                                                  {{  __('common.no')}}
                                                </label>
                                            </div>
                                        </div>
                                        {!! $errors->first('is_notification', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {{__('common.status')}}
                                                <span class="mandatory">*</span>
                                            </label>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" value="1"
                                                    id="status_enable" checked>
                                                <label class="form-check-label" for="status_enable">
                                                    {{__('common.active')}}
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" value="0"
                                                    id="status_disable">
                                                <label class="form-check-label" for="status_disable">
                                                  {{  __('common.inactive')}}
                                                </label>
                                            </div>
                                        </div>
                                        {!! $errors->first('status', '<p class="help-block text-danger">:message</p>') !!}
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
                                      {{  __('common.submit')}}
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                      {{  __('common.clear')}}
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

    <script src="{{ asset('image-uploader/src/image-uploader.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#country_id").change(function() {
                $(this).parsley().validate();
            });

            //added parsley custom validation for images
            window.Parsley.addValidator('fileextension', function(value, requirement) {
                    var fileExtension = value.split('.').pop();
                    var arr = requirement.split(',');

                    if ((arr.indexOf(fileExtension)) < 0) {
                        return false;
                    }
                }, 32)
                .addMessage('en', 'fileextension', 'The extension doesn\'t match the required');
            //parsley validate the form
            $('#addMarketing').parsley();

            $('#send_form').click(function() {
                $('#img_err').css('display', 'none').html('');
            });

            $('form').on('reset', function() {
                let form = $(this);
                setTimeout(function() {
                    form.find('input:file').trigger('change');
                }, 100);
            });
        });

        $('.input-images-1').imageUploader();
    </script>
@endsection
