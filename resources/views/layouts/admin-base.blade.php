<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>AfyaTime - Patient Appointment's Reminder App</title>

    <meta name="description"
        content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework">
    <meta property="og:site_name" content="Codebase">
    <meta property="og:description"
        content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
    <!-- END Icons -->

    <!-- Stylesheets -->

    <!-- Fonts and Codebase framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700&display=swap">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/base/css/codebase.min.css') }}">

    <!-- Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/base/css/toastr.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('assets/base/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/base/js/plugins/flatpickr/flatpickr.min.css') }}">
    {{--
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"> --}}

    @livewireStyles
    @stack('styles')

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/flat.min.css"> -->
    <!-- END Stylesheets -->
</head>

<body>
    <!-- Page Container -->
    <div id="page-container" class="sidebar-inverse side-scroll page-header-fixed main-content-boxed">

        <!-- Sidebar & Header -->
        <x-admin-navigation />
        <!-- END Sidebar & Header -->


        <!-- Main Container -->
        <main id="main-container">
            {{ $slot }}
        </main>
        <!-- END Main Container -->

        <!-- Footer -->
        <footer id="page-footer" class="bg-white">
            <div class="content py-20 font-size-sm clearfix">
                <div class="float-right">
                    Crafted with <i class="fa fa-heart text-pulse"></i> by <a class="font-w600"
                        href="https://njiwa.tech" target="_blank">Njiwa Technologies</a>
                </div>
                <div class="float-left">
                    <a class="font-w600" href="https://afyatime.com" target="_blank">AfyaTime</a> &copy;
                    <span class="js-year-copy"></span>
                </div>
            </div>
        </footer>
        <!-- END Footer -->
    </div>
    <!-- END Page Container -->

    <!--
        Codebase JS Core

        Vital libraries and plugins used in all pages. You can choose to not include this file if you would like
        to handle those dependencies through webpack. Please check out assets/_js/main/bootstrap.js for more info.

        If you like, you could also include them separately directly from the assets/js/core folder in the following
        order. That can come in handy if you would like to include a few of them (eg jQuery) from a CDN.

        assets/js/core/jquery.min.js
        assets/js/core/bootstrap.bundle.min.js
        assets/js/core/simplebar.min.js
        assets/js/core/jquery-scrollLock.min.js
        assets/js/core/jquery.appear.min.js
        assets/js/core/jquery.countTo.min.js
        assets/js/core/js.cookie.min.js
    -->
    <script src="{{ asset('assets/base/js/codebase.core.min.js') }}"></script>

    <!--
        Codebase JS

        Custom functionality including Blocks/Layout API as well as other vital and optional helpers
        webpack is putting everything together at assets/_js/main/app.js
    -->
    <script src="{{ asset('assets/base/js/codebase.app.min.js') }}"></script>

    <!-- Plugins -->
    <script src="{{ asset('assets/base/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/base/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}">
    </script>
    <script src="{{ asset('assets/base/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
    {{-- <script type=" text/javascript"
        src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script> --}}

    @livewireScripts
    @stack('scripts')
</body>

</html>
