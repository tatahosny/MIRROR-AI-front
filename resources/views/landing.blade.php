@extends('layouts.main')

@section('title', 'Clinical Intelligence')

@section('styles')
    .glass-panel {
        background: rgba(18, 18, 18, 0.6);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
    }
@endsection

@section('content')
<!-- Main Content -->
<div class="pt-20">
    <!-- Hero Section -->
    <section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden px-margin-mobile md:px-margin-desktop py-20">
        <div class="absolute inset-0 z-0">
            <img alt="Mirror AI Interface" class="w-full h-full object-cover opacity-20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA3uqcto4ghY-md3SmLXl5ZyCJGzT6lDu9PI-DEHZhj3ukVSw1ECUx8MHe9ydTxc6IdreqwLyF1qvenayNsH3LoG-WA7A_Fsp8ZBjEAtJtZlLd9xjFxLGiDddk2gAeSOCP3CNQKPiRcx-Mu7YLCzx0D8PMA-x2EGLqrQwbL1Qo_4xbSgUh7OTX2-JedMCQi2WF6t7y41PfyKzGV5wwEWEaWh2Sgqaqf1GB8CB2KXrK0QV7I2U9ixNWmXxvOQm01j87-DGm3iPaTnF0"/>
            <div class="absolute inset-0 bg-gradient-to-t from-background via-background/60 to-background/20"></div>
        </div>
        <div class="relative z-10 max-w-container-max w-full flex flex-col items-center text-center space-y-10">
            <div class="inline-flex items-center px-6 py-2 rounded-full bg-surface-container-high/80 backdrop-blur-md">
                <span class="material-symbols-outlined text-primary text-sm mr-2" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                <span class="font-label-sm text-label-sm text-primary uppercase tracking-widest">AI-Powered Skin Analysis</span>
            </div>
            <h1 class="font-display-lg text-display-lg text-on-surface max-w-4xl leading-tight">
                Meet the <span class="text-primary italic">Smartest</span> Mirror for Your Skin
            </h1>
            <div class="flex flex-col sm:flex-row items-center gap-6 pt-6">
                <a href="{{ route('register') }}" class="w-full sm:w-auto bg-primary-container text-on-primary-fixed font-label-sm text-label-sm uppercase tracking-widest px-8 py-4 rounded hover:bg-primary transition-colors">
                    Create Free Account
                </a>
            </div>
        </div>
    </section>

    <!-- Supervisors Section -->
    <section class="py-12 bg-background border-y border-primary/5">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-surface-container/40 backdrop-blur-md p-8 rounded-2xl border border-primary/10 flex items-center space-x-6">
                    <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center border border-primary/20">
                        <span class="material-symbols-outlined text-4xl text-primary">engineering</span>
                    </div>
                    <div>
                        <h4 class="font-headline-sm text-xl text-primary mb-1">Eng. Ragab Hassan</h4>
                        <p class="font-label-sm text-on-surface-variant uppercase tracking-widest">Project Supervisor</p>
                    </div>
                </div>
                <div class="bg-surface-container/40 backdrop-blur-md p-8 rounded-2xl border border-primary/10 flex items-center space-x-6">
                    <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center border border-primary/20">
                        <span class="material-symbols-outlined text-4xl text-primary">school</span>
                    </div>
                    <div>
                        <h4 class="font-headline-sm text-xl text-primary mb-1">Dr. Heimen</h4>
                        <p class="font-label-sm text-on-surface-variant uppercase tracking-widest">Project Supervisor</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-24 px-margin-mobile md:px-margin-desktop bg-surface-container-lowest">
        <div class="max-w-container-max mx-auto text-center">
            <h2 class="font-headline-lg text-headline-lg text-on-surface mb-16">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="flex flex-col items-center p-8 bg-surface-container rounded-xl">
                    <span class="material-symbols-outlined text-display-lg text-primary mb-6">center_focus_strong</span>
                    <h3 class="font-headline-md text-headline-md text-on-surface mb-4">1. Scan</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant text-center">Our system captures high-resolution images of your face, analyzing multiple skin layers.</p>
                </div>
                <div class="flex flex-col items-center p-8 bg-surface-container rounded-xl">
                    <span class="material-symbols-outlined text-display-lg text-primary mb-6">psychology</span>
                    <h3 class="font-headline-md text-headline-md text-on-surface mb-4">2. Analyze</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant text-center">Advanced AI algorithms evaluate skin texture, hydration levels, and pigmentation with clinical precision.</p>
                </div>
                <div class="flex flex-col items-center p-8 bg-surface-container rounded-xl">
                    <span class="material-symbols-outlined text-display-lg text-primary mb-6">monitor_heart</span>
                    <h3 class="font-headline-md text-headline-md text-on-surface mb-4">3. Results</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant text-center">Receive a comprehensive report and actionable insights tailored to your unique skin needs.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-24 px-margin-mobile md:px-margin-desktop bg-background">
        <div class="max-w-container-max mx-auto">
            <div class="text-center mb-16">
                <h2 class="font-headline-lg text-headline-lg text-on-surface mb-6">Advanced Technology</h2>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">Discover the features that make MIRROR AI the leader in clinical skin analysis.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="p-8 bg-surface-container-low rounded-xl hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-primary mb-4 text-3xl">wb_sunny</span>
                    <h4 class="font-headline-sm text-headline-md text-on-surface mb-2">UV Visualization</h4>
                    <p class="font-body-md text-body-md text-on-surface-variant">Detect hidden sun damage and analyze sub-surface skin health.</p>
                </div>
                <div class="p-8 bg-surface-container-low rounded-xl hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-primary mb-4 text-3xl">biotech</span>
                    <h4 class="font-headline-sm text-headline-md text-on-surface mb-2">Biometric Tracking</h4>
                    <p class="font-body-md text-body-md text-on-surface-variant">Monitor subtle changes in skin elasticity and composition over time.</p>
                </div>
                <div class="p-8 bg-surface-container-low rounded-xl hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-primary mb-4 text-3xl">video_camera_front</span>
                    <h4 class="font-headline-sm text-headline-md text-on-surface mb-2">Tele-Dermatology Integration</h4>
                    <p class="font-body-md text-body-md text-on-surface-variant">Seamlessly share your results with certified dermatologists.</p>
                </div>
                <div class="p-8 bg-surface-container-low rounded-xl hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-primary mb-4 text-3xl">layers</span>
                    <h4 class="font-headline-sm text-headline-md text-on-surface mb-2">Texture Mapping</h4>
                    <p class="font-body-md text-body-md text-on-surface-variant">3D analysis of pores, wrinkles, and skin roughness.</p>
                </div>
                <div class="p-8 bg-surface-container-low rounded-xl hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-primary mb-4 text-3xl">water_drop</span>
                    <h4 class="font-headline-sm text-headline-md text-on-surface mb-2">Hydration Analysis</h4>
                    <p class="font-body-md text-body-md text-on-surface-variant">Assess skin moisture levels and optimize your skincare routine.</p>
                </div>
                <div class="p-8 bg-surface-container-low rounded-xl hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-primary mb-4 text-3xl">history</span>
                    <h4 class="font-headline-sm text-headline-md text-on-surface mb-2">Clinical History</h4>
                    <p class="font-body-md text-body-md text-on-surface-variant">Keep a detailed record of your skin's progress and treatment efficacy.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- The Science Section -->
    <section class="py-24 px-margin-mobile md:px-margin-desktop bg-surface-container-lowest">
        <div class="max-w-container-max mx-auto flex flex-col md:flex-row items-center gap-16">
            <div class="w-full md:w-1/2">
                <h2 class="font-headline-lg text-headline-lg text-on-surface mb-6">Scientifically Backed Precision</h2>
                <p class="font-body-lg text-body-lg text-on-surface-variant mb-8">Developed in collaboration with leading dermatologists and data scientists, MIRROR AI provides unprecedented accurate and reliable analysis.</p>
                <ul class="space-y-4">
                    <li class="flex items-center">
                        <span class="material-symbols-outlined text-primary mr-4">check_circle</span>
                        <span class="font-body-md text-body-md text-on-surface">Dermatologist Approved</span>
                    </li>
                    <li class="flex items-center">
                        <span class="material-symbols-outlined text-primary mr-4">check_circle</span>
                        <span class="font-body-md text-body-md text-on-surface">Over 98% Detection Accuracy</span>
                    </li>
                    <li class="flex items-center">
                        <span class="material-symbols-outlined text-primary mr-4">check_circle</span>
                        <span class="font-body-md text-body-md text-on-surface">Database of Millions of Images</span>
                    </li>
                </ul>
            </div>
            <div class="w-full md:w-1/2 bg-surface-container h-[400px] rounded-2xl flex items-center justify-center">
                <span class="material-symbols-outlined text-[120px] text-primary/20">biotech</span>
            </div>
        </div>
    </section>
</div>
@endsection
