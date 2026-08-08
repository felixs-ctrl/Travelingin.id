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
    #tripFinderModal.hidden {
        display: none !important;
    }
    
    .wizard-step.hidden {
        display: none !important;
    }

    /* Option Card Styling */
    .option-card-label input:checked ~ .option-card-inner {
        border-color: #D4AF37;
        background: rgba(212, 175, 55, 0.08);
        transform: translateY(-2px);
    }
    
    .option-card-label input:checked ~ .option-card-inner i {
        color: #D4AF37;
    }
</style>

<!-- Trip Finder Modal -->
<div id="tripFinderModal" class="fixed inset-0 z-50 flex items-center justify-center hidden" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-[#0A192F]/80 backdrop-blur-md transition-opacity duration-300" onclick="closeTripFinderModal()"></div>
    
    <!-- Modal Card -->
    <div class="relative bg-[#0A192F] text-white w-full max-w-2xl mx-4 rounded-3xl border border-[#D4AF37]/30 shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 z-10 p-8" id="tripFinderCard">
        <!-- Close Button -->
        <button onclick="closeTripFinderModal()" class="absolute top-6 right-6 text-white/50 hover:text-[#D4AF37] transition-colors focus:outline-none z-20">
            <i class="fas fa-times text-xl"></i>
        </button>

        <!-- Progress Indicator -->
        <div class="flex items-center justify-center gap-2 mb-8 mt-2" id="wizardProgress">
            <div class="step-dot w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs bg-[#D4AF37] text-[#0A192F]">1</div>
            <div class="w-10 h-0.5 bg-white/10" id="line-step-1"></div>
            <div class="step-dot w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs bg-white/5 text-white/40">2</div>
            <div class="w-10 h-0.5 bg-white/10" id="line-step-2"></div>
            <div class="step-dot w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs bg-white/5 text-white/40">3</div>
            <div class="w-10 h-0.5 bg-white/10" id="line-step-3"></div>
            <div class="step-dot w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs bg-white/5 text-white/40"><i class="fas fa-sparkles"></i></div>
        </div>

        <!-- Title block -->
        <div class="text-center mb-6">
            <h3 id="wizardTitle" class="text-2xl font-heading font-bold text-white mb-2">Trip Finder</h3>
            <p id="wizardSubtitle" class="text-sm text-white/60">Temukan perjalanan yang paling sesuai dengan preferensi Anda.</p>
        </div>

        <form id="tripFinderForm" onsubmit="event.preventDefault(); submitTripFinder();">
            <!-- STEP 1: BUDGET -->
            <div class="wizard-step" id="step-budget">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                    <!-- Economy -->
                    <label class="option-card-label cursor-pointer relative block">
                        <input type="radio" name="budget" value="economy" checked class="absolute opacity-0 w-0 h-0">
                        <div class="option-card-inner flex flex-col items-center justify-center p-6 bg-white/5 border-2 border-transparent rounded-2xl transition-all duration-300 hover:bg-white/10 text-center">
                            <i class="fas fa-wallet text-2xl text-white/40 mb-3 transition-colors"></i>
                            <span class="font-bold text-sm block mb-1">Ekonomi</span>
                            <span class="text-[10px] text-white/50">Di bawah Rp 2jt</span>
                        </div>
                    </label>
                    <!-- Mid -->
                    <label class="option-card-label cursor-pointer relative block">
                        <input type="radio" name="budget" value="mid" class="absolute opacity-0 w-0 h-0">
                        <div class="option-card-inner flex flex-col items-center justify-center p-6 bg-white/5 border-2 border-transparent rounded-2xl transition-all duration-300 hover:bg-white/10 text-center">
                            <i class="fas fa-coins text-2xl text-white/40 mb-3 transition-colors"></i>
                            <span class="font-bold text-sm block mb-1">Menengah</span>
                            <span class="text-[10px] text-white/50">Rp 2jt - Rp 7jt</span>
                        </div>
                    </label>
                    <!-- Luxury -->
                    <label class="option-card-label cursor-pointer relative block">
                        <input type="radio" name="budget" value="luxury" class="absolute opacity-0 w-0 h-0">
                        <div class="option-card-inner flex flex-col items-center justify-center p-6 bg-white/5 border-2 border-transparent rounded-2xl transition-all duration-300 hover:bg-white/10 text-center">
                            <i class="fas fa-crown text-2xl text-white/40 mb-3 transition-colors"></i>
                            <span class="font-bold text-sm block mb-1">Luxury</span>
                            <span class="text-[10px] text-white/50">Di atas Rp 7jt</span>
                        </div>
                    </label>
                </div>
                
                <div class="flex justify-end pt-2">
                    <button type="button" onclick="goToStep(2)" class="bg-[#D4AF37] hover:bg-[#B8860B] text-[#0A192F] font-bold px-8 py-3 rounded-xl transition-all flex items-center gap-2 text-sm uppercase tracking-wider">
                        Lanjut <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- STEP 2: GROUP TYPE -->
            <div class="wizard-step hidden" id="step-group">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                    <!-- Family -->
                    <label class="option-card-label cursor-pointer relative block">
                        <input type="radio" name="package_type" value="family" checked class="absolute opacity-0 w-0 h-0">
                        <div class="option-card-inner flex flex-col items-center justify-center p-6 bg-white/5 border-2 border-transparent rounded-2xl transition-all duration-300 hover:bg-white/10 text-center">
                            <i class="fas fa-users text-2xl text-white/40 mb-3 transition-colors"></i>
                            <span class="font-bold text-sm block">Family</span>
                        </div>
                    </label>
                    <!-- Backpacker -->
                    <label class="option-card-label cursor-pointer relative block">
                        <input type="radio" name="package_type" value="backpacker" class="absolute opacity-0 w-0 h-0">
                        <div class="option-card-inner flex flex-col items-center justify-center p-6 bg-white/5 border-2 border-transparent rounded-2xl transition-all duration-300 hover:bg-white/10 text-center">
                            <i class="fas fa-hiking text-2xl text-white/40 mb-3 transition-colors"></i>
                            <span class="font-bold text-sm block">Backpacker</span>
                        </div>
                    </label>
                    <!-- General -->
                    <label class="option-card-label cursor-pointer relative block">
                        <input type="radio" name="package_type" value="general" class="absolute opacity-0 w-0 h-0">
                        <div class="option-card-inner flex flex-col items-center justify-center p-6 bg-white/5 border-2 border-transparent rounded-2xl transition-all duration-300 hover:bg-white/10 text-center">
                            <i class="fas fa-user-friends text-2xl text-white/40 mb-3 transition-colors"></i>
                            <span class="font-bold text-sm block">General</span>
                        </div>
                    </label>
                </div>
                
                <div class="flex justify-between pt-2">
                    <button type="button" onclick="goToStep(1)" class="border border-white/20 hover:bg-white/5 text-white font-bold px-6 py-3 rounded-xl transition-all text-sm uppercase tracking-wider">
                        Kembali
                    </button>
                    <button type="button" onclick="goToStep(3)" class="bg-[#D4AF37] hover:bg-[#B8860B] text-[#0A192F] font-bold px-8 py-3 rounded-xl transition-all flex items-center gap-2 text-sm uppercase tracking-wider">
                        Lanjut <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- STEP 3: FOCUS / CATEGORY -->
            <div class="wizard-step hidden" id="step-focus">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                    <!-- Paket -->
                    <label class="option-card-label cursor-pointer relative block">
                        <input type="radio" name="type" value="paket" checked class="absolute opacity-0 w-0 h-0">
                        <div class="option-card-inner flex flex-col items-center justify-center p-6 bg-white/5 border-2 border-transparent rounded-2xl transition-all duration-300 hover:bg-white/10 text-center">
                            <i class="fas fa-box-open text-2xl text-white/40 mb-3 transition-colors"></i>
                            <span class="font-bold text-sm block">All-in Paket</span>
                        </div>
                    </label>
                    <!-- Tiket -->
                    <label class="option-card-label cursor-pointer relative block">
                        <input type="radio" name="type" value="tiket" class="absolute opacity-0 w-0 h-0">
                        <div class="option-card-inner flex flex-col items-center justify-center p-6 bg-white/5 border-2 border-transparent rounded-2xl transition-all duration-300 hover:bg-white/10 text-center">
                            <i class="fas fa-ticket-alt text-2xl text-white/40 mb-3 transition-colors"></i>
                            <span class="font-bold text-sm block">Tiket Saja</span>
                        </div>
                    </label>
                    <!-- Tourguide -->
                    <label class="option-card-label cursor-pointer relative block">
                        <input type="radio" name="type" value="tourguide" class="absolute opacity-0 w-0 h-0">
                        <div class="option-card-inner flex flex-col items-center justify-center p-6 bg-white/5 border-2 border-transparent rounded-2xl transition-all duration-300 hover:bg-white/10 text-center">
                            <i class="fas fa-map-signs text-2xl text-white/40 mb-3 transition-colors"></i>
                            <span class="font-bold text-sm block">Tour Guide</span>
                        </div>
                    </label>
                </div>
                
                <div class="flex justify-between pt-2">
                    <button type="button" onclick="goToStep(2)" class="border border-white/20 hover:bg-white/5 text-white font-bold px-6 py-3 rounded-xl transition-all text-sm uppercase tracking-wider">
                        Kembali
                    </button>
                    <button type="submit" class="bg-gradient-to-r from-[#D4AF37] to-[#B8860B] hover:scale-[1.02] active:scale-95 text-[#0A192F] font-bold px-8 py-3 rounded-xl transition-all flex items-center gap-2 text-sm uppercase tracking-wider shadow-lg shadow-[#D4AF37]/10">
                        Temukan Rekomendasi <i class="fas fa-sparkles"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- STEP 4: RESULTS -->
        <div class="wizard-step hidden" id="step-results">
            <!-- Loading Skeleton -->
            <div id="resultsLoading" class="space-y-4 mb-6">
                <div class="flex items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#D4AF37]"></div>
                </div>
                <p class="text-center text-sm text-white/50">Menganalisis kecocokan destinasi terbaik...</p>
            </div>

            <!-- Dynamic Results Container -->
            <div id="resultsContainer" class="hidden mb-6">
                <!-- Grid of matches -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-[380px] overflow-y-auto pr-2" id="resultsGrid">
                    <!-- Cards will be populated here -->
                </div>
            </div>

            <div class="flex justify-between pt-4 border-t border-white/10">
                <button type="button" onclick="restartWizard()" class="border border-[#D4AF37]/50 text-[#D4AF37] hover:bg-[#D4AF37]/10 font-bold px-6 py-3 rounded-xl transition-all text-sm uppercase tracking-wider flex items-center gap-2">
                    <i class="fas fa-undo"></i> Cari Lagi
                </button>
                <button type="button" onclick="closeTripFinderModal()" class="bg-[#112240] hover:bg-white/5 text-white font-bold px-6 py-3 rounded-xl transition-all text-sm uppercase tracking-wider">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentStep = 1;

    function openTripFinderModal() {
        const modal = document.getElementById('tripFinderModal');
        const card = document.getElementById('tripFinderCard');
        
        restartWizard();

        // Show Modal
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        
        // Animation
        setTimeout(() => {
            card.classList.remove('scale-95', 'opacity-0');
            card.classList.add('scale-100', 'opacity-100');
        }, 50);
    }

    function closeTripFinderModal() {
        const modal = document.getElementById('tripFinderModal');
        const card = document.getElementById('tripFinderCard');

        // Animation
        card.classList.remove('scale-100', 'opacity-100');
        card.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    function goToStep(step) {
        // Hide all steps
        document.querySelectorAll('.wizard-step').forEach(el => el.classList.add('hidden'));
        
        // Show target step
        if (step === 1) {
            document.getElementById('step-budget').classList.remove('hidden');
            document.getElementById('wizardTitle').innerText = "Trip Finder - Anggaran";
            document.getElementById('wizardSubtitle').innerText = "Berapa anggaran liburan yang Anda rencanakan?";
        } else if (step === 2) {
            document.getElementById('step-group').classList.remove('hidden');
            document.getElementById('wizardTitle').innerText = "Trip Finder - Teman Perjalanan";
            document.getElementById('wizardSubtitle').innerText = "Anda merencanakan perjalanan ini bersama siapa?";
        } else if (step === 3) {
            document.getElementById('step-focus').classList.remove('hidden');
            document.getElementById('wizardTitle').innerText = "Trip Finder - Fokus Perjalanan";
            document.getElementById('wizardSubtitle').innerText = "Apa prioritas utama akomodasi/kegiatan perjalanan Anda?";
        } else if (step === 4) {
            document.getElementById('step-results').classList.remove('hidden');
            document.getElementById('wizardTitle').innerText = "Rekomendasi Cerdas Untukmu";
            document.getElementById('wizardSubtitle').innerText = "Pilihan destinasi terbaik berdasarkan preferensi Anda.";
        }

        currentStep = step;
        updateProgressIndicator(step);
    }

    function updateProgressIndicator(step) {
        const dots = document.querySelectorAll('.step-dot');
        const line1 = document.getElementById('line-step-1');
        const line2 = document.getElementById('line-step-2');
        const line3 = document.getElementById('line-step-3');

        // Reset
        dots.forEach((dot, idx) => {
            dot.className = "step-dot w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs bg-white/5 text-white/40";
            if (idx === 3) dot.innerHTML = '<i class="fas fa-sparkles"></i>';
            else dot.innerText = idx + 1;
        });
        
        line1.className = "w-10 h-0.5 bg-white/10";
        line2.className = "w-10 h-0.5 bg-white/10";
        line3.className = "w-10 h-0.5 bg-white/10";

        // Highlight
        if (step >= 1) {
            dots[0].className = "step-dot w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs bg-[#D4AF37] text-[#0A192F]";
        }
        if (step >= 2) {
            line1.className = "w-10 h-0.5 bg-[#D4AF37]";
            dots[1].className = "step-dot w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs bg-[#D4AF37] text-[#0A192F]";
        }
        if (step >= 3) {
            line2.className = "w-10 h-0.5 bg-[#D4AF37]";
            dots[2].className = "step-dot w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs bg-[#D4AF37] text-[#0A192F]";
        }
        if (step >= 4) {
            line3.className = "w-10 h-0.5 bg-[#D4AF37]";
            dots[3].className = "step-dot w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs bg-gradient-to-r from-[#D4AF37] to-[#B8860B] text-[#0A192F]";
        }
    }

    function restartWizard() {
        document.getElementById('tripFinderForm').reset();
        goToStep(1);
    }

    function submitTripFinder() {
        goToStep(4);
        
        // Show Loading, Hide Grid
        document.getElementById('resultsLoading').classList.remove('hidden');
        document.getElementById('resultsContainer').classList.add('hidden');

        // Collect Form Data
        const form = document.getElementById('tripFinderForm');
        const budget = form.budget.value;
        const packageType = form.package_type.value;
        const type = form.type.value;

        // Fetch using AJAX
        const url = `/recommendations?step=2&budget=${budget}&package_type=${packageType}&type=${type}`;
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(res => {
            // Hide Loading
            document.getElementById('resultsLoading').classList.add('hidden');
            
            const grid = document.getElementById('resultsGrid');
            grid.innerHTML = ''; // clear grid

            if (res.success && res.destinations.length > 0) {
                res.destinations.forEach(dest => {
                    const price = dest.discount_price ?? dest.price;
                    const priceFormatted = parseFloat(price).toLocaleString('id-ID');
                    
                    const imgUrl = dest.image 
                        ? `/storage/${dest.image}` 
                        : 'https://images.unsplash.com/photo-1506012733851-bb9745564c73?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';

                    const cardHtml = `
                        <div class="bg-[#112240] rounded-2xl overflow-hidden border border-white/5 flex flex-col justify-between h-full">
                            <div class="relative h-40">
                                <img src="${imgUrl}" class="w-full h-full object-cover" alt="${dest.name}">
                                <span class="absolute top-3 left-3 bg-[#D4AF37] text-[#0A192F] font-bold text-[9px] uppercase tracking-wider px-2 py-0.5 rounded-full">${dest.type}</span>
                            </div>
                            <div class="p-4 flex-grow flex flex-col justify-between">
                                <div>
                                    <h4 class="font-bold text-base text-white mb-1.5 line-clamp-1">${dest.name}</h4>
                                    <p class="text-xs text-white/50 line-clamp-2 mb-3">${dest.description}</p>
                                </div>
                                <div class="flex items-center justify-between pt-3 border-t border-white/5">
                                    <div>
                                        <span class="text-[9px] text-white/40 block">Mulai dari</span>
                                        <span class="text-sm font-bold text-[#D4AF37]">Rp ${priceFormatted}</span>
                                    </div>
                                    <a href="/destinations/${dest.id}" class="text-[10px] font-bold text-white bg-[#D4AF37]/15 hover:bg-[#D4AF37] hover:text-[#0A192F] px-3 py-1.5 rounded-lg transition-all uppercase tracking-wider">
                                        Detail <i class="fas fa-chevron-right text-[8px] ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                    grid.insertAdjacentHTML('beforeend', cardHtml);
                });
                document.getElementById('resultsContainer').classList.remove('hidden');
            } else {
                // Empty state HTML
                grid.innerHTML = `
                    <div class="col-span-full text-center py-12 px-4">
                        <i class="fas fa-search text-3xl text-white/20 mb-4 block"></i>
                        <h4 class="font-bold text-base mb-1">Rekomendasi Tidak Ditemukan</h4>
                        <p class="text-xs text-white/40">Silakan coba ubah kriteria pencarian Anda untuk hasil yang lebih luas.</p>
                    </div>
                `;
                document.getElementById('resultsContainer').classList.remove('hidden');
            }
        })
        .catch(err => {
            document.getElementById('resultsLoading').classList.add('hidden');
            const grid = document.getElementById('resultsGrid');
            grid.innerHTML = `
                <div class="col-span-full text-center py-12 px-4">
                    <i class="fas fa-exclamation-triangle text-3xl text-[#E74C3C] mb-4 block"></i>
                    <h4 class="font-bold text-base mb-1">Terjadi Kesalahan</h4>
                    <p class="text-xs text-white/40">Gagal mengambil data rekomendasi. Silakan coba sesaat lagi.</p>
                </div>
            `;
            document.getElementById('resultsContainer').classList.remove('hidden');
        });
    }
</script>
