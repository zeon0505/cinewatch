<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CINEWATCH</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        :root {
            --red: #E50914;
            --bg: #0A0A0A;
            --card: #141414;
        }
        body { background: var(--bg); color: #E5E5E5; font-family: 'DM Sans', sans-serif; margin: 0; padding: 0; height: 100vh; overflow: hidden; }
        .logo { font-family: 'Bebas Neue', sans-serif; letter-spacing: 2px; }
        .nav-glass { backdrop-filter: blur(12px); background: linear-gradient(to bottom, rgba(0,0,0,.85), transparent); }
        .sidebar-item { display: flex; align-items: center; padding: 12px 24px; color: #808080; transition: all 0.2s; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; opacity: 0; transform: translateX(-20px); animation: slideIn 0.4s forwards; }
        .sidebar-item:nth-child(2) { animation-delay: 0.1s; }
        .sidebar-item:nth-child(3) { animation-delay: 0.2s; }
        .sidebar-item:hover { color: #fff; background: rgba(255,255,255,0.02); }
        .sidebar-item.active { color: #E50914; background: linear-gradient(90deg, rgba(229, 9, 20, 0.1) 0%, transparent 100%); border-left: 3px solid var(--red); }
        .card { background: var(--card); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 20px; overflow: hidden; transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1); }
        .card:hover { transform: translateY(-5px); border-color: rgba(229, 9, 20, 0.3); box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; font-size: 22px; margin-right: 12px; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: var(--red); border-radius: 2px; }
        
        @keyframes slideIn { to { opacity: 1; transform: translateX(0); } }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade { opacity: 0; animation: fadeIn 0.6s cubic-bezier(0.2, 1, 0.3, 1) forwards; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
        .stagger-item { opacity: 0; animation: fadeIn 0.5s ease-out forwards; }
    </style>
    @livewireStyles
</head>
<body class="flex">

    <!-- Navbar -->
    <nav class="nav-glass fixed top-0 left-0 right-0 z-[100] flex items-center justify-between px-6 md:px-12 py-4 border-b border-white/5">
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
             <div class="relative hidden md:block w-64 h-10">
                  @livewire('search')
             </div>
             <form action="/logout" method="POST">
                 @csrf
                 <button type="submit" class="text-xs text-gray-600 hover:text-white font-bold uppercase transition-colors flex items-center gap-2 px-4 py-2 hover:bg-white/5 rounded-lg">
                    <span class="material-symbols-outlined text-sm">logout</span> Keluar
                 </button>
             </form>
        </div>
    </nav>

    <!-- Content Area -->
    <div class="flex-1 flex overflow-hidden pt-24">
        <!-- Sidebar -->
        <aside class="w-72 border-r border-white/5 flex flex-col pt-10 px-4 bg-black/40 backdrop-blur-xl shrink-0">
            <div class="px-6 mb-12 flex items-center gap-4 animate-fade">
                <div class="relative group">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=E50914&color=fff&size=256" class="w-16 h-16 rounded-2xl border-2 border-white/10 p-1 shadow-2xl transition-transform group-hover:rotate-6" />
                </div>
                <div>
                    <h2 class="text-white font-black text-lg uppercase tracking-tighter">{{ explode(' ', auth()->user()->name)[0] }}</h2>
                    <span class="text-[10px] text-gray-700 font-bold uppercase tracking-widest">{{ auth()->user()->role }} Account</span>
                </div>
            </div>
            
            <nav class="space-y-1.5 flex-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">home</span> Dashboard
                </a>
                <a href="{{ route('user.profile') }}" class="sidebar-item {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">person_outline</span> Pengaturan Profil
                </a>
                @if(auth()->user()->role === 'admin')
                <a href="/admin" class="sidebar-item text-red-500 font-black">
                    <span class="material-symbols-outlined">admin_panel_settings</span> Terminal Admin
                </a>
                @endif
            </nav>
            
            <div class="p-6 italic mb-6 animate-fade delay-4">
                <p class="text-[10px] text-gray-800 font-black uppercase tracking-widest leading-relaxed">CINEWATCH v1.0.8<br>Premium Member Access</p>
            </div>
        </aside>

        <!-- Main Scrollable -->
        <main class="flex-1 p-12 overflow-y-auto bg-[#080808]">
            @php
                $watchlist = \App\Models\Watchlist::where('user_id', auth()->id())->with('movie')->latest()->get();
                $histories = \App\Models\History::where('user_id', auth()->id())->with('movie')->latest()->take(5)->get();
                $ratings = \App\Models\Rating::where('user_id', auth()->id())->count();
            @endphp

            <div class="max-w-6xl mx-auto space-y-20">
                <!-- Header Welcome -->
                <div class="flex items-center justify-between animate-fade delay-1">
                    <div>
                        <h1 class="text-5xl md:text-6xl font-black text-white uppercase tracking-tighter mb-4">Selamat Datang, <span class="text-[#E50914]">{{ explode(' ', auth()->user()->name)[0] }}!</span></h1>
                        <p class="text-gray-600 text-sm font-bold uppercase tracking-widest italic leading-relaxed">Lanjutkan pengalaman sinematik kamu yang tertunda.</p>
                    </div>
                    <div class="flex gap-6">
                         <div class="card p-8 flex flex-col items-center justify-center min-w-[140px] bg-white/[0.02] border-white/5">
                              <span class="text-4xl font-black text-white">{{ $watchlist->count() }}</span>
                              <span class="text-[10px] text-gray-700 uppercase font-black tracking-widest mt-2">Daftar Saya</span>
                         </div>
                         <div class="card p-8 flex flex-col items-center justify-center min-w-[140px] bg-white/[0.02] border-white/5">
                              <span class="text-4xl font-black text-[#E50914]">{{ $ratings }}</span>
                              <span class="text-[10px] text-gray-700 uppercase font-black tracking-widest mt-2">Total Rating</span>
                         </div>
                    </div>
                </div>

                <!-- Watchlist Grid -->
                <section class="animate-fade delay-2">
                    <div class="flex items-center justify-between mb-10 border-b border-white/5 pb-6">
                        <div class="flex items-center gap-4">
                            <span class="material-symbols-outlined text-[#E50914]">favorite</span>
                            <h2 class="text-2xl font-black text-white uppercase tracking-widest">Daftar Tontonan Saya</h2>
                        </div>
                        <a href="/" class="text-[10px] text-gray-500 font-black uppercase hover:text-white transition-all tracking-widest">Tambah Film →</a>
                    </div>

                    @if($watchlist->isEmpty())
                        <div class="card p-24 text-center bg-white/[0.01]">
                            <p class="text-gray-700 font-black text-lg uppercase tracking-widest mb-10 italic">"Belum ada karya pilihan yang masuk dalam daftar kamu."</p>
                            <a href="/" class="bg-[#E50914] px-12 py-4 text-white rounded-xl font-black uppercase text-xs tracking-widest shadow-2xl hover:scale-105 transition-all">Jelajahi Sekarang</a>
                        </div>
                    @else
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">
                            @foreach($watchlist as $index => $item)
                            <div class="group relative card stagger-item" style="animation-delay: {{ 0.3 + ($index * 0.05) }}s">
                                <img src="{{ $item->movie->thumbnail }}" class="w-full h-80 object-cover opacity-70 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500" />
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-90"></div>
                                <div class="absolute bottom-6 left-6 right-6">
                                    <h3 class="text-white font-black text-xs mb-1 uppercase truncate tracking-wide">{{ $item->movie->title }}</h3>
                                    <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">{{ $item->movie->category->name }}</p>
                                </div>
                                <div class="absolute top-6 right-6 opacity-0 group-hover:opacity-100 transition-all transform translate-y-2 group-hover:translate-y-0">
                                     <a href="{{ route('movie.detail', $item->movie->slug) }}" class="w-10 h-10 bg-white text-black rounded-full shadow-2xl flex items-center justify-center hover:bg-[#E50914] hover:text-white transition-all">
                                        <span class="material-symbols-outlined text-md m-0">play_arrow</span>
                                     </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                <!-- Recent Activity -->
                <section class="max-w-4xl animate-fade delay-3 pb-20">
                    <div class="flex items-center justify-between mb-10 border-b border-white/5 pb-6">
                        <div class="flex items-center gap-4">
                            <span class="material-symbols-outlined text-gray-600">history</span>
                            <h2 class="text-2xl font-black text-white uppercase tracking-widest">Aktivitas Terakhir</h2>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($histories as $index => $history)
                        <div class="card p-6 flex items-center justify-between hover:bg-white/[0.04] transition-all group stagger-item" style="animation-delay: {{ 0.4 + ($index * 0.05) }}s">
                            <div class="flex items-center gap-8">
                                <div class="relative overflow-hidden rounded-lg w-24 h-14">
                                     <img src="{{ $history->movie->thumbnail }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500" />
                                </div>
                                <div>
                                    <h4 class="text-white font-bold text-sm uppercase tracking-tight group-hover:text-[#E50914] transition-colors">{{ $history->movie->title }}</h4>
                                    <p class="text-[10px] text-gray-700 font-bold uppercase tracking-widest mt-1 italic">Dilihat {{ $history->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('movie.detail', $history->movie->slug) }}" class="text-[10px] font-black uppercase text-gray-700 hover:text-white transition-colors flex items-center gap-2 border border-white/5 px-4 py-2 rounded-lg hover:border-white/20">
                                <span class="material-symbols-outlined text-[16px] m-0">replay</span> Putar Kembali
                            </a>
                        </div>
                        @empty
                             <p class="text-gray-800 italic uppercase text-[11px] font-black tracking-[4px] py-20 text-center">Belum ada jejak tontonan terdeteksi.</p>
                        @endforelse
                    </div>
                </section>
            </div>
        </main>
    </div>

    @livewireScripts
    <script>
        document.addEventListener('DOMContentLoaded', () => {
             console.log('Dashboard Animated Engine Loaded');
        });
    </script>
</body>
</html>
