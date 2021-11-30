<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>AfyaTime - Patient Appointment's Reminder App</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('landing//favicon.ico') }}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing/css/style.css') }}">
    @livewireStyles
</head>

<body>

    <!-- header -->
    <!-- header -->
    <header id="header-sticky" class="header transparent-header pt-70 pl-65 pr-65">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-xl-2 col-lg-3">
                    <div class="header__logo">
                        <a href="index-3.html"><img src="{{ asset('assets/landing/img/logo/logo.png') }}"
                                alt="logo"></a>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-9">
                    <div class="header__menu main-menu text-center">
                        <nav class="navbar navbar-expand-lg">
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarNav">
                                <span class="navbar-icon"></span>
                                <span class="navbar-icon"></span>
                                <span class="navbar-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                                <ul class="navbar-nav">
                                    <li class="nav-item active"><a class="nav-link" href="#hero">Home</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#work">How It Work?</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#whyafyatime">Why AfyaTime?</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
                <div class="col-xl-2 d-none d-xl-block">
                    <div class="header__btn text-right">
                        <a href="#contact-us" class="btn">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-end -->
    {{ $slot }}
    <!-- footer-area -->
    <footer class="footer__bg pt-105" data-background="{{ ('assets/landing/img/bg/footer_bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 mb-90">
                    <div class="footer__cta text-center">
                        <div class="section__title footer-title text-center mb-45 wow fadeInUp" data-wow-delay="0.2s">
                            <h2>For Future Updates</h2>
                        </div>
                        <div class="footer__cta-form wow fadeInUp" data-wow-delay="0.4s">
                            <form action="#">
                                <input type="text" placeholder="Enter your email address....">
                                <button class="btn">Subscribe Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright-wrap">
                <div class="row">
                    <div class="col-12">
                        <div class="copyright__text pt-35 pb-35 text-center">
                            <p>Copyright. AfyaTime 2021. All Right Reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer-area-end -->

    <!-- JS here -->
    <script src="{{ asset('assets/landing/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <script src="{{ asset('assets/landing/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('assets/landing/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/landing/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/landing/js/one-page-nav-min.js') }}"></script>
    <script src="{{ asset('assets/landing/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/landing/js/ajax-form.js') }}"></script>
    <script src="{{ asset('assets/landing/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/landing/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('assets/landing/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/landing/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/landing/js/main.js') }}"></script>
    @livewireScripts
</body>

</html>
