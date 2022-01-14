<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap Min CSS -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/bootstrap.min.css') }}">
    <!-- Animate Min CSS -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/animate.min.css') }}">
    <!-- Owl Carousel Min CSS -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/owl.carousel.min.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/fontawesome.min.css') }}">
    <!-- Odometer CSS -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/odometer.css') }}">
    <!-- Popup CSS -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/magnific-popup.min.css') }}">
    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/slick.min.css') }}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/style.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/responsive.css') }}">

    <title>AfyaTime - App Landing Page HTML Template</title>

    <link rel="icon" type="image/png" href="{{ asset('favicons/favicon-32x32.png') }}">
    @livewireStyles
    @stack('styles')
</head>

<body data-spy="scroll" data-offset="120">

    <!-- Start Preloader Area -->
    <div class="preloader">
        <div class="preloader">
            <span></span>
            <span></span>
        </div>
    </div>
    <!-- End Preloader Area -->

    <!-- Start Navbar Area -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <div class="logo">
                <a href="index.html">
                    <img src="{{ asset('assets/landing/img/afya-logo.png') }}" style="margin-right: 5px;">
                </a>
            </div>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="#home" class="nav-link">
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#about" class="nav-link">
                            About
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#features" class="nav-link">
                            Features
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#screenshots" class="nav-link">
                            Screenshots
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#faq" class="nav-link">
                            FAQ
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#contact" class="nav-link">
                            Contact
                        </a>
                    </li>
                </ul>

                <div class="others-option">
                    <div class="d-flex align-items-center">
                        <div class="option-item">
                            <a href="#contact" class="default-btn">
                                Get Started
                                <span></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- End Navbar Area -->

    {{ $slot }}

    <!-- Start Copy Right Area -->
    <div class="copy-right">
        <div class="container">
            <div class="copy-right-content wow fadeInUp" data-wow-delay=".3s">
                <p>
                    <i class="far fa-copyright"></i>
                    2020 AfyaTime. All Rights Reserved by
                    <a href="https://njiwa.tech" target="_blank">
                        Njiwa Technologies
                    </a>
                </p>
            </div>
        </div>
    </div>
    <!-- End Copy Right Area -->

    <!-- Start Go Top Section -->
    <div class="go-top">
        <i class="fa fa-chevron-up"></i>
        <i class="fa fa-chevron-up"></i>
    </div>
    <!-- End Go Top Section -->

    <!-- jQuery Min JS -->
    <script src="{{ asset('assets/landing/js/jquery-3.5.1.min.js') }}"></script>
    <!-- Popper Min JS -->
    <script src="{{ asset('assets/landing/js/popper.min.js') }}"></script>
    <!-- Bootstrap Min JS -->
    <script src="{{ asset('assets/landing/js/bootstrap.min.js') }}"></script>
    <!-- Owl Carousel Min JS -->
    <script src="{{ asset('assets/landing/js/owl.carousel.min.js') }}"></script>
    <!-- Appear JS -->
    <script src="{{ asset('assets/landing/js/jquery.appear.js') }}"></script>
    <!-- Odometer JS -->
    <script src="{{ asset('assets/landing/js/odometer.min.js') }}"></script>
    <!-- Slick JS -->
    <script src="{{ asset('assets/landing/js/slick.min.js') }}"></script>
    <!-- Particles JS -->
    <script src="{{ asset('assets/landing/js/particles.min.js') }}"></script>
    <!-- Ripples JS -->
    <script src="{{ asset('assets/landing/js/jquery.ripples-min.js') }}"></script>
    <!-- Popup JS -->
    <script src="{{ asset('assets/landing/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- WOW Min JS -->
    <script src="{{ asset('assets/landing/js/wow.min.js') }}"></script>
    <!-- AjaxChimp Min JS -->
    <script src="{{ asset('assets/landing/js/jquery.ajaxchimp.min.js') }}"></script>
    <!-- Form Validator Min JS -->
    <script src="{{ asset('assets/landing/js/form-validator.min.js') }}"></script>
    <!-- Contact Form Min JS -->
    <script src="{{ asset('assets/landing/js/contact-form-script.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('assets/landing/js/main.js') }}"></script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
