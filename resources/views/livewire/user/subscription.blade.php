<div class="max-w-4xl mx-auto py-16 px-4">
    <div class="text-center mb-14 animate-fadeIn">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Pilih Paket <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-yellow-600">VIP</span></h1>
        <p class="text-gray-400 text-base md:text-lg max-w-xl mx-auto">Buka semua akses film premium tanpa batas dengan kualitas tayangan terbaik.</p>
    </div>

    <div id="flash-messages">
        @if (session()->has('error'))
            <div class="mb-10 p-4 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl text-center font-medium text-sm flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-lg">error</span> {{ session('error') }}
            </div>
        @endif

        @if (session()->has('success'))
            <div class="mb-10 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-xl text-center font-medium text-sm flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-lg">check_circle</span> {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto items-stretch">
        <!-- Free Plan -->
        <div class="bg-[#111] border border-white/5 p-8 md:p-10 rounded-3xl flex flex-col hover:border-white/10 transition-colors duration-300">
            <h2 class="text-xl font-bold text-gray-400 mb-2">Member Biasa</h2>
            <div class="text-4xl font-black text-white mb-6">Gratis</div>
            <p class="text-gray-500 text-sm mb-8">Akses dasar ke sebagian koleksi film publik.</p>
            
            <ul class="space-y-4 mb-8 flex-1 text-sm font-medium text-gray-400">
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-green-500 text-xl">check</span> Akses Film Publik
                </li>
                <li class="flex items-center gap-3 opacity-40">
                    <span class="material-symbols-outlined text-gray-500 text-xl">close</span> Film VIP Terbaru
                </li>
                <li class="flex items-center gap-3 opacity-40">
                    <span class="material-symbols-outlined text-gray-500 text-xl">close</span> Kualitas Ultra HD 4K
                </li>
                <li class="flex items-center gap-3 opacity-40">
                    <span class="material-symbols-outlined text-gray-500 text-xl">close</span> Bebas Iklan
                </li>
            </ul>
            <button disabled class="w-full py-4 bg-white/5 text-gray-400 rounded-xl font-bold text-sm cursor-not-allowed border border-white/5">Paket Aktif</button>
        </div>

        <!-- VIP Plan -->
        <div class="relative bg-gradient-to-b from-[#1a1500] to-[#111] border border-yellow-500/50 p-8 md:p-10 rounded-3xl flex flex-col shadow-2xl shadow-yellow-500/10">
            <!-- Badge -->
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-gradient-to-r from-yellow-500 to-yellow-400 text-black font-bold text-[10px] tracking-wider uppercase px-4 py-1.5 rounded-full shadow-lg">
                Pilihan Terbaik
            </div>
            
            <h2 class="text-xl font-bold text-yellow-500 mb-2 flex items-center gap-2">
                <span class="material-symbols-outlined">workspace_premium</span> VIP Supreme
            </h2>
            <div class="text-4xl font-black text-white mb-6 flex items-baseline gap-1">
                Rp 49.000 <span class="text-sm text-gray-400 font-normal">/ bulan</span>
            </div>
            <p class="text-gray-400 text-sm mb-8">Pengalaman nonton eksklusif tanpa batasan.</p>
            
            <ul class="space-y-4 mb-8 flex-1 text-sm font-medium text-gray-200">
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-yellow-400 text-xl">check_circle</span> Nonton Semua Film VIP
                </li>
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-yellow-400 text-xl">check_circle</span> Kualitas Ultra HD 4K
                </li>
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-yellow-400 text-xl">check_circle</span> Prioritas Request Film
                </li>
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-yellow-400 text-xl">check_circle</span> Tanpa Gangguan Iklan
                </li>
            </ul>

            @if(auth()->check() && auth()->user()->is_vip)
                <div class="w-full py-4 bg-yellow-500/10 border border-yellow-500/30 text-yellow-500 rounded-xl font-bold text-sm flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-lg">verified</span> Member VIP Aktif
                </div>
                <p class="mt-4 text-xs text-center text-gray-500 font-medium">Berlaku hingga: {{ auth()->user()->vip_until ? auth()->user()->vip_until->format('d M Y') : '-' }}</p>
            @else
                <button wire:click="checkout(49000)" wire:loading.attr="disabled" class="w-full py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-black rounded-xl font-bold text-sm hover:from-yellow-400 hover:to-yellow-500 transition-all shadow-lg shadow-yellow-500/20 flex items-center justify-center gap-2">
                    <span wire:loading.remove wire:target="checkout" class="flex items-center gap-2">
                        Aktifkan VIP Sekarang <span class="material-symbols-outlined text-lg">rocket_launch</span>
                    </span>
                    <span wire:loading wire:target="checkout">Memproses...</span>
                </button>

                <button wire:click="checkStatus" wire:loading.attr="disabled" class="mt-3 w-full py-3 text-yellow-500/80 hover:text-yellow-500 rounded-xl font-medium text-xs hover:bg-yellow-500/10 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-base">refresh</span>
                    <span wire:loading.remove wire:target="checkStatus">Sudah bayar? Cek status</span>
                    <span wire:loading wire:target="checkStatus">Mengecek...</span>
                </button>

                <p class="mt-5 text-xs text-gray-500 font-medium text-center flex items-center justify-center gap-1.5">
                     <span class="material-symbols-outlined text-[16px]">shield_check</span> Pembayaran aman oleh <span class="text-white">Midtrans</span>
                </p>
            @endif
        </div>
    </div>

    @push('scripts')
    <script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('show-payment', (event) => {
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
