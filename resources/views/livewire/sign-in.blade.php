<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MedicApp - Medical & Hospital HTML5/Bootstrap admin template</title>
    <meta name="keywords" content="MedicApp">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/img/favicon.ico">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/icofont.min.css">
    <link rel="stylesheet" href="../assets/css/simple-line-icons.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>


<body class="public-layout">
    <div class="app-loader main-loader">
        <div class="loader-box">
            <div class="bounceball"></div>
            <div class="text">Medic<span>app</span></div>
        </div>
    </div>
    <!-- .main-loader -->

    <div class="page-box">
        <div class="app-container page-sign-in">
            <div class="content-box">
                <div class="content-header">
                    <div class="app-logo">
                        <div class="logo-wrap">
                            <img src="../assets/img/logo.png" alt="" width="147" height="33" class="logo-img">
                        </div>
                    </div>
                </div>

                <div class="content-body">
                    <div class="w-100">
                        {{-- <h2 class="h4 mt-0 mb-1">Sign in</h2> --}}
                        <p class="text-muted">Forgot your password? No problem. Just let us know your email address and
                            we will email you a password reset link that will allow you to choose a new one.</p>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group">
                                <input class="form-control" id="email" type="email" name="email" :value="old('email')"
                                    required autofocus>
                            </div>

                            <div class="actions justify-content-between">
                                <button type="submit" class="btn btn-primary">
                                    <span class="btn-icon icofont-send-mail mr-2"></span>Email Password Reset Link
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/jquery-3.3.1.min.js"></script>
    <script src="../assets/js/jquery-migrate-1.4.1.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>

    <script src="../assets/js/main.js"></script>


</body>

</html>
