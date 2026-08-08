<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Travelingin.id</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
            margin-bottom: 35px;
            color: var(--navy-blue);
            font-weight: 700;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            color: var(--navy-blue);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i.input-icon {
            position: absolute;
            left: 18px;
            color: #A0A0A5;
            font-size: 1rem;
            transition: var(--transition);
        }

        .input-wrapper input {
            width: 100%;
            padding: 14px 20px 14px 48px;
            border: 1.5px solid #E5E5EA;
            border-radius: 14px;
            font-family: var(--font-body);
            font-size: 0.95rem;
            background: rgba(255, 255, 255, 0.7);
            color: var(--navy-blue);
            transition: var(--transition);
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: var(--soft-gold);
            background: #FFFFFF;
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.12);
        }

        .input-wrapper input:focus ~ i.input-icon {
            color: var(--soft-gold);
        }
        
        .toggle-password-btn {
            position: absolute;
            right: 18px;
            background: none;
            border: none;
            cursor: pointer;
            color: #A0A0A5;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            z-index: 5;
        }

        .toggle-password-btn:hover {
            color: var(--soft-gold);
        }

        .error-msg {
            color: #E74C3C;
            font-size: 0.8rem;
            margin-top: 6px;
            font-weight: 500;
            display: block;
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
            margin-top: 15px;
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

        .back-home {
            margin-top: 30px;
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
    </style>
</head>
<body>
    <div class="auth-container">
        <a href="{{ url('/') }}" class="auth-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Travelingin.id Logo">
        </a>
        <h2>Reset Password</h2>
        
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address Input -->
            <div class="input-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <i class="input-icon fas fa-envelope"></i>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="name@example.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="error-msg" />
            </div>

            <!-- Password Input -->
            <div class="input-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <i class="input-icon fas fa-lock"></i>
                    <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
                    <button type="button" onclick="toggleVisibility('password', 'toggle-icon-pw')" class="toggle-password-btn" title="Toggle password visibility">
                        <i id="toggle-icon-pw" class="far fa-eye"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="error-msg" />
            </div>

            <!-- Confirm Password Input -->
            <div class="input-group">
                <label for="password_confirmation">Confirm Password</label>
                <div class="input-wrapper">
                    <i class="input-icon fas fa-lock"></i>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                    <button type="button" onclick="toggleVisibility('password_confirmation', 'toggle-icon-confirm')" class="toggle-password-btn" title="Toggle password visibility">
                        <i id="toggle-icon-confirm" class="far fa-eye"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="error-msg" />
            </div>

            <!-- Reset Button -->
            <button type="submit" class="btn-gold">
                {{ __('Reset Password') }} <i class="fas fa-arrow-right"></i>
            </button>
        </form>
        
        <!-- Back to Homepage -->
        <a href="{{ url('/') }}" class="back-home">
            <i class="fas fa-arrow-left"></i> Back to Homepage
        </a>
    </div>

    <!-- Toggle Password Visibility JS -->
    <script>
        function toggleVisibility(inputId, iconId) {
            const inputField = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            
            if (inputField.type === 'password') {
                inputField.type = 'text';
                toggleIcon.classList.remove('far', 'fa-eye');
                toggleIcon.classList.add('fas', 'fa-eye-slash');
            } else {
                inputField.type = 'password';
                toggleIcon.classList.remove('fas', 'fa-eye-slash');
                toggleIcon.classList.add('far', 'fa-eye');
            }
        }
    </script>
</body>
</html>
