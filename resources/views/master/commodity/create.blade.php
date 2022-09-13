@extends('layouts.master')
@section('title',__('common.masters.commodity.commodity_add_title'))

@section('content')

    
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{__('common.masters.commodity.add_commodity_details')}}
                            </h3>
                        </div>
                        <div class="back-url-div">
                          <a href="{{ route('commodity.index') }}" class="btn btn-brand btn-elevate btn-icon-sm back-url">
                              {{__('common.back_button')}}
                          </a>
                        </div>
                    </div>

                    <!--begin::Form-->
                    {!! Form::open(array('route' => 'commodity.store','class' => 'form-horizontal','method'=>'POST','enctype' => 'multipart/form-data','id'=>'addCommodity')) !!}
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-md-12">
                                     <div class="form-group">
                                        {!! Html::decode(Form::label('name',__('common.masters.commodity.commodity_name').'<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
                                        <div class="col-md-6">
                                            {!! Form::text('name', null, ['class' => 'form-control','placeholder' => __('common.masters.commodity.placeholder'),
                                            'data-parsley-required' => 'true',
                                            'data-parsley-required-message' =>  __('common.masters.commodity.required'),
                                            'data-parsley-pattern'=> config('common.masters.commodity.safe_string_pattern'),
                                            'data-parsley-pattern-message' =>  __('common.masters.commodity.pattern'),
                                            'data-parsley-trigger' => "input",
                                            'data-parsley-trigger'=>"blur"]) !!}
                                            {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                                        </div>
                                    </div>
                                    
                                    <div class="form-group custom-group">
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
                    {!! Form::close(); !!}
                </div>

                <!--end::Portlet-->
            </div>
        </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            //parsley validate the form
            //$('#addCommodity').parsley();
            
        });
    </script>

@endsection
