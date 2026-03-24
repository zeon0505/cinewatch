<div x-data="{ open: false }" @profile-added.window="open = false" class="min-h-screen bg-[#050505] flex flex-col items-center justify-center p-6 bg-[radial-gradient(circle_at_center,rgba(229,9,20,0.05)_0%,transparent_70%)]">
    <div class="text-center mb-12 animate-fadeInDown">
        <h1 class="text-5xl font-black text-white uppercase tracking-tighter logo mb-3">Siapa yang <span class="text-red-600">Menonton?</span></h1>
        <p class="text-gray-500 font-bold uppercase tracking-[4px] text-xs">Pilih profil Anda untuk pengalaman personal</p>
    </div>

    <div class="flex flex-wrap justify-center gap-10 max-w-5xl">
        @foreach($profiles as $profile)
            <div class="group flex flex-col items-center gap-4 animate-fadeInUp" style="animation-delay: {{ $loop->index * 100 }}ms">
                <button 
                    wire:click="selectProfile({{ $profile->id }})"
                    class="relative w-36 h-36 md:w-44 md:h-44 rounded-2xl bg-zinc-900 border-4 border-transparent hover:border-white transition-all overflow-hidden shadow-2xl group-hover:scale-105 active:scale-95"
                >
                    <div class="w-full h-full flex items-center justify-center text-5xl font-black text-white bg-gradient-to-br from-red-600 to-red-900">
                        {{ substr($profile->name, 0, 1) }}
                    </div>
                    @if($profile->is_kids)
                        <div class="absolute bottom-2 right-2 bg-yellow-500 text-black text-[8px] font-black px-2 py-0.5 rounded uppercase tracking-widest">KIDS</div>
                    @endif
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-4xl">play_arrow</span>
                    </div>
                </button>
                <div class="flex items-center gap-2">
                    <span class="text-gray-400 font-bold uppercase tracking-widest text-sm group-hover:text-white transition-colors">{{ $profile->name }}</span>
                    <button wire:click="deleteProfile({{ $profile->id }})" wire:confirm="Hapus profil ini?" class="opacity-0 group-hover:opacity-40 hover:!opacity-100 text-red-500 transition-all">
                        <span class="material-symbols-outlined text-sm">delete</span>
                    </button>
                </div>
            </div>
        @endforeach

        @if(count($profiles) < 5)
            <div class="flex flex-col items-center gap-4 animate-fadeInUp" style="animation-delay: {{ count($profiles) * 100 }}ms">
                <button 
                    @click="open = true"
                    class="w-36 h-36 md:w-44 md:h-44 rounded-2xl border-4 border-dashed border-zinc-800 hover:border-zinc-500 hover:bg-white/5 transition-all flex flex-col items-center justify-center gap-3 text-zinc-600 hover:text-zinc-300"
                >
                    <span class="material-symbols-outlined text-5xl">add_circle</span>
                    <span class="text-[10px] font-black uppercase tracking-[3px]">Tambah Profil</span>
                </button>
            </div>
        @endif
    </div>

    <!-- MODAL (Moved here to avoid transform parent issues) -->
    <div x-show="open" x-cloak class="fixed inset-0 bg-black/90 backdrop-blur-xl z-[200] flex items-center justify-center p-6">
        <div @click.outside="open = false" class="bg-zinc-900 border border-white/5 p-10 rounded-[32px] w-full max-w-sm md:max-w-md shadow-2xl relative">
            <button @click="open = false" class="absolute top-6 right-6 text-gray-500 hover:text-white">
                <span class="material-symbols-outlined">close</span>
            </button>
            
            <h3 class="text-2xl font-black text-white uppercase tracking-tighter mb-8 italic">PROFIL BARU</h3>
            
            @if (session()->has('error'))
                <div class="mb-4 p-3 bg-red-600/10 border border-red-600/20 text-red-500 rounded-xl text-[10px] font-black uppercase text-center">
                    {{ session('error') }}
                </div>
            @endif

            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] text-gray-500 font-black uppercase tracking-[3px] mb-3">Nama Profil</label>
                    <input wire:model.live="newProfileName" type="text" placeholder="Contoh: My Profile" class="w-full bg-black/40 border border-white/10 rounded-xl p-4 text-white focus:ring-1 focus:ring-red-600 outline-none font-bold" />
                    @error('newProfileName') <span class="text-red-500 text-[9px] font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>
                
                <label class="flex items-center gap-4 p-4 rounded-xl bg-white/[0.02] border border-white/5 cursor-pointer hover:bg-white/[0.05] transition-all group">
                    <input type="checkbox" wire:model="isKids" class="hidden peer">
                    <div class="w-10 h-10 rounded-xl bg-zinc-800 flex items-center justify-center text-gray-500 peer-checked:bg-yellow-500/20 peer-checked:text-yellow-500 transition-all">
                        <span class="material-symbols-outlined">child_care</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-black uppercase text-gray-400 peer-checked:text-white transition-colors">Profil Anak (Kids)</span>
                        <span class="text-[8px] text-gray-600 font-bold uppercase">Hanya menampilkan konten anak-anak</span>
                    </div>
                    <div class="ml-auto w-5 h-5 rounded border-2 border-zinc-700 flex items-center justify-center peer-checked:bg-yellow-500 peer-checked:border-yellow-500 transition-all">
                        <span class="material-symbols-outlined text-black text-[14px] scale-0 peer-checked:scale-100 transition-transform">check</span>
                    </div>
                </label>

                <button 
                    wire:click="addProfile" 
                    wire:loading.attr="disabled"
                    class="w-full py-5 bg-red-600 text-white rounded-2xl font-black uppercase tracking-[3px] text-xs shadow-xl shadow-red-900/20 hover:scale-105 active:scale-95 transition-all flex items-center justify-center gap-2 group"
                >
                    <span wire:loading.remove>BUAT PROFIL</span>
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        MEMPROSES...
                    </span>
                    <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform" wire:loading.remove>arrow_forward</span>
                </button>
            </div>
        </div>
    </div>

    <div class="mt-20">
        <button class="px-8 py-3 rounded-lg border border-white/10 text-gray-500 hover:text-white hover:border-white/30 text-[10px] font-black uppercase tracking-[4px] transition-all">Kelola Profil</button>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fadeInDown { animation: fadeInDown 0.8s ease-out forwards; }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; }
    </style>
</div>
