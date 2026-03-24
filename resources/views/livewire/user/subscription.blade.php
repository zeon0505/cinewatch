<div class="max-w-4xl mx-auto py-16 px-4">
    <div class="text-center mb-12">
        <h1 class="text-5xl font-black text-white uppercase tracking-tighter logo mb-4">Pilih Paket <span class="text-red-600 underline decoration-yellow-500">VIP</span></h1>
        <p class="text-gray-400 font-bold uppercase tracking-widest text-sm">Buka semua akses film premium tanpa batas</p>
    </div>

    @if (session()->has('error'))
        <div class="mb-8 p-4 bg-red-600/10 border border-red-600/20 text-red-500 rounded-xl text-center font-black uppercase text-xs tracking-widest animate-shake">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Free Plan -->
        <div class="bg-zinc-900/40 border border-white/5 p-10 rounded-[32px] flex flex-col items-center text-center opacity-50 grayscale">
            <h2 class="text-xl font-black text-gray-400 uppercase tracking-widest mb-2">Member Biasa</h2>
            <div class="text-4xl font-black text-white mb-6">GRATIS</div>
            <ul class="space-y-4 mb-10 text-xs font-bold text-gray-500 uppercase tracking-widest">
                <li class="flex items-center gap-2"> <span class="material-symbols-outlined text-sm">check</span> Akses Film Publik </li>
                <li class="flex items-center gap-2"> <span class="material-symbols-outlined text-sm">close</span> Film VIP Terbaru </li>
                <li class="flex items-center gap-2"> <span class="material-symbols-outlined text-sm">close</span> Dukungan HD 1080p </li>
            </ul>
            <button disabled class="w-full py-4 bg-zinc-800 text-zinc-500 rounded-2xl font-black uppercase tracking-widest text-xs cursor-not-allowed">AKTIF</button>
        </div>

        <!-- VIP Plan -->
        <div class="bg-gradient-to-br from-zinc-900 to-black border-2 border-yellow-500/30 p-10 rounded-[32px] flex flex-col items-center text-center relative overflow-hidden shadow-[0_0_50px_rgba(234,179,8,0.1)]">
            <div class="absolute top-6 -right-12 bg-yellow-500 text-black font-black text-[9px] uppercase px-14 py-1 rotate-45 tracking-widest">TERLARIS</div>
            
            <span class="material-symbols-outlined text-yellow-500 text-6xl mb-4 animate-pulse">workspace_premium</span>
            <h2 class="text-xl font-black text-yellow-500 uppercase tracking-widest mb-2">VIP SUPREME</h2>
            <div class="text-4xl font-black text-white mb-6">Rp 49.000 <span class="text-sm text-gray-500 font-normal">/bulan</span></div>
            
            <ul class="space-y-4 mb-10 text-xs font-bold text-gray-300 uppercase tracking-widest">
                <li class="flex items-center gap-2"> <span class="material-symbols-outlined text-green-500 text-sm">check_circle</span> Nonton Semua Film VIP </li>
                <li class="flex items-center gap-2"> <span class="material-symbols-outlined text-green-500 text-sm">check_circle</span> Kualitas Ultra HD 4K </li>
                <li class="flex items-center gap-2"> <span class="material-symbols-outlined text-green-500 text-sm">check_circle</span> Prioritas Request Film </li>
                <li class="flex items-center gap-2"> <span class="material-symbols-outlined text-green-500 text-sm">check_circle</span> Tanpa Gangguan Iklan </li>
            </ul>

            @if(auth()->check() && auth()->user()->is_vip)
                <div class="w-full py-5 bg-green-600/20 border border-green-500/30 text-green-500 rounded-2xl font-black uppercase tracking-[3px] text-xs flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">verified</span> MEMBER VIP AKTIF
                </div>
                <p class="mt-4 text-[8px] text-gray-500 font-bold uppercase tracking-widest">Berlaku sampai: {{ auth()->user()->vip_until ? auth()->user()->vip_until->format('d M Y') : '-' }}</p>
            @else
                <button wire:click="checkout(49000)" wire:loading.attr="disabled" class="w-full py-5 bg-gradient-to-r from-yellow-500 to-orange-600 text-black rounded-2xl font-black uppercase tracking-[3px] text-xs hover:scale-105 active:scale-95 transition-all shadow-xl shadow-yellow-900/20 disabled:opacity-50">
                    <span wire:loading.remove>AKTIFKAN VIP SEKARANG</span>
                    <span wire:loading>PROSES...</span>
                </button>
                <p class="mt-4 text-[8px] text-gray-600 font-bold uppercase tracking-widest">Sistem Pembayaran Aman via <span class="text-white">Midtrans</span></p>
            @endif
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
                        window.location.href = 'https://cinewatch.fpyoga.my.id/dashboard';
                    },
                    onPending: function(result) {
                        window.location.href = 'https://cinewatch.fpyoga.my.id/dashboard';
                    },
                    onError: function(result) {
                        window.location.href = 'https://cinewatch.fpyoga.my.id/subscription';
                    },
                    onClose: function() {
                        alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                    }
                });
            });
        });
    </script>
    @endpush
</div>
