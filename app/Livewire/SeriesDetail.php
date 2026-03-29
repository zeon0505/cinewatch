<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Series;
use App\Models\Movie;
use Livewire\Attributes\Layout;

class SeriesDetail extends Component
{
    use WithPagination;
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        $series = Series::where('slug', $this->slug)->firstOrFail();
        $isKids = session('is_kids_mode', false);
        
        $movies = Movie::where('series_id', $series->id)
            ->when($isKids, fn($q) => $q->kids())
            ->latest()
            ->paginate(24);

        return view('livewire.series-detail', [
            'series' => $series,
            'movies' => $movies
        ]);
    }
}
