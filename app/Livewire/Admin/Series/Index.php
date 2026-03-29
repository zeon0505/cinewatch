<?php

namespace App\Livewire\Admin\Series;

use Livewire\Component;
use App\Models\Series;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

class Index extends Component
{
    public $name, $series_id;
    public $isModalOpen = false;

    #[Layout('admin.dashboard-layout')]
    public function render()
    {
        $series = Series::withCount('movies')->latest()->get();
        return view('livewire.admin.series.index', compact('series'));
    }

    public function openModal() { $this->isModalOpen = true; }
    public function closeModal() { $this->isModalOpen = false; $this->resetInput(); }
    private function resetInput() { $this->name = ''; $this->series_id = ''; }

    public function save()
    {
        $this->validate(['name' => 'required|unique:series,name,' . $this->series_id]);
        
        Series::updateOrCreate(['id' => $this->series_id], [
            'name' => $this->name,
            'slug' => Str::slug($this->name)
        ]);
        
        session()->flash('message', $this->series_id ? 'Series diperbarui.' : 'Series ditambah.');
        $this->isModalOpen = false;
        $this->resetInput();
    }

    public function edit($id)
    {
        $cat = Series::findOrFail($id);
        $this->series_id = $id;
        $this->name = $cat->name;
        $this->openModal();
    }

    public function delete($id)
    {
        Series::find($id)->delete();
        session()->flash('message', 'Series dihapus.');
    }
}
