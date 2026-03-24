<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Movie;
use App\Models\History;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class Player extends Component
{
    public $movie;
    public $progress = 0;

    public function mount($id)
    {
        $this->movie = Movie::findOrFail($id);

        // VIP Check
        if ($this->movie->is_premium) {
            if (!Auth::check() || !Auth::user()->is_vip) {
                return redirect()->route('subscription')->with('error', 'Film ini khusus untuk member VIP. Silakan berlangganan untuk melanjutkan.');
            }
        }

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
    public function reportLink($type, $description = null)
    {
        Report::create([
            'user_id' => Auth::id(),
            'movie_id' => $this->movie->id,
            'type' => $type,
            'description' => $description,
            'status' => 'pending'
        ]);

        $this->dispatch('notify', ['message' => 'Laporan berhasil terkirim. Terima kasih!', 'type' => 'success']);
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        $relatedMovies = Movie::where('category_id', $this->movie->category_id)
            ->where('id', '!=', $this->movie->id)
            ->take(12)
            ->get();

        return view('livewire.player', compact('relatedMovies'));
    }
}
