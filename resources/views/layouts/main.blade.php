<!DOCTYPE html>
<html class="dark" dir="ltr" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>MIRROR AI - @yield('title', 'Clinical Intelligence')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
                        "on-primary-fixed": "#241a00",
                    },
                    "fontFamily": {
                        "display-lg": ["EB Garamond", "serif"],
                        "body-md": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-lg": ["EB Garamond", "serif"],
                        "headline-md": ["EB Garamond", "serif"],
                        "label-sm": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    "spacing": {
                        "container-max": "1280px",
                        "margin-mobile": "20px",
                        "margin-desktop": "64px"
                    },
                    "fontSize": {
                        "display-lg": ["64px", { "lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "500" }],
                        "headline-lg": ["40px", { "lineHeight": "1.2", "fontWeight": "500" }],
                        "headline-md": ["28px", { "lineHeight": "1.3", "fontWeight": "400" }],
                        "label-sm": ["12px", { "lineHeight": "1.2", "letterSpacing": "0.1em", "fontWeight": "600" }]
                    }
                }
            }
        }
    </script>
    <style>
        .grain-bg {
            position: relative;
        }
        .grain-bg::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url('data:image/svg+xml,%3Csvg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"%3E%3Cfilter id="noiseFilter"%3E%3CfeTurbulence type="fractalNoise" baseFrequency="0.85" numOctaves="3" stitchTiles="stitch"/%3E%3C/filter%3E%3Crect width="100%25" height="100%25" filter="url(%23noiseFilter)" opacity="0.05"/%3E%3C/svg%3E');
            pointer-events: none;
            z-index: 0;
        }
        @yield('styles')
    </style>
</head>
<body class="bg-background text-on-surface min-h-screen flex flex-col grain-bg overflow-x-hidden selection:bg-primary/30 font-body-md">
    @include('partials.navbar')
    
    <main class="flex-grow">
        @yield('content')
    </main>
    
    @include('partials.footer')
    
    @yield('scripts')
</body>
</html>
