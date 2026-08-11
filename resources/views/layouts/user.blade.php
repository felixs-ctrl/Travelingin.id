<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no">
    <title>@yield('title') | Travelingin.id</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0A192F',
                        secondary: '#112240',
                        accent: '#D4AF37',
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
        html { -webkit-text-size-adjust: 100%; -webkit-tap-highlight-color: transparent; width: 100%; max-width: 100vw; overflow-x: hidden; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; color: #0A192F; width: 100%; max-width: 100vw; overflow-x: hidden; }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }
        .sidebar-link.active { background: #0A192F; color: #D4AF37; box-shadow: 0 10px 15px -3px rgba(10, 25, 47, 0.2); }
    </style>
</head>
<body class="flex flex-col md:flex-row min-h-screen bg-gray-50">

    <!-- Mobile Top Header Bar -->
    <header class="md:hidden bg-white border-b border-gray-100 px-4 py-3 flex items-center justify-between sticky top-0 z-40">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" class="h-9">
        </a>
        <button id="user-sidebar-toggle" class="text-primary text-lg p-1.5 focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>
    </header>

    <!-- Backdrop for mobile sidebar -->
    <div id="user-sidebar-backdrop" class="fixed inset-0 bg-primary/50 z-40 hidden md:hidden"></div>

    <!-- Sidebar -->
    <aside id="user-sidebar" class="w-80 bg-white border-r border-gray-100 flex flex-col p-6 md:p-8 fixed h-full z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
        <div class="flex items-center justify-between mb-8 md:mb-12">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" class="h-12 md:h-16">
            </a>
            <button id="user-sidebar-close" class="md:hidden text-gray-400 hover:text-primary text-lg">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <nav class="flex-1 space-y-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4 ml-4">Utama</p>
            <a href="{{ route('profile.edit') }}" class="sidebar-link flex items-center gap-4 px-6 py-4 rounded-2xl font-bold text-sm transition-all {{ request()->routeIs('profile.edit') ? 'active' : 'text-gray-400 hover:bg-gray-50' }}">
                <i class="fas fa-user-circle text-lg"></i>
                <span>Profil Saya</span>
            </a>
            <a href="{{ route('profile.bookings') }}" class="sidebar-link flex items-center gap-4 px-6 py-4 rounded-2xl font-bold text-sm transition-all {{ request()->routeIs('profile.bookings') ? 'active' : 'text-gray-400 hover:bg-gray-50' }}">
                <i class="fas fa-ticket-alt text-lg"></i>
                <span>Pemesanan</span>
            </a>
            <a href="{{ route('profile.saved-places') }}" class="sidebar-link flex items-center gap-4 px-6 py-4 rounded-2xl font-bold text-sm transition-all {{ request()->routeIs('profile.saved-places') ? 'active' : 'text-gray-400 hover:bg-gray-50' }}">
                <i class="fas fa-heart text-lg"></i>
                <span>Disimpan</span>
            </a>
            
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4 mt-10 ml-4">Lainnya</p>
            <a href="{{ url('/') }}" class="sidebar-link flex items-center gap-4 px-6 py-4 rounded-2xl font-bold text-sm text-gray-400 hover:bg-gray-50 transition-all">
                <i class="fas fa-home text-lg"></i>
                <span>Beranda</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-0 md:ml-80 p-4 md:p-12">
        <!-- Header -->
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6 md:mb-12">
            <div>
                <h1 class="text-xl md:text-3xl font-bold text-primary italic">@yield('page_title')</h1>
                <p class="text-gray-400 text-xs font-medium mt-0.5">
                    Selamat datang kembali, 
                        {{ Auth::user()->name }}
                </p>
            </div>
            
            <div class="flex items-center gap-4 self-end sm:self-auto">
                <button class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center text-gray-400 hover:text-primary transition-colors">
                    <i class="far fa-bell text-lg md:text-xl"></i>
                </button>
                <div class="flex items-center gap-3 bg-white p-2 pr-4 md:pr-6 rounded-full shadow-sm border border-gray-100 cursor-pointer group hover:shadow-md transition-all">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0A192F&color=D4AF37&bold=true" class="w-8 h-8 md:w-10 md:h-10 rounded-full">
                    <span class="text-xs md:text-sm font-bold text-primary">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors ml-2">
                            <i class="fas fa-power-off"></i>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl font-medium text-sm flex items-center gap-3">
                <i class="fas fa-check-circle text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 bg-rose-50 border border-rose-200 text-rose-700 px-6 py-4 rounded-2xl font-medium text-sm flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-lg"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-8 bg-blue-50 border border-blue-200 text-blue-700 px-6 py-4 rounded-2xl font-medium text-sm flex items-center gap-3">
                <i class="fas fa-info-circle text-lg"></i>
                <span>{{ session('info') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <x-chat-widget />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('user-sidebar-toggle');
            const closeBtn = document.getElementById('user-sidebar-close');
            const sidebar = document.getElementById('user-sidebar');
            const backdrop = document.getElementById('user-sidebar-backdrop');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);
        });
    </script>
</html>
