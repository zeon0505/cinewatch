<div class="min-h-screen bg-[#050505] pt-28 pb-20 px-10 md:px-20">
    <!-- Header Series -->
    <div class="max-w-7xl mx-auto mb-16 animate-fadeIn">
        <div class="flex items-center gap-4 mb-4">
             <a href="/" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-gray-400 hover:bg-white/10 hover:text-white transition-all">
                <span class="material-symbols-outlined">arrow_back</span>
             </a>
             <span class="tag !mb-0">Series Explorer</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-black text-white uppercase tracking-tighter" style="font-family:'Bebas Neue',sans-serif">
            Series: <span class="text-[#E50914]">{{ $series->name }}</span>
        </h1>
        <p class="text-gray-500 text-sm font-bold uppercase tracking-[2px] mt-2 italic opacity-70">
            Menampilkan {{ $movies->total() }} judul pilihan terbaik untukmu di koleksi ini.
        </p>
    </div>

    <!-- Movie Grid -->
    <div class="max-w-7xl mx-auto grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 md:gap-8">
        @forelse($movies as $index => $movie)
        <a href="{{ route('movie.detail', $movie->slug) }}" 
           class="film-card group animate-fadeInUp" 
           style="animation-delay: {{ 0.1 + ($index % 12) * 0.05 }}s">
            <div class="relative aspect-[2/3] rounded-lg overflow-hidden bg-neutral-900 border border-white/5 transition-all group-hover:scale-105 group-hover:-translate-y-2 group-hover:shadow-2xl">
                <img src="{{ $movie->thumbnail }}" class="w-full h-full object-cover transition-filter group-hover:brightness-50" />
                <div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-black via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                    <h3 class="text-white font-bold text-[10px] uppercase tracking-wide leading-tight mb-1 truncate">{{ $movie->title }}</h3>
                    <div class="flex items-center justify-between gap-2">
                         <span class="text-[8px] text-[#E50914] font-black uppercase tracking-widest">{{ $movie->duration }}</span>
                         @auth
                            <div @click.stop="" class="scale-50 origin-right transition-transform hover:scale-75">
                                <livewire:⚡watchlist-button :movieId="$movie->id" :key="'cat-'.$movie->id" :showText="false" />
                            </div>
                         @else
                            <span class="material-symbols-outlined text-[14px] text-yellow-500">star</span>
                         @endauth
                    </div>
                </div>
            </div>
        </a>
        @empty
            <div class="col-span-full py-32 text-center opacity-30">
                <span class="material-symbols-outlined text-6xl mb-4">movie_filter</span>
                <p class="text-xl font-black uppercase tracking-[5px]">Belum ada film di series ini.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="max-w-7xl mx-auto mt-20 flex justify-center">
        {{ $movies->links('livewire.user.films.pagination-premium') }}
    </div>

    <style>
        .film-card { width: auto !important; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.6s cubic-bezier(0.2, 1, 0.3, 1) forwards; opacity: 0; }
        .tag { font-size: 9px; font-weight: 900; background: var(--red); padding: 3px 8px; border-radius: 3px; text-transform: uppercase; letter-spacing: 1.2px; margin-bottom: 6px; display: inline-block; }
    </style>
</div>
