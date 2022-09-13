@extends('layouts.master')
@section('title', __('common.bid_location.update_bid_locatio'))

@section('content')

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {!! session()->get('success') !!}
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
                                {{__('common.bid_location.update_bid_location_details')}}
                            </h3>
                        </div>
                        <div class="back-url-div">
                            <a href="{{ route('bid_location.index') }}" 
                            class="btn btn-brand btn-elevate btn-icon-sm back-url">
                            {{ __('common.back_button') }}
                            </a>
                        </div>
                    </div>

                    <!--begin::Form-->
                    <form class="form-horizontal" method="POST" 
                    enctype="multipart/form-data" id="add-form" 
                    action="{{ route('bid_location.update', $item->id) }}">
                        <div class="kt-portlet__body">
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title" class="control-label">{{__('common.bid_location.bid_location_name')}}
                                            <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" name="name" id="title" 
                                        placeholder="{{__('common.bid_location.name_placeholder')}}" 
                                            data-parsley-maxlength="100"
                                            data-parsley-maxlength-message="{{__('common.bid_location.name_parsley_max_validation')}}"
                                            data-parsley-required='true'
                                            data-parsley-required-message='{{__('common.bid_location.name_parsley_validation')}}'
                                            data-parsley-trigger='blur'
                                            data-parsley-pattern='{{ config('common.safe_string_pattern') }}'
                                            data-parsley-pattern-message="{{__('common.bid_location.name_parsley_pattern_message')}}"
                                        value="{{ $item->name }}"
                                        />
                                        {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label">{{__('common.status')}} <span class="mandatory">*</span></label>
                                        <div class="custom-control custom-radio custom-control">
                                            <input type="radio" id="active-status" name="status" class="custom-control-input"
                                             value="1" {{ $item->status ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="active-status">{{__('common.active')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control">
                                            <input type="radio" id="inactive-status" name="status" class="custom-control-input" value="0" 
                                            {{ !$item->status ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="inactive-status">{{__('common.inactive')}} </label>
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
                                        <button type="submit" id="send_form" class="btn btn-brand">{{__('common.update')}}</button>
                                        <button type="reset" class="btn btn-secondary">{{__('common.clear')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @csrf
                        @method('PATCH')
                    </form>

                    
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
            $('#add-form').parsley();
        });
    </script>

@endsection