<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>AfyaTime - Patient Appointment's Reminder App</title>
    <meta name="keywords" content="MedicApp">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.typeahead.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css') }}">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @livewireStyles
    @stack('styles')
</head>


<body class="horizontal-layout boxed">
    <div class="app-loader main-loader">
        <div class="loader-box">
            <div class="bounceball"></div>
            <div class="text">Afya<span>Time</span></div>
        </div>
    </div>
    <!-- .main-loader -->

    <div class="page-box">
        <div class="app-container">
            <!-- Horizontal navbar -->
            <div id="navbar1" class="app-navbar horizontal">
                <div class="navbar-wrap">

                    <button class="no-style navbar-toggle navbar-open d-lg-none">
                        <span></span><span></span><span></span>
                    </button>


                    <div class="app-logo">
                        <div class="logo-wrap">
                            <img src="{{ asset('assets/img/logo.svg') }}" alt="" width="147" height="33" class="logo-img">
                        </div>
                    </div>


                    <form class="app-search d-none d-md-block">
                        <div class="form-group typeahead__container with-suffix-icon mb-0">
                            <div class="typeahead__field">
                                <div class="typeahead__query">
                                    <input class="form-control autocomplete-control topbar-search" type="search"
                                        placeholder="Type page's title" autocomplete="off"
                                        data-source="assets/data/search-menu.json">
                                    <div class="suffix-icon icofont-search"></div>
                                </div>
                            </div>
                        </div>
                    </form>


                    <div class="app-actions">
                        <div class="dropdown item">
                            <button class="no-style dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" data-offset="0, 12">
                                <span class="icon icofont-notification"></span>
                                <span class="badge badge-danger badge-sm">5</span>
                            </button>

                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-w-280">
                                <div class="menu-header">
                                    <h4 class="h5 menu-title mt-0 mb-0">Notifications</h4>

                                    <a href="#" class="text-danger">Clear All</a>
                                </div>

                                <ul class="list">
                                    <li>
                                        <a href="#">
                                            <span class="icon icofont-heart"></span>

                                            <div class="content">
                                                <span class="desc">Sara Crouch liked your photo</span>
                                                <span class="date">17 minutes ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="icon icofont-users-alt-6"></span>

                                            <div class="content">
                                                <span class="desc">New user registered</span>
                                                <span class="date">23 minutes ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="icon icofont-share"></span>

                                            <div class="content">
                                                <span class="desc">Amanda Lie shared your post</span>
                                                <span class="date">25 minutes ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="icon icofont-users-alt-6"></span>

                                            <div class="content">
                                                <span class="desc">New user registered</span>
                                                <span class="date">32 minutes ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="icon icofont-ui-message"></span>

                                            <div class="content">
                                                <span class="desc">You have a new message</span>
                                                <span class="date">58 minutes ago</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>

                                <div class="menu-footer">
                                    <button class="btn btn-primary btn-block">
                                        View all notifications
                                        <span class="btn-icon ml-2 icofont-tasks-alt"></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown item">
                            <button class="no-style dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" data-offset="0, 10">
                                <span class="d-flex align-items-center">
                                    <img src="assets/content/user-400-1.jpg" alt="" width="40" height="40"
                                        class="rounded-500 mr-1">
                                    <i class="icofont-simple-down"></i>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-w-180">
                                <ul class="list">
                                    <li>
                                        <a href="#" class="align-items-center">
                                            <span class="icon icofont-ui-home"></span>
                                            Edit account
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="align-items-center">
                                            <span class="icon icofont-ui-user"></span>
                                            User profile
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="align-items-center">
                                            <span class="icon icofont-ui-calendar"></span>
                                            Calendar
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="align-items-center">
                                            <span class="icon icofont-ui-settings"></span>
                                            Settings
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="align-items-center">
                                            <span class="icon icofont-logout"></span>
                                            Log Out
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="navbar-skeleton horizontal">
                        <div class="left-part d-flex align-items-center">
                            <span class="navbar-button bg animated-bg d-lg-none"></span>
                            <span class="sk-logo bg animated-bg d-none d-lg-block"></span>
                            <span class="search d-none d-md-block bg animated-bg"></span>
                        </div>

                        <div class="right-part d-flex align-items-center">
                            <div class="icon-box">
                                <span class="icon bg animated-bg"></span>
                                <span class="badge"></span>
                            </div>
                            <span class="avatar bg animated-bg"></span>
                        </div>
                    </div>

                </div>
            </div>
            <!-- end Horizontal navbar -->

            <!-- Horizontal navbar 2 -->
            @include('layouts.navigation')

            <!-- endHorizontal navbar 2 -->

            <main class="main-content">
                <div class="app-loader"><i class="icofont-spinner-alt-4 rotate"></i></div>

                {{ $slot }}
            </main>

            <div class="content-overlay"></div>
        </div>
    </div>



    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-migrate-1.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.typeahead.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.barrating.min.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
