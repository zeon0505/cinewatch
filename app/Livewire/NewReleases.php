<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Movie;
use Livewire\WithPagination;

class NewReleases extends Component
{
    use WithPagination;

    public function render()
    {
        $isKids = session('is_kids_mode', false);
        
        $movies = Movie::when($isKids, fn($q) => $q->kids())
            ->latest()
            ->paginate(18);

        return view('livewire.new-releases', [
            'movies' => $movies
        ])->layout('components.layouts.app');
    }
}
