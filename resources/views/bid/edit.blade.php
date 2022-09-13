@extends('layouts.master')
@section('title',  __('common.bid.update_bid'))

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
													{{__('common.bid.update_bid_details')}}
												</h3>
											</div>
											  <div class="back-url-div">
                                                 <a href="{{ URL::previous() }}" class="btn btn-brand btn-elevate 
												 btn-icon-sm back-url">
												 {{ __('common.back_button') }}
						                          </a>
						                        </div>
										</div>

										<!--begin::Form-->
										
											 {!! Form::model($bid,array('class' => 'kt-form','method'=>'put',
												'enctype' => 'multipart/form-data','id'=>'editbid','route' 
												=>['bid.update',$bid->id])) !!}
											 @csrf
											<div class="kt-portlet__body">
												<div class="kt-section kt-section--first">
													<div class="form-group">
														
														 {!! Html::decode(Form::label('bid_name',' <span class
															="text-danger">*</span>', ['class' => 'col-md-4
															 control-label'])) !!}
				                                        <div class="col-md-6">
				                                            {!! Form::text('bid_name', null, ['class' => 
																'form-control','placeholder' => "Enter Bid name",
				                                            'data-parsley-required' => 'true',
				                                            'data-parsley-required-message' => 'Bid name is required',
				                                            'data-parsley-maxlength'=>'50',
				                                            'data-parsley-maxlength-message'=>'Variety Name must have less than 50 characters',
				                                            'data-parsley-trigger' => "blur",
															'data-parsley-pattern-message' => 'Please enter valid bid name'
				                                            ]) !!}
				                                            {!! $errors->first('bid_name', '<p class="help-block text-danger"
																>:message</p>') !!}
				                                        </div>
													</div>
													<div class="form-group">
														
														 {!! Html::decode(Form::label('bid_date','Bid Date <span class="text-danger">*
															 
														 </span>', ['class' => 'col-md-4 control-label'])) !!}
				                                        <div class="col-md-6">
				                                            <!-- {!! Form::text('bid_name', null, ['class' => 'form-control','placeholder' => "Enter Bid name",
				                                            'data-parsley-required' => 'true',
				                                            'data-parsley-required-message' => 'Bid name is required',
				                                            'data-parsley-maxlength'=>'50',
				                                            'data-parsley-maxlength-message'=>'Variety Name must have less than 50 characters',
				                                            'data-parsley-trigger' => "input",
				                                            'data-parsley-trigger'=>"blur",
				                                            ]) !!} -->
				                                            <input type="text" 
				                                            name="bid_date" 
				                                            
				                                            id="bid_date" 
				                                            class="form-control" 
				                                            placeholder="Bid Date" readonly value="{{$bid->bid_date}}" />
				                                            {!! $errors->first('bid_date', '<p class="help-block text-danger">:message</p>') !!}
				                                        </div>
													</div>

													<div class="form-group">
														
													 {!! Html::decode(Form::label('commodity_id','Commodity <span class="text-danger">*</span>',
														 ['class' => 'col-md-4 control-label'])) !!}
				                                        <div class="col-md-6">
				                                            {!! Form::select('commodity_id',$commodity,null,['class'=>'form-control',
																'placeholder'=>'Select Commodity',
				                                            'onchange'=>'get_data(this)',
				                                            'data-parsley-required' => 'true',
				                                            'data-parsley-required-message' => 'Please Select Commodity',
				                                            ]) !!}
				                                            {!! $errors->first('commodity_id', '<p class="help-block text-danger">:message</p>') 
																!!}
				                                        </div>


													</div>
													<div class="form-group">
														
													 {!! Html::decode(Form::label('variety_id','Variety <span class="text-danger">*</span>', 
														['class' => 'col-md-4 control-label'])) !!}
				                                        <div class="col-md-6">
				                                            {!! Form::select('variety_id',$variety,$bid->variety_id,['class'=>'form-control 
																variety',
				                                            'data-parsley-required' => 'true',
				                                            'data-parsley-required-message' => 'Please Select Variety',
				                                            ]) !!}
				                                            {!! $errors->first('variety_id', '<p class="help-block text-danger">:message</p>') !!}
				                                        </div>


													</div>
													<div class="form-group hidden">
														
													 {!! Html::decode(Form::label('specification_id','Specification <span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
				                                        <div class="col-md-6">
				                                            {!! Form::select('specification_id',$specification,$bid->specification_id,['class'=>'form-control specification',
				                                            'data-parsley-required' => 'true',
				                                            'data-parsley-required-message' => 'Please Select Specification',
				                                            ]) !!}
				                                            {!! $errors->first('specification_id', '<p class="help-block text-danger">:message</p>') !!}
				                                        </div>


													</div>
													<div class="form-group">
														
													 {!! Html::decode(Form::label('max_tonnage','Max Tonnage <span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
				                                        <div class="col-md-6">
				                                            {!! Form::select('max_tonnage',$tonnage,null,['class'=>'form-control'
																,'placeholder'=>'Select Max Tonnage',
				                                            'data-parsley-required' => 'true',
				                                            'data-parsley-required-message' => 'Please Select Max Tonnage',
				                                            ]) !!}
				                                            {!! $errors->first('max_tonnage', '<p class="help-block text-danger">:
																message</p>') !!}
				                                        </div>


													</div>
													<div class="form-group">
														
														 {!! Html::decode(Form::label('price','Price <span class="text-danger">*</span>',
															 ['class' => 'col-md-4 control-label'])) !!}
				                                        <div class="col-md-6">
				                                            {!! Form::text('price', null, ['class' => 'form-control','placeholder' =>
																 "Enter Price",
				                                            'data-parsley-required' => 'true',
				                                            'data-parsley-required-message' => 'Price is required',
				                                            'data-parsley-type'=>"number",
				                                            'data-parsley-pattern'=>"/^\d+(\.\d{1,2})?$/",

				                                            'data-parsley-trigger' => "input",
				                                            'data-parsley-trigger'=>"blur",
				                                            ]) !!}
				                                            {!! $errors->first('price', '<p class="help-block text-danger">:message</p>') !!}
				                                        </div>

													</div>
											
											<div class="form-group">
														
														 {!! Html::decode(Form::label('validity','Bid Validity <span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
				                                        <div class="col-md-6">
				                                            <!-- {!! Form::text('bid_name', null, ['class' => 'form-control','placeholder' => "Enter Bid name",
				                                            'data-parsley-required' => 'true',
				                                            'data-parsley-required-message' => 'Bid name is required',
				                                            'data-parsley-maxlength'=>'50',
				                                            'data-parsley-maxlength-message'=>'Variety Name must have less than 50 characters',
				                                            'data-parsley-trigger' => "input",
				                                            'data-parsley-trigger'=>"blur",
				                                            ]) !!} -->
				                                            <input type="text" class="form-control" id="validity" name="validity" readonly="" 
															placeholder="Select date &amp; time"
				                                            data-parsley-required = 'true'
				                                            data-parsley-required-message = 'Validity is required' value="{{ $bid->validity}}" 
				                                            >
				                                            {!! $errors->first('validity', '<p class="help-block text-danger">:message</p>') !!}
				                                        </div>
													</div>
													<div class="form-group">
														
														 {!! Html::decode(Form::label('bid_loaction_id','Select Bid Location <span
															 class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
				                                        <div class="col-md-6">
				                                           <select class="form-control" id="bid_location_id" name="bid_location_id[]"
														    multiple="multiple" 
				                                           data-parsley-required = 'true'
				                                            data-parsley-required-message = 'Bid Location is required' 
		

				                                            >

																@foreach($bidLocation as $key => $value)
																<option value="{{$key}}"
																@if(in_array($key,$bid->bid_location_id))
																selected
																@endif
																>{{$value }}</option>
																@endforeach
												            </select>
												            {!! $errors->first('bid_location_id', '<p class="help-block text-danger">:message</p>') !!}
				                                        </div>
													</div>
													<div class="form-group">
														
														 {!! Html::decode(Form::label('select_user','Users <span class="text-danger">*</span>', 
															['class' => 'col-md-2 control-label'])) !!}
				                                        <!-- <div class="col-md-6"> -->
				                                           <button type="button" class="btn btn-primary select_user" name="select_user"
														    id="select_user" onclick="get_user()">Add User</button>
				                                           {!! $errors->first('user_ids', '<p class="help-block text-danger">:message</p>') !!}

				                                        <!-- </div> -->
													</div>
													<input type="hidden" name="user_ids" id="user_ids" value="{{$bid->user_ids}}"

													>

													<!-- ******************** user div********************** -->
													<div class="user_table">
														<table class="table table-striped- table-bordered table-hover table-checkable data-table" id="user_table">
													                    <thead>
													                    <tr>
													                        <th>{{__('common.table.id')}}</th>
													                        <th>{{__('common.table.name')}}</th>
													                        <th>{{__('common.table.action')}}</th>
													                     
													                    </tr>
													                    </thead>
													                    <tbody>
													                        
													                    </tbody>
													                </table>
													</div>
													<!-- **************************user div end*************************** -->



													<div class="form-group">
													<label class="col-md-4 control-label">Status <span class="mandatory">*</span></label>
													<div class="col-md-6">
                                       
			                                        <div class="custom-control custom-radio custom-control">
			                                            <input type="radio" id="active-status" name="status" class="custom-control-input" 
														value="1" {{ $bid->status ? 'checked' : '' }}>
			                                            <label class="custom-control-label" for="active-status">{{__('common.active')}}</label>
			                                        </div>
			                                        <div class="custom-control custom-radio custom-control">
			                                            <input type="radio" id="inactive-status" name="status" class="custom-control-input" 
														value="0" {{ $bid->status ? '' : 'checked' }}>
			                                            <label class="custom-control-label" for="inactive-status"></label>
			                                        </div>
			                                    </div>



				                            {!! $errors->first('status', '<p class="help-block text-danger">:message</p>') !!}

                                        <!-- </div> -->
													</div>
												</div>
											</div>
											<div class="kt-portlet__foot">
												<div class="kt-form__actions">
													<button type="submit" class="btn btn-primary">{{__('common.update')}}</button>
													<a href="{{ route('bid.index') }}" class="btn btn-secondary">{{__('common.cancel')}}</a>
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
    $('.user_table').hide();

    	var user_ids=[];
    	$('#editbid').parsley();
    	  // user_ids='{{json_encode($bid->user_ids_arr)}}';
    	@foreach($bid->user_ids_arr as $value)
    	    user_ids.push({{$value}});

    	@endforeach
    	console.log(user_ids);
    	check_checkboxes(user_ids);





    	function get_data(ele)
            {
            	var route = '{{ route("getData", ":id") }}';
            	if($(ele).val()!='')
            	{  $('.variety').empty();
                   $('.specification').empty();
                   var id = $(ele).val();
    				var url = route.replace(':id',id);
            		 $.ajax({
					            type: "get",
					            url: '/bid/get_data/'+$(ele).val(),
					            dataType: 'json',
					            success: function( result ) {
					            	console.log(result);
					            	console.log(result['variety']);
					                for ( const [key,value] of Object.entries( result['variety'] ) ) {
                                          $('.variety').append('<option value='+ key+'>'+value+'</option>');
                                        }
                                        for ( const [key,value] of Object.entries( result['specification'] ) ) {
                                          $('.specification').append('<option value='+ key+'>'+value+'</option>');
                                        }
					                
					            }
                          });

            	}
            }
        $(document).ready(function() {


        	var dtable = $('#user_table').DataTable({
            processing: true,
            serverSide: true,
            order: [[ 1, "desc" ]],
            ajax: {
                url:'{{ route("bid.edit",$bid->id) }}',
                
            },
            columns: [
               
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
               
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        	
            //parsley validate the form
          $('#bid_date').datepicker({
          todayBtn:'linked',
          format:'yyyy-mm-dd',
          autoclose:true,

         });
            $('#validity').datetimepicker({
            // todayHighlight: true,
            autoclose: true,
            format: 'yyyy-mm-dd hh:ii',
            startDate: "+0d"

        });
            $('#bid_location_id').select2({
            placeholder: "Select Location",
            maximumSelectionLength: 3

        });

         


        });
    
        function get_user()
            {
            	$('.user_table').toggle();
             
            }
            function on_checked(ele)
            {   
            	if($(ele). prop("checked") == true)
            	{      if(!user_ids.includes($(ele).val()))
            		{
		            	user_ids.push($(ele).val());
		            	$('#user_ids').val(user_ids);
		            	console.log($(ele).val());
		            	console.log($('#user_ids').val());
		            }
                 }
                 else
                 {
		          var result = arrayRemove(user_ids, $(ele).val());
		          user_ids=result;
		            $('#user_ids').val(user_ids);
		            console.log($(ele).val());
		            console.log($('#user_ids').val());
		           

            }
                console.log(user_ids);

                 }
                 function arrayRemove(arr, value) 
		        { 
		        	return arr.filter(function(ele)
		            	{ return ele != value; }
		            	);
		        }
		        $('#user_table').on( 'draw.dt', function () {
		        	check_checkboxes(user_ids);

				} );
				function check_checkboxes(arr)
				{
					for (var i = 0; i < arr.length; i++) {
				  	console.log(arr[i]);
				   $('#user'+arr[i]).prop('checked','checked');
				  }

				}




    </script>


@endsection