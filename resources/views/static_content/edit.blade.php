@extends('layouts.master') 
@section('title', __('common.static_contents.update_title'))


@section('content')
    <div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title"> 
                            {{ static_content_type($content_type) }}
                        </h3>
                    </div>
                    <div class="back-url-div">
                        <a href="{{ URL::previous() }}" class="btn btn-brand btn-elevate btn-icon-sm back-url">
                        {{ __('common.back_button') }}
                        </a>
                    </div>
                </div>

                <!--begin::Form-->
                <form class="kt-form" id='editContent' action="{{ $content ? route('static_contents.update',['id' => $content->id]) : route('static_contents.store') }}" method="POST" enctype="multipart/form-data">
                    @if(!empty($content)) @method('PATCH') @endif
                @csrf
                <input type="hidden" name="content_type" value="{{$content_type}}">
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-12">



                        </div>
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::textarea('contents', isset($content->contents) ? $content->contents : null , ['class' => 'form-control ckeditor', 'placeholder' => __('news.news_long_description_placeholder'), 'data-parsley-required' => 'true', 'data-parsley-required-message' => __('news.news_long_description_parsley_validation'
                                    ),'id'=>'static_contents'
                                    ]) !!}
                                    {!! $errors->first('description', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                            <div class="col-10">
                                <button type="submit" id="send_form" class="btn btn-brand">{{ __('common.submit') }}</button>
                                <a href="{{ URL::previous() }}" class="btn btn-secondary">{{ __('common.cancel') }}</a>
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
    <script type="text/javascript" src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
    {{-- <script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script> --}}
    <script>
       CKEDITOR.replace( 'static_contents', {
        height: 300,
        removePlugins:'about',
        filebrowserUploadUrl: "{{route('ckEditorupload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
        });
    </script>
@endsection
