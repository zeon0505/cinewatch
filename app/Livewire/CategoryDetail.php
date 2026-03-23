<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Movie;

class CategoryDetail extends Component
{
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $category = Category::where('slug', $this->slug)->firstOrFail();
        $movies = Movie::whereHas('categories', function($query) use ($category) {
            $query->where('categories.id', $category->id);
        })->latest()->paginate(24);

        return view('livewire.category-detail', [
            'category' => $category,
            'movies' => $movies
        ])->layout('components.layouts.app');
    }
}
