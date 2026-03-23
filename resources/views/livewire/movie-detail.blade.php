<div class="pt-24 min-h-screen bg-black text-white">
    <div class="relative h-[60vh] overflow-hidden">
        <img src="{{ $movie->thumbnail }}" class="w-full h-full object-cover opacity-40 blur-sm scale-105" />
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
        
        <div class="absolute inset-0 flex flex-col justify-end px-6 md:px-16 pb-12 max-w-5xl">
            <div class="flex flex-col md:flex-row gap-8 items-end">
                <img src="{{ $movie->thumbnail }}" class="w-48 md:w-64 aspect-[2/3] object-cover rounded-lg shadow-2xl border border-white/10 z-10" />
                <div class="flex-1">
                    <div class="badge-genre mb-3">{{ $movie->category->name ?? 'Film' }}</div>
                    <h1 class="text-4xl md:text-6xl font-black mb-4 uppercase tracking-tight" style="font-family:'Bebas Neue',sans-serif">{{ $movie->title }}</h1>
                    
                    <div class="flex items-center gap-4 mb-6 text-sm text-gray-400">
                        <span class="text-yellow-500 font-bold">★★★★★ 9.1</span>
                        <span>{{ $movie->created_at->format('Y') }}</span>
                        <span>{{ $movie->duration }}</span>
                        <span class="border border-gray-700 px-2 py-0.5 rounded text-xs uppercase">17+</span>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('movie.watch', $movie->id) }}" class="btn-red flex items-center gap-2">
                             <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M11.596 8.697l-6.363 3.692A.5.5 0 0 1 4.5 12V4a.5.5 0 0 1 .732-.441l6.364 3.692a.5.5 0 0 1 0 .882z"/></svg>
                             Nonton Sekarang
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
    </section>
</div>
