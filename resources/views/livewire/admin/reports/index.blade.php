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
            <div class="absolute -right-4 -top-4 text-8xl opacity-5 group-hover:scale-110 transition-transform">💰</div>
            <h3 class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-2 italic">Revenue VIP</h3>
            <p class="text-4xl font-black text-[#E50914] tracking-tighter">Rp {{ number_format($totalRevenue) }}</p>
        </div>
        <div class="card p-10 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 text-8xl opacity-5 group-hover:scale-110 transition-transform">👁️</div>
            <h3 class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-2 italic">Total Views</h3>
            <p class="text-5xl font-black text-white tracking-tighter">{{ number_format($totalViews) }}</p>
        </div>
    </div>

    <!-- Charts & Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Analytics Charts -->
        <div class="lg:col-span-2 space-y-10">
            <!-- Views Chart -->
            <div class="card p-10">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-xl font-black text-white uppercase tracking-widest">Trend Tontonan</h3>
                    <span class="px-3 py-1 bg-white/5 rounded-full text-[10px] font-bold uppercase tracking-widest text-gray-400 italic">User Engagement</span>
                </div>
                <div class="h-64">
                    <canvas id="viewsChart"></canvas>
                </div>
            </div>

            <!-- Revenue Chart -->
            <div class="card p-10">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-xl font-black text-white uppercase tracking-widest">Revenue VIP</h3>
                    <span class="px-3 py-1 bg-green-500/10 rounded-full text-[10px] font-bold uppercase tracking-widest text-green-500 italic">Financial Growth</span>
                </div>
                <div class="h-64">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <div class="space-y-10">
            <!-- Top Movies -->
            <div class="card p-10 space-y-8">
                <h3 class="text-xl font-black text-white uppercase tracking-widest border-b border-white/5 pb-4">🍿 Film Berjaya</h3>
                <div class="space-y-6">
                    @foreach($topMovies as $movie)
                    <div class="flex items-center gap-6 group">
                        <img src="{{ $movie->thumbnail }}" class="w-12 h-16 object-cover rounded-xl shadow-2xl transition-transform group-hover:scale-110" />
                        <div class="flex-1 min-w-0">
                            <h4 class="text-white font-bold text-sm uppercase truncate">{{ $movie->title }}</h4>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1 italic">{{ $movie->category->name }} · {{ $movie->views }} Views</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card p-10 bg-gradient-to-br from-red-600/10 to-transparent">
                <h3 class="text-xl font-black text-white uppercase tracking-widest mb-6">❤️ Watchlist</h3>
                <div class="flex items-end gap-4">
                    <p class="text-6xl font-black text-white tracking-tighter">{{ $totalWatchlist }}</p>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-2 italic">Movies Saved</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card p-10 space-y-8">
        <h3 class="text-xl font-black text-white uppercase tracking-widest border-b border-white/5 pb-4">🎥 Log Aktivitas Terminal</h3>
        <div class="space-y-2">
            @foreach($recentActivity as $activity)
            <div class="p-6 flex items-center justify-between bg-white/[0.02] border border-white/5 rounded-2xl group hover:border-red-600/50 transition-all">
                <div class="flex items-center gap-5">
                    <div class="w-2 h-2 rounded-full bg-red-600 shadow-[0_0_10px_rgba(229,9,20,0.5)] group-hover:animate-pulse"></div>
                    <div>
                        <span class="text-white font-bold text-sm uppercase tracking-tight">{{ $activity->user->name }}</span> 
                        <span class="text-gray-500 text-xs italic ml-2">sedang menonton</span>
                        <span class="text-red-500 font-bold text-sm ml-2 uppercase tracking-tight">{{ $activity->movie->title }}</span>
                    </div>
                </div>
                <span class="text-[10px] text-gray-700 font-bold uppercase tracking-widest italic truncate">{{ $activity->created_at->diffForHumans() }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const viewsCtx = document.getElementById('viewsChart');
            const revenueCtx = document.getElementById('revenueChart');

            new Chart(viewsCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_keys($dailyViews)) !!},
                    datasets: [{
                        label: 'Views',
                        data: {!! json_encode(array_values($dailyViews)) !!},
                        borderColor: '#E50914',
                        backgroundColor: 'rgba(229, 9, 20, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 4,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#E50914',
                        pointHoverBorderWidth: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#444', font: { weight: 'bold', size: 10 } } },
                        y: { grid: { color: 'rgba(255,255,255,0.05)' }, border: { display: false }, ticks: { color: '#444', font: { weight: 'bold', size: 10 } } }
                    }
                }
            });

            new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($dailyRevenue)) !!},
                    datasets: [{
                        label: 'Revenue',
                        data: {!! json_encode(array_values($dailyRevenue)) !!},
                        backgroundColor: '#22c55e',
                        borderRadius: 8,
                        barThickness: 12,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#444', font: { weight: 'bold', size: 10 } } },
                        y: { grid: { color: 'rgba(255,255,255,0.05)' }, border: { display: false }, ticks: { color: '#444', font: { weight: 'bold', size: 10 } } }
                    }
                }
            });
        });
    </script>
</div>
