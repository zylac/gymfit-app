<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-bold text-slate-800">Upload Payment Proof</h1>
    </x-slot>

    <div class="max-w-xl mx-auto space-y-5">

        {{-- Booking summary card --}}
        <div class="card p-6 border-amber-200">
            <p class="section-title mb-4">Booking Summary</p>
            <div class="space-y-3">
                @foreach([
                    ['Plan', $booking->membershipPlan?->name ?? '—'],
                    ['Trainer', $booking->pt?->name ?? '—'],
                    ['Schedule', \Carbon\Carbon::parse($booking->schedule_time)->format('d M Y, H:i')],
                ] as [$label, $value])
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-500">{{ $label }}</span>
                    <span class="text-slate-800 font-semibold">{{ $value }}</span>
                </div>
                @endforeach
                <div class="border-t border-slate-100 pt-3 flex justify-between items-center">
                    <span class="text-slate-600 font-bold text-sm">Total</span>
                    <span class="text-2xl font-black gradient-amber">Rp {{ number_format($booking->amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Bank info --}}
        <div class="card p-6 border-amber-300">
            <p class="section-title mb-4">Payment Instructions</p>
            <p class="text-sm text-slate-500 mb-3">Transfer to the following account:</p>
            <div class="rounded-xl p-4 bg-slate-50 border border-slate-200">
                <p class="text-xs text-slate-500 mb-1 font-medium">Bank BCA</p>
                <p class="text-2xl font-black tracking-widest text-slate-800">1234-5678-9012</p>
                <p class="text-xs text-slate-500 mt-1">a.n GymFit Indonesia</p>
            </div>
            <p class="text-amber-700 text-xs mt-3 font-semibold">
                ⏱ Upload proof within <span class="font-bold text-slate-800">24 hours</span> of booking.
            </p>
        </div>

        {{-- Upload form --}}
        @if($booking->status === 'PENDING_PAYMENT')
        <form method="POST" action="{{ route('bookings.payment.upload', $booking->id) }}" enctype="multipart/form-data" class="card p-6">
            @csrf
            <p class="section-title mb-4">Upload Proof</p>

            <label for="proof"
                   x-data="{ name: '' }"
                   class="block w-full rounded-2xl p-8 text-center cursor-pointer transition-all duration-300 border-2 border-dashed border-slate-200 hover:border-amber-400 bg-slate-50/50"
                   :style="name ? 'border-color: #F59E0B; background: #FEF3C7' : ''">
                <input type="file" id="proof" name="proof" accept="image/*" class="sr-only" required
                       x-on:change="name = $event.target.files[0]?.name || ''">
                <svg class="w-10 h-10 mx-auto mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-slate-500 text-sm" x-text="name || 'Click to upload or drag & drop'"></p>
                <p class="text-slate-400 text-xs mt-1" x-show="!name">PNG, JPG, JPEG · max 5MB</p>
            </label>

            @error('proof') <p class="text-red-600 text-xs mt-2">{{ $message }}</p> @enderror

            <div class="flex gap-3 mt-5">
                <a href="{{ route('dashboard') }}" class="btn-secondary flex-1 justify-center text-sm">
                    Back
                </a>
                <button type="submit" class="btn-primary flex-1 justify-center text-sm">
                    Submit Payment
                </button>
            </div>
        </form>
        @else
        <div class="card p-8 text-center border-emerald-200">
            <p class="text-5xl mb-3">✅</p>
            <p class="text-emerald-600 font-bold text-lg">Payment Submitted!</p>
            <p class="text-slate-500 text-sm mt-2">Status: <span class="text-slate-800 font-semibold">{{ str_replace('_',' ', $booking->status) }}</span></p>
            <a href="{{ route('dashboard') }}" class="inline-block mt-5 text-sm font-bold text-amber-600 hover:text-amber-700 transition">
                ← Back to Dashboard
            </a>
        </div>
        @endif

    </div>
</x-app-layout>
