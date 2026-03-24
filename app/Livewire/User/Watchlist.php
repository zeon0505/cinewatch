<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Watchlist as WatchlistModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class Watchlist extends Component
{
    #[Layout('components.layouts.app')]
    public function render()
    {
        $isKids = session('is_kids_mode', false);
        $watchlists = Auth::user()->watchlists()
            ->with(['movie' => function($q) use ($isKids) {
                $q->with('category')->when($isKids, fn($query) => $query->kids());
            }])
            ->whereHas('movie', function($q) use ($isKids) {
                $q->when($isKids, fn($query) => $query->kids());
            })
            ->latest()
            ->paginate(12);

        return view('livewire.user.watchlist', compact('watchlists'));
    }
}
