<div>
    <div class="max-w-7xl mx-auto">
        <!-- Header and Search Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 animate-fadeIn">
            <div>
                <h1 class="text-4xl font-black text-white uppercase tracking-tighter logo">
                    JELAJAH <span class="text-[#E50914]">FILM</span>
                </h1>
                <div class="flex items-center gap-3 mt-1">
                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-[3px]">Katalog Film CINEWATCH</p>
                    @if($genreFilter || $search || $audienceFilter)
                        <button wire:click="clearFilter" class="bg-red-600/10 text-red-500 px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all animate-pulse">
                            Bersihkan Filter (X)
                        </button>
                    @endif
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-4 flex-1 justify-end max-w-3xl">
                <!-- Custom Dropdown Filters with AlpineJS -->
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <!-- Genre Custom Dropdown -->
                    <div x-data="{ open: false }" @click.away="open = false" class="relative w-full sm:w-52 z-50">
                        <button @click="open = !open" type="button" class="w-full bg-white/[0.03] border border-white/5 hover:border-red-600 rounded-xl px-5 py-4 text-xs font-bold text-gray-300 outline-none transition-all cursor-pointer flex justify-between items-center group shadow-inner">
                            <span class="truncate uppercase tracking-widest text-[10px]">
                                @if($genreFilter)
                                    @php $g = $categories->firstWhere('id', $genreFilter); @endphp
                                    {{ $g ? $g->name : 'Semua Kategori' }}
                                @else
                                    Semua Kategori
                                @endif
                            </span>
                            <span class="material-symbols-outlined text-[16px] text-gray-500 group-hover:text-red-500 transition-transform" :class="open ? 'rotate-180 text-red-500' : ''">expand_more</span>
                        </button>
                        <div x-show="open" x-transition.opacity.duration.200ms class="absolute top-full left-0 mt-2 w-full bg-[#111111] border border-white/10 rounded-xl shadow-2xl py-2 max-h-64 overflow-y-auto custom-scrollbar z-50" style="display: none;">
                            <button wire:click="$set('genreFilter', '')" @click="open = false" class="w-full text-left px-5 py-3 text-[10px] font-black uppercase tracking-widest hover:bg-white/5 hover:text-white transition-colors {{ !$genreFilter ? 'text-[#E50914] bg-white/5' : 'text-gray-400' }}">
                                Semua Kategori
                            </button>
                            <div class="border-t border-white/5 my-1"></div>
                            @foreach($categories as $cat)
                                <button wire:click="$set('genreFilter', '{{ $cat->id }}')" @click="open = false" class="w-full text-left px-5 py-3 text-[11px] font-bold tracking-widest hover:bg-white/5 hover:text-white transition-colors {{ $genreFilter == $cat->id ? 'text-[#E50914] bg-white/5 border-l-2 border-[#E50914]' : 'text-gray-400 border-l-2 border-transparent' }}">
                                    {{ $cat->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    

                    <!-- Audience Toggle Buttons -->
                    <div class="flex items-center gap-1.5 bg-white/[0.03] border border-white/5 rounded-xl p-1.5">
                        <button wire:click="$set('audienceFilter', '')" class="px-4 py-2.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all {{ !$audienceFilter ? 'bg-white/10 text-white' : 'text-gray-500 hover:text-gray-300' }}">
                            Semua
                        </button>
                        <button wire:click="$set('audienceFilter', 'kids')" class="flex items-center gap-1.5 px-4 py-2.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all {{ $audienceFilter === 'kids' ? 'bg-yellow-500 text-black shadow-lg shadow-yellow-500/20' : 'text-gray-500 hover:text-yellow-400' }}">
                            <span class="material-symbols-outlined text-[14px]">child_care</span> Kids
                        </button>
                        <button wire:click="$set('audienceFilter', 'adult')" class="flex items-center gap-1.5 px-4 py-2.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all {{ $audienceFilter === 'adult' ? 'bg-red-600 text-white shadow-lg shadow-red-600/20' : 'text-gray-500 hover:text-red-400' }}">
                            <span class="material-symbols-outlined text-[14px]">no_adult_content</span> Adult
                        </button>
                    </div>
                </div>


                <!-- Search -->
                <div class="relative flex-1 group w-full sm:w-auto">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-red-600 transition-colors">search</span>
                    <input 
                        wire:model.live.debounce.300ms="search"
                        type="text" 
                        placeholder="Cari judul film..." 
                        class="w-full bg-white/[0.03] border border-white/5 rounded-xl pl-12 pr-6 py-4 text-xs font-bold text-white focus:border-red-600 outline-none transition-all"
                    />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 mb-6">
            <span class="material-symbols-outlined text-white opacity-80">grid_view</span>
            <h2 class="text-white font-black text-lg uppercase tracking-widest">Katalog Film</h2>
        </div>

        <!-- Film Grid with Dropdown per Card -->
        @php $watchlistMovieIds = $watchlists->pluck('movie_id')->toArray(); @endphp

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
            @forelse($films as $index => $film)
                @php 
                    $isInWatchlist = in_array($film->id, $watchlistMovieIds); 
                    $isWatched = in_array($film->id, $histories);
                @endphp
                <div 
                    x-data="{ open: false }" 
                    @click.away="open = false" 
                    class="animate-card relative rounded-2xl overflow-visible bg-[#141414] border border-white/5 transition-all duration-300 shadow-xl flex flex-col h-full group" 
                    :class="open ? 'border-[#E50914] shadow-[0_20px_40px_rgba(229,9,20,0.2)]' : 'hover:border-[#E50914]/40 hover:-translate-y-1'"
                    style="animation-delay: {{ $index * 50 }}ms"
                >

                    <!-- Clickable Card -->
                    <button @click="open = !open" class="w-full text-left flex flex-col flex-1 focus:outline-none relative">
                        <!-- Watched Indicator Badge -->
                        @if($isWatched)
                        <div class="absolute top-2 right-10 z-10 bg-green-500/80 backdrop-blur-sm text-white px-1.5 py-0.5 rounded text-[7px] font-black uppercase flex items-center gap-1 shadow-lg">
                            <span class="material-symbols-outlined text-[8px]">check_circle</span>
                            DITONTON
                        </div>
                        @endif

                        <div class="relative aspect-[2/3] overflow-hidden rounded-t-2xl">
                            <img src="{{ $film->thumbnail }}" alt="{{ $film->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                            <!-- Audience Badge -->
                            <div class="absolute top-2 left-2">
                                @if($film->audience_type === 'kids')
                                    <span class="bg-yellow-500 text-black px-1.5 py-0.5 rounded text-[7px] font-black uppercase">KIDS</span>
                                @elseif($film->audience_type === 'adult')
                                    <span class="bg-red-600 text-white px-1.5 py-0.5 rounded text-[7px] font-black uppercase">ADULT</span>
                                @endif
                            </div>

                            <!-- Rating -->
                            <div class="absolute top-2 right-2 bg-black/60 backdrop-blur-md px-1.5 py-0.5 rounded border border-white/10 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[9px] text-yellow-500">star</span>
                                <span class="text-white text-[9px] font-black">{{ number_format($film->rating_value, 1) }}</span>
                            </div>

                            <!-- Watchlist Indicator -->
                            @if($isInWatchlist)
                            <div class="absolute bottom-2 right-2 w-6 h-6 bg-[#E50914] rounded-full flex items-center justify-center shadow-lg">
                                <span class="material-symbols-outlined text-[12px] text-white">bookmark</span>
                            </div>
                            @endif

                            <!-- Open hint -->
                            <div class="absolute inset-0 flex items-end justify-center pb-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="bg-black/70 backdrop-blur-sm text-white text-[8px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-white/10">Klik untuk opsi</span>
                            </div>
                        </div>

                        <div class="p-3 flex flex-col flex-1 justify-between">
                            <h3 class="text-white font-black text-[11px] uppercase tracking-tight line-clamp-2 leading-snug" :class="open ? 'text-[#E50914]' : ''">{{ $film->title }}</h3>
                            <div class="flex items-center gap-1.5 mt-1.5 text-gray-500 font-bold text-[8px] uppercase tracking-widest">
                                <span>{{ $film->year }}</span>
                                <span class="w-1 h-1 rounded-full bg-white/20"></span>
                                <span>{{ $film->duration }}</span>
                            </div>
                        </div>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="absolute bottom-0 left-0 right-0 bg-[#1a1a1a] border border-white/10 border-t-0 rounded-b-2xl z-50 overflow-hidden shadow-2xl" style="display:none">
                        <a href="{{ route('movie.detail', $film->slug) }}" class="flex items-center gap-3 px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-300 hover:bg-[#E50914] hover:text-white transition-all border-b border-white/5">
                            <span class="material-symbols-outlined text-[16px]">play_circle</span> Lihat Film
                        </a>
                        <button wire:click="toggleWatchlist({{ $film->id }})" @click="open = false" class="w-full flex items-center gap-3 px-4 py-3 text-[10px] font-black uppercase tracking-widest transition-all border-b border-white/5 {{ $isInWatchlist ? 'text-[#E50914] hover:bg-red-600/10' : 'text-gray-300 hover:bg-white/5' }}">
                            <span class="material-symbols-outlined text-[16px]">{{ $isInWatchlist ? 'bookmark_remove' : 'bookmark_add' }}</span>
                            {{ $isInWatchlist ? 'Hapus dari Watchlist' : 'Tambah ke Watchlist' }}
                        </button>
                        <div class="px-4 py-3 bg-white/[0.02] flex items-center justify-between">
                            <span class="text-[9px] font-bold uppercase tracking-[2px] text-gray-500">History</span>
                            @if($isWatched)
                                <span class="text-[9px] font-black uppercase text-green-500 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[12px]">check_circle</span> Sudah
                                </span>
                            @else
                                <span class="text-[9px] font-black uppercase text-gray-600 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[12px]">schedule</span> Belum
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 text-center text-gray-500 border border-dashed border-white/10 rounded-3xl bg-white/[0.02]">
                    <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                        <span class="material-symbols-outlined text-5xl text-gray-600">movie_off</span>
                    </div>
                    <p class="text-white font-black text-lg uppercase tracking-widest mb-2">Tidak Ada Film</p>
                    <p class="italic text-[11px] font-bold tracking-[2px] mb-8">Film yang Anda cari tidak ditemukan sesuai filter.</p>
                    <button wire:click="clearFilter" class="inline-block bg-[#E50914] text-white px-8 py-3 rounded-lg font-black uppercase text-[10px] tracking-widest shadow-xl shadow-red-900/40 hover:scale-105 transition-all">
                        Hapus Filter Pencarian
                    </button>
                </div>
            @endforelse
        </div>
        
        <div class="mt-12 flex justify-center">
            {{ $films->links() }}
        </div>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255,255,255,0.02); border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(229,9,20,0.5); border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(229,9,20,0.8); }
        
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .animate-fadeIn { animation: fadeIn 0.4s ease-out; }
    </style>
</div>
