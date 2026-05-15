@extends('layouts.portal')

@section('title', 'Overview')

@section('content')
<main class="flex-1 md:ml-64 pt-24 md:pt-margin-desktop px-margin-mobile md:px-margin-desktop pb-24 md:pb-margin-desktop max-w-container-max mx-auto w-full relative z-10">
    <!-- Header -->
    <header class="mb-12">
        <h2 class="font-display-lg text-headline-lg md:text-display-lg text-on-surface mb-2 tracking-tight">Good {{ date('a') == 'am' ? 'morning' : 'evening' }}, {{ auth()->user()->name }}</h2>
        <p class="font-body-md text-on-surface-variant text-body-lg">Here is your clinical intelligence overview for today.</p>
    </header>

    @if($analyses->isEmpty())
        <div class="clinical-card p-12 text-center border border-outline-variant/20 shadow-[0_0_50px_rgba(154,204,243,0.03)]">
            <span class="material-symbols-outlined text-primary/50 text-6xl mb-4 drop-shadow-[0_0_15px_rgba(154,204,243,0.3)]">medical_information</span>
            <h3 class="font-display-lg text-headline-md text-on-surface mb-2">No Clinical Data Found</h3>
            <p class="font-body-md text-on-surface-variant max-w-md mx-auto mb-8">You haven't completed any skin analyses yet. Use the MIRROR AI device to perform your first scan.</p>
        </div>
    @else
        <!-- Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="clinical-card p-6 flex flex-col justify-between border border-outline-variant/10">
                <span class="font-label-sm text-on-surface-variant uppercase tracking-widest mb-4">Total Analyses</span>
                <div class="flex items-end justify-between">
                    <span class="font-display-lg text-headline-lg text-primary drop-shadow-[0_0_12px_rgba(242,202,80,0.4)]">{{ $analyses->count() }}</span>
                    <span class="material-symbols-outlined text-primary/50 text-3xl">analytics</span>
                </div>
            </div>
            
            @php
                $avgScore = 0;
                $primaryConcern = 'None';
                if ($latestAnalysis && $latestAnalysis->global_scores) {
                    $scores = is_string($latestAnalysis->global_scores) ? json_decode($latestAnalysis->global_scores, true) : $latestAnalysis->global_scores;
                    if(is_array($scores) && count($scores) > 0) {
                        $avgScore = round(array_sum($scores) / count($scores));
                        asort($scores);
                        $lowestKeys = array_keys($scores);
                        $primaryConcern = ucfirst(str_replace('_', ' ', $lowestKeys[0]));
                    }
                }
                
                $daysSince = 0;
                if ($analyses->last()) {
                    $daysSince = $analyses->last()->created_at->diffInDays(now());
                }
            @endphp
            
            <div class="clinical-card p-6 flex flex-col justify-between border border-outline-variant/10">
                <span class="font-label-sm text-on-surface-variant uppercase tracking-widest mb-4">Skin Score</span>
                <div class="flex items-end justify-between">
                    <span class="font-display-lg text-headline-lg text-primary drop-shadow-[0_0_12px_rgba(242,202,80,0.4)]">{{ $avgScore }}<span class="font-body-md text-body-lg text-on-surface-variant ml-1 drop-shadow-none">/100</span></span>
                    <span class="material-symbols-outlined text-primary/50 text-3xl">verified</span>
                </div>
            </div>
            
            <div class="clinical-card p-6 flex flex-col justify-between border border-outline-variant/10">
                <span class="font-label-sm text-on-surface-variant uppercase tracking-widest mb-4">Primary Concern</span>
                <div class="flex items-end justify-between">
                    <span class="font-display-lg text-headline-md text-primary truncate drop-shadow-[0_0_12px_rgba(242,202,80,0.4)] max-w-[70%]">{{ $primaryConcern }}</span>
                    <span class="material-symbols-outlined text-primary/50 text-3xl">water_drop</span>
                </div>
            </div>
            
            <div class="clinical-card p-6 flex flex-col justify-between border border-outline-variant/10">
                <span class="font-label-sm text-on-surface-variant uppercase tracking-widest mb-4">Days Since First Scan</span>
                <div class="flex items-end justify-between">
                    <span class="font-display-lg text-headline-lg text-primary drop-shadow-[0_0_12px_rgba(242,202,80,0.4)]">{{ $daysSince }}</span>
                    <span class="material-symbols-outlined text-primary/50 text-3xl">calendar_today</span>
                </div>
            </div>
        </div>

        <!-- Bento Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
            <!-- Latest Analysis Card (Spans 2 cols on LG) -->
            <div class="clinical-card p-8 lg:col-span-2 flex flex-col border border-outline-variant/10">
                <div class="flex justify-between items-center mb-8 border-b border-outline-variant/15 pb-4">
                    <h3 class="font-display-lg text-headline-md text-on-surface">Latest Analysis</h3>
                    <span class="font-label-sm text-on-surface-variant">{{ $latestAnalysis->created_at->format('M d, Y') }}</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 flex-1">
                    <div class="space-y-6">
                        @if($latestAnalysis->global_scores)
                            @php $scores = is_string($latestAnalysis->global_scores) ? json_decode($latestAnalysis->global_scores, true) : $latestAnalysis->global_scores; @endphp
                            @foreach(['radiance', 'hydration', 'smoothness', 'pore_clarity'] as $key)
                                @if(isset($scores[$key]))
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="font-label-sm text-on-surface uppercase">{{ str_replace('_', ' ', $key) }}</span>
                                        <span class="font-display-lg text-label-sm text-primary">{{ $scores[$key] }}%</span>
                                    </div>
                                    <div class="h-1.5 w-full bg-surface-container-highest rounded-full overflow-hidden">
                                        <div class="h-full {{ $loop->index % 2 == 0 ? 'bg-primary shadow-[0_0_10px_rgba(242,202,80,0.5)]' : 'bg-primary/70 shadow-[0_0_10px_rgba(242,202,80,0.3)]' }}" style="width: {{ $scores[$key] }}%"></div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    
                    <div class="flex flex-col justify-center md:border-l border-outline-variant/15 md:pl-8">
                        <h4 class="font-label-sm text-on-surface-variant uppercase tracking-widest mb-4">Detected Concerns</h4>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $concerns = is_string($latestAnalysis->detected_concerns) ? json_decode($latestAnalysis->detected_concerns, true) : $latestAnalysis->detected_concerns;
                                $hasActiveConcerns = false;
                            @endphp
                            @if($concerns)
                                @foreach($concerns as $k => $c)
                                    @if(is_array($c) && isset($c['detected']) && $c['detected'])
                                        @php $hasActiveConcerns = true; @endphp
                                        <span class="px-4 py-2 rounded-full font-label-sm {{ $loop->index % 2 == 0 ? 'text-background bg-primary shadow-[0_0_15px_rgba(242,202,80,0.3)]' : 'text-primary bg-primary/10 border border-primary/30 shadow-[0_0_15px_rgba(242,202,80,0.1)]' }}">{{ ucfirst(str_replace('_', ' ', $k)) }}</span>
                                    @endif
                                @endforeach
                            @endif
                            
                            @if(!$hasActiveConcerns)
                                <span class="px-4 py-2 border border-outline-variant/30 rounded-full font-label-sm text-on-surface-variant">None Detected</span>
                            @endif
                        </div>
                        
                        <a href="{{ route('portal.reports') }}" class="mt-8 self-start px-8 py-3 bg-primary/10 text-primary font-label-sm uppercase tracking-wider rounded-full transition-all hover:bg-primary/20 hover:shadow-[0_0_20px_rgba(154,204,243,0.2)]">View Full Report</a>
                    </div>
                </div>
            </div>
            
            <!-- Recent Analyses List -->
            <div class="clinical-card p-8 flex flex-col border border-outline-variant/10">
                <h3 class="font-display-lg text-headline-md text-on-surface mb-6 border-b border-outline-variant/15 pb-4">Recent Scans</h3>
                <div class="space-y-2 flex-1">
                    @foreach($analyses->take(3) as $an)
                        @php
                            $s = is_string($an->global_scores) ? json_decode($an->global_scores, true) : $an->global_scores;
                            $sc = 0;
                            if(is_array($s) && count($s) > 0) $sc = round(array_sum($s)/count($s));
                        @endphp
                        <a href="{{ route('portal.reports') }}" class="flex justify-between items-center p-4 hover:bg-surface-variant/30 rounded-xl transition-colors cursor-pointer group border border-transparent hover:border-outline-variant/20">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:shadow-[0_0_15px_rgba(242,202,80,0.3)] transition-all">
                                    <span class="material-symbols-outlined text-sm">face</span>
                                </div>
                                <div>
                                    <p class="font-body-md text-on-surface">{{ $an->created_at->format('M d, Y') }}</p>
                                    <p class="font-label-sm text-on-surface-variant">Score: {{ $sc }}</p>
                                </div>
                            </div>
                            <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary transition-colors">chevron_right</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recommendations Section -->
        <section>
            <div class="flex justify-between items-end mb-8 border-b border-outline-variant/15 pb-4">
                <h3 class="font-display-lg text-headline-md text-on-surface">Targeted Recommendations</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Product Card 1 -->
                <div class="clinical-card overflow-hidden flex flex-col group border border-outline-variant/10">
                    <div class="h-48 relative bg-surface-container-high/50 flex items-center justify-center overflow-hidden p-6 mix-blend-luminosity opacity-80 group-hover:opacity-100 transition-opacity">
                        <div class="absolute top-4 right-4 bg-surface/60 backdrop-blur-md px-3 py-1.5 rounded-full z-10 border border-outline-variant/20">
                            <span class="font-display-lg text-label-sm text-tertiary-container">98% Match</span>
                        </div>
                        <img alt="Hyaluronic Acid Serum" class="object-contain h-full w-full group-hover:scale-105 transition-transform duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBmL4VJ__dhwnmXxMP0zQoU4WQs5SxQyFKfWqXGSfl_o18x2iEObxI78QUI2reXmT_OaC0M4InrGfDNdjzJSCF964qPaG989cfBPPyvuDkA6OQm1BA2GHYa9NxQlgy6AxFoUkq36g4DdeMUemKbyzGb0TezMw-jGGZxjB4OM-A5SkXdacIYN6aPiFOntF_SBQuETp5EMbxasLWR4pz1ISsKUVq4goI6mB1S1wrPAdGMDlKHC7ixXGsErY7usrKsiWW4y90xG4U9XMI"/>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h4 class="font-display-lg text-body-lg text-on-surface mb-2">Advanced Hydration Serum</h4>
                        <p class="font-label-sm text-on-surface-variant mb-6 flex-1">Addresses primary concern: {{ $primaryConcern }}</p>
                        <button class="w-full py-3 bg-primary/5 border border-primary/20 text-primary font-label-sm uppercase tracking-wider rounded-full hover:bg-primary/15 transition-colors">Add to Routine</button>
                    </div>
                </div>
                
                <!-- Product Card 2 -->
                <div class="clinical-card overflow-hidden flex flex-col group border border-outline-variant/10">
                    <div class="h-48 relative bg-surface-container-high/50 flex items-center justify-center overflow-hidden p-6 mix-blend-luminosity opacity-80 group-hover:opacity-100 transition-opacity">
                        <div class="absolute top-4 right-4 bg-surface/60 backdrop-blur-md px-3 py-1.5 rounded-full z-10 border border-outline-variant/20">
                            <span class="font-display-lg text-label-sm text-tertiary-container">92% Match</span>
                        </div>
                        <img alt="Barrier Repair Cream" class="object-contain h-full w-full group-hover:scale-105 transition-transform duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB2M1oZIbkI9kzJohdpXLizEihrwCtZGsoVXLrDDTKMeenutKlkhRAjZuTuFsEXxbYJkIG8rcKEnM-wlejz0DJgHnFhgtQW5P4qVkccFyG9doslmXFOAeauOBX1EsF5NVvzPOxCyW08vXhLyeyhuN6kg0c98lcxAjpmJteiMDamhfaCY-OL5hk5nkS8n0nz-7PIKp714U42fkGR3f6NwAUWiMQDL_rmhQdx7AcZE497P4aKSVWU-ERBkWjYdn1vNZe9TGOhMKS5uWo"/>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h4 class="font-display-lg text-body-lg text-on-surface mb-2">Barrier Repair Complex</h4>
                        <p class="font-label-sm text-on-surface-variant mb-6 flex-1">Addresses concern: Sensitive Skin</p>
                        <button class="w-full py-3 bg-primary/5 border border-primary/20 text-primary font-label-sm uppercase tracking-wider rounded-full hover:bg-primary/15 transition-colors">Add to Routine</button>
                    </div>
                </div>
                
                <!-- Product Card 3 -->
                <div class="clinical-card overflow-hidden flex flex-col group border border-outline-variant/10">
                    <div class="h-48 relative bg-surface-container-high/50 flex items-center justify-center overflow-hidden p-6 mix-blend-luminosity opacity-80 group-hover:opacity-100 transition-opacity">
                        <div class="absolute top-4 right-4 bg-surface/60 backdrop-blur-md px-3 py-1.5 rounded-full z-10 border border-outline-variant/20">
                            <span class="font-display-lg text-label-sm text-tertiary-container">85% Match</span>
                        </div>
                        <img alt="Exfoliating Treatment" class="object-contain h-full w-full group-hover:scale-105 transition-transform duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDKgzi7A54xh4-bPUW7I1lwxpy_x5bSe3VwJs8hhdyAn04f0W0wUOPfMWMRten7gd4mnjI4GMJdDqx3yHnI81ddplQSswMk53mg1n0VVcAzWDiDyuYlmVG0DSNwetV2xrazsl9E1MDrZ_ELxaPtd2_EwUaCTPaDELAo_0YYW7uyhxoVgRw_04ssdCdtpXKUhCxCd_iy4BR9vfBxkv6HGUl8LMqvqw3xapgSP5Suc84nGJfD-cVUZPJP77pPHVOlmTO-mRBX6WBxV-M"/>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h4 class="font-display-lg text-body-lg text-on-surface mb-2">Cellular Turn-Over Liquid</h4>
                        <p class="font-label-sm text-on-surface-variant mb-6 flex-1">Maintenance for: Texture Refinement</p>
                        <button class="w-full py-3 bg-primary/5 border border-primary/20 text-primary font-label-sm uppercase tracking-wider rounded-full hover:bg-primary/15 transition-colors">Add to Routine</button>
                    </div>
                </div>
            </div>
        </section>
    @endif
</main>
@endsection
