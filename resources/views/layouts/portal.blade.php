<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MIRROR AI - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "secondary": "#eac249",
                    "background": "#131313",
                    "primary": "#f2ca50",
                    "on-surface": "#e5e2e1",
                    "on-surface-variant": "#d0c5af",
                    "surface-container": "#201f1f",
                    "surface-container-low": "#1c1b1b",
                    "surface-container-high": "#2a2a2a",
                    "surface-container-lowest": "#0e0e0e",
                    "primary-container": "#d4af37",
                    "on-primary-fixed": "#241a00",
                    "error": "#ffb4ab",
                    "error-container": "#93000a",
                    "on-error-container": "#ffdad6",
                },
                borderRadius: {
                    DEFAULT: "0.25rem",
                    lg: "0.5rem",
                    xl: "0.75rem",
                    full: "9999px"
                },
                spacing: {
                    "4": "1.4rem",
                    "10": "3.5rem",
                    "8": "2.75rem",
                    "container-max": "1280px",
                    "margin-mobile": "20px",
                    "margin-desktop": "64px",
                    "gutter": "24px"
                },
                fontFamily: {
                    "display-lg": ["EB Garamond", "serif"],
                    "body-md": ["Plus Jakarta Sans", "sans-serif"],
                    "label-sm": ["Plus Jakarta Sans", "sans-serif"],
                    "headline-sm": ["EB Garamond", "serif"],
                    "headline-lg": ["EB Garamond", "serif"],
                    "body-lg": ["Plus Jakarta Sans", "sans-serif"],
                    "headline-md": ["EB Garamond", "serif"]
                },
                fontSize: {
                    "body-md": ["14px", { lineHeight: "1.5", letterSpacing: "0.01em", fontWeight: "400" }],
                    "display-lg": ["64px", { lineHeight: "1.1", letterSpacing: "-0.02em", fontWeight: "500" }],
                    "label-sm": ["12px", { lineHeight: "1.4", letterSpacing: "0.05em", fontWeight: "600" }],
                    "headline-sm": ["24px", { lineHeight: "1.2", letterSpacing: "-0.02em", fontWeight: "600" }],
                    "headline-lg": ["40px", { lineHeight: "1.2", fontWeight: "500" }],
                    "body-lg": ["18px", { lineHeight: "1.6", fontWeight: "400" }],
                    "headline-md": ["28px", { lineHeight: "1.3", fontWeight: "400" }]
                }
            }
        }
    }
    </script>
    <style>
        body {
            background-color: #131313;
            color: #e5e2e1;
        }
        .noise-bg {
            position: relative;
        }
        .noise-bg::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url('data:image/svg+xml,%3Csvg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"%3E%3Cfilter id="noiseFilter"%3E%3CfeTurbulence type="fractalNoise" baseFrequency="0.85" numOctaves="3" stitchTiles="stitch"/%3E%3C/filter%3E%3Crect width="100%25" height="100%25" filter="url(%23noiseFilter)" opacity="0.05"/%3E%3C/svg%3E');
            pointer-events: none;
            z-index: 0;
        }
        .clinical-card {
            background-color: rgba(32, 31, 31, 0.4);
            position: relative;
            overflow: hidden;
            border-radius: 1.5rem;
            transition: all 0.4s ease;
            border: 1px solid rgba(242, 202, 80, 0.05);
        }
        .clinical-card:hover {
            background-color: rgba(32, 31, 31, 0.6);
            box-shadow: 0 0 30px rgba(242, 202, 80, 0.05);
            border-color: rgba(242, 202, 80, 0.15);
        }
        .glass-panel {
            background: rgba(32, 31, 31, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(242, 202, 80, 0.1);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-background text-on-surface font-body-md min-h-screen flex flex-col md:flex-row noise-bg selection:bg-primary/30 selection:text-primary overflow-x-hidden">

    <!-- SideNavBar (Desktop) -->
    <nav class="hidden md:flex bg-surface-container-lowest fixed left-0 top-0 h-screen w-64 border-r border-primary/10 flex-col p-6 space-y-4 z-40">
        <div class="mb-8">
            <h1 class="font-display-lg text-headline-sm text-primary tracking-tighter drop-shadow-[0_0_15px_rgba(242,202,80,0.3)]">MIRROR AI</h1>
            <p class="font-label-sm text-on-surface-variant uppercase tracking-widest mt-1">Clinical Intelligence</p>
        </div>
        
        <div class="flex items-center space-x-3 mb-8 px-4 py-3 bg-surface-container rounded-lg border border-primary/10">
            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary border border-primary/30">
                <span class="material-symbols-outlined">person</span>
            </div>
            <div class="overflow-hidden">
                <p class="font-body-md text-on-surface text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                <p class="font-body-md text-on-surface-variant text-xs truncate">Premium Tier</p>
            </div>
        </div>

        <div class="flex-1 space-y-2">
            <a href="{{ route('portal.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all scale-98 hover:scale-100 font-body-md text-body-md {{ request()->routeIs('portal.dashboard') ? 'text-primary font-bold bg-primary/10' : 'text-on-surface-variant hover:bg-surface-variant/50 hover:text-primary' }}">
                <span class="material-symbols-outlined" style="{{ request()->routeIs('portal.dashboard') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">dashboard</span>
                <span>Overview</span>
            </a>
            <a href="{{ route('portal.reports') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all scale-98 hover:scale-100 font-body-md text-body-md {{ request()->routeIs('portal.reports') ? 'text-primary font-bold bg-primary/10' : 'text-on-surface-variant hover:bg-surface-variant/50 hover:text-primary' }}">
                <span class="material-symbols-outlined" style="{{ request()->routeIs('portal.reports') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">analytics</span>
                <span>My Reports</span>
            </a>
            <a href="{{ route('portal.progress') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all scale-98 hover:scale-100 font-body-md text-body-md {{ request()->routeIs('portal.progress') ? 'text-primary font-bold bg-primary/10' : 'text-on-surface-variant hover:bg-surface-variant/50 hover:text-primary' }}">
                <span class="material-symbols-outlined" style="{{ request()->routeIs('portal.progress') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">trending_up</span>
                <span>Progress</span>
            </a>
            <a href="{{ route('portal.locations') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all scale-98 hover:scale-100 font-body-md text-body-md {{ request()->routeIs('portal.locations') ? 'text-primary font-bold bg-primary/10' : 'text-on-surface-variant hover:bg-surface-variant/50 hover:text-primary' }}">
                <span class="material-symbols-outlined" style="{{ request()->routeIs('portal.locations') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">map</span>
                <span>Locations</span>
            </a>
            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-on-surface-variant hover:bg-surface-variant/50 hover:text-primary transition-all scale-98 hover:scale-100 font-body-md text-body-md">
                <span class="material-symbols-outlined">settings</span>
                <span>Settings</span>
            </a>
        </div>
        
        <div class="mt-auto space-y-2 pt-6 border-t border-primary/10">
            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-on-surface-variant hover:bg-surface-variant/50 hover:text-primary transition-all scale-98 hover:scale-100 font-body-md text-body-md">
                <span class="material-symbols-outlined">help</span>
                <span>Support</span>
            </a>
            <form action="{{ route('portal.logout') }}" method="POST" class="w-full m-0">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-on-surface-variant hover:bg-surface-variant/50 hover:text-error transition-all scale-98 hover:scale-100 font-body-md text-body-md">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Sign Out</span>
                </button>
            </form>
        </div>
    </nav>

    <!-- TopNavBar (Mobile) -->
    <nav class="md:hidden bg-background/80 backdrop-blur-xl fixed top-0 w-full z-50 border-b border-primary/10 flex justify-between items-center px-margin-mobile h-20">
        <h1 class="font-display-lg text-headline-sm tracking-tighter text-primary drop-shadow-[0_0_10px_rgba(242,202,80,0.3)]">MIRROR AI</h1>
        <button class="text-primary p-2">
            <span class="material-symbols-outlined">menu</span>
        </button>
    </nav>

    <!-- BottomNavBar for Mobile -->
    <nav class="md:hidden fixed bottom-0 w-full bg-surface-container-lowest/80 backdrop-blur-[30px] z-50 px-margin-mobile py-4 border-t border-outline-variant/15 flex justify-between items-center shadow-[0_-10px_30px_rgba(0,0,0,0.5)]">
        <a href="{{ route('portal.dashboard') }}" class="flex flex-col items-center scale-98 transition-transform {{ request()->routeIs('portal.dashboard') ? 'text-primary' : 'text-on-surface-variant hover:text-primary' }}">
            <span class="material-symbols-outlined" style="{{ request()->routeIs('portal.dashboard') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">dashboard</span>
            <span class="font-label-sm text-[10px] mt-1">Overview</span>
        </a>
        <a href="{{ route('portal.reports') }}" class="flex flex-col items-center scale-98 transition-transform {{ request()->routeIs('portal.reports') ? 'text-primary' : 'text-on-surface-variant hover:text-primary' }}">
            <span class="material-symbols-outlined" style="{{ request()->routeIs('portal.reports') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">analytics</span>
            <span class="font-label-sm text-[10px] mt-1">Reports</span>
        </a>
        <a href="{{ route('portal.progress') }}" class="flex flex-col items-center scale-98 transition-transform {{ request()->routeIs('portal.progress') ? 'text-primary' : 'text-on-surface-variant hover:text-primary' }}">
            <span class="material-symbols-outlined" style="{{ request()->routeIs('portal.progress') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">trending_up</span>
            <span class="font-label-sm text-[10px] mt-1">Progress</span>
        </a>
        <a href="{{ route('portal.locations') }}" class="flex flex-col items-center scale-98 transition-transform {{ request()->routeIs('portal.locations') ? 'text-primary' : 'text-on-surface-variant hover:text-primary' }}">
            <span class="material-symbols-outlined" style="{{ request()->routeIs('portal.locations') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">map</span>
            <span class="font-label-sm text-[10px] mt-1">Locations</span>
        </a>
    </nav>

    <!-- Main Content -->
    @yield('content')

    @stack('scripts')
</body>
</html>
