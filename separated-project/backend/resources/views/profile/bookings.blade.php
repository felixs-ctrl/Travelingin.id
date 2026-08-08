@extends('layouts.user')

@section('title', 'Pemesanan Saya')
@section('page_title', 'Riwayat Perjalanan')

@section('content')
<div class="space-y-8">
    @forelse($bookings as $booking)
        <div class="bg-white rounded-[40px] p-8 shadow-sm border border-gray-50 flex flex-col md:flex-row items-center gap-10 hover:shadow-xl transition-all duration-500 group">
            <div class="w-full md:w-64 h-44 rounded-[30px] overflow-hidden shrink-0">
                <img src="{{ $booking->destination->image ? (Str::startsWith($booking->destination->image, ['http://', 'https://']) ? $booking->destination->image : asset('storage/' . $booking->destination->image)) : 'https://images.unsplash.com/photo-1506012733851-bb9745564c73?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            </div>
            
            <div class="flex-1 space-y-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold text-primary italic">{{ $booking->destination->name }}</h3>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">
                            <i class="fas fa-calendar-alt text-accent mr-2"></i> {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                        </p>
                    </div>
                    @if($booking->status == 'pending')
                        <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-widest">{{ $booking->destination->type === 'tiket' ? 'Menunggu Pembayaran' : 'Menunggu DP' }}</span>
                    @elseif($booking->status == 'dp_processed')
                        <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-widest">{{ $booking->destination->type === 'tiket' ? 'Pembayaran Diproses' : 'DP Diproses' }}</span>
                    @elseif($booking->status == 'confirmed')
                        <span class="bg-indigo-100 text-indigo-700 text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-widest">{{ $booking->destination->type === 'tiket' ? 'Dikonfirmasi' : 'DP Dikonfirmasi' }}</span>
                    @elseif($booking->status == 'pelunasan_processed')
                        <span class="bg-purple-100 text-purple-700 text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-widest">Pelunasan Diproses</span>
                    @elseif($booking->status == 'lunas')
                        <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-widest">Lunas</span>
                    @elseif($booking->status == 'cancel_pending')
                        <span class="bg-orange-100 text-orange-700 text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-widest">Pengajuan Batal</span>
                    @elseif($booking->status == 'cancelled')
                        <span class="bg-rose-100 text-rose-700 text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-widest">Dibatalkan</span>
                    @else
                        <span class="bg-gray-100 text-gray-700 text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-widest">{{ strtoupper($booking->status) }}</span>
                    @endif
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-5 gap-6 pt-4 border-t border-gray-50">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">ID Booking</p>
                        <p class="text-sm font-bold text-primary">#TRV-{{ $booking->id }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Peserta</p>
                        <p class="text-sm font-bold text-primary">{{ $booking->jumlah_orang }} Pax</p>
                    </div>
                    @if($booking->destination->type === 'tiket')
                        <div class="col-span-2">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Tagihan (Lunas)</p>
                            <p class="text-sm font-bold text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </div>
                    @else
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">DP (30%)</p>
                            <p class="text-sm font-bold text-accent">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Pelunasan (70%)</p>
                            <p class="text-sm font-bold text-primary">Rp {{ number_format($booking->total_price - $booking->dp_amount, 0, ',', '.') }}</p>
                        </div>
                    @endif
                    <div class="text-right flex items-center justify-end gap-3 col-span-2 md:col-span-1 flex-wrap md:flex-nowrap shrink-0">
                        @if($booking->status == 'pending')
                            <a href="{{ route('bookings.payment', $booking->id) }}" class="inline-block bg-primary text-white text-[10px] font-bold px-6 py-2.5 rounded-xl hover:bg-secondary transition-colors whitespace-nowrap">
                                {{ $booking->destination->type === 'tiket' ? 'Bayar Lunas' : 'Bayar DP' }}
                            </a>
                        @elseif($booking->status == 'dp_processed')
                            <span class="text-[10px] text-blue-500 font-bold uppercase tracking-widest bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100 whitespace-nowrap">
                                {{ $booking->destination->type === 'tiket' ? 'Pembayaran Diproses' : 'DP Diproses' }}
                            </span>
                        @elseif($booking->status == 'confirmed')
                            @if($booking->destination->type === 'tiket')
                                <span class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100 whitespace-nowrap">Lunas</span>
                            @else
                                <a href="{{ route('bookings.payment', $booking->id) }}" class="inline-block bg-accent text-primary text-[10px] font-bold px-6 py-2.5 rounded-xl hover:bg-accent-hover transition-colors whitespace-nowrap">Bayar Pelunasan</a>
                            @endif
                        @elseif($booking->status == 'pelunasan_processed')
                            <span class="text-[10px] text-purple-500 font-bold uppercase tracking-widest bg-purple-50 px-3 py-1.5 rounded-lg border border-purple-100 whitespace-nowrap">Pelunasan Diproses</span>
                        @elseif($booking->status == 'cancel_pending')
                            <span class="text-[10px] text-orange-500 font-bold uppercase tracking-widest bg-orange-50 px-3 py-1.5 rounded-lg border border-orange-100 whitespace-nowrap">Menunggu Batal</span>
                        @elseif($booking->status == 'cancelled')
                            <span class="text-[10px] text-rose-500 font-bold uppercase tracking-widest bg-rose-50 px-3 py-1.5 rounded-lg border border-rose-100 whitespace-nowrap">Dibatalkan</span>
                        @endif

                        @if(in_array($booking->status, ['confirmed', 'pelunasan_processed', 'lunas']))
                            <a href="{{ route('bookings.invoice', $booking->id) }}" target="_blank" class="inline-flex items-center gap-1.5 text-primary hover:text-accent font-bold text-[10px] uppercase tracking-widest bg-gray-50 border border-gray-100 px-4 py-2.5 rounded-xl transition-all whitespace-nowrap">
                                <i class="fas fa-file-invoice text-xs"></i> 
                                <span>Invoice</span>
                            </a>
                            
                            @if(in_array($booking->status, ['confirmed', 'pelunasan_processed']) && $booking->destination->type !== 'tiket')
                                <button type="button" onclick="openCancelModal({{ $booking->id }}, '{{ $booking->destination->name }}')" class="inline-flex items-center gap-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-[10px] font-bold px-4 py-2.5 rounded-xl transition-all whitespace-nowrap">
                                    <i class="fas fa-times-circle text-xs"></i>
                                    <span>Batal</span>
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-[40px] p-20 text-center border border-gray-50 shadow-sm">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-plane-slash text-4xl text-gray-200"></i>
            </div>
            <h3 class="text-2xl font-bold text-primary mb-2">Belum Ada Perjalanan</h3>
            <p class="text-gray-400 max-w-sm mx-auto">Anda belum melakukan pemesanan apapun. Ayo temukan destinasi impian Anda sekarang!</p>
            <a href="{{ url('/destinations') }}" class="inline-block bg-primary text-accent font-bold px-10 py-4 rounded-2xl mt-8 shadow-xl shadow-primary/20 hover:scale-105 transition-transform uppercase tracking-widest text-xs">
                Jelajahi Destinasi
            </a>
        </div>
    @endforelse
</div>

<!-- Modal Pengajuan Pembatalan -->
<div id="cancelBookingModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-[#0A192F]/60 backdrop-blur-sm transition-opacity duration-300" onclick="closeCancelModal()"></div>
    
    <!-- Modal Card -->
    <div class="relative bg-white text-primary w-full max-w-md mx-4 rounded-3xl border border-gray-100 shadow-2xl p-8 transform scale-95 opacity-0 transition-all duration-300 z-10" id="cancelBookingModalCard">
        <div class="w-16 h-16 bg-rose-50 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-times-circle text-2xl"></i>
        </div>
        
        <h3 class="text-xl font-bold text-center text-primary mb-2">Ajukan Pembatalan?</h3>
        <p class="text-sm text-center text-gray-400 leading-relaxed mb-6">Apakah Anda yakin ingin mengajukan pembatalan perjalanan ke <span id="cancelDestName" class="font-bold text-primary"></span>?</p>
        
        <form id="cancelBookingForm" method="POST" action="">
            @csrf
            
            <div class="mb-6">
                <label for="cancellation_reason" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Alasan Pembatalan</label>
                <textarea id="cancellation_reason" name="cancellation_reason" rows="4" required minlength="10" placeholder="Tuliskan alasan pembatalan perjalanan Anda di sini..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 text-sm transition-all"></textarea>
                <p class="text-[10px] text-gray-400 mt-2">Minimal 10 karakter.</p>
            </div>
            
            <div class="flex items-center gap-4">
                <button type="button" onclick="closeCancelModal()" class="flex-1 py-3.5 rounded-xl border border-gray-200 text-gray-500 font-bold text-sm hover:bg-gray-50 transition-colors">
                    Kembali
                </button>
                <button type="submit" class="flex-1 py-3.5 rounded-xl bg-rose-600 text-white font-bold text-sm hover:bg-rose-700 shadow-lg shadow-rose-600/20 transition-all">
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCancelModal(bookingId, destName) {
        const modal = document.getElementById('cancelBookingModal');
        const card = document.getElementById('cancelBookingModalCard');
        const form = document.getElementById('cancelBookingForm');
        const destSpan = document.getElementById('cancelDestName');
        
        // Set values
        destSpan.innerText = destName;
        form.action = `/bookings/${bookingId}/cancel`;
        
        // Show modal
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        setTimeout(() => {
            card.classList.remove('scale-95', 'opacity-0');
            card.classList.add('scale-100', 'opacity-100');
        }, 50);
    }

    function closeCancelModal() {
        const modal = document.getElementById('cancelBookingModal');
        const card = document.getElementById('cancelBookingModalCard');
        
        card.classList.remove('scale-100', 'opacity-100');
        card.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }
</script>
@endsection
