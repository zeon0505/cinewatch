<?php

namespace App\Livewire\User\Films;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Movie;
use App\Models\Category;
use Illuminate\Support\Str;

class Edit extends Component
{
    use WithFileUploads;

    public $movie;
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

    public function mount($id)
    {
        $this->movie = Movie::where('user_id', auth()->id())->findOrFail($id);

        $this->title = $this->movie->title;
        $this->description = $this->movie->description;
        $this->thumbnail = $this->movie->thumbnail;
        $this->video_url = $this->movie->video_url;
        $this->duration = $this->movie->duration;
        $this->year = $this->movie->year;
        $this->audience_type = $this->movie->audience_type;
        $this->selectedCategories = $this->movie->categories->pluck('id')->toArray();
    }

    public function update()
    {
        $this->validate();

        $thumbnailPath = $this->thumbnail;
        $subtitlePath = $this->movie->subtitle_url;

        if ($this->posterFile) {
            $thumbnailPath = $this->posterFile->store('posters', 'public');
            $thumbnailPath = '/storage/' . $thumbnailPath;
        }

        if ($this->subtitleFile) {
            $subtitlePath = $this->subtitleFile->store('subtitles', 'public');
            $subtitlePath = '/storage/' . $subtitlePath;
        }

        $this->movie->update([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'thumbnail' => $thumbnailPath,
            'video_url' => $this->video_url,
            'subtitle_url' => $subtitlePath,
            'duration' => $this->duration,
            'year' => $this->year,
            'audience_type' => $this->audience_type,
            'category_id' => $this->selectedCategories[0] ?? null,
        ]);

        $this->movie->categories()->sync($this->selectedCategories);

        return redirect()->route('user.films.index')->with('message', 'Perubahan karya berhasil disimpan!');
    }

    #[Layout('components.layouts.dashboard')]
    public function render()
    {
        $categories = Category::orderBy('name')->get();
        return view('livewire.user.films.edit', compact('categories'));
    }
}
