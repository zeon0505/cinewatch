<?php

namespace App\Livewire\Admin\Reports;

use Livewire\Component;
use App\Models\Movie;
use App\Models\User;
use App\Models\History;
use App\Models\Watchlist;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public function render()
    {
        // Statistik Utama
        $totalUsers = User::count();
        $totalMovies = Movie::count();
        $totalViews = Movie::sum('views');
        $totalWatchlist = Watchlist::count();
        
        // Film Teratas
        $topMovies = Movie::with('category')->orderBy('views', 'desc')->take(5)->get();
        
        // Data Grafik (7 hari terakhir)
        $dailyViewsRaw = History::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
            
        $dailyViews = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayName = now()->subDays($i)->isoFormat('ddd');
            $found = $dailyViewsRaw->firstWhere('date', $date);
            $dailyViews[$dayName] = $found ? $found->count : 0;
        }

        // Aktivitas Terbaru
        $recentActivity = History::with(['user', 'movie'])->latest()->take(6)->get();

        return view('livewire.admin.reports.index', compact(
            'totalUsers', 
            'totalMovies', 
            'totalViews', 
            'totalWatchlist',
            'topMovies',
            'dailyViews',
            'recentActivity'
        ))->layout('admin.dashboard-layout');
    }
}
