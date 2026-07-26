<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-bold text-white">Profile Settings</h1>
    </x-slot>

    <div class="space-y-6 max-w-3xl mx-auto">
        {{-- Profile Information --}}
        <div class="glass rounded-2xl p-6 lg:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        {{-- Update Password --}}
        <div class="glass rounded-2xl p-6 lg:p-8">
            @include('profile.partials.update-password-form')
        </div>

        {{-- Delete Account --}}
        <div class="glass rounded-2xl p-6 lg:p-8">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
