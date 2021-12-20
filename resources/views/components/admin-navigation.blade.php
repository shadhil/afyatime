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
                    <a class="link-effect font-w700" href="{{ route('admin.organizations') }}">
                        <i class="si si-fire text-primary"></i>
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
                        <a href="{{ route('admin.organizations') }}"><i class="si si-cup"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.appointments.all') }}"><i class="si si-rocket"></i>Appointments</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.regions') }}"><i class="si si-wallet"></i>Location</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.types.prescriber') }}"><i class="si si-grid"></i>Prescriber Types</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.admins') }}"><i class="si si-user"></i>Admins</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="si si-logout"></i>Logout
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
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
        <!-- Left Section -->
        <div class="content-header-section">
            <!-- Logo -->
            <div class="content-header-item mr-5">
                <a class="link-effect font-w700" href="{{ route('admin.organizations') }}">
                    <i class="si si-fire text-primary"></i>
                    <span class="font-size-xl text-dual-primary-dark">afya</span><span
                        class="font-size-xl text-primary">time</span>
                </a>
            </div>
            <!-- END Logo -->
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="content-header-section">
            <!-- Header Navigation -->
            <!--
            Desktop Navigation, mobile navigation can be found in #sidebar

            If you would like to use the same navigation in both mobiles and desktops, you can use exactly the same markup inside sidebar and header navigation ul lists
            If your sidebar menu includes headings, they won't be visible in your header navigation by default
            If your sidebar menu includes icons and you would like to hide them, you can add the class 'nav-main-header-no-icons'
            -->
            <ul class="nav-main-header">
                <li>
                    <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                        <i class="si si-layers"></i> Menu
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('admin.organizations') }}"><i class="si si-cup"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.appointments.all') }}"><i class="si si-rocket"></i>Appointments</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.regions') }}"><i class="si si-wallet"></i>Location</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.types.prescriber') }}"><i class="si si-grid"></i>Prescriber
                                Types</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.admins') }}"><i class="si si-user"></i>Admins</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="si si-logout"></i>Logout
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </li>
            </ul>
            <!-- END Header Navigation -->

            <!-- Toggle Sidebar -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <button type="button" class="btn btn-dual-secondary d-lg-none" data-toggle="layout"
                data-action="sidebar_toggle">
                Menu <i class="fa fa-navicon ml-5"></i>
            </button>
            <!-- END Toggle Sidebar -->
        </div>
        <!-- END Right Section -->
    </div>
    <!-- END Header Content -->

    <!-- Header Search -->
    <div id="page-header-search" class="overlay-header">
        <div class="content-header content-header-fullrow">
            <form>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <!-- Close Search Section -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-secondary px-15" data-toggle="layout"
                            data-action="header_search_off">
                            <i class="fa fa-times"></i>
                        </button>
                        <!-- END Close Search Section -->
                    </div>
                    <input type="text" class="form-control" placeholder="Search or hit ESC.."
                        id="page-header-search-input" name="page-header-search-input">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary px-15">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END Header Search -->

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
