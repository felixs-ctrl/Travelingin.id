<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommendations For You | Travelingin.id</title>
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
            padding: 80px 5%;
        }

        .header { text-align: center; margin-bottom: 60px; }
        .header h1 { font-family: 'Playfair Display', serif; font-size: 3rem; color: var(--primary); margin-bottom: 15px; }
        .header p { color: #6E6E73; font-size: 1.1rem; }

        .recommendation-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .dest-card {
            background: var(--white);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            transition: all 0.5s ease;
            position: relative;
        }

        .dest-card:hover { transform: translateY(-15px); box-shadow: 0 30px 60px rgba(0,0,0,0.1); }

        .card-img {
            height: 250px;
            width: 100%;
            object-fit: cover;
        }

        .card-content { padding: 30px; }
        .card-tag { 
            background: rgba(212, 175, 55, 0.1); 
            color: var(--accent); 
            padding: 5px 15px; 
            border-radius: 50px; 
            font-size: 0.75rem; 
            font-weight: 700; 
            text-transform: uppercase;
            margin-bottom: 15px;
            display: inline-block;
        }

        .card-title { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: var(--primary); margin-bottom: 10px; }
        .card-price { font-size: 1.4rem; font-weight: 800; color: var(--primary); margin-top: 15px; }

        .btn-view {
            display: block;
            width: 100%;
            padding: 15px;
            background: var(--primary);
            color: var(--white);
            text-align: center;
            text-decoration: none;
            border-radius: 15px;
            font-weight: 600;
            margin-top: 25px;
            transition: all 0.3s ease;
        }

        .btn-view:hover { background: var(--accent); }

        .no-results {
            grid-column: 1 / -1;
            text-align: center;
            padding: 100px;
            background: var(--white);
            border-radius: 40px;
        }

        .no-results i { font-size: 4rem; color: #ADB5BD; margin-bottom: 20px; }

        .action-bar {
            text-align: center;
            margin-top: 80px;
        }

        .btn-retry {
            padding: 15px 40px;
            border-radius: 50px;
            border: 2px solid var(--primary);
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-retry:hover { background: var(--primary); color: var(--white); }
    </style>
</head>
<body>

    <div class="header">
        <div style="background: var(--accent); width: 40px; height: 4px; margin: 0 auto 20px; border-radius: 10px;"></div>
        <h1>Rekomendasi Terbaik Untukmu</h1>
        <p>Berdasarkan kriteria yang Anda masukkan, berikut adalah pilihan yang paling sesuai.</p>
    </div>

    <div class="recommendation-grid">
        @forelse($recommendations as $dest)
            <div class="dest-card">
                <img src="{{ $dest->image ? (Str::startsWith($dest->image, ['http://', 'https://']) ? $dest->image : asset('storage/' . $dest->image)) : 'https://images.unsplash.com/photo-1506012733851-bb9745564c73?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" class="card-img" alt="{{ $dest->name }}">
                <div class="card-content">
                    <div class="card-tag">{{ $dest->type }} | {{ $dest->package_type }}</div>
                    <h2 class="card-title">{{ $dest->name }}</h2>
                    <p style="color: #6E6E73; font-size: 0.9rem;">{{ Str::limit($dest->description, 100) }}</p>
                    <div class="card-price">Rp {{ number_format($dest->discount_price ?? $dest->price, 0, ',', '.') }}</div>
                    <a href="{{ route('destinations.show', $dest->id) }}" class="btn-view">Lihat Detail Trip</a>
                </div>
            </div>
        @empty
            <div class="no-results">
                <i class="fas fa-search"></i>
                <h2>Ups! Belum ada hasil.</h2>
                <p>Kami tidak menemukan trip yang sesuai dengan kriteria Anda saat ini. Coba ubah preferensi Anda.</p>
                <a href="{{ route('destinations.recommend') }}" class="btn-view" style="max-width: 300px; margin: 30px auto;">Cari Lagi</a>
            </div>
        @endforelse
    </div>

    <div class="action-bar">
        <a href="{{ route('destinations.recommend') }}" class="btn-retry">Ubah Kriteria</a>
        <a href="{{ url('/') }}" style="margin-left: 20px; color: #6E6E73; text-decoration: none; font-weight: 600;">Kembali ke Beranda</a>
    </div>

</body>
</html>
