@extends('layouts.main')

@section('title', 'About Project')

@section('styles')
    .member-card {
        min-height: 400px;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .member-card:hover {
        transform: translateY(-12px) scale(1.02);
        border-color: rgba(242, 202, 80, 0.4);
        box-shadow: 0 20px 40px rgba(0,0,0,0.6);
    }
    .image-placeholder {
        background: linear-gradient(135deg, rgba(242, 202, 80, 0.05) 0%, rgba(20, 20, 20, 0.8) 100%);
        border: 1px solid rgba(242, 202, 80, 0.1);
    }
@endsection

@section('content')
<div class="pt-32 relative z-10">
    <!-- Hero Section -->
    <section class="py-20 px-margin-mobile md:px-margin-desktop text-center">
        <div class="max-w-4xl mx-auto">
            <img src="/images/tech_storm_logo.png" alt="Tech Storm Logo" class="w-48 h-48 mx-auto mb-10 drop-shadow-[0_0_50px_rgba(242,202,80,0.3)]">
            <h1 class="font-display-lg text-display-lg text-on-surface mb-6">TECH_<span class="text-primary italic">STORM</span></h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto leading-relaxed">Innovation developed with clinical precision at <span class="text-primary">Burg Al Arab Technological University</span>.</p>
        </div>
    </section>

    <!-- Supervisors Section -->
    <section class="py-24 px-margin-mobile md:px-margin-desktop bg-surface-container-lowest border-y border-primary/5">
        <div class="max-w-container-max mx-auto">
            <h2 class="font-headline-lg text-headline-lg text-on-surface mb-20 text-center">Project Supervision</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-5xl mx-auto">
                <!-- Supervisor Card 1 -->
                <div class="flex flex-col bg-surface-container rounded-3xl border border-primary/10 overflow-hidden group hover:border-primary/30 transition-all">
                    <div class="h-80 w-full image-placeholder relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center opacity-20 group-hover:opacity-40 transition-opacity">
                            <span class="material-symbols-outlined text-[100px]">person</span>
                        </div>
                        <img src="#" alt="Eng. Ragab Hassan" class="w-full h-full object-cover hidden"> 
                    </div>
                    <div class="p-10 text-center">
                        <h3 class="font-headline-md text-3xl text-on-surface mb-2">Eng. Ragab Hassan</h3>
                        <p class="font-label-sm text-label-sm text-primary uppercase tracking-[0.2em] font-bold">Project Supervisor</p>
                    </div>
                </div>
                <!-- Supervisor Card 2 -->
                <div class="flex flex-col bg-surface-container rounded-3xl border border-primary/10 overflow-hidden group hover:border-primary/30 transition-all">
                    <div class="h-80 w-full image-placeholder relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center opacity-20 group-hover:opacity-40 transition-opacity">
                            <span class="material-symbols-outlined text-[100px]">person</span>
                        </div>
                        <img src="#" alt="Dr. Heimen" class="w-full h-full object-cover hidden">
                    </div>
                    <div class="p-10 text-center">
                        <h3 class="font-headline-md text-3xl text-on-surface mb-2">Dr.Hayman EL-Sayed</h3>
                        <p class="font-label-sm text-label-sm text-primary uppercase tracking-[0.2em] font-bold">Academic Supervisor</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Leader Section -->
    <section class="py-24 px-margin-mobile md:px-margin-desktop bg-background">
        <div class="max-w-container-max mx-auto text-center">
            <h2 class="font-headline-lg text-headline-lg text-on-surface mb-16">The Project Leader</h2>
            <div class="max-w-md mx-auto bg-surface-container rounded-3xl border border-primary/30 overflow-hidden group hover:shadow-[0_0_50px_rgba(242,202,80,0.1)] transition-all">
                <div class="h-96 w-full image-placeholder relative overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center opacity-30 group-hover:opacity-50 transition-opacity">
                        <span class="material-symbols-outlined text-[120px] text-primary">workspace_premium</span>
                    </div>
                    <img src="#" alt="Mostafa_Hosny" class="w-full h-full object-cover hidden">
                </div>
                <div class="p-10">
                    <h3 class="font-headline-md text-3xl text-on-surface mb-2">Mostafa_Hosny</h3>
                    <p class="font-label-sm text-label-sm text-primary uppercase tracking-widest font-bold">Chief Architect & Manager & Hardware and Front End Manager</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Members Grid -->
    <section class="py-24 px-margin-mobile md:px-margin-desktop bg-surface-container-lowest">
        <div class="max-w-container-max mx-auto">
            
            <!-- Category: Hardware -->
            <div class="mb-32">
                <h2 class="font-headline-lg text-headline-lg text-primary mb-12 border-b border-primary/20 pb-6 uppercase tracking-widest text-center">Hardware Team</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">memory</span></div><img src="#" alt="Mohamed Magdy" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Mohamed Magdy</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Hardware</p>
                        </div>
                    </div>
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">memory</span></div><img src="#" alt="Abdlla Medhat" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Abdlla Medhat</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Hardware</p>
                        </div>
                    </div>
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">memory</span></div><img src="#" alt="shehab Mohamed" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">shehab Mohamed</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Hardware</p>
                        </div>
                    </div>
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">memory</span></div><img src="#" alt="Mohamed Elsayed" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Mohamed Elsayed</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Hardware & Frontend</p>
                        </div>
                    </div>
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">memory</span></div><img src="#" alt="Adel Mohamed Mohamed" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Adel Mohamed Mohamed</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Software & Hardware</p>
                        </div>
                    </div>
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">memory</span></div><img src="#" alt="Mahmoud yousef" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Mahmoud yousef</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Hardware & Front End</p>
                        </div>
                    </div>
                    <!-- Repeated from Light Task -->
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">memory</span></div><img src="#" alt="Tasnem Ashraf" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Tasnem Ashraf</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Hardware & Lighting task</p>
                        </div>
                    </div>
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">memory</span></div><img src="#" alt="Maram Mohamed Foad" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Maram Mohamed Foad</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Hardware & lighting task</p>
                        </div>
                    </div>
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">memory</span></div><img src="#" alt="Mariam Walied" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Mariam Walied</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Hardware & Lighting task</p>
                        </div>
                    </div>
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">memory</span></div><img src="#" alt="Mariam Mohamed Omran" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Mariam Mohamed Omran</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">hardware & lighting task</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category: Software -->
            <div class="mb-32">
                <h2 class="font-headline-lg text-headline-lg text-primary mb-12 border-b border-primary/20 pb-6 uppercase tracking-widest text-center">Software Team</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">code</span></div><img src="#" alt="Abdul Majeed Saber" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Abdul Majeed Saber</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Software Manager</p>
                        </div>
                    </div>
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">code</span></div><img src="#" alt="Ziad Samy" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Ziad Samy</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Software (Back-end)</p>
                        </div>
                    </div>
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">palette</span></div><img src="#" alt="Abdulrahman Mohamed Talat" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Abdulrahman Mohamed Talat</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">UX/UI Task</p>
                        </div>
                    </div>
                    <!-- Repeated from Hardware -->
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">code</span></div><img src="#" alt="Mohamed Elsayed" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Mohamed Elsayed</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Hardware & Frontend</p>
                        </div>
                    </div>
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">code</span></div><img src="#" alt="Adel Mohamed Mohamed" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Adel Mohamed Mohamed</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Software & Hardware</p>
                        </div>
                    </div>
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">code</span></div><img src="#" alt="Mahmoud yousef" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Mahmoud yousef</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Hardware & Front End</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category: Light Task -->
            <div class="mb-32">
                <h2 class="font-headline-lg text-headline-lg text-primary mb-12 border-b border-primary/20 pb-6 uppercase tracking-widest text-center">Light Task Team</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">lightbulb</span></div><img src="#" alt="Maram Mohamed Abbass" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Maram Mohamed Abbass</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Light Task Manager & Hardware Member</p>
                        </div>
                    </div>
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">lightbulb</span></div><img src="#" alt="Hana Hytham" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Hana Hytham</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Light Task</p>
                        </div>
                    </div>
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">lightbulb</span></div><img src="#" alt="Tasnem Ashraf" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Tasnem Ashraf</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Hardware & Lighting task</p>
                        </div>
                    </div>
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">lightbulb</span></div><img src="#" alt="Maram Mohamed Foad" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Maram Mohamed Foad</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Hardware & lighting task</p>
                        </div>
                    </div>
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">lightbulb</span></div><img src="#" alt="Mariam Walied" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Mariam Walied</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">Hardware & Lighting task</p>
                        </div>
                    </div>
                    <div class="member-card bg-surface-container-low rounded-2xl border border-primary/5 overflow-hidden flex flex-col hover:bg-surface-container group">
                        <div class="h-64 image-placeholder relative overflow-hidden"><div class="absolute inset-0 flex items-center justify-center opacity-10"><span class="material-symbols-outlined text-[60px]">lightbulb</span></div><img src="#" alt="Mariam Mohamed Omran" class="w-full h-full object-cover hidden"></div>
                        <div class="p-8 text-center bg-surface-container-high/40 backdrop-blur-sm flex-grow border-t border-primary/5 flex flex-col justify-center">
                            <h4 class="font-headline-sm text-xl text-on-surface mb-1">Mariam Mohamed Omran</h4>
                            <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-[0.2em]">hardware & lighting task</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
