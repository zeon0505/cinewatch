<div>
    <style>
        .hero-bg {
            background: linear-gradient(
                to bottom,
                rgba(0,0,0,.1) 0%,
                rgba(0,0,0,.4) 50%,
                rgba(10,10,10,1) 100%
            ),
            url('{{ $heroMovie->thumbnail ?? 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=1800&q=80' }}') center/cover no-repeat;
        }
        .film-card {
            position: relative;
            border-radius: 6px;
            overflow: hidden;
            cursor: pointer;
            transition: transform .25s ease, box-shadow .25s ease;
            background: var(--card);
        }
        .film-card:hover { transform: scale(1.07); box-shadow: 0 16px 40px rgba(0,0,0,.8); z-index: 10; }
        .film-card img { width: 100%; aspect-ratio: 2/3; object-fit: cover; display: block; }
        .film-card .overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,.92) 0%, transparent 55%);
            opacity: 0;
            transition: opacity .25s;
            display: flex; flex-direction: column; justify-content: flex-end; padding: 12px;
        }
        .film-card:hover .overlay { opacity: 1; }
        .badge-genre { font-size: 10px; font-weight: 600; letter-spacing: 1px; padding: 2px 7px; border-radius: 3px; background: var(--red); color: #fff; text-transform: uppercase; display: inline-block; margin-bottom: 4px; }
        .stars { color: var(--gold); font-size: 11px; }
        .row-scroll { display: flex; gap: 12px; overflow-x: auto; padding-bottom: 8px; scroll-behavior: smooth; }
        .row-scroll::-webkit-scrollbar { height: 2px; }
        .row-scroll > * { flex-shrink: 0; width: 160px; }
        .section-title { font-family: 'Bebas Neue', sans-serif; letter-spacing: 1.5px; font-size: 1.5rem; }
        .fade-up {
            opacity: 0; transform: translateY(30px);
            transition: opacity .6s ease, transform .6s ease;
        }
        .fade-up.visible { opacity: 1; transform: translateY(0); }
        .grad-text {
            background: linear-gradient(90deg, #fff 0%, #E50914 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .top-badge { position: absolute; top: 8px; left: 8px; background: var(--red); color: #fff; font-family: 'Bebas Neue', sans-serif; font-size: 13px; padding: 2px 7px; border-radius: 4px; z-index: 2; }
        .ticker-wrap { overflow: hidden; white-space: nowrap; }
        .ticker { display: inline-block; animation: ticker 45s linear infinite; }
        @keyframes ticker { from { transform: translateX(0); } to { transform: translateX(-50%); } }
        .promo-card { border-radius: 10px; overflow: hidden; position: relative; background: var(--card); cursor: pointer; transition: transform .25s; height: 180px;}
        .promo-card:hover { transform: translateY(-4px); }
        .promo-card img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .promo-card .promo-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,.9) 0%, transparent 60%); }
    </style>

    <!-- HERO -->
    <header class="hero-bg min-h-screen flex flex-col justify-end pb-24 px-6 md:px-16" style="padding-top:80px">
        @if($heroMovie)
        <div class="max-w-2xl">
            <div class="flex items-center gap-3 mb-4">
                <span class="badge-genre">Film Unggulan</span>
                <span class="text-xs text-gray-400 uppercase tracking-widest">{{ $heroMovie->category->name }} · {{ $heroMovie->duration }}</span>
            </div>
            <h1 class="text-6xl md:text-8xl font-black leading-none mb-4 tracking-tight" style="font-family:'Bebas Neue',sans-serif">
                <span class="grad-text">{{ strtoupper($heroMovie->title) }}</span>
            </h1>
            <p class="text-gray-300 text-base md:text-lg max-w-lg leading-relaxed mb-6">
                {{ Str::limit($heroMovie->description, 160) }}
            </p>
            <div class="flex items-center gap-3 mb-8">
                <div class="stars">★★★★★</div>
                <span class="text-sm text-gray-400">9.1</span>
                <span class="text-gray-600">·</span>
                <span class="text-xs px-2 py-0.5 border border-gray-600 rounded text-gray-400">17+</span>
            </div>
            <div class="flex gap-3 flex-wrap">
                <a href="{{ route('movie.detail', $heroMovie->slug) }}" class="btn-red flex items-center gap-2">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M11.596 8.697l-6.363 3.692A.5.5 0 0 1 4.5 12V4a.5.5 0 0 1 .732-.441l6.364 3.692a.5.5 0 0 1 0 .882z"/></svg>
                    Tonton Sekarang
                </a>
            </div>
        </div>
        @endif

        <div class="ticker-wrap mt-16 py-3 border-t border-white/10 text-xs text-gray-500 tracking-widest uppercase">
            <span class="ticker">
                @foreach($trendingMovies as $m)
                    &nbsp;&nbsp;🔥 Trending: {{ $m->title }} &nbsp;·&nbsp;
                @endforeach
                @foreach($trendingMovies as $m)
                    &nbsp;&nbsp;🔥 Trending: {{ $m->title }} &nbsp;·&nbsp;
                @endforeach
            </span>
        </div>
    </header>

    <!-- TRENDING -->
    <section id="trending" class="px-6 md:px-12 py-14 fade-up">
        <div class="flex items-center justify-between mb-5">
            <h2 class="section-title">🔥 Sedang Trending</h2>
            <a href="#" class="text-sm text-gray-400 hover:text-red-500 transition-colors uppercase tracking-widest font-bold text-[10px]">Lihat Semua</a>
        </div>
        <div class="row-scroll">
            @foreach($trendingMovies as $movie)
                <a href="{{ route('movie.detail', $movie->slug) }}" class="film-card">
                    <div class="top-badge">TOP</div>
                    <img src="{{ $movie->thumbnail }}" alt="{{ $movie->title }}" loading="lazy"/>
                    <div class="overlay">
                        <span class="badge-genre">{{ $movie->category->name }}</span>
                        <p class="text-white font-bold text-sm leading-tight mb-1 uppercase">{{ $movie->title }}</p>
                        <div class="flex items-center gap-1">
                            <span class="stars" style="font-size:9px">★★★★½</span>
                            <span class="text-[10px] text-gray-400 font-bold uppercase">{{ $movie->duration }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- GENRE PROMO -->
    <section id="genre" class="px-6 md:px-12 py-12 fade-up">
        <h2 class="section-title mb-6">🎭 Jelajahi Genre</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($categories as $category)
                <div class="promo-card">
                    <img src="https://images.unsplash.com/photo-1578269174936-2709b6aeb913?w=600&q=70" alt="{{ $category->name }}"/>
                    <div class="promo-overlay"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <p class="text-white font-bold text-lg mt-1" style="font-family:'Bebas Neue',sans-serif;letter-spacing:2px">{{ strtoupper($category->name) }}</p>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-red-600"></div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- NEW RELEASES -->
    <section id="new" class="px-6 md:px-12 py-6 pb-20 fade-up">
        <div class="flex items-center justify-between mb-5">
            <h2 class="section-title">🆕 Rilis Terbaru</h2>
        </div>
        <div class="row-scroll">
            @foreach($latestMovies as $movie)
                <a href="{{ route('movie.detail', $movie->slug) }}" class="film-card">
                    <img src="{{ $movie->thumbnail }}" alt="{{ $movie->title }}" loading="lazy"/>
                    <div class="overlay">
                        <span class="badge-genre">{{ $movie->category->name }}</span>
                        <p class="text-white font-bold text-sm leading-tight mb-1 uppercase">{{ $movie->title }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <script>
        document.addEventListener('livewire:navigated', () => {
            const obs = new IntersectionObserver(entries => {
                entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
            }, { threshold: 0.1 });
            document.querySelectorAll('.fade-up').forEach(el => obs.observe(el));
        });
        
        // Initial call
        const obs = new IntersectionObserver(entries => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
        }, { threshold: 0.1 });
        document.querySelectorAll('.fade-up').forEach(el => obs.observe(el));
    </script>
</div>
