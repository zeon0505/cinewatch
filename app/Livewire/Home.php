<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Movie;
use App\Models\Category;

class Home extends Component
{
    public function render()
    {
        $trendingMovies = Movie::orderBy('views', 'desc')->take(10)->get();
        $latestMovies = Movie::latest()->take(10)->get();
        $categories = Category::all();
        $heroMovie = Movie::where('slug', 'shadow-protocol')->first() ?? Movie::first();

        return view('livewire.home', [
            'trendingMovies' => $trendingMovies,
            'latestMovies' => $latestMovies,
            'categories' => $categories,
            'heroMovie' => $heroMovie,
        ])->layout('components.layouts.app');
    }
}
