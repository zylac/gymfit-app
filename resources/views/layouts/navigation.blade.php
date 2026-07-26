<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-extrabold tracking-tight text-slate-800">
                        GYM<span class="gradient-amber">FIT</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold transition duration-150 {{ request()->routeIs('dashboard') ? 'border-amber-500 text-amber-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('bookings.create') }}"
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold transition duration-150 {{ request()->routeIs('bookings.*') ? 'border-amber-500 text-amber-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                        Book a Trainer
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative" x-data="{ menuOpen: false }">
                    <button @click="menuOpen = !menuOpen"
                            class="inline-flex items-center gap-2 px-4 py-2 border border-slate-200 text-sm leading-4 font-medium rounded-xl text-slate-700 bg-white hover:bg-slate-50 focus:outline-none transition ease-in-out duration-150">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold text-white" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="fill-current h-4 w-4 text-slate-400" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="menuOpen" @click.outside="menuOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-xl shadow-xl z-50 py-1">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition">
                            Profile Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-600 hover:bg-slate-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-slate-200">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block pl-4 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('dashboard') ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                Dashboard
            </a>
            <a href="{{ route('bookings.create') }}" class="block pl-4 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('bookings.*') ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                Book a Trainer
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-200">
            <div class="px-4">
                <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-slate-500 hover:text-slate-700 hover:bg-slate-50">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-red-600 hover:text-red-700 hover:bg-red-50">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
