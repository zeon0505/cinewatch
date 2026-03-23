<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class MovieRating extends Component
{
    public $movie_id;
    public $rating = 0;

    public function mount($movie_id)
    {
        $this->movie_id = $movie_id;
        if (Auth::check()) {
            $userRating = Rating::where('user_id', Auth::id())
                ->where('movie_id', $this->movie_id)
                ->first();
            if ($userRating) {
                $this->rating = $userRating->rating;
            }
        }
    }

    public function setRating($val)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'movie_id' => $this->movie_id],
            ['rating' => $val]
        );

        $this->rating = $val;
        session()->flash('rating_message', 'Terima kasih atas rating-nya!');
    }

    public function render()
    {
        return view('livewire.movie-rating');
    }
}
