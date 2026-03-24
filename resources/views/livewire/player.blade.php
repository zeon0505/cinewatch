<div class="pt-24 min-h-screen bg-[#050505] text-white px-6 md:px-16 pb-20">
    <div class="mb-8 animate-fadeIn">
        <a href="{{ route('movie.detail', $movie->slug) }}" class="text-[10px] text-gray-600 hover:text-white font-black uppercase tracking-[3px] transition-all flex items-center gap-3 group">
            <span class="material-symbols-outlined text-[18px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
            Back to Overview
        </a>
        <div class="flex items-center gap-4 mt-4">
             <h1 class="text-3xl md:text-5xl font-black uppercase tracking-tighter" style="font-family:'Bebas Neue',sans-serif">{{ $movie->title }}</h1>
             <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-[10px] font-black text-gray-400">{{ $movie->year ?? '2024' }}</span>
        </div>
    </div>

    <!-- Player Container -->
    <div x-data="{ server: localStorage.getItem('player_server') || 'vidsrc' }" class="space-y-8 animate-fadeIn delay-1">
        <div class="relative w-full aspect-video bg-black rounded-[32px] overflow-hidden shadow-[0_30px_60px_rgba(0,0,0,0.8)] border border-white/5 group ring-1 ring-white/10">
            
            <!-- Direct Video Source -->
            <template x-if="server === 'direct'">
                <div class="w-full h-full">
                    @if($movie->video_url)
                        <video 
                            id="main-video"
                            x-ref="player"
                            x-init="
                                const source = '{{ $movie->video_url }}';
                                const video = $refs.player;
                                const defaultOptions = { captions: { active: true, update: true, language: 'auto' } };

                                if (source.endsWith('.m3u8')) {
                                    if (Hls.isSupported()) {
                                        const hls = new Hls();
                                        hls.loadSource(source);
                                        hls.attachMedia(video);
                                    } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                                        video.src = source;
                                    }
                                } else {
                                    video.src = source;
                                }
                                
                                const player = new Plyr(video, defaultOptions);

                                // Resume & Save Progress
                                player.on('ready', () => { if(@json($progress) > 0) player.currentTime = @json($progress); });
                                player.on('timeupdate', () => {
                                    let now = Math.floor(player.currentTime);
                                    if (now > 0 && now % 10 === 0 && now !== (window.lastProgress || 0)) {
                                        window.lastProgress = now;
                                        $wire.call('update_progress', now);
                                    }
                                });

                                player.on('error', (event) => {
                                    console.error('Plyr Error:', event);
                                    alert('Gagal memutar video dari sumber ini. Pastikan link video valid dan mendukung akses langsung (bukan embed).');
                                });
                            "
                            class="w-full h-full object-contain"
                            controls
                            playsinline
                            poster="{{ $movie->thumbnail }}"
                        >
                            @if($movie->subtitle_url)
                                <track label="Indonesian" kind="subtitles" srclang="id" src="{{ $movie->subtitle_url }}" default>
                            @endif
                        </video>
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center bg-zinc-900 text-center p-8">
                            <span class="material-symbols-outlined text-6xl text-gray-700 mb-4 italic">video_stable</span>
                            <h3 class="text-xl font-black uppercase tracking-widest text-gray-500 mb-2">Sumber Lokal Kosong</h3>
                            <p class="text-xs text-gray-600 max-w-md font-bold uppercase tracking-tighter leading-relaxed">
                                Fitur Subtitle (CC) mandiri hanya tersedia untuk "Server Lokal". Silakan masukkan link video langsung (.mp4/.m3u8) di dashboard kelola film untuk menggunakan server ini.
                            </p>
                        </div>
                    @endif
                </div>
            </template>

            <!-- API Embed Sources -->
            <template x-if="server === 'vidsrc'">
                @php
                    $vidsrcUrl = "https://vidsrc.to/embed/movie/" . ($movie->tmdb_id ?? '550');
                    if ($movie->subtitle_url) {
                        $subtitleUrl = route('subtitle.cors', $movie->id);
                        $vidsrcUrl .= "?sub.file=" . urlencode($subtitleUrl) . "&sub.label=Indonesian";
                    }
                @endphp
                <iframe 
                    src="{{ $vidsrcUrl }}" 
                    class="w-full h-full border-none"
                    allowfullscreen
                ></iframe>
            </template>

            <template x-if="server === 'superembed'">
                <iframe 
                    src="https://superembed.stream/movie/{{ $movie->tmdb_id ?? '550' }}" 
                    class="w-full h-full border-none"
                    allowfullscreen
                ></iframe>
            </template>

            <template x-if="server === '2embed'">
                <iframe 
                    src="https://www.2embed.cc/embed/{{ $movie->tmdb_id ?? '550' }}" 
                    class="w-full h-full border-none"
                    allowfullscreen
                ></iframe>
            </template>
        </div>

        <!-- Server Switcher UI -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 bg-white/5 p-6 rounded-3xl border border-white/5">
            <div class="flex flex-col">
                <span class="text-[9px] text-gray-600 font-extrabold uppercase tracking-[3px]">Transmission Node</span>
                <h3 class="text-white font-black uppercase tracking-widest text-sm flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    Select Streaming Server
                </h3>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <button 
                    @click="server = 'vidsrc'; localStorage.setItem('player_server', 'vidsrc')"
                    :class="server === 'vidsrc' ? 'bg-[#E50914] text-white' : 'bg-white/5 text-gray-500 hover:text-white'"
                    class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-xl"
                >
                    Server 1 (Primary)
                </button>
                <button 
                    @click="server = 'superembed'; localStorage.setItem('player_server', 'superembed')"
                    :class="server === 'superembed' ? 'bg-[#E50914] text-white' : 'bg-white/5 text-gray-500 hover:text-white'"
                    class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-xl"
                >
                    Server 2 (Auto)
                </button>
                <button 
                    @click="server = '2embed'; localStorage.setItem('player_server', '2embed')"
                    :class="server === '2embed' ? 'bg-[#E50914] text-white' : 'bg-white/5 text-gray-500 hover:text-white'"
                    class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-xl"
                >
                    Server 3 (HD)
                </button>
                <button 
                    @click="server = 'direct'; localStorage.setItem('player_server', 'direct')"
                    :class="server === 'direct' ? 'bg-[#E50914] text-white' : 'bg-white/5 text-gray-500 hover:text-white'"
                    class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-xl"
                >
                    Server Lokal (CC)
                </button>
            </div>

            <div class="flex items-center gap-2 border-l border-white/10 pl-6 h-10">
                <button 
                    wire:click="reportLink('link_mati')"
                    wire:loading.attr="disabled"
                    class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-red-500 transition-colors group"
                >
                    <span class="material-symbols-outlined text-[18px] group-hover:scale-110 transition-transform">report</span>
                    Lapor Link Mati
                </button>
            </div>
        </div>
    </div>

    <!-- Metadata Section -->
    <section class="py-16 space-y-12 animate-fadeIn delay-2">
        <div class="flex flex-col md:flex-row items-end justify-between gap-8 border-b border-white/5 pb-8">
            <div>
                <span class="text-[9px] text-[#E50914] font-black uppercase tracking-[5px] mb-3 block">Now Playing</span>
                <h2 class="text-4xl font-black uppercase tracking-tight" style="font-family:'Bebas Neue',sans-serif">The Synopsis</h2>
            </div>
            <div class="flex items-center gap-8">
                <div class="text-right">
                    <p class="text-[9px] text-gray-600 font-bold uppercase tracking-widest">Global Views</p>
                    <p class="text-xl font-black text-white">{{ number_format($movie->views) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[9px] text-gray-600 font-bold uppercase tracking-widest">Quality</p>
                    <p class="text-xl font-black text-green-500 italic">4K UHD</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
            <div class="lg:col-span-2">
                <p class="text-gray-400 text-lg leading-relaxed font-medium">
                    {{ $movie->description }}
                </p>
            </div>
            
            <div class="bg-white/[0.02] border border-white/5 p-8 rounded-[32px] space-y-6 self-start">
                 <h4 class="text-white font-black uppercase text-xs tracking-widest border-b border-white/5 pb-4">Movie Specs</h4>
                 <div class="space-y-4">
                     <div class="flex justify-between items-center">
                         <span class="text-[10px] text-gray-600 font-bold uppercase">Source Type</span>
                         <span class="text-[10px] text-white font-black uppercase tracking-widest">API Cloud</span>
                     </div>
                     <div class="flex justify-between items-center">
                         <span class="text-[10px] text-gray-600 font-bold uppercase">Runtime</span>
                         <span class="text-[10px] text-white font-black uppercase tracking-widest">{{ $movie->duration }}</span>
                     </div>
                     <div class="flex justify-between items-center">
                         <span class="text-[10px] text-gray-600 font-bold uppercase">Language</span>
                         <span class="text-[10px] text-white font-black uppercase tracking-widest">ENG / ID Sub</span>
                     </div>
                 </div>
            </div>
        </div>
    </section>
    <!-- Related Movies Section -->
    @if(count($relatedMovies) > 0)
    <section class="animate-fadeIn delay-3 pt-10">
        <div class="px-4 mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-black text-white uppercase tracking-tighter" style="font-family:'Bebas Neue',sans-serif">Saran Film Terkait</h2>
            <div class="h-[1px] flex-1 bg-white/5 mx-6"></div>
        </div>
        
        <div class="relative group/row">
            <button onclick="scrollRow('related-row', -800)" class="absolute left-0 top-1/2 -translate-y-1/2 w-10 h-10 bg-black/60 rounded-full flex items-center justify-center z-30 opacity-0 group-hover/row:opacity-100 transition-opacity border border-white/10 backdrop-blur-md">
                <span class="material-symbols-outlined text-white">chevron_left</span>
            </button>
            
            <div id="related-row" class="flex gap-4 overflow-x-auto pb-6 scroll-smooth scrollbar-hide">
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

            <button onclick="scrollRow('related-row', 800)" class="absolute right-0 top-1/2 -translate-y-1/2 w-10 h-10 bg-black/60 rounded-full flex items-center justify-center z-30 opacity-0 group-hover/row:opacity-100 transition-opacity border border-white/10 backdrop-blur-md">
                <span class="material-symbols-outlined text-white">chevron_right</span>
            </button>
        </div>
    </section>
    @endif

    <style>
        .animate-fadeIn { animation: fadeIn 0.8s ease-out forwards; }
        .delay-1 { animation-delay: 0.2s; opacity: 0; }
        .delay-2 { animation-delay: 0.4s; opacity: 0; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</div>
