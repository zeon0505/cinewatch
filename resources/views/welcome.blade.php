<x-layouts.app>
    @push('styles')
    <style>
        .hero-section { position: relative; height: 90vh; display: flex; flex-direction: column; justify-content: center; overflow: hidden; }
        .hero-video-bg { position: absolute; inset: 0; z-index: 0; }
        .hero-video-bg img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.4) contrast(1.1); animation: heroZoom 30s linear infinite alternate; }
        .hero-overlay { position: absolute; inset: 0; background: linear-gradient(to top, var(--bg) 0%, transparent 40%, transparent 60%, rgba(0,0,0,0.8) 100%); z-index: 1; }
        
        @keyframes heroZoom { from { transform: scale(1); } to { transform: scale(1.1); } }

        .film-card { position: relative; border-radius: 8px; overflow: hidden; cursor: pointer; transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1); background: var(--card); flex-shrink: 0; width: 200px; }
        .film-card:hover { transform: scale(1.1) translateY(-5px); z-index: 50; box-shadow: 0 20px 40px rgba(0,0,0,0.9); }
        .film-card img { width: 100%; aspect-ratio: 2/3; object-fit: cover; }
        
        .card-info { position: absolute; inset: 0; display: flex; flex-direction: column; justify-content: flex-end; padding: 15px; opacity: 0; transition: all 0.3s ease-out; background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, transparent 60%); }
        .film-card:hover .card-info { opacity: 1; }

        .row-container { position: relative; padding: 0 50px; margin-bottom: 40px; }
        .row-scroll { display: flex; gap: 15px; overflow-x: auto; padding: 20px 0; scroll-behavior: smooth; -ms-overflow-style: none; scrollbar-width: none; }
        .row-scroll::-webkit-scrollbar { display: none; }

        .nav-btn { position: absolute; top: 50%; transform: translateY(-50%); width: 40px; height: 40px; background: rgba(0,0,0,0.6); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 60; opacity: 0; transition: all 0.3s; border: 1px solid rgba(255,255,255,0.05); backdrop-filter: blur(10px); }
        .row-container:hover .nav-btn { opacity: 1; }
        .nav-btn:hover { background: var(--red); transform: translateY(-50%) scale(1.1); }
        .nav-btn.prev { left: 5px; }
        .nav-btn.next { right: 5px; }

        .genre-pill { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); padding: 30px; border-radius: 12px; text-align: center; transition: all 0.4s; overflow: hidden; position: relative; cursor: pointer; }
        .genre-pill:hover { background: var(--red); transform: translateY(-5px); }
        .genre-pill h3 { font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem; letter-spacing: 1.5px; }

        .btn-primary-home { background: var(--red); color: white; padding: 12px 28px; border-radius: 8px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; font-size: 12px; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary-home:hover { transform: translateY(-2px); filter: brightness(1.1); }
        
        .fade-in-up { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.19, 1, 0.22, 1); }
        .fade-in-up.visible { opacity: 1; transform: translateY(0); }

        .tag-small { font-size: 9px; font-weight: 900; background: var(--red); padding: 3px 8px; border-radius: 3px; text-transform: uppercase; letter-spacing: 1.2px; margin-bottom: 6px; display: inline-block; }
    </style>
    @endpush

    <section class="hero-section" x-data="{ activeSlide: 0, slides: {{ count($heroMovies) ?: 1 }}, autoPlayInterval: null }" x-init="autoPlayInterval = setInterval(() => activeSlide = (activeSlide + 1) % slides, 6000)">
        @forelse($heroMovies as $index => $heroMovie)
        <div x-show="activeSlide === {{ $index }}"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-1000 absolute inset-0"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 w-full h-full">
            
            <div class="hero-video-bg">
                <img src="{{ $heroMovie->thumbnail ?? 'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=1800&q=80' }}" alt="hero-bg" class="w-full h-full object-cover" />
            </div>
            <div class="hero-overlay"></div>
            
            <div class="absolute inset-0 z-10 flex flex-col justify-center px-10 md:px-20 max-w-4xl">
                <div class="animate-fadeIn scale-entrance">
                    <span class="tag-small">Featured Billboard</span>
                    <h1 class="text-6xl md:text-8xl font-black leading-[0.85] mb-6 tracking-tighter uppercase" style="font-family:'Bebas Neue',sans-serif">
                        {{ $heroMovie->title }}
                    </h1>
                    <p class="text-gray-300 text-sm md:text-base max-w-xl leading-relaxed mb-8 opacity-70 font-light italic drop-shadow-lg">
                        "{{ $heroMovie->description }}"
                    </p>
                    <div class="flex gap-4">
                        <a href="{{ route('movie.detail', $heroMovie->slug) }}" class="btn-primary-home">
                            <span class="material-symbols-outlined">play_arrow</span> Play Now
                        </a>
                        @auth
                        <button class="bg-white/10 backdrop-blur-xl border border-white/10 text-white px-8 py-3 rounded-lg font-black uppercase text-[11px] flex items-center gap-2 hover:bg-white/20 transition-all">
                            <span class="material-symbols-outlined">analytics</span> Detail
                        </button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="absolute inset-0 w-full h-full bg-zinc-900 flex items-center justify-center">
            <p class="text-gray-500 font-black uppercase tracking-widest">No Content Featured</p>
        </div>
        @endforelse

        @if(count($heroMovies) > 1)
        <div class="absolute bottom-24 left-10 md:left-20 z-20 flex gap-3">
            @foreach($heroMovies as $index => $heroMovie)
            <button @click="activeSlide = {{ $index }}; clearInterval(autoPlayInterval); autoPlayInterval = setInterval(() => activeSlide = (activeSlide + 1) % slides, 6000)"
                    :class="{'w-8 bg-red-600': activeSlide === {{ $index }}, 'w-2 bg-white/50 hover:bg-white': activeSlide !== {{ $index }}}"
                    class="h-2 rounded-full transition-all duration-300 shadow-lg" aria-label="Go to slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
        @endif
    </section>

    <div class="relative z-20 space-y-6 pb-20 -mt-16">
        
        @if(isset($continueWatching) && count($continueWatching) > 0)
        <section id="continue-watching" class="row-container animate-fadeIn">
            <div class="px-4 mb-2 flex items-center justify-between">
                <h2 class="text-2xl font-black text-white uppercase tracking-tighter" style="font-family:'Bebas Neue',sans-serif">Lanjutkan Menonton</h2>
                <div class="h-[1px] flex-1 bg-white/5 mx-6"></div>
            </div>
            <div class="row-container !p-0">
                <button onclick="scrollRow('continue-row', -800)" class="nav-btn prev"><span class="material-symbols-outlined">chevron_left</span></button>
                <div id="continue-row" class="row-scroll px-10">
                    @foreach($continueWatching as $history)
                    <div onclick="window.location.href='{{ route('movie.detail', $history->movie->slug) }}'" class="film-card group !w-[220px]">
                        <div class="relative aspect-[16/9] overflow-hidden">
                            <img src="{{ $history->movie->thumbnail }}" alt="{{ $history->movie->title }}" class="w-full h-full object-cover" />
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="material-symbols-outlined text-white text-4xl">play_circle</span>
                            </div>
                        </div>
                        <div class="p-3">
                            <h3 class="text-white font-black text-[10px] uppercase tracking-tight line-clamp-1">{{ $history->movie->title }}</h3>
                            <div class="mt-2 h-1 w-full bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full bg-red-600 rounded-full" style="width: 45%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button onclick="scrollRow('continue-row', 800)" class="nav-btn next"><span class="material-symbols-outlined">chevron_right</span></button>
            </div>
        </section>
        @endif
        
        @auth
            @livewire('recommendations')
        @endauth

        <section id="trending" class="row-container fade-in-up">
            <div class="px-4 mb-2 flex items-center justify-between">
                <h2 class="text-2xl font-black text-white uppercase tracking-tighter" style="font-family:'Bebas Neue',sans-serif">Trending Now</h2>
                <div class="h-[1px] flex-1 bg-white/5 mx-6"></div>
            </div>
            <div class="row-container !p-0">
                <button onclick="scrollRow('trending-row', -800)" class="nav-btn prev"><span class="material-symbols-outlined">chevron_left</span></button>
                <div id="trending-row" class="row-scroll px-10">
                    @forelse($trendingMovies as $movie)
                    <div onclick="window.location.href='{{ route('movie.detail', $movie->slug) }}'" class="film-card group">
                        <img src="{{ $movie->thumbnail }}" alt="{{ $movie->title }}" />
                        <div class="card-info">
                            @if($movie->is_premium)
                                <div class="absolute top-2 right-2 bg-yellow-500 text-black text-[7px] font-black px-1.5 py-0.5 rounded flex items-center gap-0.5 shadow-lg z-20">
                                    <span class="material-symbols-outlined text-[8px]">workspace_premium</span> VIP
                                </div>
                            @endif
                            <span class="tag-small !bg-white !text-black mb-1.5">{{ $movie->category->name ?? 'Uncategorized' }}</span>
                            <h3 class="text-white font-black text-[11px] uppercase tracking-tight mb-1">{{ $movie->title }}</h3>
                            <p class="text-[9px] text-red-600 font-black uppercase tracking-widest">{{ $movie->duration }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-600 text-xs py-10 uppercase font-black tracking-widest">Belum ada film trending</p>
                    @endforelse
                </div>
                <button onclick="scrollRow('trending-row', 800)" class="nav-btn next"><span class="material-symbols-outlined">chevron_right</span></button>
            </div>
        </section>

        <section id="genre" class="px-10 md:px-20 py-12 fade-in-up">
            <div class="flex flex-col items-center mb-10 text-center">
                <h2 class="text-4xl font-black text-white uppercase tracking-tight" style="font-family:'Bebas Neue',sans-serif">Browse Categories</h2>
                <div class="w-16 h-1 bg-red-600 mt-2 rounded-full shadow-[0_0_15px_rgba(220,38,38,0.5)]"></div>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-6 gap-6">
                @foreach($categories as $category)
                <div onclick="window.location.href='{{ route('category.detail', $category->slug) }}'" class="genre-pill group">
                    <h3 class="relative z-10 text-white group-hover:scale-105 transition-transform">{{ $category->name }}</h3>
                    <p class="relative z-10 text-[8px] text-gray-500 group-hover:text-white/70 font-black uppercase tracking-[2px] mt-1">{{ $category->movies_count }} Movies</p>
                </div>
                @endforeach
            </div>
        </section>

        <section id="new" class="row-container fade-in-up">
            <div class="px-4 mb-2 flex items-center justify-between">
                <h2 class="text-2xl font-black text-white uppercase tracking-tighter" style="font-family:'Bebas Neue',sans-serif">Fresh Releases</h2>
                <div class="h-[1px] flex-1 bg-white/5 mx-6"></div>
            </div>
            <div class="row-container !p-0">
                <button onclick="scrollRow('new-row', -800)" class="nav-btn prev"><span class="material-symbols-outlined">chevron_left</span></button>
                <div id="new-row" class="row-scroll px-10">
                    @forelse($latestMovies as $movie)
                    <div onclick="window.location.href='{{ route('movie.detail', $movie->slug) }}'" class="film-card group">
                        <img src="{{ $movie->thumbnail }}" alt="{{ $movie->title }}" />
                        <div class="card-info text-center">
                            @if($movie->is_premium)
                                <div class="absolute top-2 right-2 bg-yellow-500 text-black text-[7px] font-black px-1.5 py-0.5 rounded flex items-center gap-0.5 shadow-lg z-20">
                                    <span class="material-symbols-outlined text-[8px]">workspace_premium</span> VIP
                                </div>
                            @endif
                            <h3 class="text-white font-black text-[11px] uppercase">{{ $movie->title }}</h3>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-600 text-xs py-10 uppercase font-black tracking-widest">Belum ada rilis baru</p>
                    @endforelse
                </div>
                <button onclick="scrollRow('new-row', 800)" class="nav-btn next"><span class="material-symbols-outlined">chevron_right</span></button>
            </div>
        </section>

    </div>

    <script {!! 'data-navigate-once' !!}>
        function initWelcome() {
            window.scrollRow = function(id, amount) {
                const el = document.getElementById(id);
                if(el) el.scrollBy({ left: amount, behavior: 'smooth' });
            }

            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.fade-in-up').forEach(el => observer.observe(el));
        }

        document.addEventListener('livewire:navigated', initWelcome);
        document.addEventListener('DOMContentLoaded', initWelcome);
    </script>
</x-layouts.app>