<div class="max-w-3xl mx-auto">
    <!-- Component Specific Styles -->
    <style>
        .profile-card { background: #141414; border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 20px; overflow: hidden; }
        .btn-red { background: #E50914; color: #fff; padding: 12px 28px; border-radius: 10px; font-weight: 800; transition: all 0.3s; border: none; cursor: pointer; text-transform: uppercase; letter-spacing: 2px; font-size: 11px; }
        .btn-red:hover { background: #B20710; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(229, 9, 20, 0.3); }
        .form-input { background: rgba(0,0,0,0.4) !important; color: white !important; border: 1px solid rgba(255,255,255,0.08) !important; border-radius: 12px !important; padding: 14px !important; font-size: 13px !important; transition: all 0.2s !important; outline: none !important; width: 100%; }
        .form-input:focus { border-color: #E50914 !important; }
    </style>

    <!-- Header -->
    <div class="flex items-center gap-6 mb-10 animate-fadeIn">
        <div class="relative shrink-0">
            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=E50914&color=fff&size=128"
                 class="w-16 h-16 rounded-2xl border-2 border-white/10 shadow-xl" />
            <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 border-2 border-[#050505] rounded-full flex items-center justify-center">
                <span class="material-symbols-outlined text-white text-[10px]">verified_user</span>
            </div>
        </div>
        <div>
            <h1 class="text-2xl font-black text-white uppercase tracking-tighter" style="font-family:'Bebas Neue', sans-serif">
                Profil <span class="text-[#E50914]">{{ auth()->user()->name }}</span>
            </h1>
            <p class="text-gray-500 text-[9px] font-bold uppercase tracking-[3px] mt-0.5">{{ auth()->user()->role }} • Member since {{ auth()->user()->created_at->format('Y') }}</p>
        </div>
    </div>


        @if (session()->has('message'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-500 p-5 rounded-2xl text-[11px] font-black uppercase tracking-widest flex items-center gap-4 animate-fadeIn">
                <span class="material-symbols-outlined text-[20px]">check_circle</span> {{ session('message') }}
            </div>
        @endif

        <!-- Form Card -->
        <form wire:submit.prevent="updateProfile" class="animate-fadeIn">
            <div class="profile-card p-8 space-y-10 shadow-xl">
                <!-- Data Diri -->
                <div>
                    <div class="flex items-center gap-3 mb-6 border-b border-white/5 pb-4">
                        <span class="material-symbols-outlined text-[#E50914] text-xl">badge</span>
                        <h2 class="text-sm font-black text-white uppercase tracking-[3px]">Identitas Personal</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                    <div class="flex items-center gap-3 mb-6 border-b border-white/5 pb-4">
                        <span class="material-symbols-outlined text-[#E50914] text-xl">security</span>
                        <h2 class="text-sm font-black text-white uppercase tracking-[3px]">Proteksi & Keamanan</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

    <style>
        .animate-fadeIn { animation: fadeIn 0.5s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</div>
