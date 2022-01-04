<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow bg-black-op-10">
            <div class="content-header-section text-center align-parent">
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout"
                    data-action="sidebar_close">
                    <i class="fa fa-times text-danger"></i>
                </button>
                <!-- END Close Sidebar -->

                <!-- Logo -->
                <div class="content-header-item">
                    <a class="link-effect font-w700" href="{{ route('dashboard') }}">
                        <img class="mb-1" src="{{ asset('assets/base/afyatime-logo.png') }}" alt="" height="20px">
                        <span class="font-size-xl text-dual-primary-dark">afya</span><span
                            class="font-size-xl text-primary">time</span>
                    </a>
                </div>
                <!-- END Logo -->
            </div>
        </div>
        <!-- END Side Header -->

        <!-- Sidebar Scrolling -->
        <div class="js-sidebar-scroll">
            <!-- Side Main Navigation -->
            <div class="content-side content-side-full">
                <!--
              Mobile navigation, desktop navigation can be found in #page-header

              If you would like to use the same navigation in both mobiles and desktops, you can use exactly the same markup inside sidebar and header navigation ul lists
              -->
                <ul class="nav-main">
                    <li>
                        <a class="{{ request()->routeIs('dashboard*') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}"><i class="si si-home"></i>Home</a>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('appointments*') ? 'active' : '' }}"
                            href="{{ route('appointments') }}"><i class="si si-calendar"></i>Appointments</a>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('patients*') ? 'active' : '' }}"
                            href="{{ route('patients') }}"><i class="si si-users"></i>Patients</a>
                    </li>
                </ul>
            </div>
            <!-- END Side Main Navigation -->
        </div>
        <!-- END Sidebar Scrolling -->
    </div>
    <!-- Sidebar Content -->
</nav>
<!-- END Sidebar -->

<!-- Header -->
<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
        <div class="content-header-section w-100">
            <div class="row no-gutters">
                <div class="col">
                    <!-- Toggle Sidebar -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <button type="button" class="btn btn-dual-secondary d-lg-none" data-toggle="layout"
                        data-action="sidebar_toggle">
                        <i class="fa fa-navicon"></i>
                    </button>
                    <!-- END Toggle Sidebar -->

                    <!-- Header Navigation -->
                    <!--
                Desktop Navigation, mobile navigation can be found in #sidebar

                If you would like to use the same navigation in both mobiles and desktops, you can use exactly the same markup inside sidebar and header navigation ul lists
                If your sidebar menu includes headings, they won't be visible in your header navigation by default
                If your sidebar menu includes icons and you would like to hide them, you can add the class 'nav-main-header-no-icons'
                -->
                    <ul class="nav-main-header">
                        <li>
                            <a class="{{ request()->routeIs('dashboard*') ? 'active' : '' }}"
                                href="{{ route('dashboard') }}">
                                <i class="si si-home d-none d-xl-inline-block"></i> Home
                            </a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('appointments*') ? 'active' : '' }}"
                                href="{{ route('appointments') }}">
                                <i class="si si-calendar d-none d-xl-inline-block"></i> Appointments
                            </a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('patients*') ? 'active' : '' }}"
                                href="{{ route('patients') }}">
                                <i class="si si-users d-none d-xl-inline-block"></i> Patients
                            </a>
                        </li>
                    </ul>
                    <!-- END Header Navigation -->
                </div>
                <div class="col-3 text-center">
                    <!-- Logo -->
                    <div class="content-header-item">
                        <a class="link-effect font-w700" href="{{ route('dashboard') }}">
                            <img class="mb-1" src="{{ asset('assets/base/afyatime-logo.png') }}" alt="" height="20px">
                            {{-- <i class="si si-fire text-primary"></i> --}}
                            <span class="d-none d-md-inline-block">
                                <span class="font-size-xl text-dual-primary-dark">afya</span><span
                                    class="font-size-xl text-primary">time</span>
                            </span>
                        </a>
                    </div>
                    <!-- END Logo -->
                </div>
                <div class="col text-right">

                    <!-- User-Profile -->
                    <a href="{{ route('my-profile') }}" type="button" class="btn btn-alt-info ml-5">
                        <i class="si si-user"></i>
                        <span class="d-none d-sm-inline">My Profile</span>
                    </a>
                    <!-- END Logout -->

                    <!-- User-Profile -->
                    <a href="{{ route('logout') }}" type="button" class="btn btn-alt-danger ml-5"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        data-toggle="tooltip" data-placement="right" title="Logout">
                        <i class="si si-logout"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <!-- END Logout -->
                </div>
            </div>
        </div>
    </div>
    <!-- END Header Content -->

    <!-- Header Loader -->
    <div id="page-header-loader" class="overlay-header bg-primary">
        <div class="content-header content-header-fullrow text-center">
            <div class="content-header-item">
                <i class="fa fa-sun-o fa-spin text-white"></i>
            </div>
        </div>
    </div>
    <!-- END Header Loader -->
</header>
