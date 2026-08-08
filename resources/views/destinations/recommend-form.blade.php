<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Your Perfect Trip | Travelingin.id</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0A192F;
            --accent: #D4AF37;
            --white: #FFFFFF;
            --bg-light: #FDFDFD;
            --text-main: #1D1D1F;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg-light); 
            color: var(--text-main);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 800px;
            padding: 40px;
        }

        .card {
            background: var(--white);
            padding: 50px;
            border-radius: 40px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.1);
            text-align: center;
        }

        h1 { font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--primary); margin-bottom: 10px; }
        p.subtitle { color: #6E6E73; margin-bottom: 40px; font-size: 1.1rem; }

        .form-group {
            text-align: left;
            margin-bottom: 30px;
        }

        label {
            display: block;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--primary);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .options-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .option-card {
            position: relative;
        }

        .option-card input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkmark {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: #F8F9FA;
            border: 2px solid transparent;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .checkmark i { font-size: 1.5rem; margin-bottom: 10px; color: #ADB5BD; }
        .checkmark span { font-weight: 600; font-size: 0.9rem; }

        .option-card input:checked ~ .checkmark {
            border-color: var(--accent);
            background: rgba(212, 175, 55, 0.05);
            transform: translateY(-5px);
        }

        .option-card input:checked ~ .checkmark i { color: var(--accent); }
        .option-card input:checked ~ .checkmark span { color: var(--primary); }

        .btn-submit {
            width: 100%;
            padding: 20px;
            border-radius: 100px;
            background: var(--primary);
            color: var(--white);
            border: none;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .btn-submit:hover {
            background: #112240;
            transform: scale(1.02);
            box-shadow: 0 10px 30px rgba(10, 25, 47, 0.2);
        }

        .back-link {
            display: inline-block;
            margin-top: 25px;
            color: #6E6E73;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .back-link:hover { color: var(--primary); }

        @media (max-width: 600px) {
            .options-grid { grid-template-columns: 1fr; }
            .card { padding: 30px; }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div style="width: 60px; height: 60px; background: var(--accent); border-radius: 18px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                <i class="fas fa-magic fa-lg"></i>
            </div>
            <h1>Trip Finder</h1>
            <p class="subtitle">Beri tahu kami preferensi Anda, dan biarkan sistem merekomendasikan perjalanan terbaik.</p>

            <form action="{{ route('destinations.recommend') }}" method="GET">
                <input type="hidden" name="step" value="2">

                <!-- Question 1: Budget -->
                <div class="form-group">
                    <label>Berapa anggaran liburan Anda?</label>
                    <div class="options-grid">
                        <label class="option-card">
                            <input type="radio" name="budget" value="economy" checked>
                            <div class="checkmark">
                                <i class="fas fa-wallet"></i>
                                <span>Ekonomi</span>
                                <small style="font-size: 0.7rem; opacity: 0.6; margin-top: 5px;">Di bawah 2 Juta</small>
                            </div>
                        </label>
                        <label class="option-card">
                            <input type="radio" name="budget" value="mid">
                            <div class="checkmark">
                                <i class="fas fa-coins"></i>
                                <span>Menengah</span>
                                <small style="font-size: 0.7rem; opacity: 0.6; margin-top: 5px;">2jt - 7jt</small>
                            </div>
                        </label>
                        <label class="option-card">
                            <input type="radio" name="budget" value="luxury">
                            <div class="checkmark">
                                <i class="fas fa-crown"></i>
                                <span>Luxury</span>
                                <small style="font-size: 0.7rem; opacity: 0.6; margin-top: 5px;">Di atas 7 Juta</small>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Question 2: Group -->
                <div class="form-group">
                    <label>Anda pergi bersama siapa?</label>
                    <div class="options-grid">
                        <label class="option-card">
                            <input type="radio" name="package_type" value="backpacker" checked>
                            <div class="checkmark">
                                <i class="fas fa-hiking"></i>
                                <span>Backpacker</span>
                            </div>
                        </label>
                        <label class="option-card">
                            <input type="radio" name="package_type" value="family">
                            <div class="checkmark">
                                <i class="fas fa-users"></i>
                                <span>Family</span>
                            </div>
                        </label>
                        <label class="option-card">
                            <input type="radio" name="package_type" value="general">
                            <div class="checkmark">
                                <i class="fas fa-user-friends"></i>
                                <span>General</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Question 3: Type -->
                <div class="form-group">
                    <label>Apa fokus perjalanan Anda?</label>
                    <div class="options-grid">
                        <label class="option-card">
                            <input type="radio" name="type" value="paket" checked>
                            <div class="checkmark">
                                <i class="fas fa-box-open"></i>
                                <span>All-in Paket</span>
                            </div>
                        </label>
                        <label class="option-card">
                            <input type="radio" name="type" value="tiket">
                            <div class="checkmark">
                                <i class="fas fa-ticket-alt"></i>
                                <span>Tiket Saja</span>
                            </div>
                        </label>
                        <label class="option-card">
                            <input type="radio" name="type" value="tourguide">
                            <div class="checkmark">
                                <i class="fas fa-map-signs"></i>
                                <span>Tour Guide</span>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Temukan Rekomendasi <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <a href="{{ url('/') }}" class="back-link">Kembali ke Beranda</a>
        </div>
    </div>

</body>
</html>
