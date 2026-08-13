<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Aman | Travelingin.id</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0A192F; }
        h1 { font-family: 'Playfair Display', serif; }
        .glass-card { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.05); }
    </style>
</head>
<body class="text-white antialiased min-h-screen flex flex-col">

    <!-- Simple Header with Back Button -->
    <header class="p-5 md:p-8 flex justify-between items-center">
        <a href="{{ url()->previous() }}" class="flex items-center gap-3 text-white/50 hover:text-accent transition-colors font-bold text-sm">
            <i class="fas fa-arrow-left"></i>
            <span>KEMBALI</span>
        </a>
        <img src="{{ asset('images/logo.png') }}" class="h-10 md:h-12 brightness-0 invert opacity-80">
        <div class="w-16 md:w-20"></div> <!-- Spacer for symmetry -->
    </header>

    <main class="flex-1 flex items-center justify-center p-4 md:p-6 pb-20">
        <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-start">
            
            <!-- Left Side: Payment Methods -->
            <div class="space-y-8">
                <div>
                    <h1 class="text-3xl md:text-5xl font-bold mb-3 md:mb-4 italic leading-tight">Metode<br>Pembayaran</h1>
                    <p class="text-white/40 text-base md:text-lg">Pilih metode yang paling nyaman bagi Anda.</p>
                </div>

                <!-- Payment Tabs -->
                <div class="grid grid-cols-3 gap-3 p-2 bg-white/5 rounded-2xl border border-white/5">
                    <button onclick="switchPayment('midtrans')" id="tab-midtrans" class="flex-1 flex items-center justify-center gap-2 py-3.5 rounded-xl font-bold text-[11px] uppercase tracking-wider transition-all bg-accent text-primary">
                        <i class="fas fa-bolt"></i>
                        <span>Otomatis (PG)</span>
                    </button>
                    <button onclick="switchPayment('bank')" id="tab-bank" class="flex-1 flex items-center justify-center gap-2 py-3.5 rounded-xl font-bold text-[11px] uppercase tracking-wider transition-all text-white/40 hover:text-white">
                        <i class="fas fa-university"></i>
                        <span>Bank Transfer</span>
                    </button>
                    <button onclick="switchPayment('qris')" id="tab-qris" class="flex-1 flex items-center justify-center gap-2 py-3.5 rounded-xl font-bold text-[11px] uppercase tracking-wider transition-all text-white/40 hover:text-white">
                        <i class="fas fa-qrcode"></i>
                        <span>QRIS / E-Wallet</span>
                    </button>
                </div>

                <!-- Midtrans Automatic Card -->
                <div id="midtrans-info" class="glass-card p-6 md:p-10 rounded-3xl md:rounded-[40px] transition-all duration-500 text-center">
                    <p class="text-accent text-[10px] font-bold uppercase tracking-[4px] mb-4">Payment Gateway Otomatis (Midtrans)</p>
                    <p class="text-white/70 text-sm mb-6">Bayar via Virtual Account (BCA, Mandiri, BRI, BNI), QRIS, ShopeePay, GoPay, atau Kartu Kredit. Transaksi diverifikasi secara otomatis dalam hitungan detik.</p>
                    <button id="pay-button" class="w-full bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-amber-500 hover:to-yellow-600 text-primary font-bold py-4 px-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all flex items-center justify-center gap-3">
                        <i class="fas fa-shield-alt text-lg"></i>
                        <span class="tracking-wide">BAYAR SEKARANG VIA MIDTRANS</span>
                    </button>
                </div>

                <!-- Bank Info Card -->
                <div id="bank-info" class="glass-card p-6 md:p-10 rounded-3xl md:rounded-[40px] relative overflow-hidden transition-all duration-500">
                    <p class="text-accent text-[10px] font-bold uppercase tracking-[4px] mb-4 md:mb-6">Informasi Rekening</p>
                    <div class="bg-white rounded-2xl md:rounded-3xl p-6 md:p-8 text-primary shadow-2xl">
                        <div class="flex justify-between items-center mb-4 md:mb-6">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" class="h-5 md:h-6">
                            <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">BCA Virtual Account</span>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nomor Rekening</p>
                                <div class="flex items-center justify-between">
                                    <p class="text-2xl md:text-3xl font-bold tracking-wider">8820 9912 34</p>
                                    <button onclick="copyToClipboard('8820991234')" class="bg-primary/5 hover:bg-primary/10 text-primary text-[10px] font-bold px-4 py-2 rounded-xl transition-colors">SALIN</button>
                                </div>
                            </div>
                            <p class="text-xs font-semibold text-gray-400 italic">a.n Travelingin Indonesia</p>
                        </div>
                    </div>
                </div>

                <!-- QRIS Info Card (Hidden by default) -->
                <div id="qris-info" class="hidden glass-card p-6 md:p-10 rounded-3xl md:rounded-[40px] transition-all duration-500 text-center">
                    <p class="text-accent text-[10px] font-bold uppercase tracking-[4px] mb-4 md:mb-6">Scan QRIS Untuk Bayar</p>
                    <div class="bg-white rounded-2xl md:rounded-3xl p-4 md:p-6 inline-block shadow-2xl">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=TravelinginID-Booking-{{ $booking->id }}" class="w-48 h-48 md:w-56 md:h-56 mx-auto">
                        <div class="mt-4 flex items-center justify-center gap-3">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" class="h-5">
                        </div>
                    </div>
                    <p class="text-white/40 text-[10px] mt-6 font-bold uppercase tracking-widest">Mendukung Gopey, OVO, Dana, LinkAja & M-Banking</p>
                </div>

                <div class="bg-accent/5 border border-accent/10 p-4 md:p-6 rounded-2xl md:rounded-[30px] flex items-center gap-4 md:gap-5">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-accent/20 flex items-center justify-center text-accent shrink-0">
                        <i class="fas fa-shield-alt text-lg md:text-xl"></i>
                    </div>
                    <p class="text-[11px] text-white/50 font-medium leading-relaxed">Sistem kami mencatat setiap transaksi secara otomatis. Harap unggah bukti bayar untuk mempercepat proses konfirmasi.</p>
                </div>
            </div>

            <!-- Right Side: Details & Upload -->
            <div class="lg:sticky lg:top-10">
                <form action="{{ route('bookings.confirmPayment', $booking->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white p-6 md:p-12 rounded-3xl md:rounded-[60px] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.5)]">
                        <div class="flex justify-between items-start mb-6 md:mb-10">
                            <div>
                                <h3 class="text-primary font-bold text-2xl md:text-3xl italic">Konfirmasi</h3>
                                <p class="text-gray-400 text-xs mt-1">Unggah bukti bayar Anda</p>
                            </div>
                            <div class="text-right">
                                @if($booking->destination->type == 'tiket')
                                    <p class="text-[10px] font-bold text-accent uppercase tracking-widest">Total Tagihan (Bayar Lunas)</p>
                                    <p class="text-2xl font-bold text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                @elseif(in_array($booking->status, ['confirmed', 'pelunasan_processed']))
                                    <p class="text-[10px] font-bold text-accent uppercase tracking-widest">Tagihan Pelunasan (70%)</p>
                                    <p class="text-2xl font-bold text-primary">Rp {{ number_format($booking->total_price - $booking->dp_amount, 0, ',', '.') }}</p>
                                @else
                                    <p class="text-[10px] font-bold text-accent uppercase tracking-widest">Tagihan DP (30%)</p>
                                    <p class="text-2xl font-bold text-primary">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Upload Area -->
                        <div class="mb-6 md:mb-10">
                            <label class="block cursor-pointer group">
                                <div class="relative border-2 border-dashed border-gray-100 rounded-2xl md:rounded-[40px] p-6 md:p-10 text-center transition-all hover:border-accent hover:bg-accent/[0.02]">
                                    <input type="file" name="payment_proof" id="payment_proof" required class="hidden" onchange="previewImage(this)">
                                    
                                    <div id="upload-placeholder" class="space-y-4">
                                        <div class="w-16 h-16 md:w-20 md:h-20 bg-gray-50 rounded-2xl md:rounded-[25px] flex items-center justify-center mx-auto text-gray-300 group-hover:text-accent group-hover:bg-accent/10 transition-all duration-500">
                                            <i class="fas fa-camera text-3xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-primary font-bold">Ambil Foto Bukti</p>
                                            <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Maksimal 2MB</p>
                                        </div>
                                    </div>

                                    <div id="preview-container" class="hidden absolute inset-2 rounded-[35px] overflow-hidden bg-white">
                                        <img id="image-preview" src="#" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-primary/60 flex flex-col items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                            <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-full flex items-center justify-center mb-2">
                                                <i class="fas fa-sync-alt text-white"></i>
                                            </div>
                                            <p class="text-white text-[10px] font-bold uppercase tracking-widest">Ganti Foto</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Summary -->
                        <div class="bg-gray-50 rounded-[30px] p-8 mb-10 space-y-4">
                            <div class="flex justify-between text-xs font-bold text-gray-400 uppercase tracking-widest">
                                <span>Pesanan Untuk</span>
                                <span class="text-primary">{{ $booking->jumlah_orang }} Pax</span>
                            </div>
                            @if($booking->destination->type == 'tiket')
                                <div class="flex justify-between text-xs font-bold text-gray-400 uppercase tracking-widest border-t border-gray-100 pt-4">
                                    <span>Total Pembayaran</span>
                                    <span class="text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                </div>
                            @else
                                <div class="flex justify-between text-xs font-bold text-gray-400 uppercase tracking-widest border-t border-gray-100 pt-4">
                                    <span>Total Tagihan</span>
                                    <span class="text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-xs font-bold text-gray-400 uppercase tracking-widest">
                                    <span>DP (30%)</span>
                                    <span class="text-primary">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-xs font-bold text-gray-400 uppercase tracking-widest">
                                    <span>Pelunasan (70%)</span>
                                    <span class="text-primary">Rp {{ number_format($booking->total_price - $booking->dp_amount, 0, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="w-full bg-primary hover:bg-secondary text-accent font-bold py-6 rounded-[25px] shadow-2xl transition-all transform hover:scale-[1.02] active:scale-95 text-xs uppercase tracking-[4px]">
                            Selesaikan Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="p-12 text-center">
        <p class="text-white/10 text-[10px] font-bold uppercase tracking-[8px]">Travelingin.id &bull; Secure Checkout</p>
    </footer>

    @if(isset($snapToken) && $snapToken)
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        const payButton = document.getElementById('pay-button');
        if (payButton) {
            payButton.addEventListener('click', function () {
                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result){
                        alert("Pembayaran berhasil diselesaikan!");
                        window.location.href = "{{ route('bookings.success', $booking->id) }}";
                    },
                    onPending: function(result){
                        alert("Menunggu pembayaran Anda.");
                    },
                    onError: function(result){
                        alert("Pembayaran gagal atau dibatalkan.");
                    },
                    onClose: function(){
                        alert('Anda menutup popup sebelum menyelesaikan pembayaran');
                    }
                });
            });
        }
    </script>
    @endif

    <script>
        function switchPayment(type) {
            const bankInfo = document.getElementById('bank-info');
            const qrisInfo = document.getElementById('qris-info');
            const midtransInfo = document.getElementById('midtrans-info');

            const tabBank = document.getElementById('tab-bank');
            const tabQris = document.getElementById('tab-qris');
            const tabMidtrans = document.getElementById('tab-midtrans');

            if (bankInfo) bankInfo.classList.add('hidden');
            if (qrisInfo) qrisInfo.classList.add('hidden');
            if (midtransInfo) midtransInfo.classList.add('hidden');

            if (tabBank) { tabBank.classList.remove('bg-accent', 'text-primary'); tabBank.classList.add('text-white/40'); }
            if (tabQris) { tabQris.classList.remove('bg-accent', 'text-primary'); tabQris.classList.add('text-white/40'); }
            if (tabMidtrans) { tabMidtrans.classList.remove('bg-accent', 'text-primary'); tabMidtrans.classList.add('text-white/40'); }

            if (type === 'midtrans' && midtransInfo && tabMidtrans) {
                midtransInfo.classList.remove('hidden');
                tabMidtrans.classList.add('bg-accent', 'text-primary');
                tabMidtrans.classList.remove('text-white/40');
            } else if (type === 'bank' && bankInfo && tabBank) {
                bankInfo.classList.remove('hidden');
                tabBank.classList.add('bg-accent', 'text-primary');
                tabBank.classList.remove('text-white/40');
            } else if (type === 'qris' && qrisInfo && tabQris) {
                qrisInfo.classList.remove('hidden');
                tabQris.classList.add('bg-accent', 'text-primary');
                tabQris.classList.remove('text-white/40');
            }
        }

        // Default to midtrans tab if available
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('tab-midtrans')) {
                switchPayment('midtrans');
            }
        });

        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const container = document.getElementById('preview-container');
            const placeholder = document.getElementById('upload-placeholder');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Nomor rekening berhasil disalin!');
            });
        }
    </script>
</body>
</html>
