<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Movie;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

class Player extends Component
{
    public $movie;
    public $progress = 0;

    public function mount($id)
    {
        $this->movie = Movie::findOrFail($id);
        $this->movie->increment('views');

        if (Auth::check()) {
            $history = History::where('user_id', Auth::id())
                ->where('movie_id', $this->movie->id)
                ->first();
            
            if ($history) {
                $this->progress = $history->progress;
            } else {
                History::create([
                    'user_id' => Auth::id(),
                    'movie_id' => $this->movie->id,
                    'progress' => 0,
                    'last_watched' => now()
                ]);
            }
        }
    }

    public function update_progress($seconds)
    {
        if (Auth::check()) {
            History::where('user_id', Auth::id())
                ->where('movie_id', $this->movie->id)
                ->update([
                    'progress' => (int) $seconds,
                    'last_watched' => now()
                ]);
        }
    }

    public function render()
    {
        return view('livewire.player')->layout('components.layouts.app');
    }
}
