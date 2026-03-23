<div class="h-full overflow-y-auto scrollbar-hide">
    <div class="max-w-7xl mx-auto p-8 pt-0">
        <!-- Header and Search Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 animate-fadeIn">
            <div>
                <h1 class="text-4xl font-black text-white uppercase tracking-tighter logo">
                    KELOLA <span class="text-[#E50914]">FILM SAYA</span>
                </h1>
                <div class="flex items-center gap-3 mt-1">
                    <p class="text-gray-500 text-[10px] font-bold uppercase tracking-[3px] opacity-60">Pusat Distribusi Karya Kreator</p>
                    @if($genreFilter || $search || $audienceFilter)
                        <button wire:click="clearFilter" class="bg-red-600/10 text-red-500 px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all animate-pulse">
                            Bersihkan Filter (X)
                        </button>
                    @endif
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-4 flex-1 justify-end max-w-3xl">
                <!-- Dropdown Filters -->
                <div class="flex gap-2 w-full sm:w-auto">
                    <select wire:model.live="genreFilter" class="bg-white/[0.03] border border-white/5 rounded-xl px-4 py-4 text-xs font-bold text-gray-300 focus:border-red-600 outline-none transition-all cursor-pointer hover:bg-white/5 appearance-none">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    
                    <select wire:model.live="audienceFilter" class="bg-white/[0.03] border border-white/5 rounded-xl px-4 py-4 text-xs font-bold text-gray-300 focus:border-red-600 outline-none transition-all cursor-pointer hover:bg-white/5 appearance-none">
                        <option value="">Semua Umur (Kids & Adult)</option>
                        <option value="kids">KIDS (Anak-anak)</option>
                        <option value="adult">ADULT (Dewasa)</option>
                    </select>
                </div>

                <!-- Search -->
                <div class="relative flex-1 group w-full sm:w-auto">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-red-600 transition-colors">search</span>
                    <input 
                        wire:model.live.debounce.300ms="search"
                        type="text" 
                        placeholder="Search title..." 
                        class="w-full bg-white/[0.03] border border-white/5 rounded-xl pl-12 pr-6 py-4 text-xs font-bold text-white focus:border-red-600 outline-none transition-all"
                    />
                </div>
                
                <a href="{{ route('user.films.create') }}" class="bg-[#E50914] text-white px-8 py-4 rounded-xl font-black text-xs uppercase tracking-[2px] shadow-xl shadow-red-900/40 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-3 shrink-0">
                    <span class="material-symbols-outlined text-[18px]">cloud_upload</span> UNGGAH KARYA
                </a>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-500 p-4 rounded-xl text-[10px] uppercase font-black tracking-widest mb-8 animate-fadeIn">
                <span class="material-symbols-outlined text-[16px] align-middle mr-2">check_circle</span> {{ session('message') }}
            </div>
        @endif

        <!-- Film Table -->
        <div class="bg-neutral-900/40 backdrop-blur-3xl border border-white/5 rounded-2xl overflow-hidden shadow-2xl">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/5 text-[10px] font-black uppercase text-gray-500 tracking-[3px]">
                        <th class="px-8 py-6">Karya & Identitas</th>
                        <th class="px-8 py-6">Kategori / Genre</th>
                        <th class="px-8 py-6">Filter Umur</th>
                        <th class="px-8 py-6">Tahun</th>
                        <th class="px-8 py-6 text-right">Opsi Operasional</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-300">
                    @forelse($films as $film)
                    <tr class="border-b border-white/[0.03] hover:bg-white/[0.02] transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-6">
                                <div class="w-16 h-20 rounded-lg overflow-hidden shrink-0 border border-white/10 group-hover:border-[#E50914] transition-colors">
                                    <img src="{{ $film->thumbnail }}" class="w-full h-full object-cover" />
                                </div>
                                <div>
                                    <p class="text-white font-black uppercase tracking-tight group-hover:text-[#E50914] transition-colors">{{ $film->title }}</p>
                                    <p class="text-[9px] text-gray-600 font-bold uppercase tracking-widest mt-1">{{ $film->duration }} • {{ $film->views }} Views</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-wrap gap-1.5 max-w-[200px]">
                                @foreach($film->categories as $cat)
                                    <button wire:click="$set('genreFilter', {{ $cat->id }})" class="bg-white/5 border border-white/10 px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest text-gray-400 hover:bg-red-600 hover:text-white transition-all">{{ $cat->name }}</button>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            @if($film->audience_type === 'kids')
                                <button wire:click="$set('audienceFilter', 'kids')" class="bg-yellow-500/10 border border-yellow-500/20 text-yellow-600 px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest flex items-center gap-1.5 w-fit hover:bg-yellow-500 hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-[12px]">child_care</span> KIDS
                                </button>
                            @else
                                <button wire:click="$set('audienceFilter', 'adult')" class="bg-red-600/10 border border-red-600/20 text-red-600 px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest flex items-center gap-1.5 w-fit hover:bg-red-600 hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-[12px]">no_adult_content</span> ADULT
                                </button>
                            @endif
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="text-white font-black text-xs uppercase">{{ $film->year }}</span>
                                <div class="flex items-center gap-1 text-yellow-500">
                                    <span class="material-symbols-outlined text-[12px]">star</span>
                                    <span class="text-[10px] font-black">{{ number_format($film->rating_value, 1) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('user.films.edit', $film->id) }}" class="w-10 h-10 bg-blue-500/10 text-blue-500 rounded-lg flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-[18px]">edit_note</span>
                                </a>
                                <button wire:click="confirmDelete({{ $film->id }})" class="w-10 h-10 bg-red-600/10 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-600 hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-[18px]">delete_forever</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-gray-700 italic uppercase font-black text-xs tracking-[5px]">
                            <span class="material-symbols-outlined text-5xl mb-4 block">folder_off</span> Belum Ada Karya Yang Anda Unggah
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-8">
            {{ $films->links() }}
        </div>
    </div>

    <!-- Custom Themed Deletion Modal -->
    @if($confirmingDeletion)
    <div class="fixed inset-0 z-[1000] flex items-center justify-center p-6 bg-black/80 backdrop-blur-md animate-fadeIn">
        <div class="w-full max-w-md bg-neutral-900 border border-white/10 rounded-3xl p-10 text-center shadow-[0_0_100px_rgba(229,9,20,0.3)] animate-cardSlide">
            <div class="w-20 h-20 bg-red-600/10 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                <span class="material-symbols-outlined text-4xl">warning</span>
            </div>
            <h3 class="text-2xl font-black text-white uppercase tracking-tighter mb-4" style="font-family:'Bebas Neue',sans-serif">Hapus Karya Permanen?</h3>
            <p class="text-gray-500 text-[11px] font-bold uppercase tracking-widest leading-relaxed mb-10 italic">"Tindakan ini akan menghapus data film dari koleksimu selamanya. Operasi tidak dapat dibatalkan."</p>
            <div class="flex gap-4">
                <button wire:click="$set('confirmingDeletion', false)" class="flex-1 bg-white/5 border border-white/10 text-white py-4 rounded-xl font-black uppercase text-[10px] tracking-widest hover:bg-white/10 transition-all">
                    Batal
                </button>
                <button wire:click="deleteFilm" class="flex-1 bg-red-600 text-white py-4 rounded-xl font-black uppercase text-[10px] tracking-widest shadow-xl shadow-red-900/30 hover:bg-red-700 transition-all">
                    Hapus Permanen
                </button>
            </div>
        </div>
    </div>
    @endif

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes cardSlide { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .animate-fadeIn { animation: fadeIn 0.4s ease-out; }
    </style>
</div>
