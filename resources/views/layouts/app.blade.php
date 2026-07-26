<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GymFit — {{ $title ?? 'Member Portal' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        :root {
            --bg-page:    #F8F7F4;
            --sidebar:    #FFFFFF;
            --header:     #FFFFFF;
            --card:       #FFFFFF;
            --border:     #E2E8F0;
            --border-light: #F1F5F9;
            --accent:     #F59E0B;
            --accent-hover: #D97706;
            --accent-light: #FEF3C7;
            --text:       #1E293B;
            --text-secondary: #475569;
            --text-muted:  #94A3B8;
            --slate-100:  #F1F5F9;
            --slate-200:  #E2E8F0;
        }

        body { background: var(--bg-page); color: var(--text-secondary); }

        /* Sidebar */
        .sidebar { background: var(--sidebar); border-right: 1px solid var(--border); }
        .sidebar-logo { border-bottom: 1px solid var(--border); }
        .nav-link {
            color: var(--text-secondary);
            transition: all 0.15s ease;
        }
        .nav-link:hover {
            color: var(--text);
            background: var(--slate-100);
        }
        .nav-link.active {
            color: var(--accent);
            background: var(--accent-light);
        }

        /* Header */
        .top-header { background: var(--header); border-bottom: 1px solid var(--border); }

        /* Cards */
        .card-bg { background: var(--card); border: 1px solid var(--border); }
        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }

        /* Progress */
        .progress-bg { background: var(--slate-100); }
        .progress-fill {
            background: linear-gradient(90deg, #F59E0B, #D97706);
            box-shadow: 0 0 8px rgba(245,158,11,0.3);
        }

        /* Gradient text */
        .gradient-amber { background: linear-gradient(135deg, #F59E0B, #D97706); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--slate-200); border-radius: 10px; }

        /* Toast */
        .toast-enter { animation: slide-in 0.35s cubic-bezier(.16,1,.3,1) forwards; }
        .toast-leave  { animation: slide-out 0.25s ease forwards; }
        .toast-bar    { animation: shrink linear forwards; }
        @keyframes slide-in  { from { opacity:0; transform: translateX(100%); } to { opacity:1; transform: translateX(0); } }
        @keyframes slide-out { from { opacity:1; transform: translateX(0); }   to { opacity:0; transform: translateX(100%); } }
        @keyframes shrink    { from { width: 100%; } to { width: 0%; } }
    </style>
</head>
<body class="antialiased min-h-screen flex">

<!-- ============================================================ -->
<!-- TOAST NOTIFICATIONS                                          -->
<!-- ============================================================ -->
<div id="toastContainer"
     x-data="toastSystem()"
     x-init="init()"
     class="fixed top-5 right-5 z-[999] flex flex-col gap-3 min-w-[320px] max-w-sm pointer-events-none"
     aria-live="polite">

    <template x-for="toast in toasts" :key="toast.id">
        <div class="toast rounded-2xl overflow-hidden"
             :class="toast.leaving ? 'toast-leave' : 'toast-enter'"
             style="box-shadow: 0 8px 32px rgba(0,0,0,0.12);">

            <div class="flex items-start gap-3 p-4"
                 :style="`background: ${toast.bg}; border: 1px solid ${toast.border};`">

                <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 text-base"
                     :style="`background: ${toast.iconBg}`"
                     x-text="toast.icon">
                </div>

                <div class="flex-1 min-w-0 pt-0.5">
                    <p class="text-sm font-bold" :style="`color: ${toast.titleColor}`" x-text="toast.title"></p>
                    <p class="text-xs mt-0.5 text-slate-500 leading-relaxed" x-text="toast.message"></p>
                </div>

                <button @click="dismiss(toast.id)"
                        class="shrink-0 text-slate-300 hover:text-slate-500 transition text-lg leading-none mt-0.5">×</button>
            </div>

            <div class="h-0.5 w-full" :style="`background: ${toast.border}`">
                <div class="h-full toast-bar rounded-full"
                     :style="`background: ${toast.titleColor}; animation-duration: ${toast.duration}ms`">
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    function toastSystem() {
        return {
            toasts: [],
            init() {
                const flashSuccess = document.querySelector('meta[name="flash-success"]')?.content;
                const flashError   = document.querySelector('meta[name="flash-error"]')?.content;
                const flashInfo    = document.querySelector('meta[name="flash-info"]')?.content;

                if (flashSuccess) this.$nextTick(() => this.show('success', flashSuccess));
                if (flashError)   this.$nextTick(() => this.show('error', flashError));
                if (flashInfo)    this.$nextTick(() => this.show('info', flashInfo));

                window.addEventListener('show-toast', (e) => {
                    this.show(e.detail.type, e.detail.message, e.detail.duration);
                });
            },
            show(type, message, duration = 4500) {
                const config = {
                    success: { icon: '✓', title: 'Berhasil',   titleColor: '#059669', bg: '#F0FDF4', border: '#D1FAE5', iconBg: '#D1FAE5' },
                    error:   { icon: '✕', title: 'Gagal',      titleColor: '#DC2626', bg: '#FEF2F2', border: '#FECACA', iconBg: '#FECACA' },
                    warning: { icon: '!', title: 'Perhatian',  titleColor: '#D97706', bg: '#FFFBEB', border: '#FDE68A', iconBg: '#FDE68A' },
                    info:    { icon: 'i', title: 'Info',        titleColor: '#2563EB', bg: '#EFF6FF', border: '#BFDBFE', iconBg: '#BFDBFE' },
                };
                const c = config[type] ?? config.info;
                const id = Date.now() + Math.random();
                this.toasts.push({ id, message, duration, ...c, leaving: false });
                setTimeout(() => this.dismiss(id), duration);
            },
            dismiss(id) {
                const t = this.toasts.find(t => t.id === id);
                if (t) { t.leaving = true; setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 280); }
            }
        }
    }
</script>

@if(session('success')) <meta name="flash-success" content="{{ session('success') }}"> @endif
@if(session('error'))   <meta name="flash-error"   content="{{ session('error') }}"> @endif
@if(session('info'))    <meta name="flash-info"     content="{{ session('info') }}"> @endif

<!-- ============================================================ -->
<!-- SIDEBAR                                                      -->
<!-- ============================================================ -->
<aside class="hidden lg:flex flex-col w-60 shrink-0 fixed h-full z-30 sidebar">

    <!-- Logo -->
    <div class="sidebar-logo px-5 h-16 flex items-center">
        <a href="/" class="text-lg font-extrabold tracking-tight text-slate-800">
            Gym<span class="gradient-amber">Fit</span>
        </a>
    </div>

    <!-- Nav -->
    <nav class="flex-1 px-3 py-5 space-y-0.5 overflow-y-auto">
        <p class="px-3 text-[10px] font-bold tracking-widest text-slate-400 mb-3 uppercase">Menu</p>

        @php
            $navItems = [
                ['route' => 'dashboard',        'label' => 'Dashboard',      'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
                ['route' => 'bookings.create',  'label' => 'Book Trainer',   'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                ['route' => 'profile.edit',     'label' => 'Profile',        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
            ];
        @endphp

        @foreach($navItems as $item)
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium nav-link {{ request()->routeIs($item['route']) || (str_starts_with($item['route'], 'bookings') && request()->routeIs('bookings.*')) ? 'active' : '' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $item['icon'] !!}</svg>
                {{ $item['label'] }}
            </a>
        @endforeach

        <div class="pt-4 mt-4" style="border-top: 1px solid var(--border);">
            <p class="px-3 text-[10px] font-bold tracking-widest text-slate-400 mb-3 uppercase">Account</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 text-red-500 hover:bg-red-50">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Sign Out
                </button>
            </form>
        </div>
    </nav>

    <!-- User avatar -->
    <div class="px-4 py-4" style="border-top: 1px solid var(--border);">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center font-bold text-xs text-white shrink-0" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-slate-400 truncate">Member</p>
            </div>
        </div>
    </div>
</aside>

<!-- ============================================================ -->
<!-- MAIN                                                          -->
<!-- ============================================================ -->
<div class="flex-1 lg:ml-60 flex flex-col min-h-screen">

    <!-- Top header -->
    <header class="top-header h-16 px-6 lg:px-8 flex items-center justify-between sticky top-0 z-20">

        <div>
            @isset($header){{ $header }}@else<h1 class="text-sm font-bold text-slate-800">{{ $title ?? 'Dashboard' }}</h1>@endisset
        </div>

        <div class="flex items-center gap-3" x-data="notifDropdown()">

            {{-- Notification Bell --}}
            <div class="relative">
                <button @click="open = !open"
                        class="relative w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-150 hover:bg-slate-100 border border-slate-200">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @php $pendingCount = Auth::user()->memberBookings()->where('status','PENDING_PAYMENT')->count(); @endphp
                    @if($pendingCount > 0)
                        <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full text-[9px] font-black text-white flex items-center justify-center" style="background: #EF4444;">{{ $pendingCount }}</span>
                    @endif
                </button>

                <!-- Notification Dropdown -->
                <div x-show="open" @click.outside="open=false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     class="absolute right-0 mt-2 w-80 rounded-2xl overflow-hidden z-50 bg-white border border-slate-200 shadow-xl">
                    <div class="px-4 py-3 flex items-center justify-between border-b border-slate-100">
                        <p class="text-sm font-bold text-slate-800">Notifications</p>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full text-amber-700" style="background: #FEF3C7;">{{ $pendingCount }} pending</span>
                    </div>
                    <div class="divide-y divide-slate-100 max-h-[280px] overflow-y-auto">
                        @php $recentBookings = Auth::user()->memberBookings()->with(['pt','membershipPlan'])->latest()->take(5)->get(); @endphp
                        @forelse($recentBookings as $nb)
                        <div class="px-4 py-3 flex items-start gap-3 hover:bg-slate-50 transition-colors duration-100">
                            @php
                                $icons = ['PENDING_PAYMENT'=>['⏳','#FEF3C7'],'AWAITING_VERIFICATION'=>['👁','#DBEAFE'],'APPROVED'=>['✅','#D1FAE5'],'REJECTED'=>['❌','#FEE2E2'],'COMPLETED'=>['🏁','#F1F5F9']];
                                [$nIcon, $nBg] = $icons[$nb->status] ?? ['📋','#F1F5F9'];
                            @endphp
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm shrink-0" style="background: {{ $nBg }}">{{ $nIcon }}</div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-slate-800">{{ $nb->membershipPlan?->name ?? 'Booking' }}</p>
                                <p class="text-[10px] mt-0.5 text-slate-500">with {{ $nb->pt?->name ?? 'TBD' }} · {{ str_replace('_',' ',$nb->status) }}</p>
                                <p class="text-[10px] mt-0.5 text-slate-400">{{ $nb->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="px-4 py-8 text-center text-xs text-slate-400">No notifications yet</div>
                        @endforelse
                    </div>
                    <div class="px-4 py-2.5 border-t border-slate-100">
                        <a href="{{ route('dashboard') }}" class="text-xs font-semibold block text-center text-amber-600 hover:text-amber-700 transition">View all bookings →</a>
                    </div>
                </div>
            </div>

            <!-- User chip -->
            <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white border border-slate-200">
                <div class="w-6 h-6 rounded-lg flex items-center justify-center text-xs font-bold text-white" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span class="hidden sm:block text-xs font-semibold text-slate-700">{{ Str::limit(Auth::user()->name, 14) }}</span>
            </div>
        </div>
    </header>

    <!-- Main content -->
    <main class="flex-1 p-6 lg:p-8 max-w-6xl w-full mx-auto">
        {{ $slot }}
    </main>

    <footer class="px-8 py-4 text-center text-[10px] font-medium border-t border-slate-100 text-slate-400">
        &copy; {{ date('Y') }} GymFit · Cloud Computing Assignment
    </footer>
</div>

<script>
    function notifDropdown() {
        return { open: false }
    }
</script>

</body>
</html>
