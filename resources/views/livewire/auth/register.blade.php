<div class="min-h-screen relative flex items-center justify-center p-4 bg-black overflow-x-hidden">
    <!-- Smooth Background with High Contrast Dark Overlay -->
    <div class="absolute inset-0 z-0 select-none pointer-events-none">
        <img src="https://images.unsplash.com/photo-1594909122845-11baa439b7bf?w=1800&q=80" 
             class="w-full h-full object-cover opacity-30 animate-zoom">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/80 to-black/60"></div>
    </div>
    
    <!-- Professional Register Container -->
    <div class="relative z-10 w-full max-w-[560px] bg-neutral-900 shadow-[0_0_80px_rgba(0,0,0,0.8)] border border-white/5 rounded-2xl p-10 md:p-12 animate-cardSlide">
        <div class="text-center mb-10">
            <h1 class="logo text-4xl text-[#E50914] mb-3 tracking-[3px] font-black animate-fadeIn delay-1">CINEWATCH</h1>
            <h2 class="text-white text-xl font-bold uppercase tracking-tight animate-fadeIn delay-2">Daftar Member Premium</h2>
            <p class="text-[10px] text-gray-500 mt-2 font-bold uppercase tracking-[2px] animate-fadeIn delay-3 opacity-60">Nikmati Akses Film Tanpa Batas</p>
        </div>

        <form wire:submit.prevent="register" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="animate-fadeIn delay-4">
                    <label class="block text-gray-400 text-[10px] font-black uppercase tracking-[1.5px] mb-2 ml-1">Nama Lengkap</label>
                    <input wire:model="name" type="text" placeholder="Budi Santoso" 
                           class="w-full h-11 bg-neutral-800 border border-white/10 rounded-lg px-4 text-white focus:ring-1 focus:ring-[#E50914] focus:bg-neutral-700 outline-none transition-all placeholder:text-gray-700 text-sm" />
                    @error('name') <span class="text-red-500 text-[9px] ml-1 mt-1 block font-bold uppercase">{{ $message }}</span> @enderror
                </div>

                <div class="animate-fadeIn delay-5">
                    <label class="block text-gray-400 text-[10px] font-black uppercase tracking-[1.5px] mb-2 ml-1">Username</label>
                    <input wire:model="username" type="text" placeholder="budi_s" 
                           class="w-full h-11 bg-neutral-800 border border-white/10 rounded-lg px-4 text-white focus:ring-1 focus:ring-[#E50914] focus:bg-neutral-700 outline-none transition-all placeholder:text-gray-700 text-sm" />
                    @error('username') <span class="text-red-500 text-[9px] ml-1 mt-1 block font-bold uppercase">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="animate-fadeIn delay-6">
                <label class="block text-gray-400 text-[10px] font-black uppercase tracking-[1.5px] mb-2 ml-1">Alamat Email Aktif</label>
                <input wire:model="email" type="email" placeholder="nama@email.com" 
                       class="w-full h-11 bg-neutral-800 border border-white/10 rounded-lg px-4 text-white focus:ring-1 focus:ring-[#E50914] focus:bg-neutral-700 outline-none transition-all placeholder:text-gray-700 text-sm" />
                @error('email') <span class="text-red-500 text-[9px] ml-1 mt-1 block font-bold uppercase">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="animate-fadeIn delay-7">
                    <label class="block text-gray-400 text-[10px] font-black uppercase tracking-[1.5px] mb-2 ml-1">Password</label>
                    <input wire:model="password" type="password" placeholder="••••••••" 
                           class="w-full h-11 bg-neutral-800 border border-white/10 rounded-lg px-4 text-white focus:ring-1 focus:ring-[#E50914] focus:bg-neutral-700 outline-none transition-all placeholder:text-gray-700 text-sm" />
                    @error('password') <span class="text-red-500 text-[9px] ml-1 mt-1 block font-bold uppercase">{{ $message }}</span> @enderror
                </div>

                <div class="animate-fadeIn delay-8">
                    <label class="block text-gray-400 text-[10px] font-black uppercase tracking-[1.5px] mb-2 ml-1">Konfirmasi</label>
                    <input wire:model="password_confirmation" type="password" placeholder="••••••••" 
                           class="w-full h-11 bg-neutral-800 border border-white/10 rounded-lg px-4 text-white focus:ring-1 focus:ring-[#E50914] focus:bg-neutral-700 outline-none transition-all placeholder:text-gray-700 text-sm" />
                </div>
            </div>

            <button type="submit" wire:loading.attr="disabled" 
                    class="w-full bg-[#E50914] hover:bg-[#B20710] py-4 rounded-lg text-white font-black text-xs uppercase tracking-[4px] transition-all transform hover:scale-[1.01] active:scale-[0.99] shadow-xl animate-fadeIn delay-9">
                <span wire:loading.remove>Daftar Membership</span>
                <span wire:loading class="flex items-center justify-center">
                    <svg class="animate-spin h-4 w-4 mr-2" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Memverifikasi...
                </span>
            </button>
        </form>

        <div class="mt-8 pt-8 border-t border-white/5 text-center animate-fadeIn delay-10">
            <p class="text-gray-600 text-[10px] font-black uppercase tracking-widest leading-relaxed">Sudah menjadi member?<br>
                <a href="/login" class="text-white hover:text-[#E50914] transition-colors mt-2 block tracking-[4px]">Masuk ke Akun</a>
            </p>
        </div>
    </div>

    <style>
        @keyframes zoom { from { transform: scale(1); } to { transform: scale(1.1); } }
        .animate-zoom { animation: zoom 30s linear infinite alternate; }
        @keyframes cardSlide { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .animate-cardSlide { animation: cardSlide 1s cubic-bezier(0.2, 1, 0.3, 1) forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fadeIn { opacity: 0; animation: fadeIn 0.8s cubic-bezier(0.2, 1, 0.3, 1) forwards; }
        .delay-1 { animation-delay: 0.1s; } .delay-2 { animation-delay: 0.2s; } .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; } .delay-5 { animation-delay: 0.5s; } .delay-6 { animation-delay: 0.6s; }
        .delay-7 { animation-delay: 0.7s; } .delay-8 { animation-delay: 0.8s; } .delay-9 { animation-delay: 0.9s; } .delay-10 { animation-delay: 1s; }
    </style>
</div>
