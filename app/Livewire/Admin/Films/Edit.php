<?php

namespace App\Livewire\Admin\Films;

use Livewire\Component;
use App\Models\Movie;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $movie_id, $title, $description, $thumbnail, $video_url, $duration, $slug, $year, $tmdb_id, $posterFile, $is_premium;
    public $category_id; // Legacy
    public $selectedCategories = []; // NEW
    public $audience_type; // NEW
    public $rating_value; // NEW
    public $age_rating; // NEW
    public $series_id;

    public function mount($id)
    {
        $movie = Movie::findOrFail($id);
        $this->movie_id = $movie->id;
        $this->title = $movie->title;
        $this->slug = $movie->slug;
        $this->description = $movie->description;
        $this->thumbnail = $movie->thumbnail;
        $this->video_url = $movie->video_url;
        $this->duration = $movie->duration;
        $this->category_id = $movie->category_id;
        $this->year = $movie->year ?? 2024;
        $this->tmdb_id = $movie->tmdb_id;
        $this->audience_type = $movie->audience_type ?? 'adult';
        $this->rating_value = $movie->rating_value ?? 0.0;
        $this->age_rating = $movie->age_rating ?? 'PG-13';
        $this->series_id = $movie->series_id;
        $this->is_premium = $movie->is_premium;
        $this->selectedCategories = $movie->categories->pluck('id')->toArray();
    }

    protected $rules = [
        'title' => 'required|min:3',
        'selectedCategories' => 'required|array|min:1',
        'audience_type' => 'required',
        'series_id' => 'nullable|exists:series,id',
    ];

    public function update()
    {
        $this->validate();

        $movie = Movie::findOrFail($this->movie_id);

        if ($this->posterFile) {
            $path = $this->posterFile->store('posters', 'public');
            $this->thumbnail = '/storage/' . $path;
        }

        $movie->update([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'thumbnail' => $this->thumbnail,
            'video_url' => $this->video_url,
            'duration' => $this->duration,
            'year' => $this->year,
            'tmdb_id' => $this->tmdb_id,
            'audience_type' => $this->audience_type,
            'rating_value' => $this->rating_value,
            'age_rating' => $this->age_rating,
            'is_premium' => $this->is_premium,
            'category_id' => $this->selectedCategories[0] ?? null, // Fallback
            'series_id' => $this->series_id ?: null,
        ]);

        $movie->categories()->sync($this->selectedCategories);

        session()->flash('message', 'Data film berhasil diperbarui di sistem.');
        return redirect()->route('admin.films.index');
    }

    #[Layout('admin.dashboard-layout')]
    public function render()
    {
        $categories = Category::all();
        $series = \App\Models\Series::all();
        return view('livewire.admin.films.edit', compact('categories', 'series'));
    }
}
