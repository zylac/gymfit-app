<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-2xl font-extrabold text-slate-800">Welcome Back</h1>
        <p class="text-sm text-slate-500 mt-2">Sign in to continue your fitness journey</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="your@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-5">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="Enter your password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-5">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-slate-300 text-amber-500 focus:ring-amber-500/30 shadow-sm"
                       name="remember">
                <span class="ms-2 text-sm text-slate-500">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-amber-600 hover:text-amber-700 font-semibold transition" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center">
                {{ __('Sign In') }}
            </x-primary-button>
        </div>

        {{-- Register link --}}
        @if (Route::has('register'))
        <p class="mt-5 text-center text-sm text-slate-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-amber-600 hover:text-amber-700 font-bold transition">
                Join Free
            </a>
        </p>
        @endif
    </form>
</x-guest-layout>
