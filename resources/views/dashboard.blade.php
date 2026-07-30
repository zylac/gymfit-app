<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-bold text-slate-800">Dashboard</h1>
    </x-slot>

    <div class="space-y-6 max-w-6xl mx-auto">

        {{-- Welcome Banner --}}
        <div class="rounded-2xl p-6 relative overflow-hidden bg-white border border-slate-200 shadow-sm">
            <div class="absolute top-0 right-0 w-48 h-48 rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle, #F59E0B, transparent);"></div>
            <div class="relative">
                <p class="text-sm font-medium text-slate-500">Welcome back,</p>
                <h2 class="text-2xl font-extrabold text-slate-800">{{ Auth::user()->name }}! 💪</h2>
                <p class="text-slate-400 text-sm mt-1">Ready to crush your fitness goals today?</p>
            </div>
        </div>

        {{-- Top KPI Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- Membership Status --}}
            <div class="md:col-span-2 rounded-2xl p-6 relative overflow-hidden bg-white border border-slate-200 shadow-sm">
                <div class="absolute top-0 right-0 w-40 h-40 rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle, #F59E0B, transparent);"></div>
                <div class="relative">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        <p class="text-xs font-bold tracking-widest text-amber-600 uppercase">Membership</p>
                    </div>
                    @if(Auth::user()->membership_expires_at && Auth::user()->membership_expires_at->isFuture())
                        @php
                            $expiry = Auth::user()->membership_expires_at;
                            $daysLeft = now()->diffInDays($expiry);
                            $totalDays = Auth::user()->membershipPlan?->duration_days ?? 30;
                            $progress = min(100, round(($daysLeft / $totalDays) * 100));
                        @endphp
                        <div class="flex items-baseline gap-3 mb-4">
                            <span class="text-3xl font-black text-emerald-600">ACTIVE</span>
                            <span class="badge badge-amber text-xs">{{ Auth::user()->membershipPlan?->name }}</span>
                        </div>
                        <div class="flex justify-between text-xs text-slate-500 mb-2">
                            <span class="font-semibold">{{ $daysLeft }} days remaining</span>
                            <span>Expires {{ $expiry->format('d M Y') }}</span>
                        </div>
                        <div class="w-full progress-bg rounded-full h-2">
                            <div class="h-2 rounded-full progress-fill transition-all duration-700" style="width:{{ $progress }}%;"></div>
                        </div>
                    @else
                        <div class="flex items-baseline gap-3 mb-4">
                            <span class="text-3xl font-black text-slate-300">NO PLAN</span>
                        </div>
                        <a href="{{ route('bookings.create') }}" class="btn-primary text-sm !px-4 !py-2">
                            Buy Membership
                        </a>
                    @endif
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-rows-2 gap-4">
                <div class="rounded-2xl p-5 bg-white border border-slate-200 shadow-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-sm" style="background: #FEF3C7;">📊</div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Sessions</p>
                            <p class="text-3xl font-black text-slate-800">{{ Auth::user()->memberBookings->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl p-5 bg-white border border-slate-200 shadow-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-sm" style="background: #D1FAE5;">✓</div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Approved</p>
                            <p class="text-3xl font-black text-emerald-600">{{ Auth::user()->memberBookings->where('status','APPROVED')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Upcoming session --}}
        @php
            $nextSession = Auth::user()->memberBookings()
                ->with(['pt','membershipPlan'])
                ->where('status','APPROVED')
                ->where('schedule_time','>',now())
                ->orderBy('schedule_time')
                ->first();
        @endphp
        @if($nextSession)
        <div class="rounded-2xl p-5 bg-white border border-amber-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl shrink-0" style="background: #FEF3C7;">
                    ⚡
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        <p class="text-xs font-bold tracking-widest text-amber-600 uppercase">Next Session</p>
                    </div>
                    <p class="font-bold text-slate-800">with {{ $nextSession->pt?->name ?? 'TBD' }}</p>
                    <p class="text-sm text-slate-500">{{ \Carbon\Carbon::parse($nextSession->schedule_time)->format('l, d F Y \a\t H:i') }}</p>
                </div>
            </div>
            <span class="badge badge-green">CONFIRMED ✓</span>
        </div>
        @endif

        {{-- Quick actions --}}
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('bookings.create') }}" class="btn-primary text-sm !px-5 !py-2.5 hover:scale-[1.02] transition-transform">
                <svg class="w-4 h-4 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Booking
            </a>
            <a href="{{ route('profile.edit') }}" class="btn-secondary text-sm !px-5 !py-2.5 hover:scale-[1.02] transition-transform">
                <svg class="w-4 h-4 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Settings
            </a>
        </div>

        {{-- Booking History Table --}}
        <div class="rounded-2xl overflow-hidden bg-white border border-slate-200 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Booking History</h3>
                <span class="badge badge-slate text-xs">{{ Auth::user()->memberBookings->count() }} total</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs font-bold tracking-widest text-slate-400 uppercase">
                            <th class="px-6 py-3 text-left">Schedule</th>
                            <th class="px-6 py-3 text-left">Trainer</th>
                            <th class="px-6 py-3 text-left">Plan</th>
                            <th class="px-6 py-3 text-left">Amount</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse(Auth::user()->memberBookings()->with(['pt','membershipPlan','payment'])->latest()->get() as $booking)
                        <tr class="hover:bg-slate-50 transition-colors duration-100">
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-slate-800">{{ \Carbon\Carbon::parse($booking->schedule_time)->format('d M Y') }}</p>
                                <p class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($booking->schedule_time)->format('H:i') }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $booking->pt?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $booking->membershipPlan?->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-slate-800">Rp {{ number_format($booking->amount, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusConfig = [
                                        'PENDING_PAYMENT'      => ['label'=>'Pending Payment',    'class'=>'badge-amber'],
                                        'AWAITING_VERIFICATION'=> ['label'=>'Awaiting Review',    'class'=>'badge-blue'],
                                        'APPROVED'             => ['label'=>'Approved',            'class'=>'badge-green'],
                                        'REJECTED'             => ['label'=>'Rejected',            'class'=>'badge-red'],
                                        'COMPLETED'            => ['label'=>'Completed',           'class'=>'badge-gray'],
                                    ];
                                    $sc = $statusConfig[$booking->status] ?? ['label'=>$booking->status,'class'=>'badge-gray'];
                                @endphp
                                <span class="badge {{ $sc['class'] }}">
                                    {{ $sc['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @if($booking->status === 'PENDING_PAYMENT')
                                        <a href="{{ route('bookings.payment', $booking->id) }}"
                                           class="px-3 py-1.5 text-xs font-bold rounded-lg text-white" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                                            Upload Proof
                                        </a>
                                        <form method="POST" action="{{ route('bookings.cancel', $booking->id) }}"
                                              onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 text-xs font-bold rounded-lg text-red-600 border border-red-200 hover:bg-red-50 transition">
                                                Cancel
                                            </button>
                                        </form>
                                    @elseif($booking->status === 'APPROVED')
                                        <span class="text-xs text-emerald-600 font-semibold">✓ See you there!</span>
                                    @else
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl bg-slate-100">📅</div>
                                    <p class="text-slate-500 font-medium">No bookings yet</p>
                                    <a href="{{ route('bookings.create') }}" class="text-sm font-bold text-amber-600 hover:text-amber-700 transition">
                                        Book your first session →
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
