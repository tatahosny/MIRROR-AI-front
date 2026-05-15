<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>MIRROR AI - Sign In</title>
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
                "background": "#111318",
                "primary": "#f2ca50",
                "on-surface": "#e2e2e5",
                "on-surface-variant": "#c4c7cf",
                "surface-container": "#212329",
                "surface-container-low": "#1a1c22",
                "surface-container-high": "#2b2d33",
                "surface-container-lowest": "#0c0e12",
                "primary-container": "#d4af37",
                "on-primary": "#00344e",
                "on-primary-fixed": "#001e2f",
                "error": "#ffb4ab",
                "error-container": "#93000a",
                "on-error-container": "#ffdad6",
                "outline-variant": "#44474e"
        },
        "borderRadius": {
                "lg": "0.5rem",
                "xl": "0.75rem",
                "full": "9999px"
        },
        "spacing": {
                "4": "1.4rem",
                "10": "3.5rem",
                "8": "2.75rem",
                "margin-mobile": "20px",
                "margin-desktop": "64px"
        },
        "fontFamily": {
                "display-lg": ["EB Garamond", "serif"],
                "body-md": ["Plus Jakarta Sans", "sans-serif"],
                "label-sm": ["Plus Jakarta Sans", "sans-serif"],
                "headline-sm": ["EB Garamond", "serif"]
        },
        "fontSize": {
                "body-md": ["14px", { lineHeight: "1.5", letterSpacing: "0.01em", fontWeight: "400" }],
                "display-lg": ["56px", { lineHeight: "1.1", letterSpacing: "-0.02em", fontWeight: "500" }],
                "label-sm": ["11px", { lineHeight: "1.4", letterSpacing: "0.05em", fontWeight: "600" }],
                "headline-sm": ["24px", { lineHeight: "1.2", letterSpacing: "-0.02em", fontWeight: "600" }]
        }
      }
    }
  }
</script>
</head>
<body class="bg-background min-h-screen flex items-center justify-center relative overflow-hidden font-body-md text-on-surface">
<!-- Original Background Image Reverted -->
<div class="absolute inset-0 z-0 bg-cover bg-center opacity-30" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAfkRWH4c6uLs3Isizd4LWeKaViw-Obpeu6mQcJy59cjnzY9_4pTbXAfiBFGe20rcU4f7ZDNnhS9c-7pTrywUw_Izzphqb7L5-H212p4DcadzFkZk8x6W_z6PbDe3sch8i_Cf1t49EnoaN-yB_Ur4Cci3lKMpM8PI1HcmFTBJyWMIN4kowQZ5ZsGNuElbz-A3V2B3oy4YrCfk6QmxsRD40V0of7fTNovr5C3WE5ninIcKzfSWrPV-YPoxJxlou4Wh-ZTadsAEKZY8E');">
</div>
<div class="absolute inset-0 z-0 bg-gradient-to-t from-background via-background/80 to-transparent"></div>

<main class="relative z-10 w-full max-w-md p-margin-mobile md:p-0">
    <div class="bg-surface-container-low/80 backdrop-blur-3xl rounded-xl border border-outline-variant/20 p-8 md:p-12 shadow-2xl flex flex-col items-center">
        <div class="text-center mb-10 w-full">
            <h1 class="font-display-lg tracking-tighter text-primary mb-4">MIRROR AI</h1>
            <h2 class="font-headline-sm text-on-surface italic">Welcome Back</h2>
            <p class="font-body-md text-on-surface-variant mt-2">Sign in to access your dashboard.</p>
        </div>

        <form class="w-full space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            @if(isset($analysisUuid) && $analysisUuid)
                <input type="hidden" name="analysis_uuid" value="{{ $analysisUuid }}">
            @endif

            @if ($errors->any())
                <div class="bg-error/10 text-error p-4 rounded-lg mb-6 text-sm border border-error/20">
                    @foreach ($errors->all() as $error)
                        <p class="flex items-center gap-2"><span class="material-symbols-outlined text-sm">error</span> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="space-y-2">
                <label class="font-label-sm text-on-surface-variant block uppercase tracking-widest text-[10px]">Email</label>
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-0 top-1/2 -translate-y-1/2 text-on-surface-variant group-focus-within:text-primary transition-colors pb-1">mail</span>
                    <input name="email" class="w-full bg-transparent border-b border-outline-variant/20 text-on-surface font-body-md pl-8 pr-4 py-3 focus:outline-none focus:border-primary transition-all placeholder:text-on-surface-variant/20 rounded-none" placeholder="Enter your email" type="email" value="{{ old('email') }}" required/>
                </div>
            </div>

            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <label class="font-label-sm text-on-surface-variant block uppercase tracking-widest text-[10px]">Password</label>
                    <a class="font-label-sm text-primary hover:opacity-80 transition-opacity" href="#">Forgot?</a>
                </div>
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-0 top-1/2 -translate-y-1/2 text-on-surface-variant group-focus-within:text-primary transition-colors pb-1">lock</span>
                    <input name="password" class="w-full bg-transparent border-b border-outline-variant/20 text-on-surface font-body-md pl-8 pr-10 py-3 focus:outline-none focus:border-primary transition-all placeholder:text-on-surface-variant/20 rounded-none" placeholder="Enter your password" type="password" required/>
                    <button class="absolute right-0 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary transition-colors focus:outline-none pb-1" type="button" onclick="const p = this.previousElementSibling; p.type = p.type === 'password' ? 'text' : 'password';">
                        <span class="material-symbols-outlined">visibility</span>
                    </button>
                </div>
            </div>

            <button class="w-full bg-primary text-on-primary font-label-sm py-4 rounded-xl hover:bg-secondary transition-colors mt-8 shadow-[0_0_20px_rgba(242,202,80,0.15)] font-bold uppercase tracking-widest" type="submit">
                Sign In
            </button>
        </form>

        <div class="w-full flex items-center justify-between my-8">
            <div class="h-px bg-outline-variant/20 flex-1"></div>
            <span class="font-label-sm text-on-surface-variant px-4 uppercase tracking-widest text-[10px]">Or</span>
            <div class="h-px bg-outline-variant/20 flex-1"></div>
        </div>

        <button class="w-full border border-outline-variant/20 text-primary font-label-sm py-4 rounded-xl hover:bg-primary/10 transition-colors flex items-center justify-center gap-3" type="button">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-4 h-4" alt="Google">
            Continue with Google
        </button>

        <div class="mt-8 text-center">
            <p class="font-body-md text-on-surface-variant text-sm">
                Don't have an account? <a class="text-primary hover:opacity-80 transition-opacity ml-1 font-bold" href="{{ route('register', ['analysis_uuid' => $analysisUuid ?? '']) }}">Sign Up</a>
            </p>
        </div>
    </div>
</main>
</body>
</html>
