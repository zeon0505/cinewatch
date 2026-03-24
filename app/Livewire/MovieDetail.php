<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Movie;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;

class MovieDetail extends Component
{
    public $movie;
    public $isInWatchlist = false;

    public function mount($slug)
    {
        $isKids = session('is_kids_mode', false);
        $this->movie = Movie::where('slug', $slug)
            ->when($isKids, fn($q) => $q->kids())
            ->firstOrFail();
        
        if (Auth::check()) {
            $this->isInWatchlist = Watchlist::where('user_id', Auth::id())
                ->where('movie_id', $this->movie->id)
                ->exists();
        }
    }

    public function toggleWatchlist()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->isInWatchlist) {
            Watchlist::where('user_id', Auth::id())
                ->where('movie_id', $this->movie->id)
                ->delete();
            $this->isInWatchlist = false;
        } else {
            Watchlist::create([
                'user_id' => Auth::id(),
                'movie_id' => $this->movie->id,
            ]);
            $this->isInWatchlist = true;
        }
    }

    public function render()
    {
        $isKids = session('is_kids_mode', false);
        $relatedMovies = Movie::where('category_id', $this->movie->category_id)
            ->where('id', '!=', $this->movie->id)
            ->when($isKids, fn($q) => $q->kids())
            ->take(12)
            ->get();

        return view('livewire.movie-detail', compact('relatedMovies'))->layout('components.layouts.app');
    }
}
