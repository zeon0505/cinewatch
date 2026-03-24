<div class="pt-24 min-h-screen bg-black text-white px-6 md:px-16 pb-20">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <h1 class="text-5xl font-black uppercase tracking-tighter logo mb-2">My <span class="text-red-600">Watchlist</span></h1>
                <p class="text-gray-500 font-bold uppercase tracking-widest text-xs">Simpan sekarang, tonton kapan saja.</p>
            </div>
            <div class="h-[2px] flex-1 bg-white/5 mx-6 hidden md:block mb-4"></div>
            <div class="text-right">
                <span class="text-4xl font-black text-white/20">{{ $watchlists->total() }}</span>
                <p class="text-[10px] text-gray-600 font-black uppercase tracking-widest mt-1">Total Film</p>
            </div>
        </div>

        @if($watchlists->isEmpty())
            <div class="flex flex-col items-center justify-center py-24 text-center bg-zinc-900/20 border border-white/5 rounded-[40px]">
                <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-5xl text-gray-700">bookmark_add</span>
                </div>
                <h2 class="text-2xl font-black text-white uppercase mb-2">Belum ada film yang disimpan</h2>
                <p class="text-gray-500 text-sm max-w-xs mx-auto mb-8 font-medium">Banyak film seru menantimu. Klik ikon Bookmark pada film untuk menyimpannya di sini.</p>
                <a href="{{ route('home') }}" class="px-8 py-3 bg-red-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-red-700 transition-all shadow-xl shadow-red-900/20">Cari Film Seru</a>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
                @foreach($watchlists as $item)
                    <div class="group/card relative">
                        <div onclick="window.location.href='{{ route('movie.detail', $item->movie->slug) }}'" class="relative aspect-[2/3] rounded-2xl overflow-hidden mb-3 cursor-pointer ring-1 ring-white/10 group-hover/card:ring-red-500/50 transition-all duration-500">
                            <img src="{{ $item->movie->thumbnail }}" alt="{{ $item->movie->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110" />
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent opacity-60"></div>
                            
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover/card:opacity-100 transition-all duration-500 bg-black/40 backdrop-blur-[2px]">
                                <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center shadow-xl shadow-red-600/40 translate-y-4 group-hover/card:translate-y-0 transition-transform duration-500">
                                    <span class="material-symbols-outlined text-white text-3xl">play_arrow</span>
                                </div>
                            </div>

                            @if($item->movie->is_premium)
                                <div class="absolute top-3 left-3 px-2 py-0.5 bg-yellow-500 text-black text-[8px] font-black uppercase rounded tracking-widest flex items-center gap-1 shadow-lg">
                                    <span class="material-symbols-outlined text-[10px]">workspace_premium</span> VIP
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-between items-start gap-2 pr-1">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-white font-bold text-xs uppercase tracking-tight line-clamp-1 group-hover/card:text-red-500 transition-colors">{{ $item->movie->title }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[9px] text-gray-500 font-black uppercase tracking-widest">{{ $item->movie->category->name ?? 'Film' }}</span>
                                    <span class="w-1 h-1 bg-gray-700 rounded-full"></span>
                                    <span class="text-[9px] text-gray-600 font-bold tracking-widest">{{ $item->movie->duration }}</span>
                                </div>
                            </div>
                            
                            <livewire:⚡watchlist-button :movieId="$item->movie_id" :key="'watchlist-'.$item->id" />
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-16">
                {{ $watchlists->links() }}
            </div>
        @endif
    </div>
</div>
