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
                <video 
                    id="main-video"
                    class="w-full h-full object-contain"
                    controls
                    src="{{ $movie->video_url }}"
                    poster="{{ $movie->thumbnail }}"
                ></video>
            </template>

            <!-- API Embed Sources -->
            <template x-if="server === 'vidsrc'">
                <iframe 
                    src="https://vidsrc.to/embed/movie/{{ $movie->tmdb_id ?? '550' }}" 
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
                    Direct Source
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

    <style>
        .animate-fadeIn { animation: fadeIn 0.8s ease-out forwards; }
        .delay-1 { animation-delay: 0.2s; opacity: 0; }
        .delay-2 { animation-delay: 0.4s; opacity: 0; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</div>
