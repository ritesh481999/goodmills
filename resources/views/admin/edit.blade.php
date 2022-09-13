@extends('layouts.master')
@section('title', __('common.admin.add_title_page')) 

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
                            {{__('common.admin.edit_form_title')}}
                            </h3>
                        </div>
                        <div class="back-url-div">
                            <a href="{{ route('admin.index') }}" class="btn btn-brand btn-elevate btn-icon-sm back-url">
                            {{__('common.back_button')}}
                            </a>
                        </div>
                    </div>

                    <!--begin::Form-->
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="add-form" action="{{ route('admin.update', $item->id) }}">
                        <div class="kt-portlet__body">
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="control-label">{{__('common.admin_form.name.label')}} <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="{{__('common.admin_form.name.placeholder')}}" 
                                            data-parsley-maxlength="100"
                                            data-parsley-maxlength-message="{{__('common.admin_form.name.maxlength')}}"
                                            data-parsley-required='true'
                                            data-parsley-required-message="{{__('common.admin_form.name.required')}}"
                                            data-parsley-pattern="{{ config('common.safe_string_pattern') }}"
                                            data-parsley-pattern-message="{{__('common.admin_form.name.pattern')}}"
                                            data-parsley-trigger='blur'
                                        value="{{ old('name') ?? $item->name }}"
                                        />
                                        {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="control-label">{{__('common.admin_form.email.label')}} <span class="mandatory">*</span></label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="{{__('common.admin_form.email.placeholder')}}" 
                                            data-parsley-maxlength="100"
                                            data-parsley-maxlength-message="{{__('common.admin_form.email.maxlength')}}"
                                            data-parsley-required='true'
                                            data-parsley-required-message="{{__('common.admin_form.email.required')}}"
                                            data-parsley-trigger='input'
                                        value="{{ old('email') ?? $item->email }}"
                                        />
                                        {!! $errors->first('email', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="control-label">{{__('common.admin_form.password.label')}} <span class="mandatory">*</span></label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="{{__('common.admin_form.password.label')}}" 
                                            data-parsley-maxlength="12"
                                            data-parsley-maxlength-message="{{__('common.admin_form.password.maxlength')}}"
                                            data-parsley-minlength="6"
                                            data-parsley-minlength-message="{{__('common.admin_form.password.minlength')}}"
                                            data-parsley-trigger='input'
                                        />
                                        {!! $errors->first('password', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>

                                    
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('role', __('common.admin_form.role.label') , ['class' => 'col-md-4 control-label'])) !!}
                                        <div class="col-md-6">
                                            <b>{{ $item->roles->name }}</b>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">{{__('common.admin_form.countries.label')}} <span class="mandatory">*</span></label>
                                        <div class="custom-file">
                                    <select class="form-control country_id" id="country_id" name="countries[]" multiple="multiple"
                                    data-parsley-trigger="change blur"
									data-parsley-required='true'
									data-parsley-required-message="{{__('common.admin_form.countries.required')}}"
                                    data-parsley-errors-container='#countries-error-message'>
                                        <option></option>
                                        @foreach (countries() as $key => $country)
                                        <option value="{{$country->id}}" {{ (in_array($country->id, $item->countries()->pluck('country_id')->toArray())) ? 'selected' : '' }}>{{$country->name}}</option>
                                        @endforeach
                                      </select>
                                      <div  id="countries-error-message">
                                      {!! $errors->first('countries', '<p class="help-block text-danger">:message</p>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">{{__('common.admin_form.status.label')}} <span class="mandatory">*</span></label>
                                        <div class="custom-control custom-radio custom-control">
                                            <input type="radio" id="active-status" name="is_active" class="update-input custom-control-input" value="1" {{ $item->is_active ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="active-status">{{__('common.active')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control">
                                            <input type="radio" id="inactive-status" name="is_active" class="custom-control-input update-input" value="0" {{ $item->is_active ? '' : 'checked' }}>
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
                                        <button type="reset" class="btn btn-secondary">{{ __('common.clear') }}</button>
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
            $('input:checkbox#is_active').on('change', function(){
                $('input:hidden[name=is_active]').val(this.checked ? '1' : '0');
            });

            $("#country_id").select2({
          placeholder: "Select Countries",
          width: '100%',
          allowClear: true, 
        });
        $("#country_id").change(function() {
            $(this).parsley().validate();
        }); 
        });
    </script>

@endsection
