<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Travelingin.id') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0A192F',
                        'primary-light': '#112240',
                        accent: '#D4AF37',
                        'accent-hover': '#B8860B',
                    },
                    fontFamily: {
                        heading: ['Playfair Display', 'serif'],
                        body: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Playfair Display', serif; }
        .glass-nav { background: rgba(10, 25, 47, 0.8); backdrop-filter: blur(15px); border-bottom: 1px solid rgba(255,255,255,0.05); }
    </style>
</head>
<body class="bg-primary text-white antialiased">
    <!-- Navbar -->
    <nav class="glass-nav fixed top-0 w-full z-50 px-10 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 brightness-0 invert">
        </a>
        <div class="hidden md:flex gap-8 items-center text-sm font-semibold uppercase tracking-widest">
            <a href="{{ url('/') }}" class="hover:text-accent transition-colors">Home</a>
            <a href="{{ url('/destinations') }}" class="hover:text-accent transition-colors">Destinations</a>
            <a href="{{ route('special-offers') }}" class="hover:text-accent transition-colors">Special Offers</a>
            <a href="{{ url('/#contact') }}" class="hover:text-accent transition-colors">Contact Us</a>
            @auth
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 border-l border-white/10 pl-8">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=D4AF37&color=0A192F&bold=true" class="w-8 h-8 rounded-full">
                </a>
            @else
                <a href="{{ route('login') }}" class="bg-accent text-primary px-6 py-2 rounded-full hover:scale-105 transition-transform">Login</a>
            @endauth
        </div>
    </nav>

    <main class="pt-24">
        @if(isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-[#050C1B] py-20 px-10 border-t border-white/5">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="col-span-2">
                <img src="{{ asset('images/logo.png') }}" class="h-20 brightness-0 invert mb-6">
                <p class="text-white/40 max-w-sm leading-relaxed">Menghadirkan pengalaman perjalanan tak terlupakan dengan sentuhan kemewahan dan keaslian lokal.</p>
            </div>
            <div>
                <h4 class="text-accent font-bold uppercase tracking-widest text-xs mb-6">Menu</h4>
                <ul class="space-y-4 text-sm text-white/60 font-medium">
                    <li><a href="{{ url('/destinations') }}" class="hover:text-white transition-colors">Destinations</a></li>
                    <li><a href="{{ route('special-offers') }}" class="hover:text-white transition-colors">Special Offers</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">About Us</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-accent font-bold uppercase tracking-widest text-xs mb-6">Contact</h4>
                <p class="text-sm text-white/60 font-medium mb-2">Sudirman CBD, Jakarta</p>
                <p class="text-sm text-white/60 font-medium">hello@travelingin.id</p>
            </div>
        </div>
    </footer>
</body>
</html>
