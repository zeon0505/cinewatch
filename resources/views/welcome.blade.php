<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>CINEWATCH — Premium Streaming Experience</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        :root {
            --red: #E50914;
            --red-glow: rgba(229, 9, 20, 0.5);
            --bg: #050505;
            --card: #101010;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: var(--bg); color: #E5E5E5; font-family: 'Outfit', sans-serif; overflow-x: hidden; scroll-behavior: smooth; }
        
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #000; }
        ::-webkit-scrollbar-thumb { background: var(--red); border-radius: 10px; }

        .logo { font-family: 'Bebas Neue', sans-serif; letter-spacing: 2px; font-size: 1.8rem; }
        .nav-glass { backdrop-filter: blur(20px); background: linear-gradient(to bottom, rgba(0,0,0,0.9), transparent); transition: all 0.4s; }
        .nav-scrolled { background: rgba(0,0,0,0.98); border-bottom: 1px solid rgba(255,255,255,0.05); }

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

        .nav-btn { position: absolute; top: 50%; transform: translateY(-50%); width: 40px; height: 40px; background: rgba(0,0,0,0.6); border-radius: 50%; display: flex; items-center: center; justify-content: center; cursor: pointer; z-index: 60; opacity: 0; transition: all 0.3s; border: 1px solid rgba(255,255,255,0.05); backdrop-filter: blur(10px); }
        .row-container:hover .nav-btn { opacity: 1; }
        .nav-btn:hover { background: var(--red); transform: translateY(-50%) scale(1.1); }
        .nav-btn.prev { left: 5px; }
        .nav-btn.next { right: 5px; }

        .genre-pill { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); padding: 30px; border-radius: 12px; text-align: center; transition: all 0.4s; overflow: hidden; position: relative; cursor: pointer; }
        .genre-pill:hover { background: var(--red); transform: translateY(-5px); }
        .genre-pill h3 { font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem; letter-spacing: 1.5px; }

        .btn-primary { background: var(--red); color: white; padding: 12px 28px; border-radius: 8px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; font-size: 12px; transition: all 0.3s; display: inline-flex; items-center: center; gap: 8px; }
        .btn-primary:hover { transform: translateY(-2px); filter: brightness(1.1); }
        
        .fade-in-up { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.19, 1, 0.22, 1); }
        .fade-in-up.visible { opacity: 1; transform: translateY(0); }

        .tag { font-size: 9px; font-weight: 900; background: var(--red); padding: 3px 8px; border-radius: 3px; text-transform: uppercase; letter-spacing: 1.2px; margin-bottom: 6px; display: inline-block; }
        .material-symbols-outlined { font-size: 20px; }
    </style>
    @livewireStyles
</head>
<body>

