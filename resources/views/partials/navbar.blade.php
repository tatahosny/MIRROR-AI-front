<nav class="bg-surface/90 backdrop-blur-xl fixed top-0 w-full z-50 flex justify-between items-center px-margin-desktop h-20 border-b border-primary/10">
    <a href="/" class="font-display-lg text-headline-md tracking-tighter text-primary">MIRROR AI</a>
    <div class="hidden md:flex space-x-8 items-center">
        <a class="font-label-sm text-label-sm {{ request()->is('/') ? 'text-primary font-bold' : 'text-on-surface-variant hover:text-primary' }} transition-colors" href="/">Home</a>
        <a class="font-label-sm text-label-sm {{ request()->routeIs('features') ? 'text-primary font-bold' : 'text-on-surface-variant hover:text-primary' }} transition-colors" href="{{ route('features') }}">Features</a>
        <a class="font-label-sm text-label-sm {{ request()->routeIs('about') ? 'text-primary font-bold' : 'text-on-surface-variant hover:text-primary' }} transition-colors" href="{{ route('about') }}">About Project</a>
    </div>
    <div class="hidden md:flex items-center space-x-6">
        @auth
            <a href="{{ route('portal.dashboard') }}" class="font-label-sm text-label-sm text-on-surface hover:text-primary transition-colors">Dashboard</a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-primary/10 text-primary border border-primary/20 font-label-sm text-label-sm px-6 py-2 rounded hover:bg-primary/20 transition-all">Sign Out</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="font-label-sm text-label-sm text-on-surface hover:text-primary transition-colors">Sign In</a>
            <a href="{{ route('register') }}" class="bg-primary-container text-on-primary-fixed font-label-sm text-label-sm px-6 py-3 rounded hover:opacity-90 transition-opacity">Get Started</a>
        @endauth
    </div>
    <button class="md:hidden text-primary">
        <span class="material-symbols-outlined">menu</span>
    </button>
</nav>
