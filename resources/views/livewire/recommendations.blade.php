<section class="animate-fadeIn delay-3 pt-4 pb-16">
    <div class="px-6 md:px-16 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 max-w-7xl mx-auto">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-red-600/10 border border-red-600/20 rounded-2xl flex items-center justify-center shadow-lg shadow-red-600/5">
                <span class="material-symbols-outlined text-red-500 text-3xl animate-pulse">magic_button</span>
            </div>
            <div>
                <h2 class="text-2xl font-black text-white uppercase tracking-tighter logo" style="font-family:'Bebas Neue',sans-serif">Spesial Untukmu</h2>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-[3px]">Rekomendasi Pintar Zeon AI</p>
            </div>
        </div>
        <div class="h-[1px] flex-1 bg-white/5 mx-6 hidden md:block"></div>
        <div class="flex items-center gap-2 px-4 py-2 bg-white/5 rounded-full border border-white/10">
            <div class="w-2 h-2 bg-green-500 rounded-full animate-ping"></div>
            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Zeon Analyzed Your History</span>
        </div>
    </div>
    
    <div class="relative group/row max-w-7xl mx-auto">
        @if($loading)
            <div class="flex gap-4 overflow-x-auto px-6 md:px-16 pb-6 scrollbar-hide">
                @for($i=0; $i<6; $i++)
                    <div class="flex-none w-[180px] md:w-[220px]">
                        <div class="aspect-[2/3] bg-zinc-900 animate-pulse rounded-2xl mb-3"></div>
                        <div class="h-4 bg-zinc-900 animate-pulse rounded w-3/4 mb-2"></div>
                        <div class="h-3 bg-zinc-900 animate-pulse rounded w-1/2"></div>
                    </div>
                @endfor
            </div>
        @else
            <div id="reco-row" class="flex gap-6 overflow-x-auto px-6 md:px-16 pb-12 scroll-smooth scrollbar-hide">
                @foreach($recommendations as $movie)
                    <div onclick="window.location.href='{{ route('movie.detail', $movie->slug) }}'" class="flex-none w-[180px] md:w-[220px] group/card cursor-pointer">
                        <div class="relative aspect-[2/3] rounded-3xl overflow-hidden mb-4 ring-1 ring-white/10 group-hover/card:ring-red-500/50 transition-all duration-500 shadow-2xl">
                            <img src="{{ $movie->thumbnail }}" alt="{{ $movie->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110" />
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent opacity-60"></div>
                            
                            <!-- AI Sparkle Tag -->
                            <div class="absolute top-4 left-4 flex items-center gap-1.5 px-2.5 py-1 bg-black/60 backdrop-blur-md rounded-lg border border-white/10 scale-90 group-hover/card:scale-100 transition-transform origin-left">
                                <span class="material-symbols-outlined text-[12px] text-red-500 font-bold">auto_awesome</span>
                                <span class="text-[8px] font-black text-white uppercase tracking-widest">AI Pick</span>
                            </div>

                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover/card:opacity-100 transition-all duration-500 bg-black/40 backdrop-blur-[2px]">
                                <div class="w-14 h-14 bg-red-600 rounded-full flex items-center justify-center shadow-2xl shadow-red-600/40 translate-y-4 group-hover/card:translate-y-0 transition-transform duration-500">
                                    <span class="material-symbols-outlined text-white text-4xl">play_arrow</span>
                                </div>
                            </div>

                            @if($movie->is_premium)
                                <div class="absolute top-4 right-4 w-8 h-8 bg-yellow-500 text-black rounded-lg flex items-center justify-center shadow-lg">
                                    <span class="material-symbols-outlined text-sm font-bold">workspace_premium</span>
                                </div>
                            @endif
                        </div>
                        <div class="px-1">
                            <h3 class="text-white font-black text-sm uppercase tracking-tight line-clamp-1 group-hover/card:text-red-500 transition-colors mb-1">{{ $movie->title }}</h3>
                            <div class="flex items-center gap-3">
                                <span class="text-[10px] text-gray-500 font-black uppercase tracking-widest">{{ $movie->category->name ?? 'Film' }}</span>
                                <div class="w-1 h-1 bg-gray-700 rounded-full"></div>
                                <span class="text-[10px] text-yellow-500 font-black tracking-widest flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[10px]">star_rate</span> 8.9
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
