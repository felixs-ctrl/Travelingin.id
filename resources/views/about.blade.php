<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no">
    <title>About Our Legacy | Travelingin.id</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #0A192F;
            --primary-light: #112240;
            --accent: #D4AF37;
            --accent-light: #E5C76B;
            --white: #FFFFFF;
            --bg-light: #FDFDFD;
            --bg-gray: #F8F9FA;
            --text-main: #1D1D1F;
            --text-muted: #6E6E73;
            --font-heading: 'Playfair Display', serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
            --transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --glass: rgba(255, 255, 255, 0.7);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { -webkit-text-size-adjust: 100%; -webkit-tap-highlight-color: transparent; width: 100%; max-width: 100vw; overflow-x: hidden; }
        body { font-family: var(--font-body); color: var(--text-main); background-color: var(--bg-light); line-height: 1.7; width: 100%; max-width: 100vw; overflow-x: hidden; }
        h1, h2, h3, h4, h5, h6 { font-family: var(--font-heading); color: var(--primary); font-weight: 700; }
        a { text-decoration: none; color: inherit; transition: var(--transition); }
        ul { list-style: none; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 14px 32px; border-radius: 100px; font-weight: 600; cursor: pointer; transition: var(--transition); border: none; gap: 10px; }
        .btn-primary { background: linear-gradient(135deg, var(--accent), #B8860B); color: var(--white); box-shadow: 0 8px 20px rgba(212, 175, 55, 0.3); }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 12px 25px rgba(212, 175, 55, 0.4); }

        /* Navbar */
        nav { position: fixed; top: 0; left: 0; width: 100%; padding: 20px 5%; display: flex; justify-content: space-between; align-items: center; z-index: 1000; background: var(--glass); backdrop-filter: blur(15px); border-bottom: 1px solid rgba(0,0,0,0.05); }
        .logo { font-family: var(--font-heading); font-size: 28px; font-weight: 800; color: var(--primary); }
        .logo span { color: var(--accent); }
        .nav-links { display: flex; gap: 40px; }
        .nav-links a { color: var(--primary); font-weight: 500; font-size: 0.95rem; }
        .nav-links a:hover { color: var(--accent); }
        .nav-actions { display: flex; align-items: center; gap: 20px; }

        /* Header */
        .about-header { 
            position: relative;
            padding: 200px 0 120px;
            text-align: center;
            background: linear-gradient(rgba(10, 25, 47, 0.8), rgba(10, 25, 47, 0.8)), url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            color: var(--white);
        }
        .about-header h1 { color: var(--white); font-size: clamp(3rem, 6vw, 4.5rem); margin-bottom: 25px; }
        .about-header p { font-size: 1.2rem; max-width: 800px; margin: 0 auto; opacity: 0.9; font-weight: 300; }

        /* Content */
        .about-section { padding: 120px 0; }
        .about-flex { display: flex; gap: 80px; align-items: center; }
        .about-text { flex: 1; }
        .about-text h2 { font-size: 2.8rem; margin-bottom: 30px; line-height: 1.2; }
        .about-text p { color: var(--text-muted); margin-bottom: 25px; font-size: 1.1rem; }
        .about-image { flex: 1; position: relative; }
        .about-image img { width: 100%; border-radius: 30px; box-shadow: var(--shadow-lg); }
        
        .about-image::before {
            content: '';
            position: absolute;
            top: -20px;
            left: -20px;
            width: 100px;
            height: 100px;
            border-top: 5px solid var(--accent);
            border-left: 5px solid var(--accent);
            border-radius: 20px 0 0 0;
            z-index: -1;
        }

        /* Footer */
        footer { background-color: var(--primary); color: var(--white); padding: 100px 0 40px; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 60px; margin-bottom: 80px; }
        .footer-col h4 { color: var(--white); font-size: 1.1rem; margin-bottom: 30px; text-transform: uppercase; letter-spacing: 2px; }
        .footer-links li { margin-bottom: 15px; }
        .footer-links a { color: rgba(255,255,255,0.6); font-size: 0.95rem; }
        .footer-links a:hover { color: var(--accent); padding-left: 8px; }
        .social-links { display: flex; gap: 20px; margin-top: 30px; }
        .social-icon { width: 45px; height: 45px; border-radius: 50%; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; transition: var(--transition); }
        .social-icon:hover { background: var(--accent); transform: translateY(-5px); color: var(--primary); }
        .footer-bottom { padding-top: 40px; border-top: 1px solid rgba(255,255,255,0.05); text-align: center; color: rgba(255,255,255,0.4); font-size: 0.9rem; }

        /* Mobile Menu Styles */
        .mobile-toggle {
            display: none;
            background: transparent;
            border: none;
            color: var(--primary);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 8px;
            z-index: 1001;
        }

        .mobile-drawer {
            position: fixed;
            top: 0;
            right: -100%;
            width: 85%;
            max-width: 360px;
            height: 100vh;
            background: var(--primary);
            z-index: 9999;
            padding: 90px 30px 40px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            transition: right 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: -10px 0 30px rgba(0,0,0,0.3);
        }

        .mobile-drawer.open {
            right: 0;
        }

        .mobile-drawer a {
            color: var(--white);
            font-size: 1.1rem;
            font-weight: 600;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .mobile-drawer-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(10, 25, 47, 0.6);
            backdrop-filter: blur(4px);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .mobile-drawer-backdrop.open {
            opacity: 1;
            visibility: visible;
        }

        @media (max-width: 992px) {
            .nav-links { display: none !important; }
            .mobile-toggle { display: block !important; }
            .nav-actions > *:not(.mobile-toggle) { display: none !important; }
            .about-flex { flex-direction: column; text-align: center; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            nav { padding: 15px 5% !important; }
            .logo img { max-height: 40px !important; }
            .mobile-toggle { font-size: 1.8rem; padding: 4px; }
            .container { padding: 0 20px; }
            .about-header { padding: 100px 0 50px !important; }
            .about-header h1 { font-size: 2rem !important; line-height: 1.2; margin-bottom: 12px !important; }
            .about-header p { font-size: 0.95rem !important; }
            .about-section { padding: 60px 0 !important; }
            .about-text h2 { font-size: 1.75rem !important; }
            .about-text p { font-size: 0.95rem !important; }
            .about-flex { gap: 40px !important; }
            .stats-grid { grid-template-columns: 1fr 1fr; gap: 16px !important; }
            .stat-card { padding: 18px !important; }
            .stat-number { font-size: 1.6rem !important; }
            .footer-grid { grid-template-columns: 1fr; gap: 30px; }
            .nav-actions { gap: 15px; }
            .btn { padding: 12px 20px !important; font-size: 0.9rem !important; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav id="navbar">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center; width: 100%; max-width: 100%;">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Travelingin.id Logo" style="max-height: 80px; width: auto;">
            </a>
            <ul class="nav-links">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('about') }}" style="color: var(--accent);">About</a></li>
                <li><a href="{{ url('/destinations') }}">Destinations</a></li>
                <li><a href="{{ route('special-offers') }}">Special Offers</a></li>
                <li><a href="{{ url('/#contact') }}">Contact Us</a></li>
            </ul>
            <div class="nav-actions" style="display: flex; align-items: center; gap: 15px;">
                @auth
                    <a href="{{ route('profile.edit') }}" style="display: flex; align-items: center; gap: 12px;">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=D4AF37&color=fff&rounded=true" alt="Profile" style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--accent);">
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary" style="padding: 10px 25px; border-radius: 50px;">Login</a>
                @endauth
                <button class="mobile-toggle" id="mobile-toggle-btn" aria-label="Toggle Navigation">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation Drawer -->
    <div class="mobile-drawer-backdrop" id="mobile-backdrop"></div>
    <div class="mobile-drawer" id="mobile-drawer">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ route('about') }}" style="color: var(--accent);">About Us</a>
        <a href="{{ url('/destinations') }}">Destinations</a>
        <a href="{{ route('special-offers') }}">Special Offers</a>
        <a href="{{ url('/#contact') }}">Contact Us</a>
        @auth
            <a href="{{ route('profile.edit') }}" style="color: var(--accent);"><i class="fas fa-user-circle"></i> Profil Saya</a>
        @else
            <a href="{{ route('login') }}" style="color: var(--accent);"><i class="fas fa-sign-in-alt"></i> Login</a>
        @endauth
    </div>

    <!-- Header -->
    <header class="about-header">
        <div class="container" data-aos="fade-up">
            <h1>Our Journey & Vision</h1>
            <p>Crafting unforgettable stories and connecting souls with the world's most breathtaking landscapes since 2024.</p>
        </div>
    </header>

    <!-- Content -->
    <section class="about-section">
        <div class="container">
            <div class="about-flex">
                <div class="about-text" data-aos="fade-right">
                    <span>SINCE 2024</span>
                    <h2>Elevating the Standard of Modern Travel</h2>
                    <p>Founded with a singular passion to make luxury travel accessible and authentic, <strong>Travelingin.id</strong> has evolved into Indonesia's premier gateway for global exploration.</p>
                    <p>We believe travel is more than just visiting a place—it's about the transformation that happens within. Whether it's a meticulously planned family heritage tour in Kyoto or a rugged nomad trail through the Swiss Alps, our mission is to provide the perfect balance of comfort, safety, and adventure.</p>
                    <a href="{{ url('/#destinations') }}" class="btn btn-primary">Discover Our Collections <i class="fas fa-chevron-right" style="font-size: 0.8rem;"></i></a>
                </div>
                <div class="about-image" data-aos="fade-left">
                    <img src="https://images.unsplash.com/photo-1522083165195-3424ed129620?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Our Team">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <a href="{{ url('/') }}" class="logo" style="display: block; margin-bottom: 30px;">
                        <img src="{{ asset('images/logo.png') }}" alt="Travelingin.id Logo" style="max-height: 100px; width: auto; filter: brightness(0) invert(1);">
                    </a>
                    <p style="color: rgba(255,255,255,0.6); margin-bottom: 30px;">Elevating travel experiences through curated luxury and authentic discovery.</p>
                    <div class="social-links">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Company</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('about') }}">Our Story</a></li>
                        <li><a href="#">Our Vision</a></li>
                        <li><a href="{{ route('special-offers') }}">Special Offers</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Support</h4>
                    <ul class="footer-links">
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Privacy</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Contact</h4>
                    <ul class="footer-links" style="color: rgba(255,255,255,0.6);">
                        <li><i class="fas fa-map-marker-alt" style="color: var(--accent); margin-right: 10px;"></i> Sudirman CBD, Jakarta</li>
                        <li><i class="fas fa-phone" style="color: var(--accent); margin-right: 10px;"></i> +62 812 3456 7890</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Travelingin.id. Crafted for global explorers.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 1200, once: true });

        // Mobile Drawer Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('mobile-toggle-btn');
            const drawer = document.getElementById('mobile-drawer');
            const backdrop = document.getElementById('mobile-backdrop');

            function toggleMobileMenu() {
                drawer.classList.toggle('open');
                backdrop.classList.toggle('open');
            }

            if (toggleBtn) toggleBtn.addEventListener('click', toggleMobileMenu);
            if (backdrop) backdrop.addEventListener('click', toggleMobileMenu);
        });
    </script>
</body>
</html>
