@extends('layouts.master')
@section('title', 'Podcast - Add New')

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
                                Add Podcast Details
                            </h3>
                            
                        </div>
                        <div class="back-url-div">
                          <a href="{{ route('podcast.index') }}" class="btn btn-brand btn-elevate btn-icon-sm back-url">
                              Back
                          </a>
                        </div>
                        
                    </div>

                    <!--begin::Form-->
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="add-podcast" action="{{ route('podcast.store') }}">
                        <div class="kt-portlet__body">
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title" class="control-label">Title <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter your podcast title here..." 
                                            data-parsley-maxlength="100"
                                            data-parsley-maxlength-message="Podcast title must have less than 100 characters"
                                            data-parsley-required='true'
                                            data-parsley-required-message='Please enter podcast title'
                                            data-parsley-trigger='blur'
                                            data-parsley-pattern='{{ config('common.safe_string_pattern') }}'
                                            data-parsley-pattern-message="Please enter a valid podcast title"
                                            
                                        value="{{ old('title') }}"
                                        />
                                        {!! $errors->first('title', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="short_description" class="control-label">Short description <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" name="short_description" id="short_description" placeholder="Enter your podcast short description here..." 
                                            data-parsley-required='true'
                                            data-parsley-pattern-message='Please enter valid podcast short description'
                                            data-parsley-trigger='blur'

                                        value="{{ old('short_description') }}"
                                        />
                                        {!! $errors->first('short_description', '<p class="help-block text-danger">:message</p>') !!}
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="description" class="control-label">Description <span class="mandatory">*</span></label>
                                        <textarea data-parsley-required='true' data-parsley-required-message='Please enter podcast description'
                                        data-parsley-trigger='blur' class="form-control" name="description" id="description" cols="30" rows="10" placeholder="Enter your podcast description here..."
                                            data-parsley-trigger='blur'
                                        >{{ old('description') }}</textarea>
                                        
                                        {!! $errors->first('description', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Podcast Album cover 
                                            <small><b>(Image must be less than 20MB)</b></small>&nbsp;
                                            <span class="mandatory">*</span>
                                        </label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image" id="image" accept="image/*"
                                                data-parsley-required='true'
                                                data-parsley-required-message='Please select podcast album image'
                                                data-parsley-trigger="change"
                                                data-parsley-fileaccept=".jpeg,.jpg,.png"
                                            />
                                            <label class="custom-file-label" for="image">Choose image file</label>
                                        </div>
                                        <img style="display: none;max-height: 300px;max-width:300px; padding-top: 1%;"  class="rounded" id="preview-podcast-image" alt="Podcast album cover">
                                        {!! $errors->first('image', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Podcast Audio
                                            <small><b>(Only accepts mp3, m4a, wav, wma, amr, aa, aax and file must less than 100MB)</b></small>&nbsp;
                                            <span class="mandatory">*</span>
                                        </label>

                                        <div class="">
                                            <audio id="podcast-audio">
                                                <source>
                                                Your browser does not support the audio element.
                                            </audio>
                                            <a href="/" title="Play" id="play-audio" data-played="0" style="display: none;">
                                                <img style="height: 100px;width: 100px;" src="{{ asset('assets/media/icons/svg/Media/Volume-full.svg') }}" class="rounded" alt="Podcast album speaker">
                                            </a>
                                        </div>

                                        <div class="custom-file">
                                            <?php
                                                $tmp = implode(',', array_map(function($ext){ return '.'.$ext; },config('common.podcast_audio_mimetypes')));
                                            ?>
                                            <input accept="{{ $tmp }}" type="file" class="custom-file-input" name="audio" id="audio" 
                                                data-parsley-required='true'
                                                data-parsley-trigger="change"
                                                data-parsley-fileaccept='{{ $tmp }}'
                                                data-parsley-required-message='Please select podcast audio'
                                            />
                                            <label class="custom-file-label" for="audio">Choose audio file</label>
                                        </div>
                                        <p style="display: none;" class="help-block text-danger" id='audio-not-support'>Your browser does not support audio file</p>
                                        {!! $errors->first('audio', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="duration" class="control-label">Podcast audio duration 
                                            <small><b>(Minutes:Seconds)</b></small>&nbsp;
                                            <span class="mandatory">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="duration" id="duration" placeholder="Enter podcast duration here..." 
                                            data-parsley-required='true'
                                            data-parsley-trigger='blur'
                                            data-parsley-pattern="[0-9]+(\:[0-5][0-9])$",
                                            data-parsley-pattern-message="Duration format is invalid"
                                            value="{{ old('duration') ?? '00:00' }}"
                                        />
                                        {!! $errors->first('duration', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Status <span class="mandatory">*</span></label>
                                        <div class="custom-control custom-radio custom-control">
                                            <input type="radio" id="active-status" name="status" class="custom-control-input" value="1" checked>
                                            <label class="custom-control-label" for="active-status">Active</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control">
                                            <input type="radio" id="inactive-status" name="status" class="custom-control-input" value="0">
                                            <label class="custom-control-label" for="inactive-status">Inactive</label>
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
                                        <button type="submit" id="send_form" class="btn btn-brand">Submit</button>
                                        <button type="reset" class="btn btn-secondary">Clear</button>
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
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var isSubmitClicked = false;
            window.parsley.addValidator('fileaccept', function(value, requirement){
                const requirements = requirement.split(',');
                const guessExt = value.substr(value.lastIndexOf('.')).toLowerCase();
                const res = requirements.indexOf(guessExt) > -1;
                return res;
            })
            .addMessage('en', 'fileaccept', 'The file extension doesn\'t match the required');

            const audioEl = document.getElementById('podcast-audio');
            
            $('#add-podcast').on('submit', function(){
                isSubmitClicked = true;
                setTimeout(function(){
                    isSubmitClicked = false;
                }, 1000)
            });
            $('#add-podcast').parsley();

            function playableAudio(type)
            {
                const res = audioEl.canPlayType(type);
                const supportedEl = $('#play-audio');
                const notSupportEl = $('#audio-not-support');
                if(res == 'maybe' || res == 'probably')
                {
                    supportedEl.show();
                    notSupportEl.hide();
                    return true;
                }
                supportedEl.hide();
                notSupportEl.show();
                return false;
            }
            //parsley validate the form
            
            $('#image').parsley().on('field:success', function(){
                if(isSubmitClicked)
                    return false;
                const el = this.$element[0];
                const previewHtml = $('#preview-podcast-image');
                if (el.files && el.files[0]) 
                {
                    var reader = new FileReader();
                    reader.onload = function (e){
                        previewHtml.attr('src', e.target.result).show();
                    }
                    reader.readAsDataURL(el.files[0]);
                }else
                    previewHtml.hide();
            });
            $('#image').parsley().on('field:success', function(){
                $('#preview-podcast-image').hide();
            });

            

            $('#audio').parsley().on('field:success', function(){
                if(isSubmitClicked)
                    return false;
                const el = this.$element[0];
                if (el.files && el.files[0]) 
                {
                    const file = el.files[0];
                    const isPlayable = playableAudio(file.type);
                    var reader = new FileReader();
                    reader.onload = function (e){
                        const sourceEl = audioEl.getElementsByTagName('source')[0];
                        sourceEl.src = e.target.result;
                        sourceEl.type = file.type;
                        audioEl.load();

                        if(isPlayable){
                            audioEl.onloadstart = function()
                            {
                                console.log('loading started...');
                            }

                            audioEl.oncanplaythrough = function()
                            {
                                console.log('can play through...');
                                console.log(audioEl.duration);
                                if(isNaN(audioEl.duration) || !isFinite(audioEl.duration))
                                {
                                    alert('Could not determine the audio duration. Please enter the same.');
                                    $('#duration').val('').trigger('input').focus();
                                }else{
                                    let comDur = ['00', '00'];
                                    let a = audioEl.duration/60;
                                    comDur[0] = Math.floor(a) < 10 ? ('0'+Math.floor(a)) : Math.floor(a);
                                    comDur[1] = Math.ceil((a - Math.floor(a)) * 60);
                                    comDur[1] = comDur[1] < 10 ? ('0' + comDur[1]) : comDur[1];
                                    $('#duration').val(comDur.join(':')).trigger('input');
                                    console.log('dura', comDur.join(':'))
                                }
                            }
                        }else{
                            audioEl.onloadstart = audioEl.oncanplaythrough = function(){};
                            alert('Could not determine the audio duration. Please enter the same.');
                            $('#duration').val('').trigger('input').focus();
                        }
                    }
                    reader.readAsDataURL(file);
                }
            });

            $('#audio').parsley().on('field:error', function(){
                $('#play-audio, #audio-not-support').hide();  
            });

        

            $('.custom-file-input').on('change',function(){
                let fileName = this.files.length > 0 ? this.files[0].name : 'Choose file';
                let formGrp = $(this.closest('.form-group'));
                formGrp.find('.custom-file-label').html(fileName);
            });

            $('form').on('reset', function(){
                let form = $(this);
                form.parsley().reset();
                form.find('.help-block.text-danger').html('');
                setTimeout(function(){ 
                    form.find('input:file').trigger('change');
                    form.find('input:text, textarea').val('');
                    $('#play-audio, #audio-not-support, #preview-podcast-image').hide();
                },100);
            });

            $('#play-audio').on('click', function(e){
                e.stopPropagation();
                e.preventDefault();
                
                if(!audioEl.paused){
                    audioEl.pause();
                }else{
                    audioEl.play();
                }
                return false;
            });
        });
    </script>

@endsection
