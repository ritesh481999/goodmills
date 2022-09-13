<!DOCTYPE html>

<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4 & Angular 8
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="../../../">
		<meta charset="utf-8" />
		<title>GoodMills | Reset</title>
		<link rel="icon" href="{!! asset('assets/media/logos/favicon.png') !!}"/>
		<meta name="description" content="Login page example">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--begin::Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
		<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700"> -->

		<!--end::Fonts -->

		<!--begin::Page Custom Styles(used by this page) -->
		<link href="{{ asset('assets/css/pages/login/login-3.css')}}" rel="stylesheet" type="text/css" />

		<!--end::Page Custom Styles -->

		<!--begin::Global Theme Styles(used by all pages) -->

		<!--begin:: Vendor Plugins -->
		
		<link href="{{asset('assets/plugins/general/animate.css/animate.css') }}" rel="stylesheet" type="text/css" />
		
		<link href="{{asset('assets/plugins/general/plugins/line-awesome/css/line-awesome.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/plugins/general/plugins/flaticon/flaticon.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/plugins/general/plugins/flaticon2/flaticon.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/plugins/general/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" />

		<!--end:: Vendor Plugins -->
		<link href="{{asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

		<!--begin:: Vendor Plugins for custom pages -->
		<link href="{{asset('assets/plugins/custom/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
		
		
		<link href="{{asset('assets/plugins/custom/jstree/dist/themes/default/style.css') }}" rel="stylesheet" type="text/css" />
		
		

		<!--end:: Vendor Plugins for custom pages -->

		<!--end::Global Theme Styles -->

		<!--begin::Layout Skins(used by all pages) -->
		<link href="{{asset('assets/css/skins/header/base/light.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/css/skins/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/css/skins/brand/dark.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/css/skins/aside/dark.css') }}" rel="stylesheet" type="text/css" />

		<!--end::Layout Skins -->
		<!-- <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" /> -->

		<link href="{{ asset('css/parsley_new.css') }}" rel="stylesheet" type="text/css" />
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

		<!-- begin:: Page -->
		<div class="kt-grid kt-grid--ver kt-grid--root">
			<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
				<!-- <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url('{{asset('assets/media//bg/bg-3.jpg')}}');"> -->
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-color:  #F9F5EC;">
					<div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
						<div class="kt-login__container">
							<div class="kt-login__logo">
								<a href="#">
									<!-- <img src="{{asset('assets/media/logos/logo-5.png')}}"> -->
									<img src="{{asset('assets/media/logos/GoodMills_Logo_RGB_72dpi.png')}}" width="75%">
								</a>
							</div>
							<div class="kt-login__signin">
								<div class="kt-login__head">
									<h3 class="kt-login__title">Reset Password</h3>
									@if(session()->has('error'))
									
									<div class="alert alert-danger" role="alert">
										{{ session('error') }}
									</div>
									@endif
                                    @if(session()->has('success'))
                                    <div class="alert-success m-alert m-alert--outline alert alert-dismissible alert fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        {!! session()->get('success') !!}
									</div>
                                    @endif
								</div>
								<form class="kt-form" action="{!! route('auth.reset.password') !!}" id="sign-in-form"  method="POST">
									{{ csrf_field() }}
                                	{{-- <div id="otp_expire">Expire OTP In <span id="timer"></span></div>
									<div class="input-group">
										<input class="form-control @error('otp') is-invalid @enderror" type="number" placeholder="OTP" name="otp" autocomplete="off" value="{{ old('otp') }}"  required />
										<span class="invalid-feedback" role="alert">
											<strong id="otp-error">@error('otp'){{ $message }}@enderror</strong>
										</span>
									</div> --}}
									<input type="hidden" name="token" value={{$token}}>
                                    <div class="input-group">
										<input class="form-control @error('password') is-invalid @enderror" type="password" placeholder="New Password" name="password" autocomplete="off" required  />
										<span class="invalid-feedback" role="alert">
											<strong id="password-error">@error('password'){{ $message }}@enderror</strong>
										</span>
									</div>
                                    <div class="input-group">
										<input class="form-control" type="password" placeholder="Confirm Password" name="password_confirmation" autocomplete="off" value="{{ old('password_confirmation') }}"  required />
										<span class="invalid-feedback" role="alert">
										</span>
									</div>
									<div class="kt-login__actions">
										<button class="btn kt-login__btn-primary" type="submit" style="background-color: #3F3B2B !important;border-color: #4B4635 !important;color:#fff !important;width: 40%;">Submit</button>
									</div>
                                    
								</form>
							</div>
							
							{{-- <div class="kt-login__forgot">
								<div class="kt-login__head">
									<h3 class="kt-login__title">Forgotten Password ?</h3>
									<div class="kt-login__desc">Enter your email to reset your password:</div>
								</div>
								<form class="kt-form" action="{{route('auth.forgot.password')}}" method="POST">
									@csrf
									<div class="input-group">
										<input class="form-control" type="text" placeholder="Email" name="email" id="kt_email" autocomplete="off">
									</div>
									<div class="kt-login__actions">
										<button type="submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Request</button>&nbsp;&nbsp;
										<button id="kt_login_forgot_cancel" class="btn btn-light btn-elevate kt-login__btn-secondary">Cancel</button>
									</div>
								</form>
							</div> --}}
							
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!-- begin::Global Config(global config for global JS sciprts) -->
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#5d78ff",
						"dark": "#282a3c",
						"light": "#ffffff",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": [
							"#c5cbe3",
							"#a1a8c3",
							"#3d4465",
							"#3e4466"
						],
						"shape": [
							"#f0f3ff",
							"#d9dffa",
							"#afb4d4",
							"#646c9a"
						]
					}
				}
			};
		</script>

		<!-- end::Global Config -->

		<!--begin::Global Theme Bundle(used by all pages) -->

		<!--begin:: Vendor Plugins -->
		<script src="{{ asset('assets/plugins/general/jquery/dist/jquery.js')}}" type="text/javascript"></script>
		<script src="{{ asset('assets/plugins/general/popper.js/dist/umd/popper.js')}}" type="text/javascript"></script>
		<script src="{{ asset('assets/plugins/general/bootstrap/dist/js/bootstrap.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('assets/plugins/general/js-cookie/src/js.cookie.js')}}" type="text/javascript"></script>
		

		<!--begin:: Vendor Plugins for custom pages -->
		<script src="{{ asset('assets/plugins/custom/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
		

		<!--end:: Vendor Plugins for custom pages -->

		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts(used by this page) -->
		<script src="{{ asset('assets/js/pages/custom/login/login-general.js')}}" type="text/javascript"></script>
		<script src="{{ asset('js/parsley_new.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
        <!--end::Page Scripts -->
        
		<script type="text/javascript">
			(function(){
				$('kt_login_forgot').on('click', function(){
					alert('hi');
					window.alert('Under construction!');
					return false;
				});

				// $('#sign-in-form').parsley({
				// 	trigger: 'change',
				// 	successClass: "is-valid",
				// 	errorClass: "is-invalid",
				// 	classHandler: function (el){
				// 		return el.$element.closest('.form-group');
				// 	},
				// 	errorsWrapper: '<span class="invalid-feedback" role="alert"><strong></strong></span>',
				// 	errorTemplate: '',
				// });
				// $('#sign-in-form').parsley();
			})()
        </script>
        <script>
