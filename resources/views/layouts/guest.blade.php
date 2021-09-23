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

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>


<body class="public-layout">
    <div class="app-loader main-loader">
        <div class="loader-box">
            <div class="bounceball"></div>
            <div class="text">Afya<span>Time</span></div>
        </div>
    </div>
    <!-- .main-loader -->

    <div class="page-box">
        <div class="app-container page-sign-in">
            <div class="content-box">
                <div class="content-header">
                    <div class="app-logo">
                        <div class="logo-wrap">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('assets/img/logo.svg') }}" alt="" width="147" height="33"
                                    class="logo-img">
                            </a>
                        </div>
                    </div>
                </div>

                {{ $slot }}
            </div>
            <div class="app-footer">
                <div class="footer-wrap">
                    <div class="row h-100 align-items-center">
                        <div class="col-12 col-md-6 d-none d-md-block">
                            <span>Copyright © 2021, <a href="https://njiwa.tech" target="_blank">Njiwa
                                    Technologies</a></span>
                        </div>

                        <div class="col-12 col-md-6 text-right">
                            <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                                <span>Version 1.0.0</span>
                                <button class="no-style ml-2 settings-btn">
                                    <span class="icon icofont-ui-settings text-primary"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="footer-skeleton">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-6 d-none d-md-block">
                                <ul class="page-breadcrumbs">
                                    <li class="item bg-1 animated-bg"></li>
                                    <li class="item bg animated-bg"></li>
                                </ul>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="info justify-content-center justify-content-md-end">
                                    <div class="version bg animated-bg"></div>
                                    <div class="settings animated-bg"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-migrate-1.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>


</body>

</html>
