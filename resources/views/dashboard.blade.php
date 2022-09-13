@extends('layouts.master')
@section('title', __('common.dashboard_title'))

@section('content')
    <div class="page-content">
        <div class="row widget-row">
            <div class="col-md-3 widget-div">
                <a href="{{ route('farmer.index') }}">
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                        <h4 class="widget-thumb-heading">{{ __('common.dashboard.label.farmers') }}</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-green fa fa-users"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup"
                                    data-value="7,644">{{ $farmerCount }} <span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 widget-div">
                <!-- BEGIN WIDGET THUMB -->
                <a href="{{ route('bid.index') }}">
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                        <h4 class="widget-thumb-heading">{{ __('common.dashboard.label.bids') }}</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-purple fa fa-gavel"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup"
                                    data-value="1,293">{{ $bidCount }}<span>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- END WIDGET THUMB -->
            </div>
            <div class="col-md-3 widget-div">
                <!-- BEGIN WIDGET THUMB -->
                <a href="{{ route('selling_request.index') }}">
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                        <h4 class="widget-thumb-heading">{{ __('common.dashboard.label.selling_requests') }}</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-blue fa fa-cubes"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup"
                                    data-value="1,293">{{ $sellCount }}<span>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- END WIDGET THUMB -->
            </div>

            <div class="col-md-3 widget-div">
                <!-- BEGIN WIDGET THUMB -->
                <a href="{{ route('news.index') }}">
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                        <h4 class="widget-thumb-heading">{{ __('common.dashboard.label.news') }}</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-red fa fa-newspaper"
                                style="background-color: #8778F1 !important"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup"
                                    data-value="1,293">{{ $newsCount }}<span>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- END WIDGET THUMB -->
            </div>


        </div>
        <div class="row widget-row">
            
            <div class="col-md-3 widget-div">
                <a href="{{ route('marketing.index') }}">
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                        <h4 class="widget-thumb-heading">{{ __('common.dashboard.label.marketing') }}</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-green fa fa-bullhorn"
                                style="background-color: #b9b6b6 !important"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup"
                                    data-value="7,644">{{ $marketingCount }} <span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 widget-div">
                <a href="{{ route('static_contents.edit', 'faqs') }}">
                    <div class="widget-thumb widget-bg-color-white  margin-bottom-20 bordered">
                        <h4 class="widget-thumb-heading">{{ __('common.dashboard.label.faq') }}</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-green fa fa-question"
                                style="background-color: #7DCB56 !important"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup"
                                    data-value="7,644">{{ $faqCount }} <span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @if (auth()->user()->is_super_admin)
            <div class="col-md-3 widget-div">
                <!-- BEGIN WIDGET THUMB -->
                <a href="{{ route('admin.index') }}">
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                        <h4 class="widget-thumb-heading">{{ __('common.dashboard.label.admin_users') }}</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-red fa fa-users"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup"
                                    data-value="1,293">{{ $users }}<span>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- END WIDGET THUMB -->
            </div>
            @endif

        </div>
    </div>
@endsection
@section('script')
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
    <script>
        $(document).ready(function() {
            const firebaseConfig = {
                apiKey: "AIzaSyCKpSp5gfTyN2v7t3Il2W-drUum_bFrVgs",
                authDomain: "goodmillspushnotification.firebaseapp.com",
                projectId: "goodmillspushnotification",
                storageBucket: "goodmillspushnotification.appspot.com",
                messagingSenderId: "921912243066",
                appId: "1:921912243066:web:10850b8eca3810fd9c1cc3",
                measurementId: "G-BG6P33ESC4"
            };


            firebase.initializeApp(firebaseConfig);
            const messaging = firebase.messaging();

            function initFirebaseMessagingRegistration() {
                messaging
                    .requestPermission()
                    .then(function() {
                        return messaging.getToken()
                    })
                    .then(function(token) {
                        console.log(token, 'token key');

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: '{{ route('storeToken') }}',
                            type: 'POST',
                            data: {
                                token: token
                            },
                            dataType: 'JSON',
                            success: function(response) {
                               console.log(response);
                            },
                            error: function(err) {
                                console.log('User Chat Token Error' + err);
                            },
                        });



                    }).catch(function(err) {
                        console.log('User Chat Token Error' + err);
                    });
            }

            messaging.onMessage(function(payload) {
                const noteTitle = payload.notification.title;
                const noteOptions = {
                    body: payload.notification.body,
                    icon: payload.notification.icon,
                };
                new Notification(noteTitle, noteOptions);
            });

            initFirebaseMessagingRegistration();
        })
    </script>
@endsection
