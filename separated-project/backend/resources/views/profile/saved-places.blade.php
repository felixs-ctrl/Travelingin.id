@extends('layouts.user')

@section('title', 'Tempat Disimpan')
@section('page_title', 'Destinasi Favorit')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($savedDestinations as $dest)
        <div class="bg-white rounded-[40px] p-6 shadow-sm border border-gray-50 group hover:shadow-xl transition-all duration-500 overflow-hidden">
            <div class="h-48 rounded-[30px] overflow-hidden mb-6 relative">
                @if($dest->image)
                    <img src="{{ Str::startsWith($dest->image, ['http://', 'https://']) ? $dest->image : asset('storage/' . $dest->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                @else
                    <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                @endif
                <button class="absolute top-4 right-4 w-10 h-10 bg-white/20 backdrop-blur rounded-full flex items-center justify-center text-red-500">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
            <h3 class="text-xl font-bold text-primary mb-2 italic">{{ $dest->name }}</h3>
            <p class="text-gray-400 text-xs mb-6 leading-relaxed">{{ Str::limit($dest->description, 100) }}</p>
            <a href="{{ route('destinations.show', $dest->id) }}" class="block text-center bg-primary text-accent font-bold py-3 rounded-2xl text-[10px] uppercase tracking-widest hover:bg-secondary transition-colors font-body">Lihat Detail</a>
        </div>
        @endforeach

        <div class="bg-white rounded-[40px] p-6 shadow-sm border border-gray-50 group hover:shadow-xl transition-all duration-500 overflow-hidden opacity-50 grayscale">
            <div class="h-48 rounded-[30px] overflow-hidden mb-6 relative">
                <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover">
            </div>
            <h3 class="text-xl font-bold text-primary mb-2 italic">Bali, Indonesia</h3>
            <p class="text-gray-400 text-xs mb-6 font-body">Coming Soon - Tambahkan ke daftar impian Anda.</p>
        </div>
    </div>

    <!-- Info Box -->
    <div class="bg-accent/5 border border-accent/10 rounded-[30px] p-8 flex items-center gap-6 mt-12">
        <div class="w-14 h-14 bg-accent/20 rounded-2xl flex items-center justify-center text-accent">
            <i class="fas fa-lightbulb text-2xl"></i>
        </div>
        <div>
            <h4 class="text-primary font-bold mb-1">Tips Perjalanan</h4>
            <p class="text-gray-500 text-sm">Simpan destinasi yang Anda sukai untuk memudahkan perencanaan liburan di masa mendatang.</p>
        </div>
    </div>
</div>
@endsection
