<div class="relative hidden md:block">
    <input 
        wire:model.live.debounce.300ms="query" 
        id="search-bar" 
        type="text" 
        placeholder="🔍  Cari film, serial..."
        class="bg-white/10 border border-white/15 rounded-md px-4 py-2 text-sm text-white focus:ring-2 focus:ring-red-600 outline-none w-[220px] transition-all focus:w-[280px]"
    />
    
    @if(strlen($query) > 1)
    <div class="absolute top-full right-0 mt-2 w-72 bg-[#1C1C1C] rounded-md shadow-2xl border border-white/5 overflow-hidden z-[60]">
        @if(count($results) > 0)
            @foreach($results as $movie)
                <a href="{{ route('movie.detail', $movie->slug) }}" class="flex items-center gap-3 p-3 hover:bg-white/5 transition-colors group">
                    <img src="{{ $movie->thumbnail }}" class="w-12 h-16 object-cover rounded shadow shadow-black" />
                    <div>
                        <p class="text-xs font-bold text-white group-hover:text-red-500">{{ $movie->title }}</p>
                        <p class="text-[10px] text-gray-400">{{ $movie->category->name ?? 'Film' }}</p>
                    </div>
                </a>
            @endforeach
        @else
            <div class="p-4 text-center text-xs text-gray-500">Film tidak ditemukan.</div>
        @endif
    </div>
    @endif
</div>
