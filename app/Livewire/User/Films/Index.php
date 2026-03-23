<?php

namespace App\Livewire\User\Films;

use Livewire\Component;
use App\Models\Movie;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $genreFilter = null;
    public $audienceFilter = null;
    public function mount()
    {
        if (request()->has('genre')) {
            $this->genreFilter = request('genre');
        }
    }

    public function clearFilter()
    {
        $this->genreFilter = null;
        $this->audienceFilter = null;
        $this->search = '';
    }

    public function toggleWatchlist($movieId)
    {
        $existing = \App\Models\Watchlist::where('user_id', auth()->id())
            ->where('movie_id', $movieId)
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            \App\Models\Watchlist::create([
                'user_id' => auth()->id(),
                'movie_id' => $movieId,
            ]);
        }
    }

    #[Layout('components.layouts.dashboard')]
    public function render()
    {
        $categories = Category::orderBy('name')->get();
        
        $films = Movie::with('categories')
            ->when($this->search, function($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->genreFilter, function($q) {
                $q->whereHas('categories', function($sq) {
                    $sq->where('categories.id', $this->genreFilter)
                       ->orWhere('categories.name', $this->genreFilter)
                       ->orWhere('categories.slug', $this->genreFilter);
                });
            })
            ->when($this->audienceFilter, function($q) {
                $q->where('audience_type', $this->audienceFilter);
            })
            ->latest()
            ->paginate(12);

        $watchlists = \App\Models\Watchlist::with(['movie', 'movie.categories'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $histories = \App\Models\History::where('user_id', auth()->id())
            ->pluck('movie_id')
            ->toArray();

        return view('livewire.user.films.index', compact('films', 'categories', 'watchlists', 'histories'));
    }
}
