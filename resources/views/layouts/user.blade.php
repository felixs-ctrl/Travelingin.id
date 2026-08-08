<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; color: #0A192F; }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }
        .sidebar-link.active { background: #0A192F; color: #D4AF37; box-shadow: 0 10px 15px -3px rgba(10, 25, 47, 0.2); }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-80 bg-white border-r border-gray-100 flex flex-col p-8 fixed h-full z-50">
        <a href="{{ url('/') }}" class="mb-12">
            <img src="{{ asset('images/logo.png') }}" class="h-16">
        </a>

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
    <main class="flex-1 ml-80 p-12">
        <!-- Header -->
        <header class="flex justify-between items-center mb-12">
            <div>
                <h1 class="text-3xl font-bold text-primary italic">@yield('page_title')</h1>
                <p class="text-gray-400 text-xs font-medium mt-1">
                    Selamat datang kembali, 
                        {{ Auth::user()->name }}
                </p>
            </div>
            
            <div class="flex items-center gap-6">
                <button class="w-12 h-12 flex items-center justify-center text-gray-400 hover:text-primary transition-colors">
                    <i class="far fa-bell text-xl"></i>
                </button>
                <div class="flex items-center gap-4 bg-white p-2 pr-6 rounded-full shadow-sm border border-gray-100 cursor-pointer group hover:shadow-md transition-all">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0A192F&color=D4AF37&bold=true" class="w-10 h-10 rounded-full">
                    <span class="text-sm font-bold text-primary">{{ Auth::user()->name }}</span>
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
</body>
</html>
