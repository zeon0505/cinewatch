<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'CINEWATCH — Dunia Film Tanpa Batas' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />


    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#E50914">
    <link rel="apple-touch-icon" href="/pwa-icon.png">
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }
    </script>
    
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
        [x-cloak] { display: none !important; }
        
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Smooth Page Transitions */
        [wire\:navigate] { cursor: pointer; }
        .page-transition-wrapper {
            animation: fadeIn 0.4s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @livewireStyles
    @stack('styles')
</head>
<body>
    <div x-data="{ mobileMenu: false, profileOpen: false }" class="min-h-screen flex flex-col relative">
        @if(!request()->is('login') && !request()->is('register'))
        <nav class="nav-glass fixed top-0 left-0 right-0 z-[100] flex items-center justify-between px-6 md:px-12 py-4">
            <div class="flex items-center gap-4 md:gap-12">
                <!-- Hamburger Button (Left) -->
                <button @click.stop="mobileMenu = true" class="md:hidden w-10 h-10 flex items-center justify-center text-white bg-white/10 rounded-xl active:scale-95 transition-all">
                    <span class="material-symbols-outlined">menu</span>
                </button>

                <a href="/" class="logo text-3xl md:text-4xl text-red-600">CINEWATCH</a>
                <ul class="hidden md:flex items-center gap-8 text-[11px] font-black uppercase tracking-[3px] text-gray-400">
                    <li><a href="/" wire:navigate class="hover:text-white transition-colors {{ request()->is('/') ? 'text-red-500' : '' }}">Beranda</a></li>
                    <li x-data="{ showCats: false }" class="relative" @mouseenter="showCats = true" @mouseleave="showCats = false">
                        <button class="hover:text-white transition-colors flex items-center gap-1 {{ request()->routeIs('series.detail') ? 'text-red-500' : '' }}">
                            Series <span class="material-symbols-outlined text-sm transition-transform" :class="showCats ? 'rotate-180' : ''">expand_more</span>
                        </button>
                        <div x-show="showCats" x-transition.opacity class="absolute top-full left-0 mt-4 w-56 bg-zinc-900/95 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl z-[300] overflow-hidden py-2" x-cloak>
                            <div class="px-4 py-2 border-b border-white/5 mb-1">
                                <span class="text-[9px] text-gray-500 font-bold uppercase tracking-[3px]">Pilih Series / Koleksi</span>
                            </div>
                            <div class="max-h-[60vh] overflow-y-auto custom-scrollbar">
                                @foreach(\App\Models\Series::orderBy('name')->get() as $s)
                                    <a href="{{ route('series.detail', $s->slug) }}" wire:navigate class="block px-4 py-2.5 text-[10px] font-black text-gray-400 hover:text-white hover:bg-white/5 transition-all uppercase tracking-widest">{{ $s->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                    <li><a href="{{ route('trending') }}" wire:navigate class="hover:text-white transition-colors {{ request()->routeIs('trending') ? 'text-red-500' : '' }}">Trending</a></li>
                    <li><a href="{{ route('new.releases') }}" wire:navigate class="hover:text-white transition-colors {{ request()->routeIs('new.releases') ? 'text-red-500' : '' }}">Terbaru</a></li>
                    @auth
                    <li><a href="{{ route('user.watchlist') }}" wire:navigate class="hover:text-white transition-colors {{ request()->routeIs('user.watchlist') ? 'text-red-500' : '' }}">Watchlist</a></li>
                    @endauth
                    <li><a href="{{ route('subscription') }}" wire:navigate class="text-yellow-500 hover:text-yellow-400 transition-colors">VIP</a></li>
                    <li><a href="{{ route('request.film') }}" wire:navigate class="text-red-500 hover:text-red-400 transition-colors font-bold">Request Film</a></li>
                </ul>
            </div>

            <div class="flex items-center gap-4">
                <div class="relative hidden md:block">
                    @livewire('search')
                </div>
                @guest
                    <div class="hidden md:flex items-center gap-3">
                        <a href="/login" class="btn-red text-sm px-4 py-2">Masuk</a>
                        <a href="/register" class="btn-outline text-sm px-4 py-2">Daftar</a>
                    </div>
                @else
                    <!-- Profile Section -->
                    <div @click="profileOpen = !profileOpen" class="flex items-center gap-2 md:gap-3 group px-2 md:px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 cursor-pointer hover:bg-white/10 transition-all relative">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-red-600 to-red-900 flex items-center justify-center text-xs font-black text-white shadow-lg">
                            {{ substr(session('active_profile_name'), 0, 1) }}
                        </div>
                        <div class="flex flex-col hidden md:flex">
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] font-black text-white uppercase tracking-wider">{{ session('active_profile_name') }}</span>
                            </div>
                        </div>

                        <!-- Profile Dropdown -->
                        <div x-show="profileOpen" @click.away="profileOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="absolute top-full right-0 mt-3 w-48 bg-zinc-900/95 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl z-[300] overflow-hidden">
                            <div class="py-2">
                                <a href="{{ route('profiles') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 text-[10px] font-black text-gray-400 hover:text-white hover:bg-white/5 transition-all uppercase tracking-widest">
                                    <span class="material-symbols-outlined text-sm">group</span> Ganti Profil
                                </a>
                                <a href="{{ auth()->user()->role === 'admin' ? '/admin' : '/dashboard' }}" class="flex items-center gap-3 px-4 py-3 text-[10px] font-black text-gray-400 hover:text-white hover:bg-white/5 transition-all uppercase tracking-widest">
                                    <span class="material-symbols-outlined text-sm">account_circle</span> Akun Saya
                                </a>
                                <div class="border-t border-white/5 my-1"></div>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-[10px] font-black text-red-500 hover:bg-red-500/10 transition-all uppercase tracking-widest">
                                        <span class="material-symbols-outlined text-sm">logout</span> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
        </nav>
        @endif

        <main class="flex-1 page-transition-wrapper" key="{{ request()->url() }}">
            {{ $slot }}
        </main>

        <!-- Sidebar Drawer & Backdrop Moved to Bottom for Absolute Reliability -->
        <div x-show="mobileMenu" 
             class="fixed inset-0 z-[500] md:hidden"
             x-cloak>
            
            <!-- Backdrop -->
            <div x-show="mobileMenu"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="mobileMenu = false"
                 class="absolute inset-0 bg-black/90 backdrop-blur-sm shadow-2xl"></div>

            <!-- Drawer -->
            <div x-show="mobileMenu"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="absolute inset-y-0 left-0 w-[280px] bg-[#050505] shadow-2xl border-r border-white/5 flex flex-col overflow-hidden">
                
                <div class="p-6 border-b border-white/5 flex items-center justify-between">
                    <a href="/" class="logo text-3xl text-red-600">CINEWATCH</a>
                    <button @click="mobileMenu = false" class="text-white opacity-50 hover:opacity-100 transition-opacity">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-6 space-y-10 custom-scrollbar">
                    @auth
                    <div class="p-5 rounded-3xl bg-white/[0.03] border border-white/5">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-600 to-red-900 flex items-center justify-center text-xl font-black text-white">
                                {{ substr(session('active_profile_name'), 0, 1) }}
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-0.5">Watching as</p>
                                <p class="text-lg font-black text-white uppercase">{{ session('active_profile_name') }}</p>
                                @if(auth()->user()->is_vip)
                                    <span class="inline-flex items-center gap-1 text-[8px] bg-yellow-500 text-black px-2 py-0.5 rounded-full font-black uppercase tracking-widest mt-1">VIP MEMBER</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endauth

                    <div class="space-y-4">
                        <p class="text-[10px] font-black text-gray-600 uppercase tracking-[5px] px-2">Navigation</p>
                        <div class="flex flex-col gap-1">
                            <a href="/" @click="mobileMenu = false" class="flex items-center gap-4 px-4 py-4 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ request()->is('/') ? 'bg-red-600 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                                <span class="material-symbols-outlined text-lg">home</span> Home
                            </a>
                            <a href="{{ route('trending') }}" @click="mobileMenu = false" class="flex items-center gap-4 px-4 py-4 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ request()->is('trending*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                                <span class="material-symbols-outlined text-lg text-red-500">local_fire_department</span> Trending
                            </a>
                            <a href="{{ route('new.releases') }}" @click="mobileMenu = false" class="flex items-center gap-4 px-4 py-4 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ request()->is('new-releases*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                                <span class="material-symbols-outlined text-lg">new_releases</span> Terbaru
                            </a>
                            <div x-data="{ open: false }" class="flex flex-col">
                                <button @click="open = !open" class="flex items-center justify-between px-4 py-4 rounded-2xl text-xs font-black uppercase tracking-widest text-gray-400 hover:text-white hover:bg-white/5 transition-all">
                                    <div class="flex items-center gap-4">
                                        <span class="material-symbols-outlined text-lg">collections</span> Series / Koleksi
                                    </div>
                                    <span class="material-symbols-outlined text-xs transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                                </button>
                                <div x-show="open" x-transition.opacity class="pl-12 pr-4 py-2 flex flex-col gap-1 border-l border-white/5 ml-6" x-cloak>
                                    @foreach(\App\Models\Series::orderBy('name')->get() as $s)
                                        <a href="{{ route('series.detail', $s->slug) }}" @click="mobileMenu = false" wire:navigate class="text-[10px] font-bold uppercase tracking-[2px] text-gray-500 hover:text-white transition-colors py-2">{{ $s->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                            @auth
                            <a href="{{ route('user.watchlist') }}" @click="mobileMenu = false" class="flex items-center gap-4 px-4 py-4 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ request()->routeIs('user.watchlist') ? 'bg-red-600 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                                <span class="material-symbols-outlined text-lg">bookmark</span> Watchlist
                            </a>
                            @endauth
                            <a href="{{ route('subscription') }}" @click="mobileMenu = false" class="flex items-center gap-4 px-4 py-4 rounded-2xl text-xs font-black uppercase tracking-widest text-yellow-500 bg-yellow-500/5 hover:bg-yellow-500/10 transition-all">
                                <span class="material-symbols-outlined text-lg">stars</span> Upgrade VIP
                            </a>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-white/5">
                    @guest
                    <div class="grid grid-cols-2 gap-3">
                        <a href="/login" class="bg-red-600 text-white text-center py-4 text-[10px] tracking-widest uppercase font-black rounded-2xl">Masuk</a>
                        <a href="/register" class="bg-zinc-800 text-white text-center py-4 text-[10px] tracking-widest uppercase font-black rounded-2xl border border-white/10">Daftar</a>
                    </div>
                    @else
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-3 py-4 text-[10px] font-black text-red-500 uppercase tracking-widest hover:bg-white/5 border border-red-500/20 rounded-2xl transition-all">
                            <span class="material-symbols-outlined text-sm">logout</span> Logout
                        </button>
                    </form>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    @if(!request()->is('login') && !request()->is('register'))
    <footer class="relative bg-zinc-950 pt-24 pb-12 px-6 md:px-20 overflow-hidden border-t border-white/5">
        <!-- Background Glow -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[500px] bg-red-600/5 blur-[120px] rounded-full -translate-y-1/2 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 mb-20">
                <!-- Brand & Newsletter -->
                <div class="lg:col-span-2 space-y-8">
                    <div>
                        <a href="/" class="logo text-4xl text-red-600 inline-block mb-4">CINEWATCH</a>
                        <p class="text-gray-500 text-sm leading-relaxed max-w-sm font-medium">
                            Nikmati ribuan koleksi film dan serial original terbaik dari seluruh dunia dengan kualitas visual tiada tanding. Kami menghadirkan bioskop di genggaman Anda.
                        </p>
                    </div>
                    
                    <div class="space-y-4">
                        <p class="text-xs font-black uppercase tracking-[3px] text-white italic">Berlangganan Newsletter</p>
                        <form class="flex gap-2 max-w-md">
                            <input type="email" placeholder="Alamat Email Anda" class="flex-1 bg-white/[0.03] border border-white/10 rounded-xl px-5 py-4 text-sm text-white focus:ring-1 focus:ring-red-600 outline-none transition-all placeholder:text-gray-700">
                            <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-4 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all">Daftar</button>
                        </form>
                    </div>

                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>

                <!-- Column 1: Explore -->
                <div>
                    <h4 class="text-white font-black text-xs uppercase tracking-[4px] mb-8">Eksplorasi</h4>
                    <ul class="space-y-4 text-sm font-bold text-gray-500">
                        <li><a href="/" wire:navigate class="hover:text-red-500 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('trending') }}" wire:navigate class="hover:text-red-500 transition-colors">Trending Now</a></li>
                        <li><a href="{{ route('new.releases') }}" wire:navigate class="hover:text-red-500 transition-colors">Rilis Terbaru</a></li>
                        <li><a href="{{ route('subscription') }}" wire:navigate class="hover:text-red-500 transition-colors">CINEWATCH VIP</a></li>
                        <li><a href="{{ route('request.film') }}" wire:navigate class="hover:text-red-500 transition-colors">Request Film</a></li>
                    </ul>
                </div>

                <!-- Column 2: Support -->
                <div>
                    <h4 class="text-white font-black text-xs uppercase tracking-[4px] mb-8">Bantuan</h4>
                    <ul class="space-y-4 text-sm font-bold text-gray-500">
                        <li><a href="{{ route('about') }}" class="hover:text-red-500 transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-red-500 transition-colors">Hubungi Kami</a></li>
                        <li><a href="{{ route('help') }}" class="hover:text-red-500 transition-colors">Pusat Bantuan</a></li>
                        <li><a href="{{ route('faq') }}" class="hover:text-red-500 transition-colors">FAQ</a></li>
                        <li><a href="{{ route('report.link') }}" class="hover:text-red-500 transition-colors">Lapor Link Mati</a></li>
                    </ul>
                </div>

                <!-- Column 3: Apps -->
                <div>
                    <h4 class="text-white font-black text-xs uppercase tracking-[4px] mb-8">Aplikasi</h4>
                    <div class="space-y-4">
                        <a href="{{ route('app.download') }}" class="flex items-center gap-3 px-5 py-3 rounded-2xl bg-white/[0.03] border border-white/10 hover:bg-white/[0.06] transition-all group">
                            <span class="material-symbols-outlined text-gray-500 group-hover:text-red-500">phone_iphone</span>
                            <div class="flex flex-col">
                                <span class="text-[8px] text-gray-600 font-black uppercase">Download on the</span>
                                <span class="text-xs text-white font-black uppercase">App Store</span>
                            </div>
                        </a>
                        <a href="{{ route('app.download') }}" class="flex items-center gap-3 px-5 py-3 rounded-2xl bg-white/[0.03] border border-white/10 hover:bg-white/[0.06] transition-all group">
                            <span class="material-symbols-outlined text-gray-500 group-hover:text-red-500">shop</span>
                            <div class="flex flex-col">
                                <span class="text-[8px] text-gray-600 font-black uppercase">Get it on</span>
                                <span class="text-xs text-white font-black uppercase">Google Play</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex flex-wrap justify-center gap-6 text-[10px] uppercase font-black tracking-widest text-gray-600">
                    <a href="{{ route('privacy') }}" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="{{ route('terms') }}" class="hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-white transition-colors">Cookie Settings</a>
                </div>
                <div class="text-[9px] font-black uppercase tracking-[3px] text-gray-700">
                    © 2026 <span class="text-red-600">CINEWATCH</span> GLOBAL INC. ALL TRADEMARKS BELONG TO THEIR RESPECTIVE OWNERS.
                </div>
            </div>
        </div>
    </footer>
    @endif

    <!-- Mobile Bottom Navigation (Native Feel) -->
    @if(!request()->is('login') && !request()->is('register'))
    <div class="md:hidden fixed bottom-0 left-0 right-0 z-[400] bottom-nav-glass px-6 pb-6 pt-3 flex justify-between items-center bg-black/80 backdrop-blur-xl border-t border-white/5">
        <a href="/" wire:navigate class="flex flex-col items-center gap-1 {{ request()->is('/') ? 'nav-item-active' : 'text-gray-500' }}">
            <span class="material-symbols-outlined text-2xl">home</span>
            <span class="text-[9px] font-black uppercase tracking-widest">Home</span>
        </a>
        <a href="{{ route('trending') }}" wire:navigate class="flex flex-col items-center gap-1 {{ request()->is('trending*') ? 'nav-item-active' : 'text-gray-500' }}">
            <span class="material-symbols-outlined text-2xl">trending_up</span>
            <span class="text-[9px] font-black uppercase tracking-widest">Trends</span>
        </a>
        <a href="{{ route('subscription') }}" wire:navigate class="flex flex-col items-center gap-1 {{ request()->is('vip*') ? 'nav-item-active' : 'text-gray-500' }}">
            <div class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center -mt-8 shadow-lg shadow-red-600/30 border-4 border-[#050505]">
                <span class="material-symbols-outlined text-white text-2xl">stars</span>
            </div>
            <span class="text-[9px] font-black uppercase tracking-widest mt-1">VIP</span>
        </a>
        <a href="{{ route('help') }}" wire:navigate class="flex flex-col items-center gap-1 {{ request()->is('help*') ? 'nav-item-active' : 'text-gray-500' }}">
            <span class="material-symbols-outlined text-2xl">help</span>
            <span class="text-[9px] font-black uppercase tracking-widest">Help</span>
        </a>
        @auth
        <a href="{{ route('user.watchlist') }}" wire:navigate class="flex flex-col items-center gap-1 {{ request()->is('watchlist*') ? 'nav-item-active' : 'text-gray-500' }}">
            <span class="material-symbols-outlined text-2xl">bookmark</span>
            <span class="text-[9px] font-black uppercase tracking-widest">Watchlist</span>
        </a>
        @endauth
        @auth
        <a href="{{ route('profiles') }}" wire:navigate class="flex flex-col items-center gap-1 {{ request()->is('profiles*') ? 'nav-item-active' : 'text-gray-500' }}">
            <div class="w-6 h-6 bg-white/10 rounded-full flex items-center justify-center border border-white/20">
                <span class="text-[10px] font-black">{{ substr(session('active_profile_name'), 0, 1) }}</span>
            </div>
            <span class="text-[9px] font-black uppercase tracking-widest">Profile</span>
        </a>
        @else
        <a href="/login" wire:navigate class="flex flex-col items-center gap-1 text-gray-500">
            <span class="material-symbols-outlined text-2xl">login</span>
            <span class="text-[9px] font-black uppercase tracking-widest">Login</span>
        </a>
        @endauth
    </div>
    @endif

    @livewireScripts
    @stack('scripts')
    
    <!-- PWA Install Banner -->
    <div id="pwa-install-banner" class="fixed bottom-24 left-1/2 -translate-x-1/2 z-[300] bg-white/[0.08] backdrop-blur-2xl border border-white/10 p-6 rounded-3xl items-center gap-6 shadow-2xl transition-all translate-y-32 opacity-0 hidden">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center shadow-lg shadow-red-600/20">
                <span class="material-symbols-outlined text-white">download</span>
            </div>
            <div>
                <p class="text-xs font-black uppercase text-white tracking-widest">Install Cinewatch App</p>
                <p class="text-[10px] text-gray-400 font-bold uppercase">Nikmati pengalaman lebih cepat!</p>
            </div>
        </div>
        <div class="flex gap-2">
            <button id="pwa-install-btn" class="bg-white text-black text-[10px] font-black uppercase px-6 py-2.5 rounded-xl hover:scale-105 transition-all">Install</button>
            <button onclick="dismissPwaBanner()" class="text-white/40 hover:text-white transition-colors"><span class="material-symbols-outlined text-sm">close</span></button>
        </div>
    </div>

    <script>
        // Global Navigation & Scroll
        window.scrollRow = function(id, amount) {
            const el = document.getElementById(id);
            if(el) el.scrollBy({ left: amount, behavior: 'smooth' });
        }

        // PWA & Other existing scripts...
        let deferredPrompt;
        const banner = document.getElementById('pwa-install-banner');
        // ... (rest of PWA script)

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            
            setTimeout(() => {
                if(!localStorage.getItem('pwa_dismissed')) {
                    banner.classList.remove('hidden');
                    setTimeout(() => {
                        banner.classList.remove('translate-y-32', 'opacity-0');
                        banner.classList.add('flex');
                    }, 50);
                }
            }, 3000);
        });

        document.getElementById('pwa-install-btn').addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                if (outcome === 'accepted') {
                    banner.classList.add('translate-y-32', 'opacity-0');
                    setTimeout(() => banner.classList.add('hidden'), 500);
                }
                deferredPrompt = null;
            }
        });

        function dismissPwaBanner() {
            banner.classList.add('translate-y-32', 'opacity-0');
            localStorage.setItem('pwa_dismissed', 'true');
            setTimeout(() => banner.classList.add('hidden'), 500);
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Toast Notifications -->
    <div x-data="{ 
            show: false, 
            message: '', 
            type: 'success',
            timeout: null 
         }"
         x-on:notify.window="
            show = true;
            message = $event.detail.message || $event.detail;
            type = $event.detail.type || 'success';
            if (timeout) clearTimeout(timeout);
            timeout = setTimeout(() => show = false, 3000);
         "
         x-show="show"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-y-10 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-300 transform"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-10 opacity-0"
         class="fixed bottom-10 right-10 z-[500] pointer-events-none"
         x-cloak>
        <div class="bg-[#1c1c1c] border border-white/10 rounded-2xl px-6 py-4 flex items-center gap-4 shadow-2xl pointer-events-auto min-w-[300px]">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" :class="type === 'success' ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500'">
                <span class="material-symbols-outlined" x-text="type === 'success' ? 'check_circle' : 'error'"></span>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase text-gray-500 tracking-widest mb-0.5" x-text="type === 'success' ? 'Berhasil' : 'Informasi'"></p>
                <p class="text-xs font-bold text-white tracking-tight" x-text="message"></p>
            </div>
        </div>
        </div>
    </div>

    @livewire('ai-chat-widget')
</body>
</html>
