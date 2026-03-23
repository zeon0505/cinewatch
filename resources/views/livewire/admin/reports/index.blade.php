<div class="space-y-12 animate-popIn">
    <div>
        <h2 class="text-4xl font-black text-white uppercase tracking-tighter">Statistics Overview</h2>
        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1 italic">Real-time platform performance data</p>
    </div>
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="card p-10 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 text-8xl opacity-5 group-hover:scale-110 transition-transform">👤</div>
            <h3 class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-2 italic">Total Member</h3>
            <p class="text-5xl font-black text-white tracking-tighter">{{ $totalUsers }}</p>
        </div>
        <div class="card p-10 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 text-8xl opacity-5 group-hover:scale-110 transition-transform">🎞️</div>
            <h3 class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-2 italic">Total Movie</h3>
            <p class="text-5xl font-black text-white tracking-tighter">{{ $totalMovies }}</p>
        </div>
        <div class="card p-10 relative overflow-hidden group border-b-4 border-red-600">
            <div class="absolute -right-4 -top-4 text-8xl opacity-5 group-hover:scale-110 transition-transform">👁️</div>
            <h3 class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-2 italic">Total Views</h3>
            <p class="text-5xl font-black text-[#E50914] tracking-tighter">{{ $totalViews }}</p>
        </div>
        <div class="card p-10 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 text-8xl opacity-5 group-hover:scale-110 transition-transform">❤️</div>
            <h3 class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-2 italic">Watchlist</h3>
            <p class="text-5xl font-black text-white tracking-tighter">{{ $totalWatchlist }}</p>
        </div>
    </div>

    <!-- Charts & Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Views Chart (Visualized with simple CSS bars for now) -->
        <div class="lg:col-span-2 card p-10 space-y-10">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-black text-white uppercase tracking-widest">Trend Tontonan (7 Hari Terakhir)</h3>
                <span class="px-3 py-1 bg-white/5 rounded-full text-[10px] font-bold uppercase tracking-widest text-gray-500 italic">Live Analytics</span>
            </div>
            <div class="flex items-end justify-between h-64 gap-6 px-4">
                @foreach($dailyViews as $day => $count)
                    <div class="flex-1 flex flex-col items-center gap-4 group">
                        <div class="w-full bg-white/5 group-hover:bg-red-600/20 transition-all rounded-t-xl relative overflow-hidden" style="height: {{ $count > 0 ? ($count / max($dailyViews) * 100) : 0 }}%">
                             <div class="absolute inset-x-0 top-0 h-1 bg-red-600 shadow-[0_0_10px_rgba(229,9,20,0.5)]"></div>
                        </div>
                        <span class="text-[10px] text-gray-700 font-bold uppercase tracking-widest truncate">{{ $day }}</span>
                        <span class="text-xs text-white font-bold">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Top Movies -->
        <div class="card p-10 space-y-8">
            <h3 class="text-xl font-black text-white uppercase tracking-widest border-b border-white/5 pb-4">🍿 Film Berjaya</h3>
            <div class="space-y-6">
                @foreach($topMovies as $movie)
                <div class="flex items-center gap-6 group">
                    <img src="{{ $movie->thumbnail }}" class="w-12 h-16 object-cover rounded shadow-2xl transition-transform group-hover:scale-110" />
                    <div class="flex-1 min-w-0">
                        <h4 class="text-white font-bold text-sm uppercase truncate">{{ $movie->title }}</h4>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1 italic">{{ $movie->category->name }} · {{ $movie->views }} Views</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card p-10 space-y-8">
        <h3 class="text-xl font-black text-white uppercase tracking-widest border-b border-white/5 pb-4">🎥 Log Aktivitas Terminal</h3>
        <div class="space-y-2">
            @foreach($recentActivity as $activity)
            <div class="p-6 flex items-center justify-between bg-white/[0.02] border border-white/5 rounded-xl group hover:border-red-600/50 transition-all">
                <div class="flex items-center gap-5">
                    <div class="w-2 h-2 rounded-full bg-red-600 shadow-[0_0_10px_rgba(229,9,20,0.5)] group-hover:animate-pulse"></div>
                    <div>
                        <span class="text-white font-bold text-sm uppercase tracking-tight">{{ $activity->user->name }}</span> 
                        <span class="text-gray-500 text-xs italic ml-2">sedang menonton</span>
                        <span class="text-red-500 font-bold text-sm ml-2 uppercase tracking-tight">{{ $activity->movie->title }}</span>
                    </div>
                </div>
                <span class="text-[10px] text-gray-700 font-bold uppercase tracking-widest italic tracking-tighter">{{ $activity->created_at->diffForHumans() }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
