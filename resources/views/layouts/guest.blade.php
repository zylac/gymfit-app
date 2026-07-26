<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GymFit — {{ $title ?? 'Member Area' }}</title>
    <meta name="description" content="GymFit — Premium gym membership and personal trainer booking platform.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        @keyframes fade-up { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
        .animate-fade-up { animation: fade-up 0.6s ease forwards; }
        .animate-fade-in { animation: fade-in 0.4s ease forwards; }
        .gradient-amber { background: linear-gradient(135deg, #F59E0B, #D97706); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    </style>
</head>
<body class="antialiased bg-[#F8F7F4] text-slate-700 min-h-screen flex flex-col items-center justify-center px-4 py-8 overflow-x-hidden">

    <!-- Decorative -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute top-[-100px] right-[-100px] w-[400px] h-[400px] rounded-full bg-amber-500 opacity-[0.03] blur-3xl"></div>
        <div class="absolute bottom-[-100px] left-[-100px] w-[300px] h-[300px] rounded-full bg-slate-500 opacity-[0.03] blur-3xl"></div>
    </div>

    <!-- Logo -->
    <div class="relative z-10 mb-8 animate-fade-up">
        <a href="/" class="text-3xl font-extrabold tracking-tight text-slate-800">
            GYM<span class="gradient-amber">FIT</span>
        </a>
    </div>

    <!-- Card -->
    <div class="relative z-10 w-full max-w-md bg-white rounded-3xl p-8 animate-fade-up shadow-lg" style="border: 1px solid #E2E8F0; box-shadow: 0 4px 24px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.03);">
        {{ $slot }}
    </div>

    <!-- Footer link -->
    <div class="relative z-10 mt-6 text-center animate-fade-up">
        <a href="/" class="text-xs text-slate-400 hover:text-slate-600 transition font-medium">
            ← Back to Home
        </a>
    </div>

</body>
</html>
