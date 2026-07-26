<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GymFit — Elevate Your Performance</title>
    <meta name="description" content="GymFit — Premium gym membership and personal trainer booking platform.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }

        :root {
            --amber: #F59E0B;
            --amber-dark: #D97706;
            --amber-light: #FDE68A;
            --slate: #475569;
            --slate-dark: #1E293B;
        }

        html { scroll-behavior: smooth; }

        @keyframes fade-up {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes count-up {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-up { animation: fade-up 0.8s ease forwards; }
        .animate-fade-in { animation: fade-in 0.6s ease forwards; }
        .animate-float { animation: float 5s ease-in-out infinite; }
        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
        .delay-4 { animation-delay: 0.4s; opacity: 0; }
        .delay-5 { animation-delay: 0.5s; opacity: 0; }
    </style>
</head>
<body class="antialiased bg-[#F8F7F4] text-slate-800 overflow-x-hidden">

    <!-- ============================================================ -->
    <!-- NAVBAR                                                       -->
    <!-- ============================================================ -->
    <header id="navbar" class="w-full py-4 px-6 md:px-12 flex justify-between items-center fixed top-0 z-50 transition-all duration-300">
        <a href="/" class="text-xl font-extrabold tracking-tight text-slate-800">
            GYM<span class="gradient-amber">FIT</span>
        </a>
        <nav class="hidden md:flex items-center gap-10 text-sm font-medium text-slate-500">
            <a href="#plans" class="hover:text-slate-800 transition duration-200">Plans</a>
            <a href="#trainers" class="hover:text-slate-800 transition duration-200">Trainers</a>
            <a href="#contact" class="hover:text-slate-800 transition duration-200">Contact</a>
        </nav>
        <div class="flex items-center gap-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary text-sm !px-5 !py-2.5">
                    My Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition">Sign In</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-primary text-sm !px-5 !py-2.5">
                        Join Free
                    </a>
                @endif
            @endauth
        </div>
    </header>

    <!-- ============================================================ -->
    <!-- HERO SECTION                                                 -->
    <!-- ============================================================ -->
    <section class="relative min-h-screen flex flex-col items-center justify-center text-center px-6 pt-28 pb-16 overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-20 right-20 w-72 h-72 opacity-[0.04] rounded-full bg-amber-500 blur-3xl animate-float"></div>
        <div class="absolute bottom-40 left-20 w-96 h-96 opacity-[0.03] rounded-full bg-slate-500 blur-3xl" style="animation: float 7s ease-in-out infinite reverse;"></div>

        <div class="relative z-10 max-w-4xl mx-auto">
            <div class="animate-fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold tracking-widest text-amber-700 rounded-full mb-8" style="background: #FEF3C7;">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                    PREMIUM FITNESS PLATFORM
                </span>
            </div>

            <h1 class="animate-fade-up delay-1 text-5xl md:text-7xl lg:text-8xl font-extrabold leading-[1.05] tracking-tight mb-6 text-slate-800">
                Elevate Your<br>
                <span class="gradient-amber">Performance.</span>
            </h1>

            <p class="animate-fade-up delay-2 text-lg md:text-xl text-slate-500 max-w-2xl mx-auto mb-10 leading-relaxed">
                Elite personal trainers, cutting-edge equipment, and a community that pushes you beyond your limits — all in one place.
            </p>

            <div class="animate-fade-up delay-3 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="btn-primary text-base !px-8 !py-4 !rounded-2xl hover:scale-[1.02] transition-transform">
                    Start Your Journey Free →
                </a>
                <a href="#plans" class="btn-secondary text-base !px-8 !py-4 !rounded-2xl hover:scale-[1.02] transition-transform">
                    View Plans ↓
                </a>
            </div>

            <!-- Stats -->
            <div class="animate-fade-up delay-4 mt-20 grid grid-cols-3 gap-10 md:gap-20 max-w-lg mx-auto">
                @foreach([['2,400+','Active Members'],['38','Expert Trainers'],['99%','Satisfaction']] as [$num,$label])
                <div>
                    <p class="text-3xl md:text-4xl font-black text-slate-800">{{ $num }}</p>
                    <p class="text-slate-400 text-sm mt-1 font-medium">{{ $label }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- PLANS SECTION                                                -->
    <!-- ============================================================ -->
    <section id="plans" class="py-24 px-6 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <p class="section-title mb-3">MEMBERSHIP PLANS</p>
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-800">Invest in <span class="gradient-amber">yourself</span></h2>
                <p class="text-slate-500 mt-4 max-w-md mx-auto text-lg">Flexible plans designed for every level — from beginners to elite athletes.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 items-start">
                <!-- Basic -->
                <div class="card p-8 hover:-translate-y-1 transition-all duration-300">
                    <p class="section-title mb-4">STARTER</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mb-2">Basic</h3>
                    <div class="flex items-baseline gap-1 mb-1">
                        <span class="text-4xl font-black text-slate-800">Rp150</span>
                        <span class="text-slate-400 text-sm font-medium">k/mo</span>
                    </div>
                    <p class="text-slate-400 text-sm mb-8">30 days access</p>

                    <ul class="space-y-3 mb-8">
                        @foreach(['Unlimited Gym Access','Locker & Shower','Community Classes'] as $f)
                        <li class="flex items-center gap-3 text-sm text-slate-600">
                            <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold text-amber-700" style="background: #FEF3C7;">✓</span>
                            {{ $f }}
                        </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('register') }}" class="block text-center py-3 rounded-xl font-bold text-sm border-2 border-slate-200 text-slate-600 hover:border-amber-400 hover:text-amber-700 transition-all duration-200">
                        Get Started
                    </a>
                </div>

                <!-- Pro — featured -->
                <div class="card p-8 hover:-translate-y-1 transition-all duration-300 relative card-highlight">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-5 py-1.5 text-xs font-black text-white rounded-full" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                        MOST POPULAR
                    </div>
                    <p class="section-title mb-4">PRO</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mb-2">Pro + PT</h3>
                    <div class="flex items-baseline gap-1 mb-1">
                        <span class="text-4xl font-black text-slate-800">Rp500</span>
                        <span class="text-slate-400 text-sm font-medium">k/3mo</span>
                    </div>
                    <p class="text-slate-400 text-sm mb-8">90 days access</p>

                    <ul class="space-y-3 mb-8">
                        @foreach(['Unlimited Gym Access','4x Personal Trainer Sessions','Nutrition Consultation','Priority Locker Access','Progress Tracking'] as $f)
                        <li class="flex items-center gap-3 text-sm text-slate-700">
                            <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold text-white" style="background: linear-gradient(135deg, #F59E0B, #D97706);">✓</span>
                            {{ $f }}
                        </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('register') }}" class="block text-center py-3 rounded-xl font-bold text-sm text-white transition-all duration-200 hover:scale-[1.02]" style="background: linear-gradient(135deg, #F59E0B, #D97706); box-shadow: 0 4px 16px rgba(245,158,11,0.3);">
                        Get Started
                    </a>
                </div>

                <!-- Elite -->
                <div class="card p-8 hover:-translate-y-1 transition-all duration-300">
                    <p class="section-title mb-4">ELITE</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mb-2">Elite Annual</h3>
                    <div class="flex items-baseline gap-1 mb-1">
                        <span class="text-4xl font-black text-slate-800">Rp1.5</span>
                        <span class="text-slate-400 text-sm font-medium">jt/yr</span>
                    </div>
                    <p class="text-slate-400 text-sm mb-8">365 days access</p>

                    <ul class="space-y-3 mb-8">
                        @foreach(['All Pro Features','Unlimited PT Sessions','VIP Lounge Access','Free Merchandise','Dedicated Account Manager'] as $f)
                        <li class="flex items-center gap-3 text-sm text-slate-600">
                            <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold text-amber-700" style="background: #FEF3C7;">✓</span>
                            {{ $f }}
                        </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('register') }}" class="block text-center py-3 rounded-xl font-bold text-sm border-2 border-slate-200 text-slate-600 hover:border-amber-400 hover:text-amber-700 transition-all duration-200">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- TRAINERS SECTION                                             -->
    <!-- ============================================================ -->
    <section id="trainers" class="py-24 px-6" style="background: #F1F5F9;">
        <div class="max-w-6xl mx-auto text-center">
            <p class="section-title mb-3">EXPERT TEAM</p>
            <h2 class="text-4xl md:text-5xl font-extrabold text-slate-800 mb-4">Meet Your <span class="gradient-amber">Trainers</span></h2>
            <p class="text-slate-500 mb-16 max-w-md mx-auto text-lg">Certified professionals dedicated to your transformation.</p>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach([['R','Riko Pratama','Strength & Powerlifting'],['S','Sinta Dewi','Yoga & Flexibility'],['A','Agus Hendra','HIIT & Cardio'],['D','Diana Putri','Body Recomposition']] as [$init,$name,$spec])
                <div class="card p-6 hover:-translate-y-1 transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl mx-auto mb-4 flex items-center justify-center text-2xl font-black text-white shadow-lg" style="background: linear-gradient(135deg, #F59E0B, #D97706);">{{ $init }}</div>
                    <p class="font-bold text-slate-800">{{ $name }}</p>
                    <p class="text-slate-400 text-xs mt-1 font-medium">{{ $spec }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- TESTIMONIALS (NEW FEATURE)                                   -->
    <!-- ============================================================ -->
    <section id="testimonials" class="py-24 px-6 bg-white">
        <div class="max-w-6xl mx-auto text-center">
            <p class="section-title mb-3">TESTIMONIALS</p>
            <h2 class="text-4xl md:text-5xl font-extrabold text-slate-800 mb-4">What Our <span class="gradient-amber">Members Say</span></h2>
            <p class="text-slate-500 mb-16 max-w-md mx-auto text-lg">Real results from real people.</p>

            <div class="grid md:grid-cols-3 gap-6">
                @foreach([
                    ['Sarah M.','Yoga Enthusiast','⭐⭐⭐⭐⭐','\"GymFit transformed my approach to fitness. The trainers are world-class and the community is incredibly supportive.\"'],
                    ['Budi S.','Strength Athlete','⭐⭐⭐⭐⭐','\"Joined for the equipment, stayed for the results. Lost 12kg in 3 months with my personal trainer. Unbelievable.\"'],
                    ['Dewi L.','Busy Professional','⭐⭐⭐⭐⭐','\"The flexible scheduling and online booking make it so easy to fit workouts into my hectic schedule. Absolutely love it!\"'],
                ] as [$name,$role,$stars,$quote])
                <div class="card p-8 text-left">
                    <p class="text-amber-500 text-lg mb-4">{{ $stars }}</p>
                    <p class="text-slate-600 text-sm leading-relaxed mb-6 italic">"{{ $quote }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white" style="background: linear-gradient(135deg, #475569, #1E293B);">
                            {{ substr($name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 text-sm">{{ $name }}</p>
                            <p class="text-slate-400 text-xs">{{ $role }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- CTA SECTION                                                  -->
    <!-- ============================================================ -->
    <section class="py-24 px-6" style="background: #1E293B;">
        <div class="max-w-3xl mx-auto text-center">
            <p class="section-title mb-4" style="color: #FBBF24;">START TODAY</p>
            <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-4">Ready to <span class="gradient-amber">level up?</span></h2>
            <p class="text-slate-400 mb-8 text-lg">Join thousands of members already transforming their bodies with GymFit.</p>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-10 py-4 rounded-2xl font-black text-white text-lg hover:scale-[1.02] transition-all duration-200" style="background: linear-gradient(135deg, #F59E0B, #D97706); box-shadow: 0 8px 32px rgba(245,158,11,0.35);">
                Create Free Account →
            </a>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- FOOTER                                                       -->
    <!-- ============================================================ -->
    <footer class="py-12 px-6 text-center" style="background: #0F172A;">
        <p class="font-extrabold text-2xl tracking-tight text-slate-600 mb-3">GYMFIT</p>
        <p class="text-slate-600 text-sm">&copy; {{ date('Y') }} GymFit. All rights reserved. — Tugas Cloud Computing.</p>
    </footer>

    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.style.background = 'rgba(248,247,244,0.92)';
                navbar.style.backdropFilter = 'blur(20px)';
                navbar.style.borderBottom = '1px solid #E2E8F0';
            } else {
                navbar.style.background = 'transparent';
                navbar.style.backdropFilter = 'none';
                navbar.style.borderBottom = 'none';
            }
        });

        // Intersection Observer for scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('[data-animate]').forEach(el => {
            el.style.animationPlayState = 'paused';
            observer.observe(el);
        });
    </script>
</body>
</html>
