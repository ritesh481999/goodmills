<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed "
    style="margin-bottom: 10px; background-color: #ffffff;">

    <!-- begin:: Header Menu -->

    <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
        <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">
            <ul class="kt-menu__nav ">
            </ul>
        </div>
    </div>

    <!-- end:: Header Menu -->

    <!-- begin:: Header Topbar -->


    <div class="kt-header__topbar">


        <div class="nav-item dropdown">
            <a class="nav-link bell_icon" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="far fa-bell fa-lg"></i>
                @if (notificationCount() > 0)
                    <span class="badge badge-danger navbar-badge">{{ notificationCount() }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left" style="left: inherit; right: 0px;">
                <span class="dropdown-item dropdown-header">You have {{ notificationCount() }} notifications</span>
                @if (getAllNotification()->count() > 0)
                    @foreach (getAllNotification() as $nF)
                        <div class="dropdown-divider"></div>
                        @if (getItemTypeUrl($nF->item_type) == 'farmer')
                            @php
                                $cUrl = getItemTypeUrl($nF->item_type) . '/' . '?farmer_id=' . $nF->item_id . '&n_id=' . $nF->id;
                            @endphp
                        @elseif(getItemTypeUrl($nF->item_type) == 'deleted_accounts')
                            @php
                                $cUrl = getItemTypeUrl($nF->item_type);
                            @endphp
                        @else
                            @php
                                $cUrl = getItemTypeUrl($nF->item_type) . '/' . $nF->item_id . '/?n_id=' . $nF->id;
                            @endphp
                        @endif

                        <p>
                            <a href="{{ url($cUrl) }}" class="notification-item">
                                <i class="fas fa-envelope mr-2"></i>{{ $nF->title }}
                                {{-- <span class="float-right text-muted text-sm"
                                >{{ $nF->human_time }}</span> --}}
                                <span class="float-right text-muted text-sm"
                                    style="display: block; position: relative; left: 13px;">{{ $nF->human_time }}</span>
                            </a>

                        </p>
                    @endforeach

                @endif

                <div class="dropdown-divider"></div>
                <a href="{{ route('notifications.index') }}" class="dropdown-item dropdown-footer">See All
                    Notifications</a>
            </div>
        </div>


        <select class="form-control changeLang" style="margin-right:81px;margin-top:15px">
            @foreach ($countryData as $key => $country)
                <option value="{{ $country->id }}"
                    {{ auth()->user()->selected_country_id == $country->id ? 'selected' : '' }}>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>

        <!--begin: User Bar -->


        <div class="kt-header__topbar-item kt-header__topbar-item--user">
            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
                <div class="kt-header__topbar-user">
                    <span class="kt-header__topbar-welcome kt-hidden-mobile">{{ __('common.hi') }},</span>
                    <span class="kt-header__topbar-username kt-hidden-mobile">
                        {{ Str::ucfirst(auth()->user()->name) }}
                    </span>
                    <img class="kt-hidden" alt="Pic" src="{{ asset('assets/media/users/300_25.jpg') }}" />
                    <i class="fa fa-angle-down"></i>
                </div>
            </div>

            <div
                class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">

                <!--begin: Navigation -->

                <div class="kt-notification">
                    <div class="kt-notification__custom kt-space-between">
                        <a href="{{ route('admin.change.password') }}"
                            class="btn btn-label btn-label-brand btn-sm btn-bold">
                            {{ __('common.reset_password_title') }}
                        </a>
                    </div>
                </div>

                <div class="kt-notification">
                    <div class="kt-notification__custom kt-space-between">
                        <a href="{{ route('auth.logout') }}" class="btn btn-label btn-label-brand btn-sm btn-bold ">
                            {{ __('common.sign_out') }}
                        </a>
                    </div>
                </div>

                <!--end: Navigation -->

            </div>

        </div>

        <!--end: User Bar -->
    </div>

    <!-- end:: Header Topbar -->
</div>
