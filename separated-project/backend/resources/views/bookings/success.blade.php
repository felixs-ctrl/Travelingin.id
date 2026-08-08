@extends('layouts.app')

@section('content')
<section class="success-section py-20 bg-primary min-h-screen flex items-center">
    <div class="container mx-auto px-6">
        <div class="max-w-2xl mx-auto text-center">
            <div class="w-24 h-24 bg-accent rounded-full flex items-center justify-center mx-auto mb-10 shadow-2xl shadow-accent/20">
                <i class="fas fa-check text-4xl text-primary animate-bounce"></i>
            </div>
            
            @if(in_array($booking->status, ['dp_processed', 'pelunasan_processed']))
                <h2 class="text-5xl font-bold text-white mb-4 italic">Pembayaran Diproses!</h2>
            @else
                <h2 class="text-5xl font-bold text-white mb-4 italic">Pembayaran Berhasil!</h2>
            @endif

            @if($booking->status == 'dp_processed')
                <p class="text-white/60 text-lg leading-relaxed mb-12">Terima kasih {{ $booking->nama }}. Bukti pembayaran {{ $booking->destination->type === 'tiket' ? 'tiket' : 'Down Payment' }} Anda telah kami terima dan sedang dalam proses verifikasi oleh tim admin kami.</p>
            @elseif($booking->status == 'pelunasan_processed')
                <p class="text-white/60 text-lg leading-relaxed mb-12">Terima kasih {{ $booking->nama }}. Bukti pembayaran Pelunasan Anda telah kami terima dan sedang dalam proses verifikasi oleh tim admin kami.</p>
            @else
                <p class="text-white/60 text-lg leading-relaxed mb-12">Terima kasih {{ $booking->nama }}. Pembayaran Anda telah kami terima dan verifikasi. Rincian pesanan telah dikirimkan ke email Anda.</p>
            @endif
            
            <div class="bg-white/5 backdrop-blur-md p-10 rounded-3xl border border-white/10 shadow-2xl mb-12 text-left">
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <p class="text-accent text-[10px] font-bold uppercase tracking-widest mb-1">ID Transaksi</p>
                        <p class="text-white font-bold tracking-widest">#TRV-{{ $booking->id }}-{{ date('Y') }}</p>
                    </div>
                    <div>
                        <p class="text-accent text-[10px] font-bold uppercase tracking-widest mb-1">Status</p>
                        @if($booking->status == 'dp_processed')
                            <p class="text-blue-400 font-bold uppercase tracking-widest text-xs">{{ $booking->destination->type === 'tiket' ? 'Pembayaran Sedang Diproses' : 'DP Sedang Diproses' }}</p>
                        @elseif($booking->status == 'pelunasan_processed')
                            <p class="text-purple-400 font-bold uppercase tracking-widest text-xs">Pelunasan Sedang Diproses</p>
                        @elseif($booking->status == 'confirmed')
                            <p class="text-indigo-400 font-bold uppercase tracking-widest text-xs">{{ $booking->destination->type === 'tiket' ? 'Terverifikasi / Lunas' : 'DP Terverifikasi' }}</p>
                        @elseif($booking->status == 'lunas')
                            <p class="text-emerald-400 font-bold uppercase tracking-widest text-xs">Lunas / Terverifikasi</p>
                        @else
                            <p class="text-white font-bold uppercase tracking-widest text-xs">{{ strtoupper($booking->status) }}</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-accent text-[10px] font-bold uppercase tracking-widest mb-1">Destinasi</p>
                        <p class="text-white font-bold">{{ $booking->destination->name }}</p>
                    </div>
                    <div>
                        <p class="text-accent text-[10px] font-bold uppercase tracking-widest mb-1">Tanggal Keberangkatan</p>
                        <p class="text-white font-bold">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" class="bg-accent hover:bg-accent-hover text-primary font-bold px-10 py-5 rounded-2xl transition-all transform hover:scale-105 shadow-xl">
                    Kembali ke Beranda
                </a>
                <button onclick="window.print()" class="bg-white/5 hover:bg-white/10 text-white font-bold px-10 py-5 rounded-2xl border border-white/10 transition-all">
                    <i class="fas fa-print mr-2"></i> Cetak Invoice
                </button>
            </div>
            
            <p class="text-white/30 text-xs mt-12 italic">Kami akan menghubungi Anda dalam 1x24 jam untuk koordinasi logistik keberangkatan.</p>
        </div>
    </div>
</section>
@endsection
