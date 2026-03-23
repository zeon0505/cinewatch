<?php

namespace App\Livewire\Admin\Genres;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

class Index extends Component
{
    public $name, $category_id;
    public $isModalOpen = false; // Match view's variable name

    #[Layout('admin.dashboard-layout')]
    public function render()
    {
        // Get genres with movie counts to match the premium view
        $genres = Category::withCount('movies')->latest()->get();
        return view('livewire.admin.genres.index', compact('genres'));
    }

    public function openModal() { $this->isModalOpen = true; }
    public function closeModal() { $this->isModalOpen = false; $this->resetInput(); }
    private function resetInput() { $this->name = ''; $this->category_id = ''; }

    public function save() // Match view's method name 'save'
    {
        $this->validate(['name' => 'required|unique:categories,name,' . $this->category_id]);
        
        Category::updateOrCreate(['id' => $this->category_id], [
            'name' => $this->name,
            'slug' => Str::slug($this->name)
        ]);
        
        session()->flash('message', $this->category_id ? 'Kategori diperbarui.' : 'Kategori ditambah.');
        $this->isModalOpen = false;
        $this->resetInput();
    }

    public function edit($id)
    {
        $cat = Category::findOrFail($id);
        $this->category_id = $id;
        $this->name = $cat->name;
        $this->openModal();
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        session()->flash('message', 'Kategori dihapus.');
    }
}
