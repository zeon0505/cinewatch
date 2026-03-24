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
        $watchlists = Auth::user()->watchlists()
            ->with('movie.category')
            ->latest()
            ->paginate(12);

        return view('livewire.user.watchlist', compact('watchlists'));
    }
}