<nav id="mainNav" class="nav-glass fixed top-0 left-0 right-0 z-[100] flex items-center justify-between px-10 py-5">
    <div class="flex items-center gap-8">
        <a href="/" class="logo text-3xl text-[#E50914] hover:scale-105 transition-transform">CINEWATCH</a>
        <ul class="hidden md:flex gap-6 text-sm text-gray-300">
            <li><a href="/" class="hover:text-white transition-colors">Beranda</a></li>
            <li><a href="/#trending" class="hover:text-white transition-colors">Trending</a></li>
            <li><a href="/#genre" class="hover:text-white transition-colors">Genre</a></li>
            <li><a href="/#terbaru" class="hover:text-white transition-colors">Terbaru</a></li>
        </ul>
    </div>
    <div class="flex items-center gap-6">
        @livewire('search')
        @guest
            <div class="flex items-center gap-5">
                <a href="/login" class="text-[10px] font-black uppercase text-gray-400 hover:text-white transition-all tracking-[1.5px]">Login</a>
                <a href="/register" class="btn-primary py-2 px-6 text-[10px]">Join Now</a>
            </div>
        @else
            <div class="flex items-center gap-6">
                <div class="hidden lg:flex flex-col items-end">
                    <span class="text-[9px] text-gray-600 font-bold uppercase tracking-[2px]">Member Area</span>
                    <div class="flex gap-4">
                        <a href="{{ auth()->user()->role === 'admin' ? '/admin' : '/dashboard' }}" class="text-[10px] font-black uppercase text-white tracking-[2px] hover:text-[#E50914] transition-all flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">dashboard</span> Dashboard
                        </a>
                        <a href="{{ route('user.profile') }}" class="text-[10px] font-black uppercase text-white tracking-[2px] hover:text-[#E50914] transition-all flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">account_circle</span> Profile
                        </a>
                    </div>
                </div>
                
                <div class="w-10 h-10 bg-[#E50914] rounded-full flex items-center justify-center font-black text-white text-sm shadow-[0_0_20px_rgba(229,9,20,0.4)] border border-white/10 group cursor-pointer relative">
                    {{ substr(auth()->user()->name, 0, 1) }}
                    
                    <!-- Hover Dropdown for Mobile/Clean look -->
                    <div class="absolute top-full right-0 mt-4 w-48 bg-neutral-900 border border-white/10 rounded-xl overflow-hidden shadow-2xl opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition-all translate-y-2 group-hover:translate-y-0 z-[200]">
                         <div class="p-4 border-b border-white/5">
                             <p class="text-[10px] text-white font-black uppercase truncate">{{ auth()->user()->name }}</p>
                             <p class="text-[8px] text-gray-600 font-bold uppercase">{{ auth()->user()->role }} Account</p>
                         </div>
                         <a href="{{ route('user.profile') }}" class="flex items-center gap-3 p-4 text-[10px] font-black uppercase text-gray-400 hover:bg-white/5 hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-[18px]">settings</span> Account Settings
                         </a>
                         <form action="/logout" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 p-4 text-[10px] font-black uppercase text-red-500 hover:bg-red-500/10 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">logout</span> Sign Out
                            </button>
                         </form>
                    </div>
                </div>
            </div>
        @endguest
    </div>
</nav>

<section class="hero-section">
    <div class="hero-video-bg">
        <img src="{{ $heroMovie->thumbnail ?? 'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=1800&q=80' }}" alt="hero-bg" />
    </div>
    <div class="hero-overlay"></div>
    
    <div class="relative z-10 px-10 md:px-20 max-w-4xl">
        @if($heroMovie)
            <div class="animate-fadeIn scale-entrance">
                <span class="tag">Exclusive Billboard</span>
                <h1 class="text-6xl md:text-8xl font-black leading-[0.85] mb-6 tracking-tighter uppercase" style="font-family:'Bebas Neue',sans-serif">
                    {{ $heroMovie->title }}
                </h1>
                <p class="text-gray-300 text-sm md:text-base max-w-xl leading-relaxed mb-8 opacity-70 font-light italic">
                    "{{ $heroMovie->description }}"
                </p>
                <div class="flex gap-4">
                    <a href="{{ route('movie.detail', $heroMovie->slug) }}" class="btn-primary">
                        <span class="material-symbols-outlined">play_arrow</span> Play Now
                    </a>
                    @auth
                    <button class="bg-white/10 backdrop-blur-xl border border-white/10 text-white px-8 py-3 rounded-lg font-black uppercase text-[11px] flex items-center gap-2 hover:bg-white/20 transition-all">
                        <span class="material-symbols-outlined">add</span> My List
                    </button>
                    @endauth
                </div>
            </div>
        @endif
    </div>
</section>

