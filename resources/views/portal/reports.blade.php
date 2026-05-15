@extends('layouts.portal')

@section('title', 'My Reports')

@section('content')
<main class="flex-1 md:ml-64 pt-20 md:pt-10 px-margin-mobile md:px-margin-desktop pb-20 overflow-y-auto w-full">
    <!-- Header & Filters -->
    <div class="max-w-container-max mx-auto mb-10">
        <h2 class="font-display-lg text-display-lg text-on-surface mb-2 tracking-tight">My Reports</h2>
        <p class="font-body-md text-body-md text-on-surface-variant mb-8">Clinical analysis history and detailed assessments.</p>
        
        <div class="flex flex-col md:flex-row gap-4 mb-8">
            <!-- Filter: Date -->
            <div class="flex-1 bg-transparent border border-outline-variant/30 rounded-lg p-2 flex items-center px-4">
                <span class="material-symbols-outlined text-primary mr-3">calendar_month</span>
                <select class="bg-transparent text-on-surface border-none focus:ring-0 w-full font-label-sm uppercase tracking-wider appearance-none cursor-pointer">
                    <option value="all">All Dates</option>
                    <option value="last30">Last 30 Days</option>
                    <option value="last90">Last 90 Days</option>
                </select>
            </div>
            <!-- Filter: Location -->
            <div class="flex-1 bg-transparent border border-outline-variant/30 rounded-lg p-2 flex items-center px-4">
                <span class="material-symbols-outlined text-primary mr-3">location_on</span>
                <select class="bg-transparent text-on-surface border-none focus:ring-0 w-full font-label-sm uppercase tracking-wider appearance-none cursor-pointer">
                    <option value="all">All Locations</option>
                    <option value="online">Online Analysis</option>
                    <option value="clinic">In-Clinic</option>
                </select>
            </div>
        </div>
    </div>

    @if($analyses->isEmpty())
        <div class="max-w-container-max mx-auto text-center py-20 bg-surface-container-low rounded-xl border border-outline-variant/15">
            <span class="material-symbols-outlined text-primary/30 text-6xl mb-4">document_scanner</span>
            <h3 class="font-display-lg text-headline-sm text-on-surface mb-2">No Reports Yet</h3>
            <p class="font-body-md text-on-surface-variant">Perform a skin analysis on the main screen to generate your first report.</p>
        </div>
    @else
        <!-- Report Cards Grid (Bento Style) -->
        <div class="max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($analyses as $an)
                @php
                    $s = is_string($an->global_scores) ? json_decode($an->global_scores, true) : $an->global_scores;
                    $sc = 0;
                    if(is_array($s) && count($s) > 0) $sc = round(array_sum($s)/count($s));
                    
                    $primaryConcern = 'None';
                    if(is_array($s) && count($s) > 0) {
                        asort($s);
                        $lowestKeys = array_keys($s);
                        $primaryConcern = ucfirst(str_replace('_', ' ', $lowestKeys[0]));
                    }
                @endphp
                <div class="bg-surface-container-low rounded-xl p-6 flex flex-col relative overflow-hidden group border border-outline-variant/20 hover:border-primary/50 transition-colors">
                    <div class="flex justify-between items-start mb-6 z-10">
                        <div>
                            <p class="font-label-sm text-primary mb-1 uppercase tracking-widest">{{ $an->created_at->format('M d, Y • h:i A') }}</p>
                            <h3 class="font-headline-sm text-headline-sm text-on-surface">Digital Analysis</h3>
                        </div>
                        <div class="{{ $loop->first ? 'bg-primary/20 text-primary border border-primary/40' : 'bg-surface-container-high text-on-surface border border-primary/20' }} px-3 py-1 rounded-full flex items-center">
                            <span class="font-label-sm font-bold">{{ $sc }}</span>
                            <span class="material-symbols-outlined ml-1 text-sm">{{ $loop->first ? 'verified' : 'analytics' }}</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6 z-10">
                        <div class="bg-surface-container rounded-lg p-3">
                            <p class="font-label-sm text-on-surface-variant mb-1">SKIN TYPE</p>
                            <p class="font-body-md text-on-surface font-semibold">{{ $an->detected_skin_type ?? 'Unknown' }}</p>
                        </div>
                        <div class="bg-surface-container rounded-lg p-3">
                            <p class="font-label-sm text-on-surface-variant mb-1">PRIMARY CONCERN</p>
                            <p class="font-body-md text-on-surface font-semibold">{{ $primaryConcern }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-auto z-10">
                        <button onclick="document.getElementById('detail-{{ $an->id }}').scrollIntoView({behavior: 'smooth'})" class="w-full bg-transparent border border-primary/30 text-primary font-label-sm py-3 rounded-lg uppercase tracking-wider hover:bg-primary/10 transition-colors flex justify-center items-center">
                            <span>View Details</span>
                            <span class="material-symbols-outlined ml-2 text-sm">arrow_downward</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        @foreach($analyses as $an)
            @php
                $s = is_string($an->global_scores) ? json_decode($an->global_scores, true) : $an->global_scores;
                $sc = 0;
                if(is_array($s) && count($s) > 0) $sc = round(array_sum($s)/count($s));
            @endphp
            <!-- Detail View -->
            <div id="detail-{{ $an->id }}" class="max-w-container-max mx-auto mt-16 bg-surface-container-low rounded-2xl overflow-hidden border border-outline-variant/20 mb-16">
                <div class="flex flex-col lg:flex-row">
                    <!-- Left: Visual/Photo -->
                    <div class="lg:w-2/5 relative bg-surface-container-lowest border-r border-surface-variant/30">
                        <div class="aspect-[3/4] w-full relative">
                            <img alt="Detailed Facial Scan" class="w-full h-full object-cover opacity-80 mix-blend-luminosity" src="{{ asset('storage/' . $an->image_path) }}"/>
                            <div class="absolute inset-0 scanning-overlay pointer-events-none"></div>
                            
                            <!-- Overlay UI elements -->
                            <div class="absolute inset-0 border-[2px] border-primary/20 m-4 rounded-xl pointer-events-none flex flex-col justify-between p-4">
                                <div class="flex justify-between items-start">
                                    <span class="material-symbols-outlined text-primary">target</span>
                                    <div class="bg-black/50 backdrop-blur-md px-3 py-1 rounded-sm border border-primary/30">
                                        <span class="font-label-sm text-primary">SCAN COMPLETE</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-end">
                                    <div class="w-16 h-16 border border-primary/50 rounded-full flex items-center justify-center backdrop-blur-sm bg-black/20">
                                        <span class="font-headline-sm text-primary font-semibold">{{ $sc }}</span>
                                    </div>
                                    <span class="material-symbols-outlined text-primary">qr_code_scanner</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right: Clinical Data -->
                    <div class="lg:w-3/5 p-8 lg:p-12 flex flex-col justify-center">
                        <div class="mb-8">
                            <p class="font-label-sm text-primary mb-2 uppercase tracking-widest">{{ $an->created_at->format('M d, Y') }}</p>
                            <h2 class="font-headline-sm text-display-lg text-on-surface mb-4">Comprehensive Analysis</h2>
                            <p class="font-body-md text-on-surface-variant max-w-2xl">{{ $an->summary }}</p>
                        </div>
                        
                        <!-- Metrics Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                            @if(is_array($s))
                                @foreach($s as $key => $score)
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <span class="font-label-sm text-on-surface uppercase tracking-wider">{{ str_replace('_', ' ', $key) }}</span>
                                            <span class="font-headline-sm {{ $score > 80 ? 'text-primary' : 'text-secondary' }}">{{ $score }}%</span>
                                        </div>
                                        <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden">
                                            <div class="{{ $score > 80 ? 'bg-primary' : 'bg-secondary' }} h-full rounded-full" style="width: {{ $score }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        
                        <!-- AI Concerns Data -->
                        <div class="mt-auto">
                            <h4 class="font-label-sm text-on-surface uppercase tracking-widest mb-4 border-b border-surface-variant/30 pb-2">Clinical Observations</h4>
                            
                            @php
                                $concerns = is_string($an->detected_concerns) ? json_decode($an->detected_concerns, true) : $an->detected_concerns;
                            @endphp
                            
                            @if($concerns)
                                @foreach($concerns as $cKey => $cData)
                                    @if(is_array($cData) && isset($cData['detected']) && $cData['detected'])
                                        <div class="flex items-center justify-between p-4 bg-surface-container rounded-lg mb-2 border border-outline-variant/10">
                                            <div class="flex items-start">
                                                <span class="material-symbols-outlined text-primary mr-4 mt-1">warning</span>
                                                <div>
                                                    <p class="font-body-md text-on-surface font-semibold">{{ ucfirst(str_replace('_', ' ', $cKey)) }}</p>
                                                    <p class="font-label-sm text-on-surface-variant">{{ $cData['specific_observations'] ?? $cData['clinical_description'] ?? 'Detected issue' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</main>
@endsection
