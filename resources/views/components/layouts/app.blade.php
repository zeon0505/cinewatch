<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'CINEWATCH — Dunia Film Tanpa Batas' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Plyr Player -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <style>
        :root {
            --red: #E50914;
            --red-dark: #B20710;
            --gold: #F5C518;
            --bg: #0A0A0A;
            --card: #141414;
            --card2: #1C1C1C;
            --text: #E5E5E5;
            --muted: #808080;
        }
        body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; overflow-x: hidden; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #111; }
        ::-webkit-scrollbar-thumb { background: var(--red); border-radius: 2px; }
        .logo { font-family: 'Bebas Neue', sans-serif; letter-spacing: 2px; }
        .nav-glass { backdrop-filter: blur(12px); background: linear-gradient(to bottom, rgba(0,0,0,.85), transparent); }
        .btn-red { background: var(--red); color: #fff; padding: 10px 28px; border-radius: 5px; font-weight: 600; border: none; cursor: pointer; transition: all .2s; font-size: 15px; }
        .btn-red:hover { background: var(--red-dark); transform: scale(1.03); }
        .btn-outline { background: rgba(255,255,255,.12); color: #fff; padding: 10px 28px; border-radius: 5px; font-weight: 600; border: 1px solid rgba(255,255,255,.25); cursor: pointer; transition: all .2s; font-size: 15px; }
        .btn-outline:hover { background: rgba(255,255,255,.22); }
    </style>
    @livewireStyles
</head>
<body>
    <nav class="nav-glass fixed top-0 left-0 right-0 z-[100] flex items-center justify-between px-6 md:px-12 py-4">
        <div class="flex items-center gap-8">
            <a href="/" class="logo text-3xl" style="color:var(--red)">CINEWATCH</a>
            <ul class="hidden md:flex gap-6 text-sm text-gray-300">
                <li><a href="/" class="hover:text-white transition-colors">Beranda</a></li>
                <li><a href="/#trending" class="hover:text-white transition-colors">Trending</a></li>
                <li><a href="/#genre" class="hover:text-white transition-colors">Genre</a></li>
                <li><a href="/#new" class="hover:text-white transition-colors">Terbaru</a></li>
            </ul>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative hidden md:block">
                 @livewire('search')
            </div>
            @guest
                <a href="/login" class="btn-red text-sm px-4 py-2">Masuk</a>
                <a href="/register" class="btn-outline text-sm px-4 py-2">Daftar</a>
            @else
                <div class="flex items-center gap-4">
                    <a href="{{ auth()->user()->role === 'admin' ? '/admin' : '/dashboard' }}" class="text-sm font-bold hover:text-red-500 uppercase tracking-widest text-gray-300 transition-colors">
                        {{ auth()->user()->name }}
                    </a>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="text-xs text-gray-500 hover:text-white uppercase font-bold tracking-tighter">Keluar</button>
                    </form>
                </div>
            @endguest
        </div>
    </nav>

    {{ $slot }}

    <footer class="px-6 md:px-12 py-12 text-gray-600 text-sm mt-20" style="background:#050505">
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-10">
                <div>
                    <span class="logo text-2xl block mb-3" style="color:var(--red)">CINEWATCH</span>
                    <p class="text-xs leading-relaxed">Platform streaming film premium Indonesia. Ribuan judul, satu layanan.</p>
                </div>
                <div>
                    <p class="text-white font-semibold mb-3 text-xs uppercase tracking-widest">Navigasi</p>
                    <ul class="space-y-2">
                        <li><a href="/" class="hover:text-white">Beranda</a></li>
                        <li><a href="/#trending" class="hover:text-white">Film</a></li>
                        <li><a href="/#genre" class="hover:text-white">Genre</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-white font-semibold mb-3 text-xs uppercase tracking-widest">Akun</p>
                    <ul class="space-y-2">
                        <li><a href="/login" class="hover:text-white">Masuk</a></li>
                        <li><a href="/dashboard" class="hover:text-white">Daftar Tontonan</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-white font-semibold mb-3 text-xs uppercase tracking-widest">Informasi</p>
                    <ul class="space-y-2">
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/5 pt-6 flex flex-col md:flex-row items-center justify-between gap-3 text-[10px] uppercase font-bold tracking-widest">
                <p>© 2024 CINEWATCH. Semua hak dilindungi.</p>
                <p>Dibuat dengan ❤️ untuk pecinta film Indonesia</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