<div class="relative z-20 space-y-6 pb-20 -mt-16">
    
    <section id="trending" class="row-container fade-in-up">
        <div class="px-4 mb-2">
            <h2 class="text-2xl font-black text-white uppercase tracking-tighter" style="font-family:'Bebas Neue',sans-serif">Trending Now</h2>
        </div>
        <div class="row-container">
            <button onclick="scrollRow('trending-row', -800)" class="nav-btn prev"><span class="material-symbols-outlined">chevron_left</span></button>
            <div id="trending-row" class="row-scroll">
                @foreach($trendingMovies as $movie)
                <div onclick="window.location.href='{{ route('movie.detail', $movie->slug) }}'" class="film-card group">
                    <img src="{{ $movie->thumbnail }}" alt="{{ $movie->title }}" />
                    <div class="card-info">
                        <span class="tag !bg-white !text-black mb-1.5">{{ $movie->category->name }}</span>
                        <h3 class="text-white font-black text-[11px] uppercase tracking-tight mb-1">{{ $movie->title }}</h3>
                        <p class="text-[9px] text-[#E50914] font-black uppercase tracking-widest">{{ $movie->duration }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <button onclick="scrollRow('trending-row', 800)" class="nav-btn next"><span class="material-symbols-outlined">chevron_right</span></button>
        </div>
    </section>

    <section id="genre" class="px-10 md:px-20 py-12 fade-in-up">
        <div class="flex flex-col items-center mb-10 text-center">
            <h2 class="text-4xl font-black text-white uppercase tracking-tight" style="font-family:'Bebas Neue',sans-serif">Browse Categories</h2>
            <div class="w-16 h-1 bg-[#E50914] mt-2 rounded-full"></div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-5">
            @foreach($categories as $category)
            <div onclick="window.location.href='{{ route('category.detail', $category->slug) }}'" class="genre-pill group">
                <h3 class="relative z-10 text-white group-hover:scale-105 transition-transform group-hover:text-white">{{ $category->name }}</h3>
                <p class="relative z-10 text-[8px] text-gray-500 group-hover:text-white/70 font-black uppercase tracking-[2px] mt-1">{{ $category->movies_count }} Movies</p>
            </div>
            @endforeach
        </div>
    </section>

    <section id="new" class="row-container fade-in-up">
        <div class="px-4 mb-2">
            <h2 class="text-2xl font-black text-white uppercase tracking-tighter" style="font-family:'Bebas Neue',sans-serif">Fresh Releases</h2>
        </div>
        <div class="row-container">
            <button onclick="scrollRow('new-row', -800)" class="nav-btn prev"><span class="material-symbols-outlined">chevron_left</span></button>
            <div id="new-row" class="row-scroll">
                @foreach($latestMovies as $movie)
                <div onclick="window.location.href='{{ route('movie.detail', $movie->slug) }}'" class="film-card group">
                    <img src="{{ $movie->thumbnail }}" alt="{{ $movie->title }}" />
                    <div class="card-info">
                        <h3 class="text-white font-black text-[11px] uppercase">{{ $movie->title }}</h3>
                    </div>
                </div>
                @endforeach
            </div>
            <button onclick="scrollRow('new-row', 800)" class="nav-btn next"><span class="material-symbols-outlined">chevron_right</span></button>
        </div>
    </section>

</div>

<footer class="bg-black py-16 px-10 md:px-20 border-t border-white/5 text-center">
    <span class="logo text-[#E50914] mb-8 block">CINEWATCH</span>
    <div class="flex flex-wrap justify-center gap-10 text-[9px] font-black uppercase text-gray-600 mb-10 tracking-[3px]">
        <a href="#" class="hover:text-white transition-all">Privacy</a>
        <a href="#" class="hover:text-white transition-all">Terms</a>
        <a href="#" class="hover:text-white transition-all">Support</a>
    </div>
    <p class="text-[8px] text-gray-800 font-black uppercase tracking-[4px]">
        © 2026 CINEWATCH GLOBAL INC.
    </p>
</footer>

@livewireScripts
<script>
    const nav = document.getElementById('mainNav');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            nav.classList.add('nav-scrolled');
            nav.classList.remove('py-5');
            nav.classList.add('py-3');
        } else {
            nav.classList.remove('nav-scrolled');
            nav.classList.add('py-5');
            nav.classList.remove('py-3');
        }
    });

    function scrollRow(id, amount) {
        document.getElementById(id).scrollBy({ left: amount, behavior: 'smooth' });
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
</script>
</body>
</html>