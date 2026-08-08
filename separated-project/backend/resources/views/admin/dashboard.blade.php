@extends('layouts.admin')
@section('title', 'Ringkasan Sistem')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
    <div class="luxury-card p-8 group hover:bg-primary transition-all duration-500">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-gray-400 text-[10px] uppercase tracking-widest font-bold group-hover:text-white/50 transition-colors">Total Destinasi</h3>
            <span class="bg-primary/5 text-primary p-3 rounded-2xl group-hover:bg-white/10 group-hover:text-accent transition-all duration-500"><i class="fas fa-map-marked-alt text-xl"></i></span>
        </div>
        <p class="text-4xl font-bold text-primary group-hover:text-white transition-colors">{{ $totalProducts }}</p>
        <p class="text-[10px] text-gray-400 mt-2 group-hover:text-white/30 transition-colors tracking-tighter italic">Produk aktif dalam katalog</p>
    </div>

    <div class="luxury-card p-8 group hover:bg-primary transition-all duration-500">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-gray-400 text-[10px] uppercase tracking-widest font-bold group-hover:text-white/50 transition-colors">Total Pesanan</h3>
            <span class="bg-primary/5 text-primary p-3 rounded-2xl group-hover:bg-white/10 group-hover:text-accent transition-all duration-500"><i class="fas fa-shopping-bag text-xl"></i></span>
        </div>
        <p class="text-4xl font-bold text-primary group-hover:text-white transition-colors">{{ $totalOrders }}</p>
        <p class="text-[10px] text-gray-400 mt-2 group-hover:text-white/30 transition-colors tracking-tighter italic">{{ $confirmedOrders }} Pesanan Terverifikasi</p>
    </div>

    <div class="luxury-card p-8 border-l-4 border-l-accent group hover:bg-primary transition-all duration-500">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-gray-400 text-[10px] uppercase tracking-widest font-bold group-hover:text-white/50 transition-colors">Menunggu Verifikasi</h3>
            <span class="bg-accent/10 text-accent p-3 rounded-2xl group-hover:bg-white/10 group-hover:text-accent transition-all duration-500"><i class="fas fa-hourglass-half text-xl"></i></span>
        </div>
        <p class="text-4xl font-bold text-primary group-hover:text-white transition-colors">{{ $pendingOrders }}</p>
        <p class="text-[10px] text-accent mt-2 group-hover:text-accent transition-colors tracking-tighter italic">Perlu tindakan segera</p>
    </div>

    <div class="luxury-card p-8 bg-primary group">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-white/40 text-[10px] uppercase tracking-widest font-bold">Total Pendapatan</h3>
            <span class="bg-white/10 text-accent p-3 rounded-2xl"><i class="fas fa-coins text-xl"></i></span>
        </div>
        <p class="text-2xl font-bold text-white tracking-tight">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
        <div class="mt-4 flex items-center gap-2">
            <span class="text-[10px] text-white/30 uppercase tracking-widest font-bold">Total dari pesanan terverifikasi</span>
        </div>
    </div>
</div>

<div class="luxury-card overflow-hidden">
    <div class="p-10 flex flex-col md:flex-row items-center gap-10 bg-white">
        <div class="flex-1">
            <h2 class="text-3xl font-bold text-primary mb-4 italic">Selamat Datang, Administrator.</h2>
            <p class="text-gray-500 leading-relaxed max-w-2xl">Dashboard ini dirancang khusus untuk memudahkan Anda mengelola setiap aspek dari Travelingin.id. Gunakan navigasi di sisi kiri untuk memantau pesanan masuk, memperbarui katalog destinasi, atau mengelola penawaran spesial untuk pelanggan setia Anda.</p>
            <div class="mt-8 flex gap-4">
                <a href="{{ route('admin.products.index') }}" class="bg-primary text-accent px-8 py-3 rounded-xl font-bold text-sm shadow-xl shadow-primary/20 hover:scale-105 transition-transform">Kelola Katalog</a>
                <a href="{{ route('admin.orders.index') }}" class="bg-gray-50 text-primary px-8 py-3 rounded-xl font-bold text-sm hover:bg-gray-100 transition-colors">Lihat Pesanan</a>
            </div>
        </div>
        <div class="w-full md:w-80">
            <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="rounded-3xl shadow-2xl rotate-3">
        </div>
    </div>
</div>
@endsection