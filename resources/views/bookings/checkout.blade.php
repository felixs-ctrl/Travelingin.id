@extends('layouts.app')

@section('content')
<section class="checkout-section py-20 bg-primary min-h-screen">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-4xl font-bold text-white mb-8 italic">Data Pemesan</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Data Form -->
                <div class="md:col-span-2">
                    <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="destination_id" value="{{ $destination->id }}">
                        <input type="hidden" name="tanggal_booking" value="{{ $destination->travel_date }}">

                        <div class="bg-white/5 backdrop-blur-md p-8 rounded-3xl border border-white/10 shadow-2xl">
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-accent text-[10px] uppercase tracking-widest font-bold mb-2">Nama Lengkap Sesuai ID</label>
                                    <input type="text" name="nama" required class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-4 text-white focus:border-accent outline-none transition-all font-medium">
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-accent text-[10px] uppercase tracking-widest font-bold mb-2">Email Aktif</label>
                                        <input type="email" name="email" required class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-4 text-white focus:border-accent outline-none transition-all font-medium">
                                    </div>
                                    <div>
                                        <label class="block text-accent text-[10px] uppercase tracking-widest font-bold mb-2">Nomor WhatsApp</label>
                                        <input type="text" name="no_hp" required class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-4 text-white focus:border-accent outline-none transition-all font-medium">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-accent text-[10px] uppercase tracking-widest font-bold mb-2">Jumlah Peserta</label>
                                    <div class="flex items-center gap-4 bg-white/5 border border-white/10 rounded-xl px-5 py-2">
                                        <input type="number" name="jumlah_orang" value="{{ $travelers }}" min="1" required class="bg-transparent border-none text-white w-full focus:ring-0 font-bold text-lg">
                                        <span class="text-white/40 font-bold">PAX</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-accent hover:bg-accent-hover text-primary font-bold py-5 rounded-2xl shadow-2xl transition-all transform hover:scale-[1.02] active:scale-95 text-lg">
                            Lanjut ke Pembayaran
                        </button>
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="space-y-6">
                    <div class="bg-white p-8 rounded-3xl shadow-2xl">
                        <h3 class="text-primary font-bold text-xl mb-6">Ringkasan</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-start border-b border-gray-100 pb-4">
                                <div class="flex-1 pr-4">
                                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Tujuan</p>
                                    <p class="text-primary font-bold leading-tight">{{ $destination->name }}</p>
                                </div>
                            </div>
                            
                            <div>
                                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Jadwal</p>
                                <p class="text-primary font-bold">{{ \Carbon\Carbon::parse($destination->travel_date)->format('d M Y') }}</p>
                            </div>

                            <div class="pt-4 border-t border-gray-100">
                                <div class="flex justify-between text-gray-400 text-sm font-bold">
                                    <span>Estimasi Harga</span>
                                    <span>Rp {{ number_format($destination->discount_price ?? $destination->price, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-[10px] text-gray-300 italic mt-1 text-right">*Belum termasuk total pax</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-accent/10 border border-accent/20 p-6 rounded-3xl">
                        <div class="flex items-start gap-4">
                            <i class="fas fa-shield-alt text-accent text-xl mt-1"></i>
                            <div>
                                <p class="text-accent font-bold text-xs uppercase tracking-widest">Aman & Terpercaya</p>
                                <p class="text-white/60 text-[10px] mt-1">Data Anda dilindungi oleh enkripsi standar industri.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
