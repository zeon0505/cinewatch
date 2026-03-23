<?php

namespace App\Livewire\User\Films;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Movie;
use App\Models\Category;
use Illuminate\Support\Str;

class Create extends Component
{
    use WithFileUploads;

    public $title, $description, $thumbnail, $video_url, $duration, $year;
    public $selectedCategories = [];
    public $audience_type = 'adult';
    public $posterFile, $subtitleFile;

    protected $rules = [
        'title' => 'required|min:2',
        'video_url' => 'required|url',
        'selectedCategories' => 'required|array|min:1',
        'audience_type' => 'required|in:adult,kids',
        'posterFile' => 'nullable|image|max:2048', // 2MB Max
        'subtitleFile' => 'nullable|file|max:1024', // 1MB Max
    ];

    public function store()
    {
        $this->validate();

        $thumbnailPath = $this->thumbnail;
        $subtitlePath = null;

        if ($this->posterFile) {
            $thumbnailPath = $this->posterFile->store('posters', 'public');
            $thumbnailPath = '/storage/' . $thumbnailPath;
        }

        if ($this->subtitleFile) {
            $subtitlePath = $this->subtitleFile->store('subtitles', 'public');
            $subtitlePath = '/storage/' . $subtitlePath;
        }

        $movie = Movie::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'thumbnail' => $thumbnailPath ?? 'https://via.placeholder.com/300x450',
            'video_url' => $this->video_url,
            'subtitle_url' => $subtitlePath,
            'duration' => $this->duration ?? '120 min',
            'year' => $this->year ?? date('Y'),
            'audience_type' => $this->audience_type,
            'status' => 'published',
            'category_id' => $this->selectedCategories[0] ?? null,
        ]);

        $movie->categories()->sync($this->selectedCategories);

        return redirect()->route('user.films.index')->with('message', 'Karya berhasil ditambahkan ke koleksimu!');
    }

    #[Layout('components.layouts.dashboard')]
    public function render()
    {
        $categories = Category::orderBy('name')->get();
        return view('livewire.user.films.create', compact('categories'));
    }
}
