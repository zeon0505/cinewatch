<?php

namespace App\Livewire\Admin\Reviews;

use Livewire\Component;
use App\Models\Rating;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function delete($id)
    {
        Rating::find($id)->delete();
        session()->flash('message', 'Rating berhasil dihapus.');
    }

    public function render()
    {
        // Use variable name $reviews to match the premium view
        $reviews = Rating::with(['user', 'movie'])->latest()->paginate(15);
        return view('livewire.admin.reviews.index', compact('reviews'))
            ->layout('admin.dashboard-layout');
    }
}
