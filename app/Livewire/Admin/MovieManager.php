<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Movie;
use App\Models\Category;
use Illuminate\Support\Str;

class MovieManager extends Component
{
    public $movies, $title, $description, $thumbnail, $video_url, $duration, $category_id, $movie_id;
    public $isModalOpen = false;

    public function render()
    {
        $this->movies = Movie::latest()->get();
        $categories = Category::all();
        return view('livewire.admin.movie-manager', compact('categories'))->layout('admin.dashboard-layout');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->thumbnail = '';
        $this->video_url = '';
        $this->duration = '';
        $this->category_id = '';
        $this->movie_id = '';
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'category_id' => 'required',
        ]);

        Movie::updateOrCreate(['id' => $this->movie_id], [
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'thumbnail' => $this->thumbnail,
            'video_url' => $this->video_url,
            'duration' => $this->duration,
            'category_id' => $this->category_id,
        ]);

        session()->flash('message', $this->movie_id ? 'Movie Updated Successfully.' : 'Movie Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        $this->movie_id = $id;
        $this->title = $movie->title;
        $this->description = $movie->description;
        $this->thumbnail = $movie->thumbnail;
        $this->video_url = $movie->video_url;
        $this->duration = $movie->duration;
        $this->category_id = $movie->category_id;

        $this->openModal();
    }

    public function delete($id)
    {
        Movie::find($id)->delete();
        session()->flash('message', 'Movie Deleted Successfully.');
    }
}
