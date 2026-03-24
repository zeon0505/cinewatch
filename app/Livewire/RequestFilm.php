<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\MovieRequest;
use Illuminate\Support\Facades\Auth;

class RequestFilm extends Component
{
    public $title;
    public $year;
    public $description;
    public $successMessage;

    protected $rules = [
        'title' => 'required|min:2',
        'year' => 'nullable|numeric|digits:4',
        'description' => 'nullable|max:500',
    ];

    public function submit()
    {
        $this->validate();

        MovieRequest::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'year' => $this->year,
            'description' => $this->description,
            'status' => 'pending',
        ]);

        $this->reset(['title', 'year', 'description']);
        $this->successMessage = 'Request film Anda berhasil dikirim! Kami akan segera meninjaunya.';
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.request-film');
    }
}
