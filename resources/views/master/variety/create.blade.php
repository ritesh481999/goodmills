@extends('layouts.master')
@section('title', 'Variety - Add New')

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
                                Add Variety Details
                            </h3>
                        </div>
                        <div class="back-url-div">
                            <a href="{{ URL::previous() }}" class="btn btn-brand btn-elevate btn-icon-sm back-url">
                                Back
                            </a>
                        </div>
                    </div>

                    <!--begin::Form-->

                    {!! Form::open(['class' => 'kt-form', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'addvariety', 'url' => route('variety.store')]) !!}
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="form-group">
                                <!-- <label>Faq:</label>
                  
                  <textarea  class="form-control"  name="faq" rows="3" required=""	placeholder="Enter FAQ" ></textarea> -->
                                <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                {!! Html::decode(Form::label('commodity_id', __('common.masters.label.commodity') . ' <span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
                                <div class="col-md-6">
                                    <select name="commodity_id" id="commodity_id" class="form-control"
                                        data-parsley-required='true'
                                        data-parsley-required-message='{{ __('common.masters.specification.commodity_required') }}'
                                        data-parsley-trigger="blur">
                                        <option value="" disabled selected>
                                            {{ __('common.masters.specification.select_commodity') }}</option>
                                        @foreach ($commodities as $commodity)
                                            <option value="{{ $commodity->id }}">{{ $commodity->name }}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('commodity_id', '<p class="help-block text-danger">:message</p>') !!}
                                </div>


                            </div>
                            <div class="form-group">
                                <!-- <label>Description:</label>
                  <textarea  class="form-control"  name="description" rows="3" required="" placeholder="Enter Description"	></textarea> -->
                                <!-- <span class="form-text text-muted">We'll never share your email with anyone else</span> -->
                                {!! Html::decode(Form::label('name', __('common.masters.variety.name') . ' <span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
                                <div class="col-md-6">
                                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('common.masters.variety.placeholder'), 'data-parsley-required' => 'true', 'data-parsley-required-message' => __('common.masters.variety.required'), 'data-parsley-maxlength' => '100', 'data-parsley-maxlength-message' => __('common.masters.variety.maxlength'), 'data-parsley-trigger' => 'input', 'data-parsley-pattern' => config('common.safe_string_pattern'), 'data-parsley-pattern-message' => __('common.masters.variety.pattern'), 'data-parsley-trigger' => 'blur']) !!}
                                    {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                                </div>




                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ __('common.status') }} <span
                                        class="mandatory">*</span></label>
                                <div class="col-md-6">

                                    <div class="custom-control custom-radio custom-control">
                                        <input type="radio" id="active-status" name="status" class="custom-control-input"
                                            value="1" checked>
                                        <label class="custom-control-label"
                                            for="active-status">{{ __('common.active') }}</label>
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
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            //parsley validate the form
            $('#addvariety').parsley();

        });
    </script>

@endsection
