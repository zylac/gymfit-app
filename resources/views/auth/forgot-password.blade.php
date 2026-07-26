<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-2xl font-extrabold text-slate-800">Reset Password</h1>
        <p class="text-sm text-slate-500 mt-2">Enter your email and we'll send you a reset link</p>
    </div>

    <div class="mb-6 p-4 rounded-xl text-sm text-slate-500 bg-slate-50 border border-slate-200">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="your@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center">
                {{ __('Send Reset Link') }}
            </x-primary-button>
        </div>

        <p class="mt-5 text-center">
            <a href="{{ route('login') }}" class="text-sm text-slate-400 hover:text-slate-600 transition font-medium">← Back to Sign In</a>
        </p>
    </form>
</x-guest-layout>
