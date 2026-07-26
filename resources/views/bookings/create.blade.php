<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-bold text-slate-800">Book a Trainer</h1>
    </x-slot>

    @if(session('error'))
    <div class="mb-6 flex items-center gap-3 p-4 rounded-xl bg-red-50 border border-red-200">
        <p class="text-sm text-red-600 font-medium">{{ session('error') }}</p>
    </div>
    @endif

    <form method="POST" action="{{ route('bookings.store') }}" class="max-w-3xl mx-auto space-y-6">
        @csrf

        {{-- Step 1: Plan --}}
        <div class="card p-6">
            <div class="flex items-center gap-3 mb-5">
                <span class="w-7 h-7 rounded-full text-xs font-bold text-white flex items-center justify-center" style="background: linear-gradient(135deg, #F59E0B, #D97706);">1</span>
                <div>
                    <h3 class="font-bold text-slate-800">Choose Your Plan</h3>
                    <p class="text-xs text-slate-500">Select the membership package you'd like to purchase.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($plans as $plan)
                <label for="plan_{{ $plan->id }}" class="cursor-pointer">
                    <input type="radio" name="membership_plan_id" id="plan_{{ $plan->id }}" value="{{ $plan->id }}"
                           class="sr-only peer" {{ old('membership_plan_id') == $plan->id ? 'checked' : '' }} required>
                    <div class="rounded-xl p-4 border border-slate-200 peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:border-slate-300 transition-all duration-200 relative">
                        <div class="hidden peer-checked:block absolute top-3 right-3 w-4 h-4 rounded-full text-white text-xs flex items-center justify-center font-bold" style="background: linear-gradient(135deg, #F59E0B, #D97706);">✓</div>
                        <p class="font-bold text-slate-800 text-sm">{{ $plan->name }}</p>
                        <p class="text-amber-600 font-black text-lg mt-0.5">Rp {{ number_format($plan->price, 0, ',', '.') }}</p>
                        <p class="text-slate-400 text-xs">{{ $plan->duration_days }} days · {{ $plan->description ?? '' }}</p>
                    </div>
                </label>
                @endforeach
            </div>
            @error('membership_plan_id') <p class="text-red-600 text-xs mt-2">{{ $message }}</p> @enderror
        </div>

        {{-- Step 2: Trainer --}}
        <div class="card p-6">
            <div class="flex items-center gap-3 mb-5">
                <span class="w-7 h-7 rounded-full text-xs font-bold text-white flex items-center justify-center" style="background: linear-gradient(135deg, #F59E0B, #D97706);">2</span>
                <div>
                    <h3 class="font-bold text-slate-800">Select a Personal Trainer</h3>
                    <p class="text-xs text-slate-500">All trainers are certified professionals.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($trainers as $trainer)
                <label for="pt_{{ $trainer->id }}" class="cursor-pointer">
                    <input type="radio" name="pt_id" id="pt_{{ $trainer->id }}" value="{{ $trainer->id }}"
                           class="sr-only peer" {{ old('pt_id') == $trainer->id ? 'checked' : '' }} required>
                    <div class="rounded-xl p-4 border border-slate-200 peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:border-slate-300 transition-all duration-200 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-white shrink-0" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                            {{ strtoupper(substr($trainer->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $trainer->name }}</p>
                            <p class="text-xs text-slate-500">Personal Trainer</p>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>
            @error('pt_id') <p class="text-red-600 text-xs mt-2">{{ $message }}</p> @enderror
        </div>

        {{-- Step 3: Schedule --}}
        <div class="card p-6">
            <div class="flex items-center gap-3 mb-5">
                <span class="w-7 h-7 rounded-full text-xs font-bold text-white flex items-center justify-center" style="background: linear-gradient(135deg, #F59E0B, #D97706);">3</span>
                <div>
                    <h3 class="font-bold text-slate-800">Pick a Schedule</h3>
                    <p class="text-xs text-slate-500">Choose a time at least 2 hours from now.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="schedule_time" class="block text-xs font-bold tracking-widest text-slate-500 uppercase mb-2">Date & Time</label>
                    <input type="datetime-local" name="schedule_time" id="schedule_time"
                           value="{{ old('schedule_time') }}"
                           min="{{ now()->addHours(2)->format('Y-m-d\TH:i') }}"
                           class="input-field" required>
                    @error('schedule_time') <p class="text-red-600 text-xs mt-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="member_notes" class="block text-xs font-bold tracking-widest text-slate-500 uppercase mb-2">Notes (Optional)</label>
                    <textarea name="member_notes" id="member_notes" rows="3"
                              placeholder="e.g., Focus on upper body, injury rehab..."
                              class="input-field resize-none">{{ old('member_notes') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('dashboard') }}" class="text-sm text-slate-500 hover:text-slate-700 transition font-medium">← Back</a>
            <button type="submit" class="btn-primary text-sm">
                Confirm Booking →
            </button>
        </div>
    </form>
</x-app-layout>
