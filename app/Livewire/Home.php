<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\Movie;
use App\Models\Category;

class Home extends Component
{
    public function render()
    {
        $trendingMovies = Movie::orderBy('views', 'desc')->take(10)->get();
        $latestMovies = Movie::latest()->take(10)->get();
        $categories = Category::all();
        
        $featuredFilmIds = [];
        if (Storage::disk('local')->exists('settings.json')) {
            $settings = json_decode(Storage::disk('local')->get('settings.json'), true);
            $featuredFilmIds = $settings['featured_film_ids'] ?? [];
        }

        if (!empty($featuredFilmIds)) {
            $heroMovies = Movie::whereIn('id', $featuredFilmIds)->get();
        } else {
            $heroMovies = collect();
        }

        if ($heroMovies->isEmpty()) {
            $heroMovies = Movie::latest()->take(3)->get();
        }

        return view('livewire.home', [
            'trendingMovies' => $trendingMovies,
            'latestMovies' => $latestMovies,
            'categories' => $categories,
            'heroMovies' => $heroMovies,
        ])->layout('components.layouts.app');
    }
}
