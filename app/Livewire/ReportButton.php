<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportButton extends Component
{
    public $movieId;
    public $type = 'link_mati';
    public $description;
    public $successMessage;

    public function submit()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate([
            'type' => 'required',
            'description' => 'nullable|max:255',
        ]);

        Report::create([
            'user_id' => Auth::id(),
            'movie_id' => $this->movieId,
            'type' => $this->type,
            'description' => $this->description,
            'status' => 'pending',
        ]);

        $this->reset(['description']);
        $this->successMessage = 'Laporan Anda telah terkirim. Terima kasih!';
        $this->dispatch('report-submitted');
    }

    public function render()
    {
        return view('livewire.report-button');
    }
}
