<div class="min-h-screen bg-[#050505] text-white pt-32 pb-20 px-6 md:px-20">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div class="animate-fadeIn">
            <span class="text-red-600 font-black uppercase tracking-[5px] text-[10px] mb-2 block">Fresh From Studio</span>
            <h1 class="text-5xl md:text-7xl font-black uppercase tracking-tighter logo leading-none">Rilis <span class="text-red-600">Terbaru</span></h1>
        </div>
        <p class="text-gray-500 font-medium max-w-sm text-sm border-l-2 border-red-600 pl-4">Nikmati koleksi film dan serial terbaru yang baru saja mendarat di Cinewatch.</p>
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
                <img src="{{ $movie->thumbnail }}" alt="{{ $movie->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-0 left-0 right-0 p-6 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <span class="text-[8px] bg-white text-black px-2 py-0.5 rounded font-black uppercase tracking-widest mb-2 inline-block">New</span>
                        <h3 class="text-xs font-black uppercase tracking-tight line-clamp-2 leading-tight mb-2">{{ $movie->title }}</h3>
                        <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">{{ $movie->duration }}</p>
                    </div>
                </div>

                <!-- Date Badge -->
                <div class="absolute top-4 right-4 px-3 py-1 bg-red-600/80 backdrop-blur-xl rounded-full flex items-center justify-center font-black text-[8px] text-white uppercase tracking-widest">
                    {{ $movie->created_at->format('M Y') }}
                </div>

                @if($movie->is_premium)
                    <div class="absolute top-4 left-4 bg-yellow-500 text-black text-[9px] font-black px-2 py-0.5 rounded shadow-lg z-10 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[10px]">workspace_premium</span> VIP
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full py-32 text-center">
                <p class="text-gray-600 font-black uppercase tracking-widest">Belum ada rilis baru.</p>
            </div>
        @endforelse
    </div>
    </div>

    <!-- Pagination -->
    <div class="mt-20">
        {{ $movies->links() }}
    </div>
</div>
