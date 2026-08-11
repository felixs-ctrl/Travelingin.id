<!-- Load Tailwind CSS dynamically for pages that do not extend the admin layout -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        corePlugins: {
            preflight: false,
        },
        theme: {
            extend: {
                colors: {
                    primary: '#0A192F',
                    'primary-light': '#112240',
                    accent: '#D4AF37',
                    'accent-hover': '#B8860B',
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
    #bookingModal.hidden {
        display: none !important;
    }
</style>

<!-- Booking Modal -->
<div id="bookingModal" class="fixed inset-0 z-50 flex items-center justify-center hidden" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-[#0A192F]/80 backdrop-blur-md transition-opacity duration-300" onclick="closeBookingModal()"></div>
    
    <!-- Modal Card -->
    <div class="relative bg-[#0A192F] text-white w-full max-w-2xl mx-4 rounded-3xl border border-[#D4AF37]/30 shadow-2xl overflow-y-auto max-h-[90vh] md:max-h-none md:overflow-hidden transform scale-95 opacity-0 transition-all duration-300 z-10" id="bookingModalCard">
        <!-- Close Button -->
        <button onclick="closeBookingModal()" class="absolute top-4 right-4 md:top-6 md:right-6 text-white/50 hover:text-[#D4AF37] transition-colors focus:outline-none z-20">
            <i class="fas fa-times text-xl"></i>
        </button>

        <div class="grid grid-cols-1 md:grid-cols-12">
            <!-- Left Panel (Summary) -->
            <div class="md:col-span-5 bg-[#112240] p-5 md:p-8 flex flex-col justify-between border-b md:border-b-0 md:border-r border-[#D4AF37]/10">
                <div>
                    <span class="text-[#D4AF37] text-[10px] uppercase tracking-widest font-bold block mb-2">Pilihan Perjalanan</span>
                    <h3 id="modalDestName" class="text-2xl font-bold text-white mb-4 leading-tight">Nama Destinasi</h3>
                    
                    <div class="space-y-3 text-sm text-white/70">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-calendar-alt text-[#D4AF37] w-5"></i>
                            <span id="modalDestDate">15 Jun 2026</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-tag text-[#D4AF37] w-5"></i>
                            <span>Rp <span id="modalDestPrice">0</span> / pax</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-white/5 space-y-4">
                    <div id="modalDPContainer">
                        <p class="text-white/40 text-[10px] uppercase tracking-widest font-bold">Down Payment (30%)</p>
                        <p id="modalDPPrice" class="text-xl font-bold text-[#D4AF37]">Rp 0</p>
                    </div>
                    <div>
                        <p class="text-white/40 text-[10px] uppercase tracking-widest font-bold">Total Estimasi</p>
                        <p id="modalTotalPrice" class="text-lg font-bold text-white">Rp 0</p>
                    </div>
                </div>
            </div>

            <!-- Right Panel (Form) -->
            <form action="{{ route('bookings.store') }}" method="POST" class="md:col-span-7 p-5 md:p-8 space-y-4 md:space-y-5">
                @csrf
                <input type="hidden" name="destination_id" id="modalDestIdInput">
                <input type="hidden" name="tanggal_booking" id="modalTravelDateInput">

                <div>
                    <h4 class="text-lg font-bold text-white">Konfirmasi Pemesanan</h4>
                    <p class="text-xs text-white/50">Silakan lengkapi detail kontak untuk melanjutkan pemesanan</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-[#D4AF37] text-[10px] uppercase tracking-widest font-bold mb-1.5">Nama Lengkap (Sesuai ID)</label>
                        <input type="text" name="nama" required value="{{ Auth::check() ? Auth::user()->name : '' }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-[#D4AF37] outline-none transition-all">
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[#D4AF37] text-[10px] uppercase tracking-widest font-bold mb-1.5">Email Aktif</label>
                            <input type="email" name="email" required value="{{ Auth::check() ? Auth::user()->email : '' }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-[#D4AF37] outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[#D4AF37] text-[10px] uppercase tracking-widest font-bold mb-1.5">No. WhatsApp</label>
                            <input type="text" name="no_hp" required placeholder="0812xxxx" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-[#D4AF37] outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[#D4AF37] text-[10px] uppercase tracking-widest font-bold mb-1.5">Jumlah Peserta</label>
                        <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl px-4 py-1">
                            <input type="number" name="jumlah_orang" id="modalTravelersInput" value="1" min="1" required class="bg-transparent border-none text-white w-full focus:ring-0 font-bold text-base outline-none" oninput="calculateModalPrices()">
                            <span class="text-white/40 font-bold text-xs uppercase tracking-wider">Pax</span>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-[#D4AF37] to-[#B8860B] text-[#0A192F] font-bold py-4 rounded-xl shadow-lg shadow-[#D4AF37]/10 hover:scale-[1.02] active:scale-95 transition-all text-sm uppercase tracking-wider">
                        Lanjut ke Pembayaran <i class="fas fa-arrow-right ml-1"></i>
                    </button>
                    <p id="modalFooterNote" class="text-[10px] text-white/40 text-center mt-2.5">* Pembayaran DP 30% wajib dikonfirmasi untuk memesan slot.</p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentModalPrice = 0;
    let currentModalType = '';

    function openBookingModal(destId, destName, travelDate, price, type) {
        // Redirect to login if user is guest
        const isAuthenticated = {{ Auth::check() ? 'true' : 'false' }};
        if (!isAuthenticated) {
            window.location.href = "{{ route('login') }}";
            return;
        }

        const modal = document.getElementById('bookingModal');
        const card = document.getElementById('bookingModalCard');
        
        // Populate fields
        document.getElementById('modalDestIdInput').value = destId;
        document.getElementById('modalTravelDateInput').value = travelDate;
        document.getElementById('modalDestName').innerText = destName;
        currentModalType = type;
        
        // Format date beautifully if possible
        let formattedDate = travelDate;
        if (travelDate) {
            try {
                const dateObj = new Date(travelDate);
                formattedDate = dateObj.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            } catch (e) {
                formattedDate = travelDate;
            }
        } else {
            formattedDate = "Hubungi Kami";
        }
        document.getElementById('modalDestDate').innerText = formattedDate;
        
        currentModalPrice = parseFloat(price);
        document.getElementById('modalDestPrice').innerText = currentModalPrice.toLocaleString('id-ID');
        document.getElementById('modalTravelersInput').value = 1;
        
        calculateModalPrices();

        // Show Modal
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        
        // Animation
        setTimeout(() => {
            card.classList.remove('scale-95', 'opacity-0');
            card.classList.add('scale-100', 'opacity-100');
        }, 50);
    }

    function closeBookingModal() {
        const modal = document.getElementById('bookingModal');
        const card = document.getElementById('bookingModalCard');

        // Animation
        card.classList.remove('scale-100', 'opacity-100');
        card.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    function calculateModalPrices() {
        const travelers = parseInt(document.getElementById('modalTravelersInput').value) || 1;
        const total = currentModalPrice * travelers;
        
        const dpContainer = document.getElementById('modalDPContainer');
        const footerNote = document.getElementById('modalFooterNote');

        if (currentModalType === 'tiket') {
            if (dpContainer) dpContainer.classList.add('hidden');
            if (footerNote) footerNote.innerText = "* Tiket masuk wajib dibayar lunas untuk mendapatkan invoice tiket.";
        } else {
            if (dpContainer) dpContainer.classList.remove('hidden');
            if (footerNote) footerNote.innerText = "* Pembayaran DP 30% wajib dikonfirmasi untuk memesan slot.";
            const dp = total * 0.3;
            document.getElementById('modalDPPrice').innerText = "Rp " + dp.toLocaleString('id-ID');
        }

        document.getElementById('modalTotalPrice').innerText = "Rp " + total.toLocaleString('id-ID');
    }
</script>
