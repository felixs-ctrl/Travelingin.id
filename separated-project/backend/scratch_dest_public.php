<?php

$content = <<<'EOT'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinations | Travelingin.id</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --navy-blue: #0A192F;
            --navy-light: #172A45;
            --white: #FFFFFF;
            --soft-gold: #D4AF37;
            --gold-hover: #F1C40F;
            --gray-bg: #F8F9FA;
            --gray-text: #666666;
            --font-heading: 'Playfair Display', serif;
            --font-body: 'Poppins', sans-serif;
            --transition: all 0.3s ease-in-out;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-body); color: var(--navy-blue); background-color: var(--gray-bg); line-height: 1.6; }
        h1, h2, h3, h4, h5, h6 { font-family: var(--font-heading); color: var(--navy-blue); }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        .btn { display: inline-block; padding: 12px 28px; border-radius: 50px; font-weight: 500; cursor: pointer; transition: var(--transition); border: none; font-family: var(--font-body); }
        .btn-gold { background-color: var(--soft-gold); color: var(--white); box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3); }
        .btn-gold:hover { background-color: var(--gold-hover); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4); }
        .btn-outline { background-color: transparent; color: var(--navy-blue); border: 2px solid var(--navy-blue); }
        .btn-outline:hover { background-color: var(--navy-blue); color: var(--white); }

        /* Navbar */
        nav { position: fixed; top: 0; left: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; z-index: 1000; background: var(--white); box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .logo { font-family: var(--font-heading); font-size: 24px; font-weight: 700; color: var(--navy-blue); transition: var(--transition); }
        .logo span { color: var(--soft-gold); }
        .nav-links { display: flex; gap: 30px; }
        .nav-links a { color: var(--navy-blue); font-weight: 500; font-size: 15px; transition: var(--transition); position: relative; }
        .nav-links a::after { content: ''; position: absolute; bottom: -5px; left: 0; width: 0; height: 2px; background-color: var(--soft-gold); transition: var(--transition); }
        .nav-links a:hover::after { width: 100%; }
        .nav-actions { display: flex; align-items: center; gap: 15px; }
        .nav-actions .login:hover { background-color: rgba(10, 25, 47, 0.08); box-shadow: 0 4px 15px rgba(10, 25, 47, 0.15); color: var(--navy-blue); }

        .dropdown-content { display: none; position: absolute; right: 0; top: 100%; background-color: var(--white); min-width: 180px; box-shadow: 0 8px 20px rgba(0,0,0,0.15); border-radius: 12px; z-index: 1000; overflow: hidden; margin-top: 15px; }
        .dropdown-content a { color: var(--navy-blue) !important; padding: 12px 20px; text-decoration: none; display: flex; align-items: center; gap: 10px; font-size: 0.95rem; transition: var(--transition); }
        .dropdown-content form { margin: 0; }
        .dropdown-content a:hover { background-color: var(--gray-bg); color: var(--soft-gold) !important; }
        .dropdown-content.show { display: block; animation: fadeInDown 0.3s ease; }
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

        /* Header */
        .page-header { 
            position: relative;
            padding: 140px 5% 80px;
            text-align: center;
            background: linear-gradient(rgba(10, 25, 47, 0.7), rgba(10, 25, 47, 0.7)), url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            color: var(--white);
        }
        .page-header h1 { color: var(--white); font-size: 3.5rem; margin-bottom: 20px; }
        .page-header p { font-size: 1.1rem; max-width: 600px; margin: 0 auto; opacity: 0.9; }

        /* Main Content */
        .main-container { padding: 60px 5%; display: flex; gap: 40px; }
        
        /* Sidebar Filter */
        .sidebar { flex: 0 0 300px; background: var(--white); padding: 30px; border-radius: 20px; box-shadow: var(--shadow); height: fit-content; }
        .filter-group { margin-bottom: 30px; }
        .filter-title { font-size: 1.2rem; margin-bottom: 15px; color: var(--navy-blue); border-bottom: 2px solid var(--gray-bg); padding-bottom: 10px; }
        .filter-item { display: block; padding: 10px 15px; border-radius: 8px; margin-bottom: 10px; background: var(--gray-bg); color: var(--navy-blue); font-weight: 500; transition: var(--transition); }
        .filter-item:hover, .filter-item.active { background: var(--navy-blue); color: var(--white); }
        .filter-item i { width: 25px; color: var(--soft-gold); }
        .filter-item:hover i, .filter-item.active i { color: var(--white); }

        /* Manual Booking Form */
        .manual-booking { background: var(--navy-light); padding: 25px; border-radius: 15px; margin-top: 30px; color: var(--white); }
        .manual-booking h3 { color: var(--white); font-size: 1.2rem; margin-bottom: 15px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 0.9rem; margin-bottom: 5px; color: #ddd; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border-radius: 8px; border: none; outline: none; font-family: var(--font-body); }
        .manual-booking .btn { width: 100%; text-align: center; margin-top: 10px; }

        /* Content Area */
        .content-area { flex: 1; }
        .results-header { margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        .dest-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; }
        
        .dest-card { border-radius: 15px; overflow: hidden; box-shadow: var(--shadow); transition: var(--transition); background: var(--white); display: flex; flex-direction: column; }
        .dest-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.15); }
        .dest-img { height: 220px; position: relative; }
        .dest-img img { width: 100%; height: 100%; object-fit: cover; }
        .badge { position: absolute; top: 15px; left: 15px; background: var(--soft-gold); color: var(--white); padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; }
        .badge-type { position: absolute; top: 15px; right: 15px; background: rgba(10,25,47,0.8); color: var(--white); padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        
        .dest-info { padding: 25px; flex-grow: 1; display: flex; flex-direction: column; }
        .dest-info h3 { font-size: 1.3rem; margin-bottom: 10px; }
        .dest-desc { color: var(--gray-text); font-size: 0.9rem; margin-bottom: 20px; flex-grow: 1; }
        .dest-price { color: var(--navy-blue); font-weight: 700; font-size: 1.3rem; margin-bottom: 15px; }
        .dest-price span { color: var(--gray-text); font-size: 0.9rem; font-weight: 400; }

        /* Footer */
        footer { background-color: var(--navy-blue); color: var(--white); padding: 80px 5% 30px; }
        .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; margin-bottom: 60px; }
        .footer-col h4 { color: var(--white); font-size: 1.1rem; margin-bottom: 20px; font-family: var(--font-body); }
        .footer-col p, .footer-links a { color: #aaa; transition: var(--transition); }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a:hover { color: var(--soft-gold); padding-left: 5px; }
        .social-icon { width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.1); display: inline-flex; align-items: center; justify-content: center; color: var(--white); margin-right: 10px; transition: var(--transition); }
        .social-icon:hover { background: var(--soft-gold); transform: translateY(-3px); }
        .footer-bottom { text-align: center; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); color: #aaa; font-size: 0.9rem; }

        @media (max-width: 992px) {
            .main-container { flex-direction: column; }
            .sidebar { flex: none; width: 100%; }
            .filter-group { display: flex; flex-wrap: wrap; gap: 10px; }
            .filter-item { margin-bottom: 0; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav id="navbar">
        <a href="{{ url('/') }}" class="logo" style="display: flex; align-items: center;">
            <img src="{{ asset('images/logo.png') }}" alt="Travelingin.id Logo" style="max-height: 85px; width: auto;">
        </a>
        <ul class="nav-links">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ route('about') }}">About Us</a></li>
            <li><a href="{{ url('/destinations') }}" style="color: var(--soft-gold);">Destinations</a></li>
            <li><a href="{{ url('/#offers') }}">Special Offers</a></li>
            <li><a href="{{ url('/#contact') }}">Contact Us</a></li>
        </ul>
        <div class="nav-actions">
            @if (Route::has('login'))
                @auth
                    <div style="position: relative; display: inline-block;">
                        <a href="#" class="login" onclick="document.getElementById('dropdown-menu').classList.toggle('show'); return false;" style="padding: 0; background: transparent; box-shadow: none; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=D4AF37&color=fff&rounded=true" alt="Profile" style="width: 42px; height: 42px; border-radius: 50%; border: 2px solid var(--soft-gold); transition: transform 0.3s;">
                        </a>
                        <div id="dropdown-menu" class="dropdown-content">
                            @if(Auth::user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" style="color: #D4AF37; font-weight: bold;"><i class="fas fa-crown"></i> Admin Dashboard</a>
                            @endif
                            <a href="{{ route('profile.edit') }}"><i class="fas fa-user-edit"></i> Edit Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="login">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline">Register</a>
                    @endif
                @endauth
            @else
                <a href="#" class="login">Login</a>
                <a href="#" class="btn btn-outline">Register</a>
            @endif
        </div>
    </nav>

    <!-- Header -->
    <header class="page-header">
        <h1>Explore Packages & Tickets</h1>
        <p>Find the perfect fit for your next journey, whether you're bringing the family or backpacking solo.</p>
    </header>

    <!-- Main Content -->
    <div class="main-container">
        
        <!-- Sidebar Filters & Manual Booking -->
        <aside class="sidebar">
            <div class="filter-group">
                <h3 class="filter-title">Kategori Pembelian</h3>
                <a href="{{ url('/destinations') }}" class="filter-item {{ !request('type') ? 'active' : '' }}"><i class="fas fa-globe"></i> Semua Kategori</a>
                <a href="{{ url('/destinations?type=tiket') }}" class="filter-item {{ request('type') == 'tiket' ? 'active' : '' }}"><i class="fas fa-ticket-alt"></i> Tiket Wisata</a>
                <a href="{{ url('/destinations?type=paket') }}" class="filter-item {{ request('type') == 'paket' ? 'active' : '' }}"><i class="fas fa-box"></i> Paket Liburan</a>
                <a href="{{ url('/destinations?type=tourguide') }}" class="filter-item {{ request('type') == 'tourguide' ? 'active' : '' }}"><i class="fas fa-user-tie"></i> Tourguide</a>
            </div>

            <div class="filter-group">
                <h3 class="filter-title">Tipe Paket</h3>
                <a href="{{ url('/destinations?package_type=family' . (request('type') ? '&type='.request('type') : '')) }}" class="filter-item {{ request('package_type') == 'family' ? 'active' : '' }}"><i class="fas fa-users"></i> Family Package</a>
                <a href="{{ url('/destinations?package_type=backpacker' . (request('type') ? '&type='.request('type') : '')) }}" class="filter-item {{ request('package_type') == 'backpacker' ? 'active' : '' }}"><i class="fas fa-hiking"></i> Backpacker Package</a>
            </div>

            <!-- Manual Booking Form -->
            <div class="manual-booking">
                <h3>Pemesanan Manual</h3>
                <p style="font-size: 0.8rem; margin-bottom: 15px; color: #aaa;">Pilih sendiri tujuan, jumlah orang, dan tanggal.</p>
                <form action="#" method="GET">
                    <div class="form-group">
                        <label>Pilih Tempat / Tujuan</label>
                        <select name="manual_dest" required>
                            <option value="">-- Pilih Destinasi --</option>
                            @foreach(\App\Models\Destination::all() as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Orang (Pax)</label>
                        <input type="number" name="pax" min="1" required placeholder="Contoh: 2">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Perjalanan</label>
                        <input type="date" name="date" required>
                    </div>
                    <button type="submit" class="btn btn-gold">Pesan Sekarang</button>
                </form>
            </div>
        </aside>

        <!-- Product Grid -->
        <main class="content-area">
            <div class="results-header">
                <h2>
                    @if(request('type') == 'tiket') Tiket Wisata 
                    @elseif(request('type') == 'paket') Paket Liburan 
                    @elseif(request('type') == 'tourguide') Tourguide 
                    @else Semua Rekomendasi 
                    @endif
                    
                    @if(request('package_type') == 'family') (Family)
                    @elseif(request('package_type') == 'backpacker') (Backpacker)
                    @endif
                </h2>
                <p class="text-gray-500">{{ $destinations->count() }} produk ditemukan</p>
            </div>

            @if($destinations->isEmpty())
                <div style="text-align: center; padding: 50px; background: var(--white); border-radius: 15px;">
                    <i class="fas fa-search" style="font-size: 3rem; color: #ddd; margin-bottom: 15px;"></i>
                    <h3>Belum ada produk untuk filter ini</h3>
                    <p style="color: var(--gray-text);">Coba ubah filter atau lihat semua kategori.</p>
                </div>
            @else
                <div class="dest-grid">
                    @foreach($destinations as $dest)
                    <div class="dest-card">
                        <div class="dest-img">
                            @if($dest->package_type == 'family')
                                <span class="badge" style="background: #E84393;">Family</span>
                            @elseif($dest->package_type == 'backpacker')
                                <span class="badge" style="background: #00B894;">Backpacker</span>
                            @endif
                            <span class="badge-type">{{ ucfirst($dest->type) }}</span>
                            
                            @if($dest->image)
                                <img src="{{ asset('storage/' . $dest->image) }}" alt="{{ $dest->name }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Placeholder">
                            @endif
                        </div>
                        <div class="dest-info">
                            <h3>{{ $dest->name }}</h3>
                            <p class="dest-desc">{{ Str::limit($dest->description, 80) }}</p>
                            
                            <div style="font-size: 0.85rem; color: var(--gray-text); margin-bottom: 15px;">
                                <i class="fas fa-users" style="color: var(--soft-gold);"></i> 
                                Sisa Kuota: {{ $dest->quota == 0 ? 'Unlimited' : $dest->quota }}
                            </div>

                            <div class="dest-price">
                                Rp {{ number_format($dest->price, 0, ',', '.') }} <span>/ pax</span>
                            </div>
                            <a href="#" class="btn btn-outline" style="text-align: center;">Lihat Detail</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>

    <!-- Footer -->
    <footer>
        <!-- (Footer content same as about.blade.php) -->
        <div class="footer-bottom">
            <p>&copy; 2026 Travelingin.id. All rights reserved.</p>
        </div>
    </footer>

    <script>
        window.addEventListener('click', function(e) {
            if (!e.target.matches('.login') && !e.target.closest('.login')) {
                var dropdown = document.getElementById('dropdown-menu');
                if (dropdown && dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                }
            }
        });
    </script>
</body>
</html>
EOT;

$path = __DIR__ . '/resources/views/destinations/index.blade.php';
file_put_contents($path, $content);

echo "destinations/index.blade.php created successfully.";
