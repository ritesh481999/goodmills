@extends('layouts.master')
@section('title', 'Change-Password')

@section('content')

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                {!! \Session::get('success') !!}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {!! session()->get('error') !!}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{__('common.reset_password_title')}}
                            </h3>
                        </div>
                        <div class="back-url-div">
                            <a href="{{ route('news.index') }}" class="btn btn-brand btn-elevate btn-icon-sm back-url">
                                {{__('common.back_button')}}
                            </a>
                        </div>
                    </div>

                    <!--begin::Form-->
                    {!! Form::open(['route' => 'admin.change.password.update', 'class' => 'form-horizontal', 'method' => 'POST', 'id' => 'changePassword']) !!}
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-md-6 custom-group">
                                <div class="form-group">
                                    <label for="password" class="control-label">
                                       {{__('common.reset_password.label.current_password')}}
                                        <span class="mandatory">*</span></label>
                                    <input type="password" class="form-control" name="old_password" id="old_password"
                                        placeholder="{{__('common.reset_password.current_password.placeholder')}}" data-parsley-maxlength="12"
                                        data-parsley-maxlength-message="{{__('common.reset_password.current_password.maxlength')}}"
                                        data-parsley-minlength="6"
                                        data-parsley-minlength-message="{{__('common.reset_password.current_password.minlength')}}"
                                        data-parsley-required='true'
                                        data-parsley-required-message='{{__('common.reset_password.current_password.required')}}'
                                        data-parsley-trigger='input' />
                                    {!! $errors->first('old_password', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="password" class="control-label">
                                        {{__('common.reset_password.label.new_password')}}
                                        <span class="mandatory">*</span>
                                    </label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="{{__('common.reset_password.new_password.placeholder')}}" data-parsley-maxlength="12"
                                        data-parsley-maxlength-message="{{__('common.reset_password.new_password.maxlength')}}"
                                        data-parsley-minlength="6"
                                        data-parsley-minlength-message="{{__('common.reset_password.new_password.minlength')}}"
                                        data-parsley-required='true'
                                        data-parsley-required-message='{{__('common.reset_password.new_password.required')}}'
                                        data-parsley-trigger='input' />
                                    {!! $errors->first('password', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="password" class="control-label">
                                        {{__('common.reset_password.label.confirm_password')}}
                                        <span class="mandatory">*</span>
                                    </label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="password_confirmation" placeholder="{{__('common.reset_password.confirm_password.placeholder')}}"
                                        data-parsley-maxlength="12"
                                        data-parsley-maxlength-message="{{__('common.reset_password.confirm_password.maxlength')}}"
                                        data-parsley-minlength="6"
                                        data-parsley-minlength-message="{{__('common.reset_password.confirm_password.minlength')}}"
                                        data-parsley-required='true'
                                        data-parsley-required-message='{{__('common.reset_password.confirm_password.required')}}'
                                        data-parsley-trigger='input' />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">

                                <div class="col-10">
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
            $('#changePassword').parsley();
        })
    </script>

@endsection
