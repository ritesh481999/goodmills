<!DOCTYPE html>

<html lang="en">

<!-- begin::Head -->

<head>
    <base href="../../../">
    <meta charset="utf-8" />
    <title>
        {{ config('app.name') }} | Login
    </title>
    <link rel="icon" href="{!! asset('assets/media/logos/favicon.png') !!}" />
    <meta name="description" content="Login page example">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

    <!--end::Fonts -->

    <!--begin::Page Custom Styles(used by this page) -->
    <link href="{{ asset('assets/css/pages/login/login-3.css') }}" rel="stylesheet" type="text/css" />

    <!--end::Page Custom Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->

    <!--begin:: Vendor Plugins -->

    <link href="{{ asset('assets/plugins/general/animate.css/animate.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/plugins/general/plugins/line-awesome/css/line-awesome.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/general/plugins/flaticon/flaticon.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/general/plugins/flaticon2/flaticon.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/general/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!--end:: Vendor Plugins -->
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    <!--begin:: Vendor Plugins for custom pages -->
    <link href="{{ asset('assets/plugins/custom/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('assets/plugins/custom/jstree/dist/themes/default/style.css') }}" rel="stylesheet"
        type="text/css" />

    <!--end:: Vendor Plugins for custom pages -->

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{ asset('assets/css/skins/header/base/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/skins/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/skins/brand/dark.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/skins/aside/dark.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/parsley_new.css') }}" rel="stylesheet" type="text/css" />
</head>

<!-- end::Head -->

<!-- begin::Body -->

<body
    class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

    <!-- begin:: Page -->
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-color:  #F9F5EC;">
                <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                    <div class="kt-login__container">
                        <div class="kt-login__logo">
                            <a href="#">
                                <img src="{{ asset('assets/media/logos/goodmills_logo.png') }}" width="100%">
                            </a>
                        </div>
                        <div class="kt-login__signin">
                            <div class="kt-login__head">
                                <h3 class="kt-login__title">Log In</h3>
                                @if (session()->has('error'))

                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                @if (session()->has('success'))

                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                            </div>
                            <form class="kt-form" action="{!! route('auth.login') !!}" id="sign-in-form"
                                autocomplete="off" method="POST">
				{{ csrf_field() }}
                                <div class="input-group">
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                        placeholder="Email" name="email" value="{{ old('email') }}" required />
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="email-error">
                                            @error('email'){{ $message }}@enderror
                                            </strong>
                                        </span>
                                    </div>
                                    <div class="input-group">
                                        <input class="form-control @error('password') is-invalid @enderror" type="password"
                                            placeholder="Password" name="password" required>
                                        <span class="invalid-feedback" role="alert">
                                            <strong id="password-error">
                                                @error('password'){{ $message }}@enderror
                                                </strong>
                                            </span>
                                        </div>
                                        <div class="row kt-login__extra">
                                            <div class="col">
                                                <label class="kt-checkbox">
                                                    <input type="checkbox" name="remember" style="">
                                                    Remember me
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="col kt-align-right">
                                                <a href="{{ route('auth.forget.password') }}" class="kt-login__link">
                                                    Forget Password ?
                                                </a>
                                            </div>
                                        </div>
                                        <div class="kt-login__actions">
                                            <button class="btn kt-login__btn-primary" type="submit"
                                                style="background-color: #3F3B2B !important;border-color: #4B4635 !important;color:#fff !important;width: 40%;">
                                                Log In
                                            </button>
                                        </div>
                                    </form>
                                </div>
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
            <script src="{{ asset('assets/plugins/general/jquery/dist/jquery.js') }}" type="text/javascript"></script>
            <script src="{{ asset('assets/plugins/general/popper.js/dist/umd/popper.js') }}" type="text/javascript"></script>
            <script src="{{ asset('assets/plugins/general/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript">
            </script>
            <script src="{{ asset('assets/plugins/general/js-cookie/src/js.cookie.js') }}" type="text/javascript"></script>

            <!--begin:: Vendor Plugins for custom pages -->
            <script src="{{ asset('assets/plugins/custom/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript">
            </script>

            <!--end:: Vendor Plugins for custom pages -->

            <!--end::Global Theme Bundle -->

            <!--begin::Page Scripts(used by this page) -->
            <script src="{{ asset('assets/js/pages/custom/login/login-general.js') }}" type="text/javascript"></script>
            <script src="{{ asset('js/parsley_new.js') }}" type="text/javascript"></script>
            <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
            <!--end::Page Scripts -->

            <script type="text/javascript">
                (function() {
                    $('kt_login_forgot').on('click', function() {
                        alert('hi');
                        window.alert('Under construction!');
                        return false;
                    });
                })()
            </script>
        </body>

        <!-- end::Body -->

        </html>
