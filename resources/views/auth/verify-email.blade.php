<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-2xl font-extrabold text-slate-800">Verify Your Email</h1>
        <p class="text-sm text-slate-500 mt-2">One last step to unlock your GymFit journey</p>
    </div>

    <div class="mb-6 p-5 rounded-xl text-center bg-amber-50 border border-amber-200">
        <div class="text-4xl mb-3">📧</div>
        <p class="text-sm text-slate-600">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-3 rounded-xl text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-200">
            {{ __('A new verification link has been sent to your email address.') }}
        </div>
    @endif

    <div class="flex flex-col gap-3 mt-6">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button class="w-full justify-center">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="w-full py-2.5 rounded-xl text-sm font-medium text-slate-500 hover:text-slate-700 transition bg-slate-50 border border-slate-200">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
