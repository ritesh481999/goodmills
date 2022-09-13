@extends('layouts.master')
@section('title', __('common.masters.variety.variety_update_title'))

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
													{{__('common.masters.variety.update_variety_details')}}
												</h3>
											</div>
											 <div class="back-url-div">
						                          <a href="{{ URL::previous() }}" class="btn btn-brand btn-elevate btn-icon-sm back-url">
						                              {{__('common.back_button')}}
						                          </a>
						                        </div>
										</div>

										<!--begin::Form-->
										
											 {!! Form::model($variety,array('class' => 'kt-form','method'=>'put','enctype' => 'multipart/form-data','id'=>'editvariety','route' => ['variety.update',$variety->id])) !!}
											
											<div class="kt-portlet__body">
												<div class="kt-section kt-section--first">
													<div class="form-group">
														
														{!! Html::decode(Form::label('commodity_id', __('common.masters.label.commodity') . ' <span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
				                                        <div class="col-md-6">
				                                            {!! Form::select('commodity_id',$items,$variety->commodity_id,['class'=>'form-control','placeholder'=>'Select Commodity',
				                                            'data-parsley-required' => 'true',
				                                            'data-parsley-required-message' => __('common.masters.specification.commodity_required'),
				                                            ]) !!}
				                                            {!! $errors->first('commodity_id', '<p class="help-block text-danger">:message</p>') !!}
				                                        </div>
													</div>
													<div class="form-group">
														{!! Html::decode(Form::label('name',__('common.masters.variety.name').' <span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
				                                        <div class="col-md-6">
				                                            {!! Form::text('name', null, ['class' => 'form-control','placeholder' => __('common.masters.variety.placeholder'),
				                                            'data-parsley-required' => 'true',
				                                            'data-parsley-required-message' =>  __('common.masters.variety.required'),
				                                            'data-parsley-maxlength'=>'100',
				                                            'data-parsley-maxlength-message'=>__('common.masters.variety.maxlength'),
															'data-parsley-trigger' => "input",
															'data-parsley-pattern'=> config('common.safe_string_pattern'),
                                            'data-parsley-pattern-message'=>__('common.masters.variety.pattern'),
				                                            'data-parsley-trigger'=>"blur",
				                                            ]) !!}
				                                            {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
				                                        </div>

													</div>
													
													<div class="form-group">
														<label class="col-md-4 control-label">{{__('common.status')}} <span class="mandatory">*</span></label>
													     <div class="col-md-6">

				                                         <div class="custom-control custom-radio custom-control">
				                                            <input type="radio" id="active-status" name="status" class="custom-control-input" value="1" {{ $variety->status ? 'checked' : '' }}>
				                                            <label class="custom-control-label" for="active-status">{{__('common.active')}}</label>
				                                        </div>
				                                        <div class="custom-control custom-radio custom-control">
				                                            <input type="radio" id="inactive-status" name="status" class="custom-control-input" value="0" {{ $variety->status ? '' : 'checked' }}>
				                                            <label class="custom-control-label" for="inactive-status">{{__('common.inactive')}}</label>
				                                        </div>
				                                    </div>



				                            {!! $errors->first('status', '<p class="help-block text-danger">:message</p>') !!}

													</div>
												</div>
											</div>
											<div class="kt-portlet__foot">
												<div class="kt-form__actions">
													<button type="submit" class="btn btn-primary">{{__('common.update')}}</button>
													<a href="{{ route('variety.index') }}" class="btn btn-secondary">{{__('common.cancel')}}</a>
												</div>
											</div>
										 {!! Form::close()!!}
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
            $('#editvariety').parsley();
            
        });
    </script>

@endsection