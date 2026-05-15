<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>MIRROR AI - Sign Up</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
  tailwind.config = {
    darkMode: "class",
    theme: {
      extend: {
        "colors": {
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
                "on-primary": "#241a00",
                "on-primary-fixed": "#241a00",
                "error": "#ffb4ab",
                "error-container": "#93000a",
                "on-error-container": "#ffdad6",
                "outline-variant": "rgba(242, 202, 80, 0.1)"
        },
        "borderRadius": {
                "lg": "1.5rem",
                "2xl": "2.5rem"
        },
        "fontFamily": {
                "display-lg": ["EB Garamond", "serif"],
                "body-md": ["Plus Jakarta Sans", "sans-serif"],
                "label-sm": ["Plus Jakarta Sans", "sans-serif"],
                "headline-sm": ["EB Garamond", "serif"]
        }
      }
    }
  }
</script>
<style>
    body { background-color: #131313; color: #e5e2e1; }
    @keyframes scan {
        0% { top: 0; opacity: 0; }
        50% { opacity: 1; }
        100% { top: 100%; opacity: 0; }
    }
</style>
</head>
<body class="bg-background text-on-surface font-body-md min-h-screen flex selection:bg-primary/30 selection:text-primary overflow-x-hidden">
<main class="w-full flex min-h-screen relative">
    <!-- Left Side: Visual / Brand Area (Hidden on mobile) -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-surface-container-lowest overflow-hidden items-center justify-center border-r border-primary/10">
        <div class="absolute inset-0 z-0">
            <img alt="Abstract background" class="w-full h-full object-cover opacity-20 grayscale mix-blend-screen" src="https://images.unsplash.com/photo-1550009158-9ebf69173e03?q=80&w=2000&auto=format&fit=crop"/>
            <div class="absolute inset-0 bg-background/90"></div>
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg viewBox=\"0 0 200 200\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cfilter id=\"noiseFilter\"%3E%3CfeTurbulence type=\"fractalNoise\" baseFrequency=\"0.85\" numOctaves=\"3\" stitchTiles=\"stitch\"/%3E%3C/filter%3E%3Crect width=\"100%25\" height=\"100%25\" filter=\"url(%23noiseFilter)\" opacity=\"0.05\"/%3E%3C/svg%3E')] opacity-20 pointer-events-none"></div>
        </div>
        
        <div class="relative z-10 p-16 flex flex-col items-center justify-center h-full w-full max-w-2xl text-center">
            <div class="mb-16">
                <h1 class="font-display-lg text-[80px] text-primary tracking-tighter drop-shadow-[0_0_30px_rgba(242,202,80,0.4)]">MIRROR AI</h1>
                <p class="font-label-sm text-on-surface-variant uppercase tracking-[0.5em] mt-4">Clinical Excellence</p>
            </div>
            
            <div class="relative w-full aspect-[4/5] max-w-md mx-auto bg-surface-container-low/40 border border-primary/20 rounded-[3rem] shadow-2xl backdrop-blur-xl flex items-center justify-center overflow-hidden">
                <img alt="Facial analysis" class="w-full h-full object-cover opacity-50 grayscale" src="https://images.unsplash.com/photo-1616391182219-e080b4d1043a?q=80&w=1000&auto=format&fit=crop"/>
                <div class="absolute inset-0 pointer-events-none z-30">
                    <div class="w-full h-[2px] bg-primary shadow-[0_0_25px_4px_rgba(242,202,80,0.8)] absolute top-0 animate-[scan_4s_ease-in-out_infinite]"></div>
                </div>
                <div class="absolute bottom-10 left-10 right-10 text-left z-20">
                    <p class="font-display-lg text-3xl text-on-surface mb-3 italic">"Precision at every glance."</p>
                    <p class="font-label-sm text-primary uppercase tracking-[0.3em] font-bold">Premium Intelligence</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Form Area -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-16 bg-background relative z-10">
        <div class="w-full max-w-lg bg-surface-container/30 backdrop-blur-3xl rounded-[3rem] border border-primary/10 p-10 md:p-16 shadow-[0_0_60px_rgba(0,0,0,0.5)]">
            <div class="mb-12 text-center lg:text-left">
                <h1 class="font-display-lg text-5xl text-on-surface mb-3 italic">Create Account</h1>
                <p class="font-body-md text-on-surface-variant">Begin your personalized clinical journey.</p>
            </div>

            <form class="space-y-8" action="{{ route('register') }}" method="POST">
                @csrf
                @if(isset($analysisUuid) && $analysisUuid)
                    <input type="hidden" name="analysis_uuid" value="{{ $analysisUuid }}">
                @endif

                @if ($errors->any())
                    <div class="bg-error/10 text-error p-6 rounded-2xl mb-8 text-sm border border-error/20 backdrop-blur-sm">
                        @foreach ($errors->all() as $error)
                            <p class="flex items-center gap-2 mb-1"><span class="material-symbols-outlined text-[16px]">error</span> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="grid grid-cols-1 gap-8">
                    <!-- Full Name -->
                    <div class="space-y-3">
                        <label class="block font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px]" for="fullname">Full Name</label>
                        <input name="name" class="w-full bg-transparent border-b border-primary/10 py-4 text-on-surface font-body-md focus:outline-none focus:border-primary transition-all placeholder:text-on-surface-variant/30" id="fullname" placeholder="John Doe" type="text" value="{{ old('name') }}" required/>
                    </div>
                    
                    <!-- Email -->
                    <div class="space-y-3">
                        <label class="block font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px]" for="email">Email Address</label>
                        <input name="email" class="w-full bg-transparent border-b border-primary/10 py-4 text-on-surface font-body-md focus:outline-none focus:border-primary transition-all placeholder:text-on-surface-variant/30" id="email" placeholder="john@example.com" type="email" value="{{ old('email') }}" required/>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Password -->
                        <div class="space-y-3">
                            <label class="block font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px]" for="password">Password</label>
                            <input name="password" class="w-full bg-transparent border-b border-primary/10 py-4 text-on-surface font-body-md focus:outline-none focus:border-primary transition-all placeholder:text-on-surface-variant/30" id="password" placeholder="••••••••" type="password" required/>
                        </div>
                        
                        <!-- Confirm Password -->
                        <div class="space-y-3">
                            <label class="block font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px]" for="confirm_password">Confirm</label>
                            <input name="password_confirmation" class="w-full bg-transparent border-b border-primary/10 py-4 text-on-surface font-body-md focus:outline-none focus:border-primary transition-all placeholder:text-on-surface-variant/30" id="confirm_password" placeholder="••••••••" type="password" required/>
                        </div>
                    </div>
                </div>

                <div class="pt-10">
                    <button class="w-full bg-primary text-on-primary font-label-sm font-bold uppercase tracking-[0.2em] py-5 rounded-2xl shadow-[0_0_30px_rgba(242,202,80,0.2)] hover:bg-secondary hover:shadow-[0_0_40px_rgba(242,202,80,0.3)] transition-all duration-500 transform hover:scale-[1.01] active:scale-[0.99]" type="submit">
                        Create My Account
                    </button>
                </div>

                <div class="text-center mt-12">
                    <p class="font-body-md text-on-surface-variant">
                        Already have an account? 
                        <a class="text-primary font-bold hover:underline transition-all ml-2" href="{{ route('login', ['analysis_uuid' => $analysisUuid ?? '']) }}">Sign In</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
</html>
