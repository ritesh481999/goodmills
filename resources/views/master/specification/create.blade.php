@extends('layouts.master')
@section('title', __('common.masters.specification.specification_add_title'))

@section('content')

        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{__('common.masters.specification.add_specification_details')}}
                            </h3>
                        </div>
                        <div class="back-url-div">
                            <a href="{{ route('specification.index') }}" class="btn btn-brand btn-elevate btn-icon-sm back-url">
                               {{__('common.back_button')}}
                            </a>
                        </div>
                    </div>

                    <!--begin::Form-->
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="add-form" action="{{ route('specification.store') }}">
                        <div class="kt-portlet__body">
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title" class="control-label">{{__('common.masters.label.specification')}} <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" name="name" id="title" placeholder="{{__('common.masters.specification.specification_placeholder')}}" 
                                            data-parsley-maxlength="100"
                                            data-parsley-maxlength-message="{{__('common.masters.specification.specification_max_length')}}"
                                            data-parsley-required='true'
                                            data-parsley-required-message='{{__('common.masters.specification.specification_required')}}'
                                            data-parsley-pattern='{{ config('common.safe_string_pattern') }}'
                                            data-parsley-pattern-message="{{__('common.masters.specification.specification_pattern')}}"
                                            data-parsley-trigger='blur'
                                        value="{{ old('name') }}"
                                        />
                                        {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="commodity_id" class="control-label">{{__('common.masters.label.commodity')}} <span class="mandatory">*</span></label>
                                        
                                        <select name="commodity_id" id="commodity_id" class="form-control"
                                            data-parsley-required='true'
                                            data-parsley-required-message='{{__('common.masters.specification.commodity_required')}}'
                                            data-parsley-trigger="blur"
                                        >
                                            <option value="" disabled selected>{{__('common.masters.specification.select_commodity')}}</option>
                                            @foreach ($commodities as $commodity)
                                            <option value="{{ $commodity->id }}">{{ $commodity->name }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('commodity_id', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label">{{__('common.status')}} <span class="mandatory">*</span></label>
                                        <div class="custom-control custom-radio custom-control">
                                            <input type="radio" id="active-status" name="status" class="custom-control-input" value="1" checked>
                                            <label class="custom-control-label" for="active-status">{{__('common.active')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control">
                                            <input type="radio" id="inactive-status" name="status" class="custom-control-input" value="0">
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
                                        <button type="submit" id="send_form" class="btn btn-brand">{{__('common.submit')}}</button>
                                        <button type="reset" class="btn btn-secondary">{{__('common.clear')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @csrf
                    </form>

                    
                </div>

                <!--end::Portlet-->
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
