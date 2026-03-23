<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — CineVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap');
        body { font-family: 'Outfit', sans-serif; background: #f2f7ff; }
        .sidebar { background: #fff; width: 260px; min-height: 100vh; position: fixed; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05); }
        .main-content { margin-left: 260px; padding: 2rem; }
        .nav-item { padding: 0.75rem 1.5rem; display: flex; align-items: center; gap: 0.75rem; color: #7c8db5; transition: all 0.2s; border-radius: 0.5rem; margin: 0.25rem 1rem; }
        .nav-item:hover, .nav-item.active { background: #435ebe; color: #fff; }
        .card { background: #fff; border-radius: 0.75rem; padding: 1.5rem; border: none; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="p-6">
            <h1 class="text-2xl font-bold" style="color:#435ebe">CINEVAULT</h1>
            <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mt-1">Admin Panel</p>
        </div>
        
        <nav class="mt-4">
            <a href="/admin" class="nav-item active">Dashboard</a>
            <a href="#" class="nav-item">Kelola Film</a>
            <a href="#" class="nav-item">Kelola Kategori</a>
            <a href="#" class="nav-item">Kelola User</a>
            <div class="my-4 border-t border-gray-100 mx-6"></div>
            <a href="/" class="nav-item">Kembali ke Situs</a>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-item w-[calc(100%-2rem)] text-left">Logout</button>
            </form>
        </nav>
    </div>

    <main class="main-content">
        <header class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-[#25396f]">Statistics Overview</h2>
            <div class="flex items-center gap-4">
                <span class="text-sm font-semibold text-gray-500">{{ auth()->user()->name }}</span>
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=435ebe&color=fff" class="w-10 h-10 rounded-full shadow" />
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="card flex items-center gap-4">
                <div class="p-3 rounded-xl bg-purple-100/50 text-purple-600">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total User</p>
                    <h3 class="text-xl font-bold">{{ \App\Models\User::count() }}</h3>
                </div>
            </div>
            <div class="card flex items-center gap-4">
                <div class="p-3 rounded-xl bg-blue-100/50 text-blue-600">
                   <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/><line x1="7" y1="2" x2="7" y2="22"/><line x1="17" y1="2" x2="17" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/><line x1="2" y1="7" x2="7" y2="7"/><line x1="2" y1="17" x2="7" y2="17"/><line x1="17" y1="17" x2="22" y2="17"/><line x1="17" y1="7" x2="22" y2="7"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total Film</p>
                    <h3 class="text-xl font-bold">{{ \App\Models\Movie::count() }}</h3>
                </div>
            </div>
            <div class="card flex items-center gap-4">
                <div class="p-3 rounded-xl bg-green-100/50 text-green-600">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total Views</p>
                    <h3 class="text-xl font-bold">{{ number_format(\App\Models\Movie::sum('views')) }}</h3>
                </div>
            </div>
            <div class="card flex items-center gap-4">
                <div class="p-3 rounded-xl bg-red-100/50 text-red-600">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total Watchlist</p>
                    <h3 class="text-xl font-bold">{{ \App\Models\Watchlist::count() }}</h3>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 card">
                <h3 class="text-lg font-bold text-[#25396f] mb-4">Film Populer</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs text-gray-400 uppercase border-b border-gray-100">
                                <th class="pb-3 px-4">Judul Film</th>
                                <th class="pb-3 px-4">Kategori</th>
                                <th class="pb-3 px-4">Views</th>
                                <th class="pb-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach(\App\Models\Movie::orderBy('views', 'desc')->take(5)->get() as $movie)
                                <tr class="hover:bg-gray-50/50 border-b border-gray-50">
                                    <td class="py-4 px-4 font-semibold text-gray-700">{{ $movie->title }}</td>
                                    <td class="py-4 px-4 text-gray-500">{{ $movie->category->name ?? '-' }}</td>
                                    <td class="py-4 px-4 font-bold text-gray-800">{{ number_format($movie->views) }}</td>
                                    <td class="py-4 px-4 text-right">
                                        <button class="text-blue-500 font-bold hover:underline">Edit</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card">
                <h3 class="text-lg font-bold text-[#25396f] mb-4">Aktivitas Baru</h3>
                <div class="space-y-6">
                    @foreach(\App\Models\History::latest()->take(6)->get() as $history)
                        <div class="flex gap-4 items-center">
                            <img src="https://ui-avatars.com/api/?name={{ $history->user->name }}&background=random" class="w-10 h-10 rounded-full" />
                            <div>
                                <p class="text-xs text-gray-500"><span class="font-bold text-gray-800">{{ $history->user->name }}</span> nonton <span class="font-bold text-gray-800">{{ $history->movie->title }}</span></p>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">{{ $history->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                    @if(\App\Models\History::count() == 0)
                        <p class="text-center text-gray-400 text-sm py-12">Belum ada aktivitas tontonan.</p>
                    @endif
                </div>
            </div>
        </div>
    </main>
</body>
</html>
