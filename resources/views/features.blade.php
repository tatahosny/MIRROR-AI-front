@extends('layouts.main')

@section('title', 'Clinical Features')

@section('content')
<div class="pt-40 relative z-10 pb-32">
    <!-- Hero Header -->
    <div class="max-w-4xl mx-auto text-center mb-32 px-margin-mobile">
        <h1 class="font-display-lg text-display-lg text-on-surface mb-8 leading-tight uppercase tracking-tight">Clinical <span class="text-primary italic">Intelligence</span></h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto leading-relaxed">
            Advanced biometric analysis powered by medical-grade computer vision and state-of-the-art neural networks.
        </p>
    </div>

    <!-- Features Grid -->
    <section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="p-8 md:p-10 lg:p-12 bg-surface-container-low rounded-2xl border border-primary/5 hover:bg-surface-container hover:border-primary/20 transition-all group overflow-hidden">
                <span class="material-symbols-outlined text-primary mb-6 text-4xl group-hover:scale-110 transition-transform">biometrics</span>
                <h4 class="font-headline-sm text-2xl md:text-headline-md text-on-surface mb-4 break-words">Real-time Biometrics</h4>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">Our smart mirror identifies skin texture, hydration levels, and inflammation markers in real-time using high-resolution facial mapping.</p>
            </div>
            <div class="p-8 md:p-10 lg:p-12 bg-surface-container-low rounded-2xl border border-primary/5 hover:bg-surface-container hover:border-primary/20 transition-all group overflow-hidden">
                <span class="material-symbols-outlined text-primary mb-6 text-4xl group-hover:scale-110 transition-transform">psychology</span>
                <h4 class="font-headline-sm text-2xl md:text-headline-md text-on-surface mb-4 break-words">AI Clinical Logic</h4>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">Powered by the latest LLMs, the system generates comprehensive clinical reports with specific observations for breakouts and pigmentation.</p>
            </div>
            <div class="p-8 md:p-10 lg:p-12 bg-surface-container-low rounded-2xl border border-primary/5 hover:bg-surface-container hover:border-primary/20 transition-all group overflow-hidden">
                <span class="material-symbols-outlined text-primary mb-6 text-4xl group-hover:scale-110 transition-transform">trending_up</span>
                <h4 class="font-headline-sm text-2xl md:text-headline-md text-on-surface mb-4 break-words">Progress Journey</h4>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">Track your skin's improvement over weeks and months. See the actual impact of your treatments through longitudinal data.</p>
            </div>
            <div class="p-8 md:p-10 lg:p-12 bg-surface-container-low rounded-2xl border border-primary/5 hover:bg-surface-container hover:border-primary/20 transition-all group overflow-hidden">
                <span class="material-symbols-outlined text-primary mb-6 text-4xl group-hover:scale-110 transition-transform">verified_user</span>
                <h4 class="font-headline-sm text-2xl md:text-headline-md text-on-surface mb-4 break-words">Secure Data Linking</h4>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">Anonymous scans can be securely linked to your personal profile using encrypted QR codes, ensuring total biometric privacy.</p>
            </div>
            <div class="p-8 md:p-10 lg:p-12 bg-surface-container-low rounded-2xl border border-primary/5 hover:bg-surface-container hover:border-primary/20 transition-all group overflow-hidden">
                <span class="material-symbols-outlined text-primary mb-6 text-4xl group-hover:scale-110 transition-transform">water_drop</span>
                <h4 class="font-headline-sm text-2xl md:text-headline-md text-on-surface mb-4 break-words">Hydration Mapping</h4>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">Analyze moisture distribution across facial zones to optimize your hydration routine with clinical precision.</p>
            </div>
            <div class="p-8 md:p-10 lg:p-12 bg-surface-container-low rounded-2xl border border-primary/5 hover:bg-surface-container hover:border-primary/20 transition-all group overflow-hidden">
                <span class="material-symbols-outlined text-primary mb-6 text-4xl group-hover:scale-110 transition-transform">history</span>
                <h4 class="font-headline-sm text-2xl md:text-headline-md text-on-surface mb-4 break-words">Clinical Archiving</h4>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">Maintain a permanent, secure record of every skin state, accessible from any Mirror AI clinical partner location.</p>
            </div>
        </div>
    </section>
</div>
@endsection
