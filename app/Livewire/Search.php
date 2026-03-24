<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Movie;

class Search extends Component
{
    public $query = '';
    public $results = [];

    public function updatedQuery()
    {
        if (strlen($this->query) >= 3) {
            $isKids = session('is_kids_mode', false);
            $this->results = Movie::where('title', 'like', '%' . $this->query . '%')
                ->when($isKids, fn($q) => $q->kids())
                ->take(5)
                ->get();
        } else {
            $this->results = [];
        }
    }

    public function render()
    {
        return view('livewire.search');
    }
}
