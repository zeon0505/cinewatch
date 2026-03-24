<div class="min-h-screen bg-[#050505] text-white pt-32 pb-20 px-6 md:px-20">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div class="animate-fadeIn">
            <span class="text-red-600 font-black uppercase tracking-[5px] text-[10px] mb-2 block">Most Popular</span>
            <h1 class="text-5xl md:text-7xl font-black uppercase tracking-tighter logo leading-none">Trending <span class="text-red-600">Now</span></h1>
        </div>
        <p class="text-gray-500 font-medium max-w-sm text-sm border-l-2 border-red-600 pl-4">Menampilkan film dan serial yang paling banyak ditonton minggu ini.</p>
    </div>

    <!-- Grid -->
    <div class="relative">
        <div wire:loading.grid class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @for($i = 0; $i < 12; $i++)
                <x-movie-card-skeleton />
            @endfor
        </div>

        <div wire:loading.remove class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @forelse($movies as $movie)
            <div onclick="window.location.href='{{ route('movie.detail', $movie->slug) }}'" class="group relative aspect-[2/3] rounded-2xl overflow-hidden cursor-pointer bg-white/[0.03] border border-white/5 hover:border-red-600/50 transition-all duration-500 hover:scale-105 hover:z-20 shadow-2xl">
                <img src="{{ $movie->thumbnail }}" alt="{{ $movie->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 group-hover:rotate-1" loading="lazy">
                
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-0 left-0 right-0 p-6 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <span class="text-[8px] bg-red-600 text-white px-2 py-0.5 rounded font-black uppercase tracking-widest mb-2 inline-block">Trending</span>
                        <h3 class="text-xs font-black uppercase tracking-tight line-clamp-2 leading-tight mb-2">{{ $movie->title }}</h3>
                        <div class="flex items-center gap-3 text-[9px] text-gray-400 font-bold uppercase tracking-widest">
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[10px]">visibility</span> {{ number_format($movie->views) }}</span>
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[10px] text-yellow-500">star</span> {{ $movie->rating ?? '8.5' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Rank Badge -->
                <div class="absolute top-4 left-4 w-8 h-8 bg-black/60 backdrop-blur-xl border border-white/10 rounded-lg flex items-center justify-center font-black text-sm text-white skew-x-[-10deg]">
                    {{ $loop->iteration + (($movies->currentPage() - 1) * $movies->perPage()) }}
                </div>

                @if($movie->is_premium)
                    <div class="absolute top-4 right-4 bg-yellow-500 text-black text-[9px] font-black px-2 py-0.5 rounded shadow-lg z-10 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[10px]">workspace_premium</span> VIP
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full py-32 text-center">
                <p class="text-gray-600 font-black uppercase tracking-widest">Belum ada film trending saat ini.</p>
            </div>
        @endforelse
    </div>
    </div>

    <!-- Pagination -->
    <div class="mt-20">
        {{ $movies->links() }}
    </div>
</div>
