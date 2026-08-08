<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email | Travelingin.id</title>
    <!-- Fonts -->
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
        :root {
            --navy-blue: #0A192F;
            --white: #FFFFFF;
            --soft-gold: #D4AF37;
            --soft-gold-hover: #B8860B;
            --gray-bg: #F8F9FA;
            --gray-text: #6E6E73;
            --font-heading: 'Playfair Display', serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
            --transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }

        body { 
            font-family: var(--font-body); 
            background: linear-gradient(135deg, rgba(10, 25, 47, 0.85), rgba(17, 34, 64, 0.65)), url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat; 
            color: var(--navy-blue); 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 40px 20px;
        }

        a { 
            text-decoration: none; 
            color: inherit; 
            transition: var(--transition);
        }
        
        .auth-container {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            padding: 55px 45px;
            border-radius: 30px;
            box-shadow: 0 30px 70px rgba(10, 25, 47, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.55);
            width: 100%;
            max-width: 460px;
            text-align: center;
            transition: var(--transition);
        }
        
        .auth-logo {
            display: inline-block;
            transition: var(--transition);
        }
        
        .auth-logo:hover {
            transform: scale(1.05);
        }

        .auth-logo img {
            max-height: 85px;
            width: auto;
            margin-bottom: 25px;
        }

        .auth-container h2 {
            font-family: var(--font-heading);
            font-size: 2.2rem;
            margin-bottom: 20px;
            color: var(--navy-blue);
            font-weight: 700;
        }

        .auth-description {
            color: var(--gray-text);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .status-banner {
            background: rgba(46, 204, 113, 0.15);
            border: 1px solid rgba(46, 204, 113, 0.3);
            color: #27AE60;
            padding: 15px 20px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 25px;
            line-height: 1.5;
            text-align: left;
        }

        .btn-gold {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--soft-gold), #B8860B);
            color: var(--white);
            border-radius: 100px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            font-family: var(--font-body);
            font-size: 1rem;
            transition: var(--transition);
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.35);
            gap: 10px;
        }

        .btn-gold:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(212, 175, 55, 0.45);
            background: linear-gradient(135deg, #B8860B, var(--soft-gold));
        }

        .btn-gold i {
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .btn-gold:hover i {
            transform: translateX(4px);
        }

        .logout-btn {
            background: none;
            border: none;
            color: var(--gray-text);
            font-family: var(--font-body);
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 25px;
        }

        .logout-btn:hover {
            color: var(--soft-gold);
            transform: translateX(4px);
        }

        .back-home {
            margin-top: 15px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--gray-text);
            font-size: 0.9rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .back-home:hover {
            color: var(--soft-gold);
            transform: translateX(-4px);
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <a href="{{ url('/') }}" class="auth-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Travelingin.id Logo">
        </a>
        <h2>Verify Email</h2>
        
        <p class="auth-description">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="status-banner">
                <i class="fas fa-check-circle"></i> {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <!-- Submit Button -->
            <button type="submit" class="btn-gold">
                {{ __('Resend Verification Email') }} <i class="fas fa-paper-plane"></i>
            </button>
        </form>
        
        <div class="footer-links">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    Log Out <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>

            <!-- Back to Homepage -->
            <a href="{{ url('/') }}" class="back-home">
                <i class="fas fa-arrow-left"></i> Back to Homepage
            </a>
        </div>
    </div>
    <x-chat-widget />
</body>
</html>
