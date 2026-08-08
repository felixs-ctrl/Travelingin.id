@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . str_pad($order->id, 4, '0', STR_PAD_LEFT))

@section('content')
@if(session('success'))
    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl font-medium text-sm flex items-center gap-3">
        <i class="fas fa-check-circle text-lg"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-6 py-4 rounded-2xl font-medium text-sm flex items-center gap-3">
        <i class="fas fa-exclamation-circle text-lg"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 text-gray-500 hover:text-primary transition-colors font-medium">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Daftar</span>
    </a>
    
        @if($order->status == 'dp_processed')
        <form id="confirm-dp-form" action="{{ route('admin.orders.confirmDp', $order->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="button" onclick="confirmApproveDp()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-emerald-600/20 transition-all flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                {{ $order->destination->type === 'tiket' ? 'Konfirmasi Pembayaran' : 'Konfirmasi Pembayaran DP' }}
            </button>
        </form>
        @endif

        @if($order->status == 'pelunasan_processed')
        <form id="confirm-pelunasan-form" action="{{ route('admin.orders.confirmPelunasan', $order->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="button" onclick="confirmApprovePelunasan()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-emerald-600/20 transition-all flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                Konfirmasi Pelunasan (Lunas)
            </button>
        </form>
        @endif

        @if($order->status == 'cancel_pending')
        <form id="approve-cancellation-form" action="{{ route('admin.orders.approveCancellation', $order->id) }}" method="POST" class="inline-block">
            @csrf
            @method('PATCH')
            <button type="button" onclick="confirmApproveCancellation()" class="bg-rose-600 hover:bg-rose-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-rose-600/20 transition-all flex items-center gap-2">
                <i class="fas fa-times-circle"></i>
                Setujui Pembatalan
            </button>
        </form>
        <form id="reject-cancellation-form" action="{{ route('admin.orders.rejectCancellation', $order->id) }}" method="POST" class="inline-block">
            @csrf
            @method('PATCH')
            <button type="button" onclick="confirmRejectCancellation()" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-gray-600/20 transition-all flex items-center gap-2">
                <i class="fas fa-undo"></i>
                Tolak Pembatalan
            </button>
        </form>
        @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Pelanggan & Order Info -->
    <div class="lg:col-span-2 space-y-8">
        <div class="luxury-card p-10 bg-white">
            <h3 class="text-xl font-bold text-primary mb-8 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-accent rounded-full"></span>
                Informasi Pelanggan
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Lengkap</p>
                        <p class="text-lg font-bold text-primary">{{ $order->nama }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nomor WhatsApp</p>
                        <p class="text-lg font-bold text-primary">{{ $order->no_hp }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Alamat Email</p>
                        <p class="text-lg font-bold text-primary">{{ $order->email ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tanggal Keberangkatan</p>
                        <p class="text-lg font-bold text-primary">{{ \Carbon\Carbon::parse($order->tanggal_booking)->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Jumlah Peserta</p>
                        <p class="text-lg font-bold text-primary">{{ $order->jumlah_orang }} Orang (Pax)</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Status Pembayaran</p>
                        @if($order->status == 'pending')
                            <span class="inline-block bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-widest mt-2">{{ $order->destination->type === 'tiket' ? 'Menunggu Pembayaran' : 'Menunggu DP' }}</span>
                        @elseif($order->status == 'dp_processed')
                            <span class="inline-block bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-widest mt-2">{{ $order->destination->type === 'tiket' ? 'Pembayaran Diproses' : 'DP Diproses' }}</span>
                        @elseif($order->status == 'confirmed')
                            <span class="inline-block bg-indigo-100 text-indigo-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-widest mt-2">{{ $order->destination->type === 'tiket' ? 'Lunas' : 'DP Dikonfirmasi' }}</span>
                        @elseif($order->status == 'pelunasan_processed')
                            <span class="inline-block bg-purple-100 text-purple-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-widest mt-2">Pelunasan Diproses</span>
                        @elseif($order->status == 'lunas')
                            <span class="inline-block bg-emerald-100 text-emerald-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-widest mt-2">Lunas</span>
                        @elseif($order->status == 'cancel_pending')
                            <span class="inline-block bg-orange-100 text-orange-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-widest mt-2">Pengajuan Batal</span>
                        @elseif($order->status == 'cancelled')
                            <span class="inline-block bg-rose-100 text-rose-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-widest mt-2">Dibatalkan</span>
                        @else
                            <span class="inline-block bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-widest mt-2">{{ ucfirst($order->status) }}</span>
                        @endif
                    </div>
                </div>
            </div>

            @if($order->cancellation_reason)
            <div class="mt-8 pt-8 border-t border-gray-100 bg-rose-50/50 p-6 rounded-2xl border border-rose-100/50 text-left">
                <p class="text-[10px] font-bold text-rose-600 uppercase tracking-widest mb-2"><i class="fas fa-exclamation-triangle mr-1"></i> Alasan Pembatalan</p>
                <p class="text-sm font-bold text-primary leading-relaxed">{{ $order->cancellation_reason }}</p>
            </div>
            @endif
        </div>

        <div class="luxury-card p-10 bg-white">
            <h3 class="text-xl font-bold text-primary mb-8 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-accent rounded-full"></span>
                Rincian Biaya
            </h3>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center py-4 border-b border-gray-50">
                    <p class="text-gray-500">Harga per Pax (Destinasi)</p>
                    <p class="font-bold text-primary">Rp {{ number_format($order->destination->discount_price ?? $order->destination->price, 0, ',', '.') }}</p>
                </div>
                <div class="flex justify-between items-center py-4 border-b border-gray-50">
                    <p class="text-gray-500">Total Harga ({{ $order->jumlah_orang }} Pax)</p>
                    <p class="font-bold text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
                @if($order->destination->type === 'tiket')
                    <div class="flex justify-between items-center py-4">
                        <p class="text-gray-500">Total Pembayaran (Lunas)</p>
                        <p class="font-bold text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>
                @else
                    <div class="flex justify-between items-center py-4 border-b border-gray-50">
                        <p class="text-gray-500">Down Payment (30%)</p>
                        <p class="font-bold text-accent">Rp {{ number_format($order->dp_amount, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex justify-between items-center py-4">
                        <p class="text-gray-500">Sisa Pelunasan (70%)</p>
                        <p class="font-bold text-primary">Rp {{ number_format($order->total_price - $order->dp_amount, 0, ',', '.') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Payment Proofs -->
    <div class="space-y-8">
        <!-- Bukti DP / Bukti Transfer -->
        <div class="luxury-card p-8 bg-white">
            <h3 class="text-xl font-bold text-primary mb-8 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-accent rounded-full"></span>
                {{ $order->destination->type === 'tiket' ? 'Bukti Pembayaran Tiket' : 'Bukti Pembayaran DP' }}
            </h3>
            
            @if($order->payment_proof)
                <div class="rounded-2xl overflow-hidden shadow-2xl border border-gray-100 group relative">
                    <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="bg-white text-primary px-6 py-2 rounded-xl font-bold text-sm shadow-xl">
                            Lihat Full Size
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-gray-50 border-2 border-dashed border-gray-100 rounded-3xl p-12 text-center">
                    <i class="fas fa-image text-4xl text-gray-200 mb-4"></i>
                    <p class="text-gray-400 font-medium text-sm">{{ $order->destination->type === 'tiket' ? 'Belum ada bukti pembayaran.' : 'Belum ada bukti DP.' }}</p>
                </div>
            @endif
        </div>

        @if($order->destination->type !== 'tiket')
        <!-- Bukti Pelunasan -->
        <div class="luxury-card p-8 bg-white">
            <h3 class="text-xl font-bold text-primary mb-8 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-accent rounded-full"></span>
                Bukti Pelunasan
            </h3>
            
            @if($order->pelunasan_proof)
                <div class="rounded-2xl overflow-hidden shadow-2xl border border-gray-100 group relative">
                    <img src="{{ asset('storage/' . $order->pelunasan_proof) }}" class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <a href="{{ asset('storage/' . $order->pelunasan_proof) }}" target="_blank" class="bg-white text-primary px-6 py-2 rounded-xl font-bold text-sm shadow-xl">
                            Lihat Full Size
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-gray-50 border-2 border-dashed border-gray-100 rounded-3xl p-12 text-center">
                    <i class="fas fa-image text-4xl text-gray-200 mb-4"></i>
                    <p class="text-gray-400 font-medium text-sm">Belum ada bukti pelunasan.</p>
                </div>
            @endif
        </div>
        @endif
    </div>
</div>

<script>
    function confirmApproveDp() {
        showAdminConfirm({
            title: '{{ $order->destination->type === "tiket" ? "Konfirmasi Pembayaran?" : "Konfirmasi Pembayaran DP?" }}',
            message: '{{ $order->destination->type === "tiket" ? "Apakah Anda yakin ingin mengonfirmasi pembayaran penuh tiket masuk untuk pesanan ini? Pengguna akan menerima e-ticket QR Code." : "Apakah Anda yakin ingin mengonfirmasi pembayaran Down Payment pesanan ini? Pengguna akan menerima email rincian pelunasan dan grup WA." }}',
            confirmText: '{{ $order->destination->type === "tiket" ? "Ya, Konfirmasi" : "Ya, Konfirmasi DP" }}',
            theme: 'success',
            callback: function() {
                document.getElementById('confirm-dp-form').submit();
            }
        });
    }

    function confirmApprovePelunasan() {
        showAdminConfirm({
            title: 'Konfirmasi Pelunasan?',
            message: 'Apakah Anda yakin ingin mengonfirmasi pelunasan pesanan ini? Status pesanan akan diubah menjadi Lunas.',
            confirmText: 'Ya, Lunas',
            theme: 'success',
            callback: function() {
                document.getElementById('confirm-pelunasan-form').submit();
            }
        });
    }

    function confirmApproveCancellation() {
        showAdminConfirm({
            title: 'Setujui Pembatalan?',
            message: 'Apakah Anda yakin ingin menyetujui pengajuan pembatalan pemesanan ini? Status pesanan akan diubah menjadi dibatalkan.',
            confirmText: 'Ya, Setujui',
            theme: 'danger',
            callback: function() {
                document.getElementById('approve-cancellation-form').submit();
            }
        });
    }

    function confirmRejectCancellation() {
        showAdminConfirm({
            title: 'Tolak Pembatalan?',
            message: 'Apakah Anda yakin ingin menolak pengajuan pembatalan pemesanan ini? Status pesanan akan dikembalikan menjadi terkonfirmasi.',
            confirmText: 'Ya, Tolak',
            theme: 'warning',
            callback: function() {
                document.getElementById('reject-cancellation-form').submit();
            }
        });
    }
</script>
@endsection
