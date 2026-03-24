<?php

namespace App\Livewire\Admin\Reports;

use Livewire\Component;
use App\Models\Movie;
use App\Models\User;
use App\Models\History;
use App\Models\Watchlist;
use App\Models\Transaction;
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
        $totalRevenue = Transaction::whereIn('status', ['paid', 'settlement', 'capture'])->sum('amount');
        
        
        // Film Teratas
        $topMovies = Movie::with('category')->orderBy('views', 'desc')->take(5)->get();
        
        // Data Grafik (7 hari terakhir)
        $dailyViewsRaw = History::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
            
        $dailyViews = [];
        $dailyRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayName = now()->subDays($i)->isoFormat('ddd');
            
            $foundViews = $dailyViewsRaw->firstWhere('date', $date);
            $dailyViews[$dayName] = $foundViews ? $foundViews->count : 0;

            $rev = Transaction::whereIn('status', ['paid', 'settlement', 'capture'])
                ->whereDate('created_at', $date)
                ->sum('amount');
            $dailyRevenue[$dayName] = $rev;
        }

        // Aktivitas Terbaru
        $recentActivity = History::with(['user', 'movie'])->latest()->take(6)->get();

        return view('livewire.admin.reports.index', compact(
            'totalUsers', 
            'totalMovies', 
            'totalViews', 
            'totalWatchlist',
            'totalRevenue',
            'topMovies',
            'dailyViews',
            'dailyRevenue',
            'recentActivity'
        ))->layout('admin.dashboard-layout');
    }
}
