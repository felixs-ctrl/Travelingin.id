@extends('layouts.user')

@section('title', 'Profil Saya')
@section('page_title', 'Dashboard Profil')

@section('content')
<div class="space-y-10">
    <!-- Hero Banner -->
    <div class="relative rounded-[40px] overflow-hidden bg-primary p-12 flex items-center justify-between min-h-[300px]">
        <div class="relative z-10 max-w-lg">
            <h2 class="text-4xl font-bold text-white mb-4 italic">Halo, {{ Auth::user()->name }}</h2>
            <p class="text-white/50 leading-relaxed">Siap untuk merencanakan petualangan besar berikutnya? Ayo buat kenangan yang tak terlupakan bersama Travelingin.id.</p>
        </div>
        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="absolute right-0 top-0 h-full w-1/2 object-cover opacity-60" style="clip-path: polygon(20% 0, 100% 0, 100% 100%, 0% 100%);">
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-8 rounded-[30px] border border-gray-50 shadow-sm group hover:bg-primary transition-all duration-500">
            <div class="w-12 h-12 bg-accent/10 rounded-2xl flex items-center justify-center text-accent mb-6 group-hover:bg-white/10">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 group-hover:text-white/40">Total Booking</p>
            <h3 class="text-3xl font-bold text-primary group-hover:text-white">{{ $bookingsCount }}</h3>
        </div>
        <div class="bg-white p-8 rounded-[30px] border border-gray-50 shadow-sm group hover:bg-primary transition-all duration-500">
            <div class="w-12 h-12 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-500 mb-6 group-hover:bg-white/10">
                <i class="fas fa-map-marked-alt"></i>
            </div>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 group-hover:text-white/40">Tempat Dikunjungi</p>
            <h3 class="text-3xl font-bold text-primary group-hover:text-white">{{ $visitedCount }}</h3>
        </div>
        <div class="bg-white p-8 rounded-[30px] border border-gray-50 shadow-sm group hover:bg-primary transition-all duration-500">
            <div class="w-12 h-12 bg-pink-500/10 rounded-2xl flex items-center justify-center text-pink-500 mb-6 group-hover:bg-white/10">
                <i class="fas fa-star"></i>
            </div>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 group-hover:text-white/40">Loyalty Points</p>
            <h3 class="text-3xl font-bold text-primary group-hover:text-white">{{ number_format($totalPoints, 0, ',', '.') }}</h3>
        </div>
    </div>

    <!-- Forms -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 pb-20">
        <!-- Update Info -->
        <div class="bg-white p-10 rounded-[40px] shadow-sm border border-gray-50">
            <h3 class="text-2xl font-bold text-primary mb-8 flex items-center gap-4">
                <span class="w-1.5 h-6 bg-accent rounded-full"></span>
                Informasi Profil
            </h3>
            
            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                    <input name="name" type="text" value="{{ old('name', $user->name) }}" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-primary font-bold focus:ring-2 focus:ring-accent outline-none">
                    <x-input-error class="text-red-500 text-[10px] mt-1" :messages="$errors->get('name')" />
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Alamat Email</label>
                    <input name="email" type="email" value="{{ old('email', $user->email) }}" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-primary font-bold focus:ring-2 focus:ring-accent outline-none">
                    <x-input-error class="text-red-500 text-[10px] mt-1" :messages="$errors->get('email')" />
                </div>
                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" class="bg-primary text-accent font-bold px-8 py-4 rounded-2xl shadow-xl shadow-primary/20 hover:scale-105 transition-transform text-sm uppercase tracking-widest">
                        Simpan Perubahan
                    </button>
                    @if (session('status') === 'profile-updated')
                        <span class="text-emerald-500 text-xs font-bold animate-pulse">Tersimpan!</span>
                    @endif
                </div>
            </form>
        </div>

        <!-- Update Password -->
        <div class="bg-white p-10 rounded-[40px] shadow-sm border border-gray-100">
            <h3 class="text-2xl font-bold text-primary mb-8 flex items-center gap-4">
                <span class="w-1.5 h-6 bg-accent rounded-full"></span>
                Ganti Kata Sandi
            </h3>
            
            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                @method('put')
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Sandi Saat Ini</label>
                    <input name="current_password" type="password" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-primary font-bold focus:ring-2 focus:ring-accent outline-none">
                    <x-input-error class="text-red-500 text-[10px] mt-1" :messages="$errors->updatePassword->get('current_password')" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Sandi Baru</label>
                        <input name="password" type="password" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-primary font-bold focus:ring-2 focus:ring-accent outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Konfirmasi</label>
                        <input name="password_confirmation" type="password" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-primary font-bold focus:ring-2 focus:ring-accent outline-none">
                    </div>
                </div>
                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" class="bg-primary text-accent font-bold px-8 py-4 rounded-2xl shadow-xl shadow-primary/20 hover:scale-105 transition-transform text-sm uppercase tracking-widest">
                        Update Sandi
                    </button>
                    @if (session('status') === 'password-updated')
                        <span class="text-emerald-500 text-xs font-bold animate-pulse">Terupdate!</span>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