//             let timerOn = true;

// function timer(remaining) {
//     var m = Math.floor(remaining / 60);
//     var s = remaining % 60;

//     m = m < 10 ? '0' + m : m;
//     s = s < 10 ? '0' + s : s;
//     document.getElementById('timer').innerHTML = m + ':' + s;
//     remaining -= 1;

//     if(remaining >= 0 && timerOn) {
//         setTimeout(function() {
//             timer(remaining);
//         }, 1000);
//         return;
//     }

//     if(!timerOn) {
//         // Do validate stuff here
//         return;
//     }

//     // Do timeout stuff here
//     alert('Timeout for otp');
// }

// timer(120);

function startTimer(duration, display) {
var timer = duration, minutes, seconds;
var x = setInterval(function () {
    minutes = parseInt(timer / 60, 10)
    seconds = parseInt(timer % 60, 10);

    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;

    display.textContent = minutes + " " + " " + seconds;

    if (--timer <= 0) {
        //timer = duration;
        clearInterval(x);
        localStorage.removeItem('seconds');
        localStorage.removeItem('minutes');
        document.getElementById("otp_expire").innerHTML = "EXPIRED";
        console.log(timer);
    }
  //console.log(parseInt(seconds))
  window.localStorage.setItem("seconds",seconds)
  window.localStorage.setItem("minutes",minutes)
}, 1000);
}

window.onload = function () {
  sec  = parseInt(window.localStorage.getItem("seconds"))
  min = parseInt(window.localStorage.getItem("minutes"))

  if(parseInt(min*sec)){
    var twoMinutes = (parseInt(min*60)+sec);
  }else{
    var twoMinutes = 60 * 2;
  }
    // var twoMinutes = 60 * 2;
  display = document.querySelector('#timer');
  startTimer(twoMinutes, display);
};
        </script>

	</body>

	<!-- end::Body -->
</html>