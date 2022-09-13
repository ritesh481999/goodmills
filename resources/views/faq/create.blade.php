@extends('layouts.master')
@section('title', 'FAQ - Add New')

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
													Add FAQ Details
												</h3>
											</div>
											  <div class="back-url-div">
                                                 <a href="{{ URL::previous() }}" class="btn btn-brand btn-elevate btn-icon-sm back-url">
												 {{ __('common.back_button') }}
						                          </a>
						                        </div>
										</div>

										<!--begin::Form-->
										
											 {!! Form::open(array('class' => 'kt-form','method'=>'POST','enctype' => 'multipart/form-data','id'=>'addfaq','url' => route('faq.store'))) !!}
											 @csrf
											<div class="kt-portlet__body">
												<div class="kt-section kt-section--first">
													<div class="form-group">
														<!-- <label>Faq:</label>
														
														<textarea  class="form-control"  name="faq" rows="3" required=""	placeholder="Enter FAQ" ></textarea> -->
														<!-- <span class="form-text text-muted">Please enter your full name</span> -->
													 {!! Html::decode(Form::label('faq','FAQ <span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
				                                        <div class="col-md-6">
				                                            {!! Form::textarea('faq', null, ['class' => 'form-control','placeholder' => "Enter FAQ",
				                                            'data-parsley-required' => 'true',
				                                            'data-parsley-required-message' => 'FAQ is required',
				                                            ]) !!}
				                                            {!! $errors->first('faq', '<p class="help-block text-danger">:message</p>') !!}
				                                        </div>


													</div>
													<div class="form-group">
														<!-- <label>Description:</label>
														<textarea  class="form-control"  name="description" rows="3" required="" placeholder="Enter Description"	></textarea> -->
														<!-- <span class="form-text text-muted">We'll never share your email with anyone else</span> -->
														 {!! Html::decode(Form::label('description','Description <span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
				                                        <div class="col-md-6">
				                                            {!! Form::textarea('description', null, ['class' => 'form-control','placeholder' => "Enter description",
				                                            'data-parsley-required' => 'true',
				                                            'data-parsley-required-message' => 'Description is required',
				                                            ]) !!}
				                                            {!! $errors->first('description', '<p class="help-block text-danger">:message</p>') !!}
				                                        </div>




													</div>
													
													<div class="form-group">
													<label class="col-md-4 control-label">Status <span class="mandatory">*</span></label>
													<div class="col-md-6">
                                       
			                                        <div class="custom-control custom-radio custom-control">
			                                            <input type="radio" id="active-status" name="status" class="custom-control-input" value="1" checked>
			                                            <label class="custom-control-label" for="active-status">Active</label>
			                                        </div>
			                                        <div class="custom-control custom-radio custom-control">
			                                            <input type="radio" id="inactive-status" name="status" class="custom-control-input" value="0">
			                                            <label class="custom-control-label" for="inactive-status">Inactive</label>
			                                        </div>
			                                    </div>



				                            {!! $errors->first('status', '<p class="help-block text-danger">:message</p>') !!}

                                        <!-- </div> -->
													</div>
												</div>
											</div>
											<div class="kt-portlet__foot">
												<div class="kt-form__actions">
													<button type="submit" class="btn btn-primary">Submit</button>
													<button type="reset" class="btn btn-secondary">Clear</button>
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
            $('#addfaq').parsley();
            
        });
    </script>

@endsection