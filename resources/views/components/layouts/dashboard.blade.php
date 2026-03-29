<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CINEWATCH</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        :root {
            --red: #E50914;
            --sidebar-bg: #0D0D0D;
            --card-bg: #141414;
            --text-muted: #808080;
        }
        body { font-family: 'Outfit', sans-serif; background-color: #050505; color: #E5E5E5; margin: 0; padding: 0; min-height: 100vh; }
        .logo { font-family: 'Bebas Neue', sans-serif; letter-spacing: 2px; }
        .nav-item { display: flex; align-items: center; padding: 14px 20px; color: var(--text-muted); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; position: relative; overflow: hidden; }
        .nav-item:hover { color: #fff; background: rgba(255, 255, 255, 0.03); }
        .nav-item.active { color: #fff; background: linear-gradient(90deg, rgba(229, 9, 20, 0.15) 0%, transparent 100%); border-left: 4px solid var(--red); }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; font-size: 20px; flex-shrink: 0; }
        .sidebar-transition { transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .fade-transition { transition: opacity 0.3s ease, transform 0.3s ease; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: var(--red); border-radius: 2px; }
    </style>
    @livewireStyles
</head>
<body x-data="{ sidebarOpen: localStorage.getItem('sidebarOpen') === 'false' ? false : true }" 
      x-init="$watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', value))"
      class="flex h-screen bg-[#050505] overflow-hidden">

    <!-- Sidebar -->
    <aside 
        class="bg-[#0A0A0A] border-r border-white/5 flex flex-col shrink-0 sidebar-transition relative z-[9999] shadow-[10px_0_30px_rgba(0,0,0,0.5)]"
        :class="sidebarOpen ? 'w-64' : 'w-20'"
    >
        <!-- Logo & Toggle -->
        <div class="p-6 flex items-center justify-between overflow-hidden border-b border-white/5">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-red-900/40">
                    <span class="material-symbols-outlined text-white font-bold">movie_filter</span>
                </div>
                <div x-show="sidebarOpen" x-transition class="flex flex-col">
                    <span class="text-white font-black text-xl tracking-tighter leading-none logo">CINEWATCH</span>
                    <span class="text-[8px] text-gray-500 font-bold uppercase tracking-[2px]">{{ auth()->user()->role === 'admin' ? 'Core Engine v5.0' : 'Member Dashboard' }}</span>
                </div>
            </div>
            <button 
                @click="sidebarOpen = !sidebarOpen" 
                class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-white transition-colors"
            >
                <span class="material-symbols-outlined" x-text="sidebarOpen ? 'menu_open' : 'menu'"></span>
            </button>
        </div>
        
        <nav class="flex-1 space-y-1 overflow-y-auto px-3">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-item rounded-xl {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard">
                    <span class="material-symbols-outlined" :class="sidebarOpen ? 'mr-4' : ''">dashboard</span>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Dashboard</span>
                </a>
                <a href="{{ route('admin.films.index') }}" class="nav-item rounded-xl {{ request()->is('admin/films*') ? 'active' : '' }}" title="Kelola Film Admin">
                    <span class="material-symbols-outlined" :class="sidebarOpen ? 'mr-4' : ''">movie</span>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Kelola Film</span>
                </a>
                <a href="{{ route('admin.genres.index') }}" class="nav-item rounded-xl {{ request()->is('admin/genres*') ? 'active' : '' }}" title="Kelola Kategori">
                    <span class="material-symbols-outlined" :class="sidebarOpen ? 'mr-4' : ''">category</span>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Kategori</span>
                </a>
                <a href="{{ route('admin.series.index') }}" class="nav-item rounded-xl {{ request()->is('admin/series*') ? 'active' : '' }}" title="Kelola Series / Koleksi">
                    <span class="material-symbols-outlined" :class="sidebarOpen ? 'mr-4' : ''">collections</span>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Kelola Series</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="nav-item rounded-xl {{ request()->is('admin/users*') ? 'active' : '' }}" title="Kelola User">
                    <span class="material-symbols-outlined" :class="sidebarOpen ? 'mr-4' : ''">group</span>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">User</span>
                </a>
                <a href="{{ route('admin.reviews.index') }}" class="nav-item rounded-xl {{ request()->is('admin/reviews*') ? 'active' : '' }}" title="Rating & Ulasan">
                    <span class="material-symbols-outlined" :class="sidebarOpen ? 'mr-4' : ''">star</span>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Rating</span>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="nav-item rounded-xl {{ request()->is('admin/reports*') ? 'active' : '' }}" title="Laporan Masalah">
                    <span class="material-symbols-outlined" :class="sidebarOpen ? 'mr-4' : ''">report</span>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Laporan</span>
                </a>
                <a href="{{ route('admin.requests.index') }}" class="nav-item rounded-xl {{ request()->is('admin/requests*') ? 'active' : '' }}" title="Request Film">
                    <span class="material-symbols-outlined" :class="sidebarOpen ? 'mr-4' : ''">playlist_add</span>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Request</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="nav-item rounded-xl {{ request()->is('admin/settings*') ? 'active' : '' }}" title="Site Settings">
                    <span class="material-symbols-outlined" :class="sidebarOpen ? 'mr-4' : ''">settings_suggest</span>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Settings</span>
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="nav-item rounded-xl {{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Beranda Akun">
                    <span class="material-symbols-outlined" :class="sidebarOpen ? 'mr-4' : ''">home</span>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Beranda Akun</span>
                </a>
                <a href="{{ route('user.films.index') }}" class="nav-item rounded-xl {{ request()->is('dashboard/films*') ? 'active' : '' }}" title="Film">
                    <span class="material-symbols-outlined" :class="sidebarOpen ? 'mr-4' : ''">video_library</span>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Film</span>
                </a>
                <a href="{{ route('user.profile') }}" class="nav-item rounded-xl {{ request()->routeIs('user.profile') ? 'active' : '' }}" title="Profil">
                    <span class="material-symbols-outlined" :class="sidebarOpen ? 'mr-4' : ''">person</span>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Profil</span>
                </a>
            @endif
        </nav>

        <div class="mt-auto p-4 space-y-3 border-t border-white/5 bg-black/20">
             <a href="/" class="flex items-center p-3 rounded-lg opacity-40 hover:opacity-100 transition-all font-black text-[9px] uppercase tracking-widest text-gray-500 hover:bg-white/5" title="Ke Situs">
                <span class="material-symbols-outlined text-[18px]" :class="sidebarOpen ? 'mr-3' : ''">arrow_back</span>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Ke Situs</span>
             </a>
             <form action="/logout" method="POST">
                 @csrf
                 <button type="submit" class="w-full flex items-center p-3 rounded-lg bg-red-600/5 text-red-600 hover:bg-red-600 hover:text-white transition-all font-black text-[9px] uppercase tracking-widest" title="Logout">
                    <span class="material-symbols-outlined text-[18px]" :class="sidebarOpen ? 'mr-3' : ''">logout</span>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Logout</span>
                 </button>
             </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-w-0 bg-[#050505]">
        <!-- Header -->
        <header class="h-20 border-b border-white/5 flex items-center justify-between px-10 shrink-0">
            <div class="flex items-center gap-4">
                <div class="flex flex-col animate-fadeIn">
                    <h2 class="text-white font-black text-sm uppercase tracking-[2px]">{{ auth()->user()->role === 'admin' ? 'Terminal Administrator' : 'Member Dashboard' }}</h2>
                    <p class="text-[9px] text-gray-600 uppercase font-bold tracking-widest flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                        Status: {{ auth()->user()->role === 'admin' ? 'Active' : 'Premium Member' }}
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <div x-data="{ open: false }" class="relative whitespace-nowrap">
                    <button @click="open = !open" class="flex items-center gap-4 bg-white/5 px-4 py-2 rounded-xl border border-white/5 hover:bg-white/10 transition-all cursor-pointer">
                        <div class="flex flex-col items-end">
                            <span class="text-[10px] text-white font-black uppercase tracking-tight">{{ explode(' ', auth()->user()->name)[0] }}</span>
                            <span class="text-[8px] text-gray-600 font-bold uppercase tracking-widest">{{ auth()->user()->role }}</span>
                        </div>
                        <div class="w-10 h-10 bg-[#E50914] rounded-lg flex items-center justify-center font-black text-white shadow-xl shadow-red-900/10">
                             {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </button>

                    <div x-show="open" @click.outside="open = false" x-transition.opacity class="absolute top-full right-0 mt-3 w-48 bg-[#141414] border border-white/10 rounded-xl shadow-2xl z-[100] py-2 overflow-hidden">
                        <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-5 py-3 text-[10px] font-black uppercase text-gray-400 hover:text-white hover:bg-white/5 transition-all">
                            <span class="material-symbols-outlined text-[18px]">account_circle</span> Profil Saya
                        </a>
                        <a href="/" class="flex items-center gap-3 px-5 py-3 text-[10px] font-black uppercase text-gray-400 hover:text-white hover:bg-white/5 transition-all">
                            <span class="material-symbols-outlined text-[18px]">open_in_new</span> Ke Beranda
                        </a>
                        <div class="border-t border-white/5 my-2"></div>
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-[10px] font-black uppercase text-red-500 hover:bg-red-500/10 transition-all">
                                <span class="material-symbols-outlined text-[18px]">logout</span> Keluar Sistem
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Scrollable Area -->
        <div class="flex-1 overflow-y-auto px-4 md:px-6 py-8 custom-scrollbar relative z-10">
            <div class="max-w-full mx-auto pb-96">
                {{ $slot }}
            </div>
        </div>
    </main>

    @livewireScripts
    @stack('scripts')
</body>
</html>
