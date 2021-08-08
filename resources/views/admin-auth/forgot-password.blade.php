<x-guest-layout>
    <div class="content-body">
        <div class="w-100">
            <h2 class="h4 mt-0 mb-1">Forgot your password?</h2>
            <p class="text-muted"> No problem. Just let us know your email address and
                we will email you a password reset link that will allow you to choose a new one.</p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <input class="form-control" id="email" type="email" name="email" :value="old('email')" required
                        autofocus>
                </div>

                <div class="actions justify-content-between">
                    <button type="submit" class="btn btn-primary">
                        <span class="btn-icon icofont-send-mail mr-2"></span>Email Password Reset Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
