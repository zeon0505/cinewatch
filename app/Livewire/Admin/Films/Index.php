<?php

namespace App\Livewire\Admin\Films;

use Livewire\Component;
use App\Models\Movie;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';
    #[Url]
    public $genreFilter = null;
    public $confirmingDeletion = false;
    public $filmIdBeingDeleted = null;

    public function mount()
    {
        // Capture genre from request if needed
        if (request()->has('genre')) {
            $this->genreFilter = request('genre');
        }
    }

    public function clearFilter()
    {
        $this->genreFilter = null;
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
            Movie::find($this->filmIdBeingDeleted)->delete();
            $this->confirmingDeletion = false;
            $this->filmIdBeingDeleted = null;
            session()->flash('message', 'Film berhasil dihapus dari arsip.');
        }
    }

    public function render()
    {
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
            ->latest()
            ->paginate(10);

        return view('livewire.admin.films.index', compact('films'))
            ->layout('admin.dashboard-layout');
    }
}
