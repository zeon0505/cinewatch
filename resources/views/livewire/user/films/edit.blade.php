<div class="h-full overflow-y-auto scrollbar-hide pb-20">
    <div class="max-w-4xl mx-auto p-8 pt-0">
        <!-- Header -->
        <div class="flex items-center gap-6 mb-10 animate-fadeIn">
            <a href="{{ route('user.films.index') }}" class="w-12 h-12 bg-white/5 border border-white/10 rounded-xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#E50914] hover:border-[#E50914] transition-all group">
                <span class="material-symbols-outlined transition-transform group-hover:-translate-x-1">arrow_back</span>
            </a>
            <div>
                <h1 class="text-3xl font-black text-white uppercase tracking-tighter">Edit <span class="text-[#E50914]">Karya Anda</span></h1>
                <p class="text-gray-500 text-[10px] font-bold uppercase tracking-[3px] mt-1">Ubah atau sesuaikan rincian film</p>
            </div>
        </div>

        <div class="bg-neutral-900/40 backdrop-blur-3xl border border-white/5 rounded-2xl p-8 shadow-2xl animate-cardSlide">
            <form wire:submit="update" class="space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Title -->
                    <div class="space-y-2">
                        <label class="text-[10px] text-gray-400 font-black uppercase tracking-widest block">Judul Film / Series</label>
                        <input wire:model="title" type="text" class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-[#E50914] outline-none transition-all placeholder:text-gray-700 font-medium" placeholder="Contoh: The Matrix Resurrections">
                        @error('title') <span class="text-red-500 text-[10px] uppercase font-bold tracking-widest mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Year -->
                    <div class="space-y-2">
                        <label class="text-[10px] text-gray-400 font-black uppercase tracking-widest block">Tahun Rilis</label>
                        <input wire:model="year" type="number" class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-[#E50914] outline-none transition-all placeholder:text-gray-700 font-medium" placeholder="Contoh: 2024">
                        @error('year') <span class="text-red-500 text-[10px] uppercase font-bold tracking-widest mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Duration -->
                    <div class="space-y-2">
                        <label class="text-[10px] text-gray-400 font-black uppercase tracking-widest block">Durasi</label>
                        <input wire:model="duration" type="text" class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-[#E50914] outline-none transition-all placeholder:text-gray-700 font-medium" placeholder="Contoh: 120 min">
                        @error('duration') <span class="text-red-500 text-[10px] uppercase font-bold tracking-widest mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Audience Type -->
                    <div class="space-y-2 relative transition-all" x-data="{ open: false }" :class="open ? 'z-50' : 'z-10'">
                        <label class="text-[10px] text-gray-400 font-black uppercase tracking-widest block">Target Penonton (Audience)</label>
                        <div @click="open = !open" @click.away="open = false" 
                             class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-2.5 hover:border-white/20 hover:bg-white/5 transition-all cursor-pointer flex justify-between items-center group">
                             <span class="font-medium text-xs text-white transition-colors">
                                {{ $audience_type == 'adult' ? 'ADULT (Dewasa / 13+)' : 'KIDS (Anak-anak)' }}
                             </span>
                             <span class="material-symbols-outlined text-gray-500 transition-transform" :class="open ? 'rotate-180 text-white' : 'group-hover:text-white'">expand_more</span>
                        </div>

                        <div x-show="open" x-transition.opacity 
                             class="absolute top-full left-0 right-0 mt-2 bg-[#0A0A0A] border border-white/10 rounded-xl shadow-[0_30px_60px_rgba(0,0,0,0.8)] z-50 overflow-hidden flex flex-col p-1.5" x-cloak style="display: none;">
                             @foreach(['adult' => 'ADULT (Dewasa / 13+)', 'kids' => 'KIDS (Anak-anak)'] as $val => $label)
                             <div wire:click="$set('audience_type', '{{ $val }}')" @click="open = false" 
                                  class="px-4 py-2.5 flex items-center gap-3 rounded-lg text-xs font-medium cursor-pointer transition-all {{ $audience_type == $val ? 'bg-red-600/10 text-red-500 border-l-[3px] border-red-600' : 'text-gray-400 hover:text-white hover:bg-white/5 border-l-[3px] border-transparent' }}">
                                  <span class="material-symbols-outlined text-[16px] {{ $audience_type == $val ? 'opacity-100' : 'opacity-0' }}">check</span>
                                  {{ $label }}
                             </div>
                             @endforeach
                        </div>
                        @error('audience_type') <span class="text-red-500 text-[10px] uppercase font-bold tracking-widest mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Video URL -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] text-gray-400 font-black uppercase tracking-widest block">URL Video (Direct Link / .mp4 / .m3u8)</label>
                        <div class="flex relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 material-symbols-outlined text-[18px]">link</span>
                            <input wire:model="video_url" type="url" class="w-full bg-black/50 border border-white/10 rounded-xl pl-12 pr-4 py-3 text-sm text-white focus:border-[#E50914] outline-none transition-all placeholder:text-gray-700 font-medium" placeholder="https://domain.com/movie.mp4">
                        </div>
                        <p class="text-[9px] text-gray-500 font-bold uppercase tracking-tight leading-relaxed mt-2 p-3 bg-white/5 rounded-lg border border-white/5">
                            <span class="text-[#E50914] block mb-1">PENTING:</span>
                            Gunakan link video langsung (**mp4/m3u8**) agar fitur **Subtitle (CC)** lokal berfungsi. Jika Anda menggunakan link embed (seperti vidsrc), subtitle hanya bisa dikelola oleh penyedia link tersebut.
                        </p>
                        @error('video_url') <span class="text-red-500 text-[10px] uppercase font-bold tracking-widest mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Description -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] text-gray-400 font-black uppercase tracking-widest block">Sinopsis / Deskripsi</label>
                        <textarea wire:model="description" rows="4" class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-[#E50914] outline-none transition-all placeholder:text-gray-700 font-medium leading-relaxed" placeholder="Tulis plot menarik tentang film ini..."></textarea>
                        @error('description') <span class="text-red-500 text-[10px] uppercase font-bold tracking-widest mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Categories -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] text-gray-400 font-black uppercase tracking-widest block mb-3 border-b border-white/10 pb-2">Kategori & Genre</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($categories as $cat)
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-white/5 bg-black/30 hover:bg-white/5 cursor-pointer transition-all group relative overflow-hidden">
                                <input type="checkbox" wire:model="selectedCategories" value="{{ $cat->id }}" class="peer sr-only">
                                <div class="w-4 h-4 rounded border border-gray-600 peer-checked:bg-[#E50914] peer-checked:border-[#E50914] flex items-center justify-center transition-all">
                                    <span class="material-symbols-outlined text-[12px] text-white opacity-0 peer-checked:opacity-100 scale-0 peer-checked:scale-100 transition-all font-bold">check</span>
                                </div>
                                <span class="text-[11px] font-black uppercase tracking-widest text-gray-400 peer-checked:text-white transition-colors">{{ $cat->name }}</span>
                                <div class="absolute inset-0 bg-gradient-to-r from-[#E50914]/10 to-transparent opacity-0 peer-checked:opacity-100 pointer-events-none"></div>
                            </label>
                            @endforeach
                        </div>
                        @error('selectedCategories') <span class="text-red-500 text-[10px] uppercase font-bold tracking-widest mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Thumbnail / Poster -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] text-gray-400 font-black uppercase tracking-widest block">Poster Film (Ganti jika perlu)</label>
                        <div class="border-2 border-dashed border-white/10 rounded-2xl p-8 text-center hover:border-red-500/50 hover:bg-red-500/5 transition-all group flex flex-col items-center">
                             
                             @if ($posterFile)
                                 <img src="{{ $posterFile->temporaryUrl() }}" class="h-40 mx-auto rounded-lg shadow-2xl mb-4 border border-white/10 object-cover">
                             @elseif($thumbnail)
                                 <img src="{{ $thumbnail }}" class="h-40 mx-auto rounded-lg shadow-2xl mb-4 border border-white/10 object-cover">
                             @endif

                             <div class="w-12 h-12 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-red-500/20 group-hover:text-red-500 transition-colors text-gray-500">
                                 <span class="material-symbols-outlined text-[24px]">cloud_upload</span>
                             </div>
                             <p class="text-[11px] text-gray-500 font-bold uppercase tracking-widest mb-4">Pilih File Baru (.jpg, .png)</p>
                             <input type="file" wire:model="posterFile" id="posterFile" class="hidden" accept="image/*">
                             <label for="posterFile" class="bg-white/10 hover:bg-white/20 text-white px-6 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest cursor-pointer transition-all border border-white/5">Cari File Baru</label>
                        </div>
                        @error('posterFile') <span class="text-red-500 text-[10px] uppercase font-bold tracking-widest mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Subtitle Upload (Edit) -->
                    <div class="space-y-4 md:col-span-2 p-6 bg-white/[0.02] border border-white/5 rounded-2xl">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="text-[11px] text-white font-black uppercase tracking-widest mb-1 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-[#E50914]">closed_caption</span>
                                    Subtitle (CC)
                                </h4>
                                @if($movie->subtitle_url)
                                    <p class="text-[9px] text-green-500 font-bold uppercase tracking-widest">Subtitle saat ini tersedia</p>
                                @else
                                    <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">Belum ada subtitle untuk film ini</p>
                                @endif
                            </div>
                            @if ($subtitleFile)
                                <div class="bg-green-500/10 text-green-500 px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[12px]">check_circle</span>
                                    File Baru Siap
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <input type="file" wire:model="subtitleFile" id="subtitleFile" class="hidden" accept=".vtt">
                            <label for="subtitleFile" class="flex-1 border {{ $movie->subtitle_url ? 'border-green-500/20 bg-green-500/5' : 'border-white/10 bg-black/50' }} rounded-xl px-5 py-4 cursor-pointer hover:bg-white/5 transition-all group flex items-center justify-between">
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest group-hover:text-white transition-colors">
                                    {{ $subtitleFile ? $subtitleFile->getClientOriginalName() : ($movie->subtitle_url ? 'Ganti file subtitle (.vtt)' : 'Pilih file subtitle (.vtt)') }}
                                </span>
                                <span class="material-symbols-outlined text-gray-600 group-hover:text-[#E50914] transition-colors">attach_file</span>
                            </label>
                            @if($subtitleFile)
                                <button type="button" wire:click="$set('subtitleFile', null)" class="w-12 h-12 flex items-center justify-center bg-red-500/10 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            @endif
                        </div>
                        <div wire:loading wire:target="subtitleFile" class="text-[9px] text-[#E50914] font-black uppercase tracking-[2px] animate-pulse">
                            Memproses file...
                        </div>
                        @error('subtitleFile') <span class="text-red-500 text-[10px] uppercase font-bold tracking-widest mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-white/10 flex justify-end">
                    <button type="submit" class="bg-[#E50914] text-white px-10 py-4 rounded-xl font-black text-xs uppercase tracking-[2px] shadow-xl shadow-red-900/40 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-3 w-full md:w-auto justify-center">
                        <span wire:loading.remove wire:target="update" class="material-symbols-outlined text-[18px]">save</span>
                        <span wire:loading wire:target="update" class="material-symbols-outlined text-[18px] animate-spin">refresh</span>
                        SIMPAN PERUBAHAN
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255,255,255,0.02); border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(229,9,20,0.5); border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(229,9,20,0.8); }
        
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes cardSlide { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .animate-fadeIn { animation: fadeIn 0.4s ease-out; }
        .animate-cardSlide { animation: cardSlide 0.5s cubic-bezier(0.165, 0.84, 0.44, 1) forwards; }
    </style>
</div>
