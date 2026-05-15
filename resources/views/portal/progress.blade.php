@extends('layouts.portal')

@section('title', 'Progress Journey')

@push('styles')
<style>
    .glass-panel {
        background: rgba(26, 28, 34, 0.6);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(201, 230, 255, 0.1);
    }
</style>
@endpush

@section('content')
<main class="flex-1 md:ml-64 pt-24 md:pt-margin-desktop px-margin-mobile md:px-margin-desktop pb-margin-desktop max-w-container-max mx-auto w-full min-h-screen flex flex-col relative z-10">
    <!-- Header -->
    <header class="mb-12">
        <h2 class="font-display-lg text-[2.5rem] md:text-display-lg text-on-surface mb-2">Your Skin Journey</h2>
        <p class="font-body-md text-on-surface-variant max-w-2xl">Track your clinical progress and see the quantitative improvements over time.</p>
    </header>

    @if($analyses->count() < 2)
        <div class="card-bg rounded-xl p-12 text-center border border-outline-variant/20 shadow-[0_0_50px_rgba(154,204,243,0.03)] flex-1 flex flex-col justify-center items-center">
            <span class="material-symbols-outlined text-primary/50 text-6xl mb-4 drop-shadow-[0_0_15px_rgba(154,204,243,0.3)]">timeline</span>
            <h3 class="font-display-lg text-headline-md text-on-surface mb-2">More Data Needed</h3>
            <p class="font-body-md text-on-surface-variant max-w-md mx-auto">Progress tracking requires at least two skin analyses. Perform another scan in a few days to start tracking your journey.</p>
        </div>
    @else
        <!-- Progress Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter flex-1">
            <!-- Left Column: Main Timeline & Concerns -->
            <div class="lg:col-span-2 flex flex-col gap-gutter">
                <!-- Score Timeline Chart Card -->
                <div class="card-bg rounded-xl p-6 md:p-8 flex-1 min-h-[400px] flex flex-col border border-outline-variant/10">
                    <div class="card-content flex flex-col h-full">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="font-body-md text-body-md text-on-surface font-semibold uppercase tracking-wider mb-1">Overall Vitality Score</h3>
                                <p class="font-body-md text-sm text-on-surface-variant">Your Trajectory</p>
                            </div>
                            
                            @php
                                $first = $analyses->first();
                                $last = $analyses->last();
                                
                                $s1 = is_string($first->global_scores) ? json_decode($first->global_scores, true) : $first->global_scores;
                                $s2 = is_string($last->global_scores) ? json_decode($last->global_scores, true) : $last->global_scores;
                                
                                $sc1 = is_array($s1) && count($s1)>0 ? round(array_sum($s1)/count($s1)) : 0;
                                $sc2 = is_array($s2) && count($s2)>0 ? round(array_sum($s2)/count($s2)) : 0;
                                
                                $diff = $sc2 - $sc1;
                            @endphp
                            
                            <div class="flex items-center space-x-2 bg-surface-container px-3 py-1.5 rounded-full border border-primary/20">
                                <span class="material-symbols-outlined text-{{ $diff >= 0 ? 'tertiary' : 'error' }} text-sm">trending_{{ $diff >= 0 ? 'up' : 'down' }}</span>
                                <span class="font-label-sm text-label-sm text-{{ $diff >= 0 ? 'tertiary' : 'error' }}">{{ $diff >= 0 ? '+' : '' }}{{ $diff }}%</span>
                            </div>
                        </div>

                        <!-- Abstract Chart Representation (CSS/HTML only) -->
                        <div class="flex-1 relative mt-4 border-l border-b border-surface-variant/30">
                            <!-- Grid lines -->
                            <div class="absolute inset-0 flex flex-col justify-between pb-6">
                                <div class="w-full h-[1px] bg-white/5"></div>
                                <div class="w-full h-[1px] bg-white/5"></div>
                                <div class="w-full h-[1px] bg-white/5"></div>
                                <div class="w-full h-[1px] bg-white/5"></div>
                                <div class="w-full h-[1px] bg-white/5"></div>
                            </div>
                            <!-- Fake Line (SVG) - For demo, drawing static but beautiful curve -->
                            <svg class="absolute inset-0 w-full h-full pb-6" preserveAspectRatio="none" viewBox="0 0 100 100">
                                <defs>
                                    <linearGradient id="glow-line" x1="0%" x2="100%" y1="0%" y2="0%">
                                        <stop offset="0%" style="stop-color:#c9e6ff;stop-opacity:1"></stop>
                                        <stop offset="100%" style="stop-color:#9cefff;stop-opacity:1"></stop>
                                    </linearGradient>
                                    <linearGradient id="glow-fill" x1="0%" x2="0%" y1="0%" y2="100%">
                                        <stop offset="0%" style="stop-color:#9cefff;stop-opacity:0.2"></stop>
                                        <stop offset="100%" style="stop-color:#9cefff;stop-opacity:0"></stop>
                                    </linearGradient>
                                </defs>
                                <path d="M0,80 Q20,70 40,50 T80,30 T100,20" fill="none" stroke="url(#glow-line)" stroke-width="1.5"></path>
                                <path d="M0,80 L0,100 L100,100 L100,20 Q80,30 40,50 T0,80 Z" fill="url(#glow-fill)"></path>
                                <!-- Markers -->
                                <circle cx="0" cy="80" fill="#111318" r="2" stroke="#c9e6ff" stroke-width="1"></circle>
                                <circle cx="40" cy="50" fill="#111318" r="2" stroke="#9accf3" stroke-width="1"></circle>
                                <circle cx="80" cy="30" fill="#111318" r="2" stroke="#9cefff" stroke-width="1"></circle>
                                <circle cx="100" cy="20" fill="#9cefff" r="3" style="filter: drop-shadow(0 0 4px #9cefff);"></circle>
                            </svg>
                            <!-- X Axis Labels -->
                            <div class="absolute bottom-0 left-0 w-full flex justify-between text-xs text-on-surface-variant font-body-md translate-y-full pt-2">
                                <span>{{ $analyses->first()->created_at->format('M d') }}</span>
                                <span></span>
                                <span></span>
                                <span>{{ $analyses->last()->created_at->format('M d') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Concerns Frequency -->
                <div class="card-bg rounded-xl p-6 border border-outline-variant/10">
                    <div class="card-content">
                        <h3 class="font-body-md text-body-md text-on-surface font-semibold uppercase tracking-wider mb-6">Key Metric Changes</h3>
                        <div class="space-y-4">
                            @if(is_array($s1) && is_array($s2))
                                @foreach($s1 as $k => $v1)
                                    @if(isset($s2[$k]))
                                        @php
                                            $diffKey = $s2[$k] - $v1;
                                            $percentWidth = min(100, max(0, $s2[$k]));
                                            
                                            // Assign color
                                            $barColor = match($loop->index % 3) {
                                                0 => 'bg-primary',
                                                1 => 'bg-secondary',
                                                default => 'bg-tertiary',
                                            };
                                        @endphp
                                        <div>
                                            <div class="flex justify-between text-sm mb-1 font-body-md text-on-surface-variant">
                                                <span>{{ ucfirst(str_replace('_', ' ', $k)) }}</span>
                                                <span class="text-{{ $diffKey >= 0 ? 'tertiary' : 'error' }}">{{ $diffKey >= 0 ? '+' : '' }}{{ $diffKey }}%</span>
                                            </div>
                                            <div class="h-2 w-full bg-surface-container rounded-full overflow-hidden">
                                                <div class="h-full {{ $barColor }}" style="width: {{ $percentWidth }}%;"></div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Metrics & Before/After -->
            <div class="flex flex-col gap-gutter">
                <!-- Metric Grids (Bento style) -->
                <div class="grid grid-cols-2 gap-4">
                    @if(is_array($s2))
                        @php $keys = array_keys($s2); @endphp
                        
                        @if(isset($keys[0]))
                        <div class="card-bg rounded-xl p-4 flex flex-col justify-between aspect-square border border-outline-variant/10">
                            <div class="card-content">
                                <span class="material-symbols-outlined text-primary mb-2">water_drop</span>
                                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase">{{ str_replace('_', ' ', $keys[0]) }}</p>
                                <p class="font-display-lg text-[2.5rem] leading-none text-on-surface mt-2">{{ $s2[$keys[0]] }}<span class="text-sm font-body-md text-on-surface-variant">/100</span></p>
                            </div>
                        </div>
                        @endif
                        
                        @if(isset($keys[1]))
                        <div class="card-bg rounded-xl p-4 flex flex-col justify-between aspect-square border border-outline-variant/10">
                            <div class="card-content">
                                <span class="material-symbols-outlined text-secondary mb-2">brightness_7</span>
                                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase">{{ str_replace('_', ' ', $keys[1]) }}</p>
                                <p class="font-display-lg text-[2.5rem] leading-none text-on-surface mt-2">{{ $s2[$keys[1]] }}<span class="text-sm font-body-md text-on-surface-variant">/100</span></p>
                            </div>
                        </div>
                        @endif
                        
                        @if(isset($keys[2]))
                        <div class="card-bg rounded-xl p-4 flex flex-col justify-between aspect-square border border-outline-variant/10">
                            <div class="card-content">
                                <span class="material-symbols-outlined text-tertiary mb-2">texture</span>
                                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase">{{ str_replace('_', ' ', $keys[2]) }}</p>
                                <p class="font-display-lg text-[2.5rem] leading-none text-on-surface mt-2">{{ $s2[$keys[2]] }}<span class="text-sm font-body-md text-on-surface-variant">/100</span></p>
                            </div>
                        </div>
                        @endif
                        
                        @if(isset($keys[3]))
                        <div class="card-bg rounded-xl p-4 flex flex-col justify-between aspect-square border border-outline-variant/10">
                            <div class="card-content">
                                <span class="material-symbols-outlined text-primary-fixed-dim mb-2">lens_blur</span>
                                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase">{{ str_replace('_', ' ', $keys[3]) }}</p>
                                <p class="font-display-lg text-[2.5rem] leading-none text-on-surface mt-2">{{ $s2[$keys[3]] }}<span class="text-sm font-body-md text-on-surface-variant">/100</span></p>
                            </div>
                        </div>
                        @endif
                    @endif
                </div>

                <!-- Before/After Card -->
                <div class="card-bg rounded-xl p-6 flex-1 flex flex-col border border-outline-variant/10">
                    <div class="card-content flex flex-col h-full">
                        <h3 class="font-body-md text-body-md text-on-surface font-semibold uppercase tracking-wider mb-4">Evolution</h3>
                        <div class="flex-1 flex flex-col space-y-4">
                            <!-- Oldest Scan -->
                            <div class="relative group overflow-hidden rounded-lg border border-surface-variant/50 bg-black/50">
                                <img alt="Initial Scan" class="w-full h-32 object-cover opacity-60 grayscale group-hover:grayscale-0 transition-all duration-500" src="{{ asset('storage/' . $analyses->first()->image_path) }}"/>
                                <div class="absolute bottom-2 left-2 glass-panel px-2 py-1 rounded text-xs font-label-sm text-on-surface">{{ $analyses->first()->created_at->format('M d') }}</div>
                            </div>
                            
                            <!-- Delta Arrow -->
                            <div class="flex justify-center -my-2 relative z-10">
                                <div class="bg-surface-container rounded-full p-1 border border-primary/20 shadow-[0_0_10px_rgba(201,230,255,0.2)]">
                                    <span class="material-symbols-outlined text-primary text-sm">arrow_downward</span>
                                </div>
                            </div>
                            
                            <!-- Latest Scan -->
                            <div class="relative group overflow-hidden rounded-lg border {{ $diff >= 0 ? 'border-tertiary/40 shadow-[0_0_20px_rgba(156,239,255,0.15)]' : 'border-outline-variant/30' }} bg-black/50">
                                <img alt="Latest Scan" class="w-full h-32 object-cover" src="{{ asset('storage/' . $analyses->last()->image_path) }}"/>
                                <div class="absolute bottom-2 left-2 glass-panel px-2 py-1 rounded text-xs font-label-sm text-tertiary border border-tertiary/30">{{ $analyses->last()->created_at->format('M d') }}</div>
                                
                                @if($diff >= 0)
                                <div class="absolute top-2 right-2 glass-panel px-2 py-1 rounded-full text-xs font-label-sm text-tertiary flex items-center space-x-1 border border-tertiary/30">
                                    <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                    <span>Improved</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</main>
@endsection
