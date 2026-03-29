<div class="pt-24 min-h-screen bg-black text-white">
    <div class="relative h-[60vh] overflow-hidden">
        <img src="{{ $movie->thumbnail }}" class="w-full h-full object-cover opacity-40 blur-sm scale-105" />
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
        
        <div class="absolute inset-0 flex flex-col justify-end px-6 md:px-16 pb-12 max-w-5xl">
            <div class="flex flex-col md:flex-row gap-8 items-end">
                <img src="{{ $movie->thumbnail }}" class="w-48 md:w-64 aspect-[2/3] object-cover rounded-lg shadow-2xl border border-white/10 z-10" />
                <div class="flex-1">
                    @if($movie->is_premium)
                        <div class="flex items-center gap-2 mb-3">
                            <div class="px-3 py-1 bg-yellow-500 rounded text-[10px] font-black text-black uppercase tracking-widest flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">workspace_premium</span> VIP CONTENT
                            </div>
                        </div>
                    @endif
                    <div class="badge-genre mb-3">{{ $movie->category->name ?? 'Film' }}</div>
                    <h1 class="text-4xl md:text-6xl font-black mb-4 uppercase tracking-tight" style="font-family:'Bebas Neue',sans-serif">{{ $movie->title }}</h1>
                    
                    <div class="flex items-center gap-4 mb-6 text-sm text-gray-400">
                        <span class="text-yellow-500 font-bold flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">star</span> {{ number_format($movie->rating_value ?? 9.1, 1) }}</span>
                        <span>{{ $movie->year ?? $movie->created_at->format('Y') }}</span>
                        <span>{{ $movie->duration }}</span>
                        @if($movie->age_rating)
                        <span class="border border-gray-700 px-2 py-0.5 rounded text-xs uppercase">{{ $movie->age_rating }}</span>
                        @else
                        <span class="border border-gray-700 px-2 py-0.5 rounded text-xs uppercase">17+</span>
                        @endif
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('movie.watch', $movie->id) }}" class="btn-red flex items-center gap-2 {{ $movie->is_premium && (!auth()->check() || !auth()->user()->is_vip) ? 'from-yellow-500 to-orange-600 bg-gradient-to-r text-black' : '' }}">
                             @if($movie->is_premium && (!auth()->check() || !auth()->user()->is_vip))
                                <span class="material-symbols-outlined text-[20px]">lock</span>
                                Buka dengan VIP
                             @else
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M11.596 8.697l-6.363 3.692A.5.5 0 0 1 4.5 12V4a.5.5 0 0 1 .732-.441l6.364 3.692a.5.5 0 0 1 0 .882z"/></svg>
                                Nonton Sekarang
                             @endif
                        </a>
                        <button wire:click="toggleWatchlist" class="btn-outline flex items-center gap-2">
                            @if($isInWatchlist)
                                <svg width="20" height="20" fill="currentColor" class="text-red-600" viewBox="0 0 16 16"><path d="M8 15s-7-4.35-7-9.5S7 0 8 0s7 1.15 7 5.5S8 15 8 15z"/></svg>
                                Hapus Watchlist
                            @else
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                                Tambah Watchlist
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="px-6 md:px-16 py-12 max-w-5xl mx-auto">
        <h2 class="text-2xl font-bold mb-4 border-b border-white/10 pb-2">Deskripsi</h2>
        <p class="text-gray-300 leading-relaxed text-lg mb-10">
            {{ $movie->description ?? 'Tidak ada deskripsi tersedia untuk film ini.' }}
        </p>

        @auth
             @livewire('movie-rating', ['movie_id' => $movie->id])
        @else
             <div class="mt-8 pt-8 border-t border-white/5">
                  <p class="text-gray-500 text-sm"><a href="/login" class="text-white hover:underline">Masuk</a> untuk memberikan rating.</p>
             </div>
        @endauth

        <h2 class="text-2xl font-bold mb-4 border-b border-white/10 pb-2">Detail Informasi</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
            <div>
                <p class="text-gray-500 uppercase tracking-tighter">Genre</p>
                <p class="text-white">{{ $movie->category->name }}</p>
            </div>
            <div>
                <p class="text-gray-500 uppercase tracking-tighter">Durasi</p>
                <p class="text-white">{{ $movie->duration }}</p>
            </div>
            <div>
                <p class="text-gray-500 uppercase tracking-tighter">Rilis</p>
                <p class="text-white">{{ $movie->created_at->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-gray-500 uppercase tracking-tighter">Total View</p>
                <p class="text-white">{{ number_format($movie->views) }}x ditonton</p>
            </div>
        </div>

        <div class="mt-12 flex justify-between items-center border-t border-white/10 pt-6">
             <div class="flex items-center gap-6">
                  @livewire('report-button', ['movieId' => $movie->id])
             </div>
             <a href="{{ route('request.film') }}" class="text-xs text-red-500 hover:text-red-400 font-bold uppercase tracking-widest flex items-center gap-2">
                  <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                  Request Film Lain
             </a>
        </div>
    </section>

    <!-- Related Movies Section -->
    @if(count($relatedMovies) > 0)
    <section class="animate-fadeIn delay-3 pt-4 pb-16">
        <div class="px-6 md:px-16 mb-6 flex items-center justify-between max-w-5xl mx-auto">
            <h2 class="text-2xl font-black text-white uppercase tracking-tighter" style="font-family:'Bebas Neue',sans-serif">Saran Film Terkait</h2>
            <div class="h-[1px] flex-1 bg-white/5 mx-6"></div>
        </div>
        
        <div class="relative group/row max-w-7xl mx-auto">
            <button onclick="scrollRow('related-row', -800)" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-black/60 rounded-full flex items-center justify-center z-30 opacity-0 group-hover/row:opacity-100 transition-opacity border border-white/10 backdrop-blur-md">
                <span class="material-symbols-outlined text-white">chevron_left</span>
            </button>
            
            <div id="related-row" class="flex gap-4 overflow-x-auto px-6 md:px-16 pb-6 scroll-smooth scrollbar-hide">
                @foreach($relatedMovies as $related)
                <div onclick="window.location.href='{{ route('movie.detail', $related->slug) }}'" class="flex-none w-[160px] md:w-[200px] group/card cursor-pointer">
                    <div class="relative aspect-[2/3] rounded-xl overflow-hidden mb-3">
                        <img src="{{ $related->thumbnail }}" alt="{{ $related->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-110" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-4xl">play_circle</span>
                        </div>
                    </div>
                    <h3 class="text-white font-bold text-[11px] uppercase tracking-tight line-clamp-1 group-hover/card:text-red-500 transition-colors">{{ $related->title }}</h3>
                    <p class="text-[9px] text-gray-500 font-black uppercase tracking-widest">{{ $related->year ?? '2024' }}</p>
                </div>
                @endforeach
            </div>

            <button onclick="scrollRow('related-row', 800)" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-black/60 rounded-full flex items-center justify-center z-30 opacity-0 group-hover/row:opacity-100 transition-opacity border border-white/10 backdrop-blur-md">
                <span class="material-symbols-outlined text-white">chevron_right</span>
            </button>
        </div>
    </section>
    @endif
</div>
