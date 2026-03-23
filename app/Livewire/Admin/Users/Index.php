<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin') return; // Cannot suspend admin

        $user->status = $user->status === 'active' ? 'suspended' : 'active';
        $user->save();

        session()->flash('message', 'Status user berhasil diperbarui.');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin') return;

        $user->delete();
        session()->flash('message', 'User berhasil dihapus.');
    }

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.users.index', compact('users'))
            ->layout('admin.dashboard-layout');
    }
}
