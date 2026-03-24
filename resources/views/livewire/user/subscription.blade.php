<div class="max-w-4xl mx-auto py-16 px-4">
    <div class="text-center mb-16 animate-fadeIn">
        <span class="text-red-600 font-black uppercase tracking-[5px] text-[10px] mb-2 block">Premium Experience</span>
        <h1 class="text-6xl font-black text-white uppercase tracking-tighter logo mb-4">Pilih Paket <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-200 to-yellow-500 animate-shine">VIP</span></h1>
        <p class="text-gray-500 font-bold uppercase tracking-widest text-xs opacity-80">Buka semua akses film premium tanpa batas dengan kualitas terbaik.</p>
    </div>

    @if (session()->has('error'))
        <div class="mb-12 p-5 bg-red-600/10 border border-red-600/20 text-red-500 rounded-2xl text-center font-black uppercase text-[10px] tracking-widest animate-shake shadow-2xl shadow-red-900/20">
            <span class="material-symbols-outlined text-[16px] align-middle mr-2">error</span> {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        <!-- Free Plan -->
        <div class="bg-zinc-900/20 backdrop-blur-3xl border border-white/5 p-12 rounded-[40px] flex flex-col items-center text-center opacity-40 grayscale group hover:opacity-100 hover:grayscale-0 transition-all duration-500">
            <h2 class="text-sm font-black text-gray-500 uppercase tracking-widest mb-2 group-hover:text-gray-300 transition-colors">Member Biasa</h2>
            <div class="text-4xl font-black text-white/50 mb-8 tracking-tighter group-hover:text-white transition-colors">GRATIS</div>
            <ul class="space-y-5 mb-12 text-[10px] font-bold text-gray-600 uppercase tracking-[2px] w-full text-left">
                <li class="flex items-center gap-3"> <span class="material-symbols-outlined text-sm text-green-900">check</span> Akses Film Publik </li>
                <li class="flex items-center gap-3"> <span class="material-symbols-outlined text-sm text-red-900">close</span> Film VIP Terbaru </li>
                <li class="flex items-center gap-3"> <span class="material-symbols-outlined text-sm text-red-900">close</span> Dukungan HD 1080p </li>
            </ul>
            <button disabled class="w-full py-5 bg-zinc-800 text-zinc-600 rounded-[20px] font-black uppercase tracking-[3px] text-[10px] cursor-not-allowed border border-white/5">PAKET AKTIF</button>
        </div>

        <!-- VIP Plan (The Hero) -->
        <div class="relative group h-full">
            <!-- Animated Aura Glow behind the card -->
            <div class="absolute -inset-10 bg-yellow-500/10 rounded-full blur-[120px] opacity-50 group-hover:opacity-100 transition-opacity duration-1000 animate-pulse"></div>
            
            <div class="bg-gradient-to-br from-zinc-900 to-[#050505] border-2 border-yellow-500/40 p-12 rounded-[48px] flex flex-col items-center text-center relative overflow-hidden shadow-[0_0_80px_rgba(234,179,8,0.15)] group-hover:shadow-[0_0_120px_rgba(234,179,8,0.25)] transition-all duration-700 backdrop-blur-3xl animate-float">
                <div class="absolute top-8 -right-12 bg-gradient-to-r from-yellow-600 to-yellow-400 text-black font-black text-[9px] uppercase px-16 py-1.5 rotate-45 tracking-[3px] shadow-lg">TERLARIS</div>
                
                <div class="w-20 h-20 bg-yellow-500/10 rounded-3xl flex items-center justify-center mb-8 border border-yellow-500/20 group-hover:border-yellow-500/50 transition-colors duration-500">
                    <span class="material-symbols-outlined text-yellow-500 text-5xl">workspace_premium</span>
                </div>
                
                <h2 class="text-2xl font-black text-yellow-500 uppercase tracking-[5px] mb-2 drop-shadow-lg">VIP SUPREME</h2>
                <div class="text-5xl font-black text-white mb-8 tracking-tighter">Rp 49.000 <span class="text-xs text-gray-500 font-bold uppercase tracking-widest ml-1 opacity-50">/ Bulan</span></div>
                
                <ul class="space-y-5 mb-12 text-[10px] font-black text-gray-300 uppercase tracking-[2.5px] w-full text-left">
                    <li class="flex items-center gap-3 group/li"> <span class="material-symbols-outlined text-yellow-500 text-lg group-hover/li:scale-125 transition-transform">check_circle</span> Nonton Semua Film VIP </li>
                    <li class="flex items-center gap-3 group/li"> <span class="material-symbols-outlined text-yellow-500 text-lg group-hover/li:scale-125 transition-transform">check_circle</span> Kualitas Ultra HD 4K </li>
                    <li class="flex items-center gap-3 group/li"> <span class="material-symbols-outlined text-yellow-500 text-lg group-hover/li:scale-125 transition-transform">check_circle</span> Prioritas Request Film </li>
                    <li class="flex items-center gap-3 group/li"> <span class="material-symbols-outlined text-yellow-500 text-lg group-hover/li:scale-125 transition-transform">check_circle</span> Tanpa Gangguan Iklan </li>
                </ul>

                @if(auth()->check() && auth()->user()->is_vip)
                    <div class="w-full py-6 bg-yellow-500/10 border border-yellow-500/30 text-yellow-500 rounded-[28px] font-black uppercase tracking-[4px] text-[10px] flex items-center justify-center gap-3 shadow-xl shadow-yellow-500/10">
                        <span class="material-symbols-outlined text-[18px] animate-bounce">verified</span> MEMBER VIP AKTIF
                    </div>
                    <p class="mt-6 text-[9px] text-gray-500 font-black uppercase tracking-[3px] opacity-60">BERLAKU HINGGA: {{ auth()->user()->vip_until ? auth()->user()->vip_until->format('d M Y') : '-' }}</p>
                @else
                    <button wire:click="checkout(49000)" wire:loading.attr="disabled" class="w-full py-6 bg-gradient-to-r from-yellow-500 via-orange-500 to-yellow-600 text-black rounded-[28px] font-black uppercase tracking-[4px] text-[10px] hover:scale-105 active:scale-95 transition-all shadow-[0_20px_40px_rgba(234,179,8,0.3)] hover:shadow-[0_25px_50px_rgba(234,179,8,0.4)] disabled:opacity-50 group/btn relative overflow-hidden">
                        <span wire:loading.remove class="relative z-10 flex items-center justify-center gap-3">
                            AKTIFKAN VIP SEKARANG <span class="material-symbols-outlined text-sm">rocket_launch</span>
                        </span>
                        <span wire:loading class="relative z-10">MENGHUBUNGI SATELIT...</span>
                        <!-- Gloss effect -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-1000"></div>
                    </button>
                    <p class="mt-6 text-[9px] text-gray-600 font-bold uppercase tracking-[4px] opacity-50 flex items-center gap-2">
                         <span class="material-symbols-outlined text-[14px]">shield_check</span> Secure payment by <span class="text-white">MIDTRANS</span>
                    </p>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('show-payment', (event) => {
                const token = event.token || (Array.isArray(event) ? event[0].token : null);
                if (!token) return;
                
                window.snap.pay(token, {
                    onSuccess: function(result) {
                        window.location.href = '{{ route('dashboard') }}';
                    },
                    onPending: function(result) {
                        window.location.href = '{{ route('dashboard') }}';
                    },
                    onError: function(result) {
                        window.location.href = '{{ route('subscription') }}';
                    },
                    onClose: function() {
                        alert('Anda menutup jendela pembayaran sebelum selesai.');
                    }
                });
            });
        });
    </script>
    @endpush

    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn { animation: fadeIn 0.8s cubic-bezier(0.2, 1, 0.3, 1); }

        @keyframes shine {
            from { background-position: -200% center; }
            to { background-position: 200% center; }
        }
        .animate-shine {
            background-size: 200% auto;
            animation: shine 4s linear infinite;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        .animate-shake { animation: shake 0.5s ease-in-out; }
        
        .logo { font-family: 'Bebas Neue', cursive !important; }
    </style>
</div>
