<div class="flex-grow bg-[#050505] pt-32 pb-20 px-6 md:px-12 flex flex-col justify-center">
    <!-- Component Specific Styles -->
    <style>
        .profile-card { background: #141414; border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 24px; overflow: hidden; }
        .btn-red { background: #E50914; color: #fff; padding: 14px 32px; border-radius: 12px; font-weight: 800; transition: all 0.3s; border: none; cursor: pointer; text-transform: uppercase; letter-spacing: 2px; }
        .btn-red:hover { background: #B20710; transform: translateY(-2px); box-shadow: 0 15px 30px rgba(229, 9, 20, 0.3); }
        .form-input { background: rgba(0,0,0,0.4) !important; color: white !important; border: 1px solid rgba(255,255,255,0.08) !important; border-radius: 14px !important; padding: 16px !important; font-size: 14px !important; transition: all 0.2s !important; outline: none !important; width: 100%; }
        .form-input:focus { border-color: #E50914 !important; background: rgba(255,255,255,0.02) !important; }
        .material-symbols-outlined { vertical-align: middle; }
    </style>

    <div class="max-w-4xl mx-auto space-y-12">
        <!-- Header -->
        <div class="flex flex-col md:flex-row items-center gap-8 animate-fadeIn">
            <div class="relative group">
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=E50914&color=fff&size=256" 
                     class="w-32 h-32 rounded-3xl border-4 border-white/5 shadow-2xl group-hover:scale-105 transition-transform" />
                <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-green-500 border-4 border-[#050505] rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-sm">verified_user</span>
                </div>
            </div>
            <div class="text-center md:text-left">
                <h1 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tighter mb-1" style="font-family:'Bebas Neue', sans-serif">
                    Member Area: <span class="text-[#E50914]">{{ auth()->user()->username }}</span>
                </h1>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-[4px] opacity-60">Status: {{ auth()->user()->role }} Account • Member since {{ auth()->user()->created_at->format('Y') }}</p>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-500 p-5 rounded-2xl text-[11px] font-black uppercase tracking-widest flex items-center gap-4 animate-fadeIn">
                <span class="material-symbols-outlined text-[20px]">check_circle</span> {{ session('message') }}
            </div>
        @endif

        <!-- Form Card -->
        <form wire:submit.prevent="updateProfile" class="animate-fadeIn delay-1 translate-y-4">
            <div class="profile-card p-10 md:p-14 space-y-14 shadow-2xl">
                <!-- Data Diri -->
                <div>
                    <div class="flex items-center gap-4 mb-10 border-b border-white/5 pb-6">
                        <span class="material-symbols-outlined text-[#E50914] text-3xl">badge</span>
                        <h2 class="text-xl font-black text-white uppercase tracking-[3px]">Identitas Personal</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-3">
                            <label class="block text-gray-500 text-[10px] font-black uppercase tracking-[3px] ml-1">Nama Lengkap Member</label>
                            <input type="text" wire:model="name" class="form-input" />
                            @error('name') <span class="text-red-500 text-[10px] mt-2 block font-bold uppercase">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-3">
                            <label class="block text-gray-500 text-[10px] font-black uppercase tracking-[3px] ml-1">Alamat Email Terverifikasi</label>
                            <input type="email" wire:model="email" class="form-input" />
                            @error('email') <span class="text-red-500 text-[10px] mt-2 block font-bold uppercase">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Keamanan -->
                <div class="pt-6">
                    <div class="flex items-center gap-4 mb-10 border-b border-white/5 pb-6">
                        <span class="material-symbols-outlined text-[#E50914] text-3xl">security</span>
                        <h2 class="text-xl font-black text-white uppercase tracking-[3px]">Proteksi & Keamanan</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-3">
                            <label class="block text-gray-500 text-[10px] font-black uppercase tracking-[3px] ml-1">Password Baru</label>
                            <input type="password" wire:model="password" placeholder="Biarkan kosong jika tetap" class="form-input" />
                            @error('password') <span class="text-red-500 text-[10px] mt-2 block font-bold uppercase">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-3">
                            <label class="block text-gray-500 text-[10px] font-black uppercase tracking-[3px] ml-1">Ulangi Password Baru</label>
                            <input type="password" wire:model="password_confirmation" class="form-input" />
                        </div>
                    </div>
                </div>

                <!-- Action -->
                <div class="pt-10 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-6">
                    <p class="text-gray-600 text-[9px] font-bold uppercase tracking-widest max-w-xs text-center md:text-left italic">
                        Pastikan data yang Anda masukkan sudah benar sebelum menekan tombol simpan.
                    </p>
                    <button type="submit" class="btn-red w-full md:w-auto flex items-center justify-center gap-3">
                        <span class="material-symbols-outlined">save_as</span> Perbarui Member Area
                    </button>
                </div>
            </div>
        </form>
        
        <div class="text-center pt-10">
            <a href="/" class="text-gray-600 hover:text-white text-[10px] font-black uppercase tracking-[5px] transition-colors">
                 Tutup Pengaturan & Kembali ke Beranda
            </a>
        </div>
    </div>

    <style>
        .animate-fadeIn { animation: fadeIn 0.8s ease-out forwards; }
        .delay-1 { animation-delay: 0.2s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</div>
