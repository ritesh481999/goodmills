@extends('layouts.master')
@section('title', __('common.masters.country.country_add_title'))

@section('content')

    <div class="row">
        <div class="col-lg-12">

            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{ __('common.masters.country.add_country_details') }}
                        </h3>
                    </div>
                    <div class="back-url-div">
                        <a href="{{ URL::previous() }}" class="btn btn-brand btn-elevate btn-icon-sm back-url">
                            {{ __('common.back_button') }}
                        </a>
                    </div>
                </div>

                <!--begin::Form-->

                {!! Form::open(['class' => 'kt-form', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'addCountry', 'url' => route('country.store')]) !!}
                @csrf
                <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">

                        <div class="form-group">

                            {!! Html::decode(Form::label('name', __('common.masters.country.country_name') . '<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
                            <div class="col-md-6">
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('common.masters.country.country_placeholder'), 'data-parsley-required' => 'true', 'data-parsley-required-message' => __('common.masters.country.country_required'), 'data-parsley-maxlength' => '100', 'data-parsley-maxlength-message' => __('common.masters.country.country_maxlength'), 'data-parsley-trigger' => 'input', 'data-parsley-pattern' => config('common.safe_string_pattern'), 'data-parsley-pattern-message' => __('common.masters.country.country_pattern'), 'data-parsley-trigger' => 'blur']) !!}
                                {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                            </div>




                        </div>

                        <div class="form-group">

                            {!! Html::decode(Form::label('abbreviation', __('common.masters.country.abbreviation') . '<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
                            <div class="col-md-6">
                                {!! Form::text('abbreviation', null, ['class' => 'form-control', 'placeholder' => __('common.masters.country.abbreviation_placeholder'), 'data-parsley-required' => 'true', 'data-parsley-required-message' => __('common.masters.country.abbreviation_required'), 'data-parsley-maxlength' => '100', 'data-parsley-maxlength-message' => __('common.masters.country.abbreviation_maxlength'), 'data-parsley-trigger' => 'input', 'data-parsley-pattern' => config('common.safe_string_pattern'), 'data-parsley-pattern-message' => __('common.masters.country.abbreviation'), 'data-parsley-trigger' => 'blur']) !!}
                                {!! $errors->first('abbreviation', '<p class="help-block text-danger">:message</p>') !!}
                            </div>




                        </div>
                        <div class="form-group">

                            {!! Html::decode(Form::label('language', __('common.masters.country.language') . ' <span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
                            <div class="col-md-6">
                                {!! Form::text('language', null, ['class' => 'form-control', 'placeholder' => __('common.masters.country.language_placeholder'), 'data-parsley-required' => 'true', 'data-parsley-required-message' => __('common.masters.country.language_required'), 'data-parsley-maxlength' => '100', 'data-parsley-maxlength-message' => __('common.masters.country.language_maxlength'), 'data-parsley-trigger' => 'input', 'data-parsley-pattern' => config('common.safe_string_pattern'), 'data-parsley-pattern-message' => __('common.masters.country.language_pattern'), 'data-parsley-trigger' => 'blur']) !!}
                                {!! $errors->first('language', '<p class="help-block text-danger">:message</p>') !!}
                            </div>




                        </div>

                        <div class="form-group">

                            {!! Html::decode(Form::label('direction', __('common.masters.country.direction') . '<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
                            <div class="col-md-6">
                                {!! Form::select('direction', ['ltr' => 'Left to Right', 'rtl' => 'Right to Left'], null, ['class' => 'form-control', 'placeholder' => __('common.masters.country.direction_placholder'), 'data-parsley-required' => 'true', 'data-parsley-required-message' => __('common.masters.country.direction_required')]) !!}
                                {!! $errors->first('direction', '<p class="help-block text-danger">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group">

                            {!! Html::decode(Form::label('duration', __('common.masters.country.duration') . '<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
                            <div class="col-md-6">
                                {!! Form::number('duration', null, ['min' => '1', 'class' => 'form-control', 'placeholder' => __('common.masters.country.duration_placeholder'), 'data-parsley-required' => 'true', 'data-parsley-required-message' => __('common.masters.country.duration_required'), 'data-parsley-maxlength' => '100', 'data-parsley-maxlength-message' => __('common.masters.country.duration_maxlength'), 'data-parsley-trigger' => 'input', 'data-parsley-trigger' => 'blur']) !!}
                                {!! $errors->first('duration', '<p class="help-block text-danger">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group">

                            {!! Html::decode(Form::label('timezone', __('common.masters.country.timezone') . '<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
                            <div class="col-md-6">
                                {!! Form::text('time_zone', null, ['class' => 'form-control', 'placeholder' => __('common.masters.country.timezone_placeholder'), 'data-parsley-required' => 'true', 'data-parsley-required-message' => __('common.masters.country.timezone_required'), 'data-parsley-maxlength' => '100', 'data-parsley-trigger' => 'input', 'data-parsley-pattern' => config('common.safe_string_pattern'), 'data-parsley-pattern-message' => __('common.masters.country.timezone_parsley_pattern'), 'data-parsley-trigger' => 'blur']) !!}
                                {!! $errors->first('time_zone', '<p class="help-block text-danger">:message</p>') !!}
                            </div>




                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ __('common.status') }} <span
                                    class="mandatory">*</span></label>
                            <div class="col-md-6">

                                <div class="custom-control custom-radio custom-control">
                                    <input type="radio" id="active-status" name="status" class="custom-control-input"
                                        value="1" checked>
                                    <label class="custom-control-label" for="active-status">{{ __('common.active') }}
                                    </label>
                                </div>
                                <div class="custom-control custom-radio custom-control">
                                    <input type="radio" id="inactive-status" name="status" class="custom-control-input"
                                        value="0">
                                    <label class="custom-control-label"
                                        for="inactive-status">{{ __('common.inactive') }}</label>
                                </div>
                            </div>



                            {!! $errors->first('status', '<p class="help-block text-danger">:message</p>') !!}

                            <!-- </div> -->
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <button type="submit" class="btn btn-primary">{{ __('common.submit') }}</button>
                        <button type="reset" class="btn btn-secondary">{{ __('common.clear') }}</button>
                    </div>
                </div>
                {!! Form::close() !!}
                <!--end::Form-->
            </div>

            <!--end::Portlet-->



        </div>

    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            //parsley validate the form
            $('#addCountry').parsley();

        });
    </script>

@endsection
