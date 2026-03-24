<?php

namespace App\Livewire\Admin\Requests;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\MovieRequest;
use Livewire\WithPagination;

class ListRequests extends Component
{
    use WithPagination;

    public function process($id)
    {
        $request = MovieRequest::findOrFail($id);
        $request->update(['status' => 'processed']);
    }

    public function reject($id)
    {
        $request = MovieRequest::findOrFail($id);
        $request->update(['status' => 'rejected']);
    }

    public function delete($id)
    {
        MovieRequest::findOrFail($id)->delete();
    }

    #[Layout('components.layouts.dashboard')]
    public function render()
    {
        $requests = MovieRequest::with('user')->latest()->paginate(10);
        return view('livewire.admin.requests.list-requests', compact('requests'));
    }
}
