<x-guest-layout>
    <div class="content-body">
        <div class="w-100">
            <h2 class="h4 mt-0 mb-1">Sign in</h2>
            <p class="text-muted">Sign in to access your Account</p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input class="form-control" id="email" type="email" name="email" :value="old('email')" required
                        autofocus>
                </div>

                <div class="form-group">
                    <input class="form-control" type="password" id="password" type="password" name="password" required
                        autocomplete="current-password">
                </div>

                <div class="form-group custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="remember_me" type="checkbox"
                        name="remember">
                    <label class="custom-control-label" for="remember-me">Remember me</label>
                </div>

                <div class="actions justify-content-between">
                    <button type="submit" class="btn btn-primary">
                        <span class="btn-icon icofont-login mr-2"></span>Sign in
                    </button>
                </div>
            </form>
            @if (Route::has('password.request'))
            <p class="mt-5 mb-1"><a href="{{ route('password.request') }}">Forgot password?</a></p>
            @endif
            {{-- <p>Don't have an account? <a href="./sign-up.html">Sign up!</a></p> --}}
        </div>
    </div>
</x-guest-layout>
