<?php

namespace App\Livewire\User\Films;

use Livewire\Component;
use App\Models\Movie;
use App\Models\Category;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $genreFilter = null;
    public $audienceFilter = null;
    public $confirmingDeletion = false;
    public $filmIdBeingDeleted = null;

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

    public function confirmDelete($id)
    {
        $this->filmIdBeingDeleted = $id;
        $this->confirmingDeletion = true;
    }

    public function deleteFilm()
    {
        if ($this->filmIdBeingDeleted) {
            $movie = Movie::where('user_id', auth()->id())->find($this->filmIdBeingDeleted);
            if ($movie) {
                $movie->delete();
                session()->flash('message', 'Film berhasil dihapus dari koleksimu.');
            }
            $this->confirmingDeletion = false;
            $this->filmIdBeingDeleted = null;
        }
    }

    #[Layout('components.layouts.dashboard')]
    public function render()
    {
        $categories = Category::orderBy('name')->get();
        
        $films = Movie::with('categories')
            ->where('user_id', auth()->id())
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
            ->paginate(10);

        return view('livewire.user.films.index', compact('films', 'categories'));
    }
}
