<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no">
    <title>Admin Dashboard | Travelingin.id</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0A192F',
                        secondary: '#112240',
                        accent: '#D4AF37',
                        'accent-hover': '#B8860B',
                        'bg-light': '#F8F9FA'
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
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F9FA; }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }
        .sidebar-active { 
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.1) 0%, rgba(212, 175, 55, 0) 100%);
            border-left: 4px solid #D4AF37;
            color: #D4AF37 !important;
        }
        .luxury-card {
            background: #ffffff;
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 10px 30px -5px rgba(0,0,0,0.04);
            border-radius: 20px;
        }
    </style>
</head>
<body class="antialiased text-primary">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-72 bg-primary text-white flex flex-col z-20 shadow-2xl">
            <div class="p-8 flex flex-col items-center border-b border-white/5">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="max-h-16 w-auto brightness-0 invert mb-2">
                <span class="text-[10px] tracking-[4px] uppercase font-bold text-accent">Management System</span>
            </div>
            
            <nav class="flex-1 px-6 py-8 space-y-2 overflow-y-auto">
                <p class="text-white/30 text-[10px] uppercase tracking-widest font-bold mb-4 px-4">Menu Utama</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all duration-300 hover:text-accent {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : 'text-white/60' }}">
                    <i class="fas fa-th-large text-lg"></i>
                    <span class="font-semibold text-sm">Dashboard</span>
                </a>
                
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all duration-300 hover:text-accent {{ request()->routeIs('admin.products.*') ? 'sidebar-active' : 'text-white/60' }}">
                    <i class="fas fa-suitcase-rolling text-lg"></i>
                    <span class="font-semibold text-sm">Produk & Destinasi</span>
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all duration-300 hover:text-accent {{ request()->routeIs('admin.orders.*') ? 'sidebar-active' : 'text-white/60' }}">
                    <i class="fas fa-receipt text-lg"></i>
                    <span class="font-semibold text-sm">Pesanan / Booking</span>
                </a>

                <a href="{{ route('admin.chats.index') }}" class="flex items-center justify-between px-4 py-3.5 rounded-xl transition-all duration-300 hover:text-accent {{ request()->routeIs('admin.chats.*') ? 'sidebar-active' : 'text-white/60' }}">
                    <div class="flex items-center gap-4">
                        <i class="fas fa-comments text-lg"></i>
                        <span class="font-semibold text-sm">Live Chat CS</span>
                    </div>
                    <span id="admin-sidebar-chat-badge" class="hidden bg-red-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow-sm animate-pulse">0</span>
                </a>


                <p class="text-white/30 text-[10px] uppercase tracking-widest font-bold mt-8 mb-4 px-4">External</p>
                
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-4 px-4 py-3.5 rounded-xl text-white/60 hover:text-accent transition-all duration-300">
                    <i class="fas fa-external-link-alt text-lg"></i>
                    <span class="font-semibold text-sm">Lihat Website</span>
                </a>
            </nav>

            <div class="p-6 border-t border-white/5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-xl bg-white/5 hover:bg-red-500/10 hover:text-red-500 transition-all duration-300 text-sm font-bold">
                        <i class="fas fa-power-off"></i>
                        <span>Keluar Sesi</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="h-20 bg-white flex items-center justify-between px-10 border-b border-gray-100">
                <div>
                    <h1 class="text-2xl font-bold text-primary">@yield('title')</h1>
                    <p class="text-[11px] text-gray-400 font-medium mt-0.5 tracking-wide uppercase">Travelingin.id &bull; Administrative Control Panel</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-3 pr-6 border-r border-gray-100">
                        <div class="text-right">
                            <p class="text-sm font-bold text-primary">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-accent font-bold uppercase tracking-tighter">Administrator</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0A192F&color=D4AF37&bold=true" class="w-10 h-10 rounded-full border-2 border-accent/20">
                    </div>
                    
                    <button class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-50 text-gray-400 hover:bg-primary hover:text-white transition-all duration-300">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-10">
                @if(session('success'))
                    <div class="mb-8 flex items-center gap-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-6 py-4 rounded-xl shadow-sm" role="alert">
                        <i class="fas fa-check-circle text-xl text-emerald-500"></i>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Reusable Admin Confirmation Modal -->
    <div id="adminConfirmModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-[#0A192F]/60 backdrop-blur-sm transition-opacity duration-300" onclick="closeAdminConfirmModal()"></div>
        
        <!-- Modal Card -->
        <div class="relative bg-white text-primary w-full max-w-md mx-4 rounded-3xl border border-gray-100 shadow-2xl p-8 transform scale-95 opacity-0 transition-all duration-300 z-10 text-center" id="adminConfirmModalCard">
            <div id="adminConfirmIconContainer" class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                <i id="adminConfirmIcon" class="text-2xl"></i>
            </div>
            
            <h3 id="adminConfirmTitle" class="text-xl font-bold text-primary mb-2"></h3>
            <p id="adminConfirmMessage" class="text-sm text-gray-400 leading-relaxed mb-8"></p>
            
            <div class="flex items-center gap-4">
                <button onclick="closeAdminConfirmModal()" class="flex-1 py-3.5 rounded-xl border border-gray-200 text-gray-500 font-bold text-sm hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button id="adminConfirmSubmitBtn" class="flex-1 py-3.5 rounded-xl text-white font-bold text-sm transition-all shadow-lg">
                    Konfirmasi
                </button>
            </div>
        </div>
    </div>

    <script>
        let adminConfirmCallback = null;

        function showAdminConfirm(options) {
            const modal = document.getElementById('adminConfirmModal');
            const card = document.getElementById('adminConfirmModalCard');
            const iconContainer = document.getElementById('adminConfirmIconContainer');
            const icon = document.getElementById('adminConfirmIcon');
            const titleEl = document.getElementById('adminConfirmTitle');
            const msgEl = document.getElementById('adminConfirmMessage');
            const submitBtn = document.getElementById('adminConfirmSubmitBtn');
            
            // Set content
            titleEl.innerText = options.title || 'Konfirmasi Tindakan';
            msgEl.innerText = options.message || 'Apakah Anda yakin ingin melakukan tindakan ini?';
            submitBtn.innerText = options.confirmText || 'Ya, Lakukan';
            
            // Reset classes
            iconContainer.className = "w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 ";
            icon.className = "text-2xl ";
            submitBtn.className = "flex-1 py-3.5 rounded-xl text-white font-bold text-sm transition-all shadow-lg ";
            
            // Theme styling
            if (options.theme === 'danger') {
                iconContainer.classList.add('bg-rose-50', 'text-rose-600');
                icon.className += "fas fa-exclamation-triangle";
                submitBtn.classList.add('bg-rose-600', 'hover:bg-rose-700', 'shadow-rose-600/20');
            } else if (options.theme === 'warning') {
                iconContainer.classList.add('bg-amber-50', 'text-amber-600');
                icon.className += "fas fa-exclamation-circle";
                submitBtn.classList.add('bg-amber-500', 'hover:bg-amber-600', 'shadow-amber-500/20');
            } else { // success / primary / default
                iconContainer.classList.add('bg-emerald-50', 'text-emerald-600');
                icon.className += "fas fa-check-circle";
                submitBtn.classList.add('bg-emerald-600', 'hover:bg-emerald-700', 'shadow-emerald-600/20');
            }
            
            adminConfirmCallback = options.callback || null;
            
            // Click action
            submitBtn.onclick = function() {
                if (adminConfirmCallback) {
                    adminConfirmCallback();
                }
                closeAdminConfirmModal();
            };

            // Show modal
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closeAdminConfirmModal() {
            const modal = document.getElementById('adminConfirmModal');
            const card = document.getElementById('adminConfirmModalCard');
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }, 300);
            adminConfirmCallback = null;
        }

        // Live Chat CS Sidebar Notification Badge
        document.addEventListener('DOMContentLoaded', function () {
            const badge = document.getElementById('admin-sidebar-chat-badge');
            if (!badge) return;

            function updateSidebarChatBadge() {
                fetch("{{ route('admin.chats.list') }}")
                    .then(response => response.json())
                    .then(users => {
                        const unreadUsers = users.filter(user => !user.is_from_admin).length;
                        if (unreadUsers > 0) {
                            badge.textContent = unreadUsers;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    })
                    .catch(error => console.error("Error updating sidebar chat badge:", error));
            }

            updateSidebarChatBadge();
            setInterval(updateSidebarChatBadge, 5000);
        });
    </script>
</body>
</html>