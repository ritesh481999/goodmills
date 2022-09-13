@extends('layouts.master')

@section('title', __('common.news_module.update_news_title'))

@section('content')
    <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{__('common.news_module.update_news_details')}}
                            </h3>
                        </div>
                        <div class="back-url-div">
                            <a href="{{ route('news.index') }}" 
                            class="btn btn-brand btn-elevate btn-icon-sm back-url">
                            {{ __('common.back_button') }}
                            </a>
                        </div>
                    </div>

                    <!--begin::Form-->
                    {!! Form::model($news, ['route' => ['news.update', $news->id], 'class' => 
                        'form-horizontal', 'method' => 'POST', 'enctype' => 'multipart/form-data',
                         'id' => 'editNews']) !!}
                    @method('PUT')
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-md-6 custom-group">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('title', __('common.title').
                                        '<span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                                    {!! Form::text('title', null, ['class' => 'form-control', 
                                        'placeholder' => __('common.news_module.news_title_placeholder'),
                                         'data-parsley-required' => 'true', 'data-parsley-required-message' => 
                                          __('news.news_title_parsley_validation'), 'data-parsley-maxlength' => 
                                          '100', 'data-parsley-maxlength-message' => __('news_modul.news_title_parsley_
                                          max_validation'), 'data-parsley-trigger' => 'input', 'data-parsley-pattern' => 
                                          config('common.safe_string_pattern'), 'data-parsley-pattern-message' =>  
                                          __('news_module.news_title_parsley_valid_validation'), 
                                          'data-parsley-trigger' => 'blur']) !!}
                                    {!! $errors->first('title', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    {!! Html::decode(Form::label('short_description', __('common.news_module.short_description').
                                        '<span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                                    {!! Form::text('short_description', null, ['class' => 'form-control', 'placeholder' => 
                                        __('common.news_module.news_short_description_placeholder'), 'data-parsley-required' => 
                                        'true', 'data-parsley-required-message' =>__('news_module.news_short_description_parsley_validation'), 
                                        'data-parsley-maxlength' => '100', 'data-parsley-maxlength-message' =>  
                                        __('news_module.news_short_description_parsley_max_validation'), 'data-parsley-trigger' =>
                                         'input', 'data-parsley-trigger' => 'blur']) !!}
                                    {!! $errors->first('short_description', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    {!! Html::decode(Form::label('description', __('common.news_module.long_description'). '<span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                                    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('common.news_module.news_long_description_placeholder'), 'name' => 'description', 'data-parsley-required' => 'true', 'data-parsley-required-message' =>  __('news.news_long_description_parsley_validation')]) !!}
                                    {!! $errors->first('description', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="image" class="control-label">{{ __('common.image') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image" id="image"
                                            accept="image/*" data-parsley-fileextension='jpeg,jpg,png' />
                                        <label class="custom-file-label" for="image">{{ __('common.image') }}</label>

                                    </div>
                                    <br>
                                    <div class="imgPreview"></div>
                                    @if (!empty($news->image))
                                        <div id="storedImagePreview">
                                            <a target="_blank" href="{{ fileUrl($news->image) }}">
                                                <img id="storedImage" class="storedImage"
                                                    src="{{ fileUrl($news->image) }}" alt="News cover image" height="100"
                                                    width="150" />
                                            </a>
                                        </div>

                                    @endif
                                    {!! $errors->first('image', '<p class="help-block text-danger">:message</p>') !!}
                                </div>

                                <div class="form-group">

                                    <label class="control-label">{{__('common.news_module.date_and_time') }}.<span
                                            class="mandatory">*</span></label>
                                    <div class="custom-file">

                                        <input type="text" class="form-control" id="date_time" readonly=""
                                            placeholder="Select date &amp; time" data-parsley-required='true'
                                            data-parsley-trigger="blur"
                                            data-parsley-required-message="{{__('common.date_and_time') }}" name="date_time"
                                            value="{{ date('Y-m-d H:i', strtotime($news->date_time)) }}">

                                        {!! $errors->first('date_time', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label">
                                        {{__('common.news_module.type')}}
                                        <span class="mandatory">*</span>
                                    </label>
                                    <div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            {!! Form::radio('type', 1, $news->type, ['class' => 'custom-control-input', 
                                                'id'=>'for_all_users']) !!}
                                            <label class="custom-control-label" for="for_all_users">
                                                {{__('common.news_module.all_users')}}
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            {!! Form::radio('type', 2, $news->type, ['class' => 'custom-control-input',
                                                'id'=>'for_logged_in_users']) !!}
                                            <label class="custom-control-label" for="for_logged_in_users">
                                                {{__('common.news_module.logged_in_users')}}
                                            </label>
                                        </div>
                                    </div>
                                    {!! $errors->first('type', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        {{__('common.sms_notification')}}
                                        <span class="mandatory">*</span>
                                    </label>
                                    <div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            {!! Form::radio('is_sms', 1, $news->is_sms, ['class' => 'custom-control-input','id'=>'sms_enable']) !!}
                                            <label class="custom-control-label" for="sms_enable">
                                                {{__('common.yes')}}
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            {!! Form::radio('is_sms', 0, $news->is_sms, ['class' => 'custom-control-input','id'=>'sms_disable']) !!}
                                            <label class="custom-control-label" for="sms_disable">
                                                {{__('common.no')}}
                                            </label>
                                        </div>
                                    </div>
                                    {!! $errors->first('is_sms', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    <label class="control-label">  {{__('common.push_notification')}}<span
                                            class="mandatory">*</span></label>
                                    <div class="custom-control custom-radio custom-control">
                                        <input type="radio" id="is_notification_enable" name="is_notification"
                                            class="custom-control-input" value="1"
                                            {{ $news->is_notification ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_notification_enable">{{__('common.yes')}}</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control">
                                        <input type="radio" id="is_notification_disable" name="is_notification"
                                            class="custom-control-input" value="0"
                                            {{ $news->is_notification ? '' : 'checked' }}>
                                        <label class="custom-control-label" for="is_notification_disable">{{__('common.no')}}</label>
                                    </div>
                                    {!! $errors->first('is_sms', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    <label class="control-label">{{__('common.status')}} <span class="mandatory">*</span></label>
                                    <div class="custom-control custom-radio custom-control">
                                        <input type="radio" id="active-status" name="status" class="custom-control-input"
                                            value="1" {{ $news->status ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="active-status">{{__('common.active')}}</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control">
                                        <input type="radio" id="inactive-status" name="status" class="custom-control-input"
                                            value="0" {{ $news->status ? '' : 'checked' }}>
                                        <label class="custom-control-label" for="inactive-status">{{__('common.inactive')}}</label>
                                    </div>
                                    {!! $errors->first('status', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">

                                <div class="col-10">
                                    <button type="submit" id="edit_form" class="btn btn-brand">{{__('common.update')}}</button>
                                    <a href="{{ route('news.index') }}" class="btn btn-secondary">{{__('common.cancel')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

                <!--end::Portlet-->
            </div>
        </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $("#country_id").select2({
                placeholder: "Select Countries",
                width: '100%',
                allowClear: true,
            });
            $("#country_id").change(function() {
                $(this).parsley().validate();
            });
            $('#date_time').datetimepicker({
                // todayHighlight: true,
                autoclose: true,
                format: 'yyyy-mm-dd hh:ii',
                startDate: "+0d"

            });
            //added parsley custom validation for images
            window.Parsley.addValidator('fileextension', function(value, requirement) {
                    var fileExtension = value.split('.').pop();
                    var arr = requirement.split(',');
                    console.log(arr);
                    if ((arr.indexOf(fileExtension)) < 0) {
                        return false;
                    }
                }, 32)
                .addMessage('en', 'fileextension', 'The extension doesn\'t match the required');
            //parsley validate the form
            $('#editNews').parsley();

            $('.custom-file-input').on('change', function() {
                var fileName = this.files.length > 0 ? this.files[0].name : 'Choose file';
                $(this.closest('.form-group')).find('.custom-file-label').html(fileName);
            });
        });


        function readURL(input, placeToInsertImagePreview) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $($.parseHTML(
                        '<img class="slectedImage" width="40%" height="30%" style="padding-bottom: 10px;padding-right: 10px;">'
                        )).attr('src', e.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image").change(function() {
            var value = this.files[0]['name'];
            var fileExtension = value.split('.').pop();
            var extensions = ["jpeg", "jpg", "png"];
            $('div.imgPreview').empty();
            $('#storedImagePreview').hide();
            if ((extensions.indexOf(fileExtension)) >= 0) {

                readURL(this, 'div.imgPreview');
            }
        });
    </script>
@endsection
