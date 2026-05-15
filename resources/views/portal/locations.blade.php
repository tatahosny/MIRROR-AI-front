@extends('layouts.portal')

@section('title', 'Locations')

@section('content')
<main class="flex-1 md:ml-64 pt-24 md:pt-12 px-margin-mobile md:px-margin-desktop pb-24 max-w-container-max mx-auto w-full relative z-10">
    <!-- Header -->
    <header class="mb-12">
        <h2 class="font-headline-lg-mobile md:font-headline-lg text-on-surface tracking-tight mb-2">Find a MIRROR AI Near You</h2>
        <p class="font-body-lg text-on-surface-variant max-w-2xl">Experience clinical luxury in person. Discover exclusive locations featuring our advanced smart mirror diagnostics.</p>
    </header>

    <!-- Map Section (Bento Style) -->
    <div class="w-full h-64 md:h-96 bg-surface-container rounded-xl overflow-hidden relative mb-12 border border-outline-variant/10">
        <div class="absolute inset-0 bg-surface flex items-center justify-center">
            <!-- Fallback map image -->
            <img alt="Map view" class="w-full h-full object-cover opacity-60 mix-blend-luminosity grayscale contrast-150" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBtsYxzYEqKE4Nr8Zrn4p9VLqUUuuK8tZUuQDaOrWBxP2BFSG2TeF1hvqzj81hG5clMIX5Q-K95VVmpWy6kqBbqThb9Z7GxNBRjvqZe6dhxELNIrgWDjGoXq9FZQSdGZTi8g71fiKLvPQf4jFU8mTQThV3R0Fe3Mulq8OxSj4nt5Dn43tZsmzxkhFnYOUs-MZ92KnWWWWm6aQVRUnAHOZf_Z807t2WAfjGvTJPHwuEvVhxyjdg8_-pYb5pfo4uQ7RcofwbelB7Ppnk"/>
            
            <!-- Demo Pins -->
            <div class="absolute top-1/3 left-1/4 transform -translate-x-1/2 -translate-y-1/2 flex flex-col items-center group cursor-pointer">
                <div class="w-4 h-4 bg-tertiary rounded-full shadow-[0_0_15px_rgba(0,218,243,0.6)] border-2 border-background z-10 group-hover:scale-125 transition-transform"></div>
                <div class="bg-surface-container-highest text-on-surface font-label-sm text-label-sm px-3 py-1 rounded mt-2 opacity-0 group-hover:opacity-100 transition-opacity">Cairo</div>
            </div>
            <div class="absolute top-1/2 right-1/4 transform -translate-x-1/2 -translate-y-1/2 flex flex-col items-center group cursor-pointer">
                <div class="w-4 h-4 bg-tertiary rounded-full shadow-[0_0_15px_rgba(0,218,243,0.6)] border-2 border-background z-10 group-hover:scale-125 transition-transform"></div>
                <div class="bg-surface-container-highest text-on-surface font-label-sm text-label-sm px-3 py-1 rounded mt-2 opacity-0 group-hover:opacity-100 transition-opacity">Dubai</div>
            </div>
            <div class="absolute top-2/3 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex flex-col items-center group cursor-pointer">
                <div class="w-4 h-4 bg-tertiary rounded-full shadow-[0_0_15px_rgba(0,218,243,0.6)] border-2 border-background z-10 group-hover:scale-125 transition-transform"></div>
                <div class="bg-surface-container-highest text-on-surface font-label-sm text-label-sm px-3 py-1 rounded mt-2 opacity-0 group-hover:opacity-100 transition-opacity">Riyadh</div>
            </div>
        </div>
        <div class="absolute bottom-4 right-4 bg-surface-container-high/80 backdrop-blur-md px-4 py-2 rounded-xl border border-outline-variant/10">
            <p class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">info</span>
                Interactive map disabled for demo
            </p>
        </div>
    </div>

    <!-- Locations Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
        <!-- Location Card 1 -->
        <div class="bg-surface-container-highest rounded-xl p-6 flex flex-col h-full relative overflow-hidden group transition-all duration-300 border border-outline-variant/10 hover:border-primary/30">
            <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="flex justify-between items-start mb-6 z-10">
                <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">storefront</span>
                </div>
                <span class="font-label-sm text-label-sm text-primary px-3 py-1 bg-primary/10 rounded-xl">ACTIVE</span>
            </div>
            <h3 class="font-headline-md text-headline-md text-on-surface mb-2 z-10">Dubai Mall</h3>
            <p class="font-body-md text-on-surface-variant mb-6 flex-1 z-10">Premium Clinic Partner<br/>Fashion Avenue, Ground Floor</p>
            <button class="w-full py-3 px-4 bg-primary text-on-primary font-label-sm text-label-sm uppercase tracking-wider rounded-xl hover:bg-primary/90 transition-colors duration-300 z-10 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]">directions</span>
                Get Directions
            </button>
        </div>

        <!-- Location Card 2 -->
        <div class="bg-surface-container-highest rounded-xl p-6 flex flex-col h-full relative overflow-hidden group transition-all duration-300 border border-outline-variant/10 hover:border-primary/30">
            <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="flex justify-between items-start mb-6 z-10">
                <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">storefront</span>
                </div>
                <span class="font-label-sm text-label-sm text-primary px-3 py-1 bg-primary/10 rounded-xl">ACTIVE</span>
            </div>
            <h3 class="font-headline-md text-headline-md text-on-surface mb-2 z-10">Riyadh Park</h3>
            <p class="font-body-md text-on-surface-variant mb-6 flex-1 z-10">Sephora Flagship<br/>Gate 2, Luxury Wing</p>
            <button class="w-full py-3 px-4 bg-primary text-on-primary font-label-sm text-label-sm uppercase tracking-wider rounded-xl hover:bg-primary/90 transition-colors duration-300 z-10 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]">directions</span>
                Get Directions
            </button>
        </div>

        <!-- Location Card 3 -->
        <div class="bg-surface-container rounded-xl p-6 flex flex-col h-full relative overflow-hidden group transition-all duration-300 opacity-80 border border-outline-variant/10">
            <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="flex justify-between items-start mb-6 z-10">
                <div class="w-12 h-12 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                    <span class="material-symbols-outlined">construction</span>
                </div>
                <span class="font-label-sm text-label-sm text-on-surface-variant px-3 py-1 bg-surface-variant/30 rounded-xl">COMING SOON</span>
            </div>
            <h3 class="font-headline-md text-headline-md text-on-surface mb-2 z-10">Cairo Festival City</h3>
            <p class="font-body-md text-on-surface-variant mb-6 flex-1 z-10">Exclusive Aesthetics Center<br/>Opening Q3 2024</p>
            <button class="w-full py-3 px-4 bg-surface-variant text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider rounded-xl cursor-not-allowed z-10 flex items-center justify-center gap-2" disabled>
                <span class="material-symbols-outlined text-[18px]">notifications</span>
                Notify Me
            </button>
        </div>
    </div>

    <div class="text-center">
        <p class="font-label-sm text-label-sm text-on-surface-variant opacity-50 uppercase tracking-widest">Data presented is for demonstration purposes only.</p>
    </div>
</main>
@endsection
