@extends('layouts.master')
@section('title', __('common.static_contents.pages.faqs'))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                        {{__('common.static_contents.pages.faqs')}}
                        </h3>
                    </div>
                    <div class="back-url-div">
                        <a href="{{ URL::previous() }}" class="btn btn-brand btn-elevate btn-icon-sm back-url">
                        {{__('common.back_button')}}
                        </a>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form" id='editFaqs' action="{{route('static_content.faqs.store')}}" 
                method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-md-12">
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <input type="hidden"  name="faqs_ids" id="faqs_ids" value=""/>
                                <div class="col-md-12 wrapper_div">
                                    @if ($contents->count() > 0)
                                    @foreach ($contents as $key => $item)
                                    <div class="row append_row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                {!! Html::decode(Form::label('Question','Question 
                                                    <span class="text-danger">*</span>')) !!}
                                                {!! Form::textarea('question[]', $item->question, 
                                                    ['class' => 'form-control ', 
                                                    'placeholder' =>'Enter question here...', 
                                                    'data-parsley-required' => 'true', 'data-parsley-required-message' => 'Please enter question', 'id' => 'question',
                                                 'rows' => '4']) !!}
                                                {!! $errors->first('question', '<p class="help-block text-danger">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                {!! Html::decode(Form::label('Answer','Answer <span class="text-danger">*</span>')) !!}
                                                {!! Form::textarea('answer[]',$item->answer, ['class' => 'form-control ', 'placeholder' => 'Enter answer Here...', 'data-parsley-required' => 'true', 'data-parsley-required-message' => 'Please enter answer', 'id' => 'answer', 'rows' => '4']) !!}
                                                {!! $errors->first('answer', '<p class="help-block text-danger">:message</p>') !!}
                                            </div>
                                        </div>
                                        @if($key == 0)
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-success add_button" data-faqs-id ="{{$item->id}}" style=" width:100px ;margin-top:26px" title="Add field"><i
                                                    class="fas fa-plus"></i> {{__('common.static_contents.faqs.add')}}</button>
                                        </div>     
                                        @else
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger remove_button" data-faqs-id ="{{$item->id}}" style="background-color: #e92f2f !important ; width:100px;margin-top:26px"><i class="fas fa-times"></i>{{__('common.static_contents.faqs.remove')}}</button>
                                        </div>
                                        @endif
                                       
                                    </div>
                                    @endforeach
                                        
                                    @else
                                    <div class="row append_row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('Question',__('common.static_contents.faqs.question').' <span class="text-danger">
                                                *</span>')) !!}
                                            {!! Form::textarea('question[]', null, ['class' => 'form-control ', 
                                                'placeholder' =>__('common.static_contents.faqs.placeholder_question'), 'data-parsley-required' => 
                                                'true', 'data-parsley-required-message' => 'Please enter question',
                                                 'id' => 'question', 'rows' => '4']) !!}
                                            {!! $errors->first('question', '<p class="help-block text-danger">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('Answer',__('common.static_contents.faqs.answer').' <span class="text-danger">*
                                            </span>')) !!}
                                            {!! Form::textarea('answer[]', null, ['class' => 'form-control ', 
                                                'placeholder' => __('common.static_contents.faqs.placeholder_answser'), 'data-parsley-required' => 
                                                'true', 'data-parsley-required-message' => 'Please enter answer', 'id' =>
                                                 'answer', 'rows' => '4']) !!}
                                            {!! $errors->first('answer', '<p class="help-block text-danger">:message</p>')
                                                 !!}
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-success add_button"  style=" width:100px ;margin-top:26px" title="Add field"><i
                                                class="fas fa-plus"></i>{{__('common.static_contents.faqs.add')}}</button>
                                    </div>     
                                   
                                </div>
                                    @endif
                                    
                                </div>
                                <div class="col-10">
                                    <button type="submit" id="send_form" class="btn btn-brand">   {{__('common.submit')}}</button>
                                    <button type="reset" class="btn btn-secondary">   {{__('common.clear')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
            </div>

            <!--end::Portlet-->
        </div>
    </div>
@endsection
@section('script')
    {{-- <script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script> --}}
    <script>
        $(document).ready(function() {


           // Total 5 product fields we add
           let ids = {!! json_encode($contents) !!}
                .map(row => parseInt(row.id));  
            $('#faqs_ids').val(ids);
            var addButton = $('button.add_button'); // Add more button selector

            var wrapper = $('.wrapper_div'); // Input fields wrapper

            var fieldHTML = `<div class="row append_row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                {!! Html::decode(Form::label('Question',__('common.static_contents.faqs.question').' <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                                                {!! Form::textarea('question[]', null, ['class' => 'form-control ', 'placeholder' =>__('common.static_contents.faqs.placeholder_question'), 'data-parsley-required' => 'true', 'data-parsley-required-message' => 'Please enter question', 'id' => 'question', 'rows' => '4']) !!}
                                                {!! $errors->first('question', '<p class="help-block text-danger">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                {!! Html::decode(Form::label('Answer',__('common.static_contents.faqs.answer').' <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                                                {!! Form::textarea('answer[]', null, ['class' => 'form-control ', 'placeholder' =>  __('common.static_contents.faqs.placeholder_answser'), 'data-parsley-required' => 'true', 'data-parsley-required-message' => 'Please enter answer', 'id' => 'answer', 'rows' => '4']) !!}
                                                {!! $errors->first('answer', '<p class="help-block text-danger">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger remove_button" style="background-color: 
                                            #e92f2f !important ; width:100px;margin-top:26px"><i class="fas fa-times"></i>{{__('common.static_contents.faqs.remove')}}</button>
                                        </div>
                                    </div>`; //New input field html 

            var x = 1; //Initial field counter is 1

            $(addButton).click(function() {
                //Check maximum number of input fields
             
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML);
               
            });

            //Once remove button is clicked
            $(wrapper).on('click', 'button.remove_button', function(e) {
                e.preventDefault();
                const data = this.dataset;
                
                const f = {
                    id: parseInt(data.faqsId),
                };
                $(this).parent().closest(".append_row").remove();
                x--; //Decrement field counter
                ids = ids.filter(id => id != f.id);
                console.log(ids);
                $('#faqs_ids').val(ids.join(',')).trigger('change');
            });
        });
    </script>
@endsection
