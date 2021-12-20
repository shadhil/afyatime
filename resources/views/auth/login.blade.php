<x-guest-layout>
    <main id="main-container">
        <!-- Page Content -->
        <div class="bg-body-dark bg-pattern"
            style="background-image: url('assets/base/media/various/bg-pattern-inverse.png');">
            <div class="row mx-0 justify-content-center">
                <div class="hero-static col-lg-6 col-xl-4">
                    <div class="content content-full overflow-hidden">
                        <!-- Header -->
                        <div class="py-30 text-center">
                            <a class="link-effect font-w700" href="index.html">
                                <i class="si si-fire"></i>
                                <span class="font-size-xl text-primary-dark">afya</span><span
                                    class="font-size-xl">time</span>
                            </a>
                            <h1 class="h4 font-w700 mt-30 mb-10">Welcome to Your Doc. Dashboard</h1>
                            <h2 class="h5 font-w400 text-muted mb-0">It’s a great day today!</h2>
                        </div>
                        <!-- END Header -->

                        <!-- Session Status -->
                        @if (session('status'))
                        <div class="alert alert-success alert-dismissable" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <p class="mb-0">
                                {{ session('status') }}
                            </p>
                        </div>
                        @endif

                        <!-- Validation Errors -->
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissable" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="alert-heading font-size-h5 font-w700 mb-5">Error</h3>
                            @foreach ($errors->all() as $error)
                            <p class="mb-0">
                                ** {{ $error }} **
                            </p>
                            @endforeach
                        </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="block block-themed block-rounded block-shadow">
                                <div class="block-header bg-gd-dusk">
                                    <h3 class="block-title">Please Sign In</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option">
                                            <i class="si si-wrench"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <label for="login-username">Email</label>
                                            <input class="form-control" id="email" type="email" name="email"
                                                :value="old('email')" required autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <label for="login-password">Password</label>
                                            <input class="form-control" type="password" id="password" type="password"
                                                name="password" required autocomplete="current-password">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-sm-6 d-sm-flex align-items-center push">
                                            <div class="custom-control custom-checkbox mr-auto ml-0 mb-0">
                                                <input type="checkbox" class="custom-control-input" id="remember_me"
                                                    name="remember">
                                                <label class="custom-control-label" for="login-remember-me">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 text-sm-right push">
                                            <button type="submit" class="btn btn-alt-primary">
                                                <i class="si si-login mr-10"></i> Sign In
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content bg-body-light">
                                    <div class="form-group text-center">
                                        @if (Route::has('password.request'))
                                        <a class="link-effect text-muted mr-10 mb-5 d-inline-block"
                                            href="{{ route('password.request') }}">
                                            <i class="fa fa-warning mr-5"></i> Forgot Password
                                        </a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- END Sign In Form -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END Page Content -->
    </main>
</x-guest-layout>
