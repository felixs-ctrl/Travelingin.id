<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #TRV-{{ $booking->id }}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0B1C3F',
                        secondary: '#1E3A8A',
                        accent: '#EAB308',
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #F8FAFC;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #FFFFFF !important;
            }
            .print-card {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen py-10">

    <div class="max-w-4xl mx-auto px-6">
        <!-- Action Bar (Hidden when printing) -->
        <div class="no-print mb-8 flex justify-between items-center bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
            <a href="{{ route('profile.bookings') }}" class="flex items-center gap-2 text-slate-500 hover:text-primary transition-colors text-sm font-medium">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali ke Riwayat</span>
            </a>
            <button onclick="window.print()" class="bg-primary hover:bg-secondary text-white px-6 py-2.5 rounded-xl font-bold text-xs shadow-lg shadow-primary/20 transition-all flex items-center gap-2">
                <i class="fas fa-download"></i>
                Download / Cetak PDF
            </button>
        </div>

        <!-- Invoice Card -->
        <div class="print-card bg-white rounded-3xl border border-slate-100 shadow-2xl p-10 md:p-16">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 pb-10 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Travelingin Logo" class="h-12 w-auto">
                </div>
                <div class="text-left md:text-right">
                    <h2 class="text-xl font-bold text-primary">INVOICE</h2>
                    <p class="text-sm font-medium text-slate-500 mt-1">Nomor: #TRV-{{ $booking->id }}-{{ date('Y', strtotime($booking->created_at)) }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">Tanggal: {{ \Carbon\Carbon::parse($booking->created_at)->format('d F Y') }}</p>
                </div>
            </div>

            <!-- Customer & Trip Details Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 py-10 border-b border-slate-100 text-sm">
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Informasi Pelanggan</h3>
                    <div class="space-y-1.5">
                        <p class="font-bold text-primary text-base">{{ $booking->nama }}</p>
                        <p class="text-slate-500 font-medium"><i class="fas fa-envelope text-slate-400 mr-2 w-4"></i>{{ $booking->email ?? 'N/A' }}</p>
                        <p class="text-slate-500 font-medium"><i class="fab fa-whatsapp text-slate-400 mr-2 w-4"></i>{{ $booking->no_hp }}</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Detail Keberangkatan</h3>
                    <div class="space-y-1.5">
                        <p class="font-bold text-primary text-base">{{ $booking->destination->name }}</p>
                        <p class="text-slate-500 font-medium"><i class="fas fa-calendar-alt text-slate-400 mr-2 w-4"></i>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d F Y') }}</p>
                        <p class="text-slate-500 font-medium"><i class="fas fa-users text-slate-400 mr-2 w-4"></i>{{ $booking->jumlah_orang }} Orang (Pax)</p>
                    </div>
                </div>
            </div>

            <!-- Item Table -->
            <div class="py-10">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="pb-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Deskripsi Layanan</th>
                            <th class="pb-4 text-center text-xs font-bold text-slate-400 uppercase tracking-widest w-20">Qty</th>
                            <th class="pb-4 text-right text-xs font-bold text-slate-400 uppercase tracking-widest w-40">Harga Satuan</th>
                            <th class="pb-4 text-right text-xs font-bold text-slate-400 uppercase tracking-widest w-40">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-slate-50">
                            <td class="py-6">
                                <p class="font-bold text-primary text-base">{{ $booking->destination->name }}</p>
                                <p class="text-xs text-slate-400 mt-1">Paket Perjalanan Kategori: {{ ucfirst($booking->destination->type) }}</p>
                            </td>
                            <td class="py-6 text-center text-slate-500 font-medium text-base">{{ $booking->jumlah_orang }}</td>
                            <td class="py-6 text-right text-slate-500 font-medium text-base">Rp {{ number_format($booking->destination->discount_price ?? $booking->destination->price, 0, ',', '.') }}</td>
                            <td class="py-6 text-right font-bold text-primary text-base">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Payment Summary and Breakdown -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-6 border-t border-slate-100 text-sm">
                <!-- Status Pembayaran Detail -->
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Status Pembayaran</h3>
                    <div class="space-y-3.5">
                        @if($booking->destination->type == 'tiket')
                            <div class="flex items-center justify-between bg-slate-50 p-3.5 rounded-xl border border-slate-100/50">
                                <span class="font-medium text-slate-600 text-xs">Pembayaran Tiket (100%)</span>
                                @if($booking->status == 'lunas')
                                    <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i> Lunas</span>
                                @elseif($booking->status == 'dp_processed')
                                    <span class="bg-blue-50 text-blue-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider"><i class="fas fa-spinner fa-spin mr-1"></i> Diproses</span>
                                @else
                                    <span class="bg-yellow-50 text-yellow-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Belum Bayar</span>
                                @endif
                            </div>
                        @else
                            <!-- Down Payment (30%) status -->
                            <div class="flex items-center justify-between bg-slate-50 p-3.5 rounded-xl border border-slate-100/50">
                                <span class="font-medium text-slate-600 text-xs">1. Down Payment (30%)</span>
                                @if(in_array($booking->status, ['confirmed', 'pelunasan_processed', 'lunas']))
                                    <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i> Lunas</span>
                                @elseif($booking->status == 'dp_processed')
                                    <span class="bg-blue-50 text-blue-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider"><i class="fas fa-spinner fa-spin mr-1"></i> Diproses</span>
                                @else
                                    <span class="bg-yellow-50 text-yellow-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Belum Bayar</span>
                                @endif
                            </div>
                            
                            <!-- Pelunasan (70%) status -->
                            <div class="flex items-center justify-between bg-slate-50 p-3.5 rounded-xl border border-slate-100/50">
                                <span class="font-medium text-slate-600 text-xs">2. Sisa Pelunasan (70%)</span>
                                @if($booking->status == 'lunas')
                                    <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i> Lunas</span>
                                @elseif($booking->status == 'pelunasan_processed')
                                    <span class="bg-purple-50 text-purple-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider"><i class="fas fa-spinner fa-spin mr-1"></i> Diproses</span>
                                @else
                                    <span class="bg-yellow-50 text-yellow-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Belum Bayar</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Totals Breakdown -->
                <div class="space-y-4">
                    @if($booking->destination->type == 'tiket')
                        <div class="flex justify-between items-center text-slate-500 font-medium pb-4 border-b border-slate-100">
                            <span>Total Pembayaran</span>
                            <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <div>
                                <span class="text-base font-bold text-primary">Sisa Tagihan</span>
                            </div>
                            @if($booking->status == 'lunas')
                                <span class="text-2xl font-extrabold text-emerald-600">Rp 0</span>
                            @else
                                <span class="text-2xl font-extrabold text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    @else
                        <div class="flex justify-between items-center text-slate-500 font-medium">
                            <span>Total Tagihan</span>
                            <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-500 font-medium">
                            <span>Pembayaran DP (30%)</span>
                            <span class="text-primary font-semibold">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-500 font-medium border-b border-slate-100 pb-4">
                            <span>Pembayaran Pelunasan (70%)</span>
                            <span class="text-primary font-semibold">Rp {{ number_format($booking->total_price - $booking->dp_amount, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center pt-2">
                            <div>
                                <span class="text-base font-bold text-primary">Sisa Tagihan</span>
                            </div>
                            @if($booking->status == 'lunas')
                                <span class="text-2xl font-extrabold text-emerald-600">Rp 0</span>
                            @elseif(in_array($booking->status, ['confirmed', 'pelunasan_processed']))
                                <span class="text-2xl font-extrabold text-primary">Rp {{ number_format($booking->total_price - $booking->dp_amount, 0, ',', '.') }}</span>
                            @else
                                <span class="text-2xl font-extrabold text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            @if($booking->destination->type == 'tiket' && $booking->status == 'lunas')
                <div class="mt-10 bg-slate-50 border border-slate-100 p-8 rounded-3xl flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="space-y-2 text-center md:text-left">
                        <h3 class="text-xs font-bold text-[#EAB308] uppercase tracking-widest">E-Ticket QR Code Entry</h3>
                        <p class="text-sm text-slate-600 font-medium">Tunjukkan kode QR ini kepada petugas pintu masuk untuk dipindai secara langsung.</p>
                        <p class="text-xs text-slate-400">Kode Tiket: <span class="font-mono font-bold text-primary">TKT-{{ $booking->id }}-{{ strtoupper(Str::random(6)) }}</span></p>
                    </div>
                    <div class="flex-shrink-0 bg-white p-3.5 rounded-2xl shadow-md border border-slate-100">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=130x130&data=TKT-TRV-{{ $booking->id }}" alt="QR Code Ticket Entry" class="w-[130px] h-[130px]">
                    </div>
                </div>
            @endif

            <!-- Footer / Notes -->
            <div class="mt-16 pt-10 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-400 font-medium leading-relaxed">
                    Terima kasih telah mempercayakan perjalanan liburan Anda bersama kami.<br>
                    Untuk informasi atau bantuan, hubungi Layanan Pelanggan kami via WhatsApp Live Chat di website Travelingin.
                </p>
                <p class="text-[9px] text-slate-300 font-bold uppercase tracking-wider mt-4"> travelingin.id — all rights reserved </p>
            </div>
        </div>
    </div>

</body>
</html>
