<?php

use Livewire\Volt\Component;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $movieId;
    public $isAdded = false;

    public function mount($movieId)
    {
        $this->movieId = $movieId;
        if (Auth::check()) {
            $this->isAdded = Auth::user()->watchlists()->where('movie_id', $this->movieId)->exists();
        }
    }

    public function toggle()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->isAdded) {
            Auth::user()->watchlists()->where('movie_id', $this->movieId)->delete();
            $this->isAdded = false;
        } else {
            Watchlist::create([
                'user_id' => Auth::id(),
                'movie_id' => $this->movieId
            ]);
            $this->isAdded = true;
        }

        $this->dispatch('notif', message: $this->isAdded ? 'Berhasil ditambahkan ke Watchlist' : 'Berhasil dihapus dari Watchlist');
    }
};
?>

<button 
    wire:click="toggle" 
    class="flex items-center gap-2 group transition-all"
    title="{{ $isAdded ? 'Hapus dari Watchlist' : 'Tambah ke Watchlist' }}"
>
    @if($isAdded)
        <div class="w-12 h-12 bg-red-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-red-600/20 group-hover:scale-105 active:scale-95 transition-all">
            <span class="material-symbols-outlined fill-1">bookmark</span>
        </div>
    @else
        <div class="w-12 h-12 bg-white/5 border border-white/10 text-white rounded-2xl flex items-center justify-center hover:bg-white/10 group-hover:scale-105 active:scale-95 transition-all">
            <span class="material-symbols-outlined">bookmark_add</span>
        </div>
    @endif
    <div class="flex flex-col items-start">
        <span class="text-[10px] font-black uppercase tracking-widest text-gray-500 group-hover:text-gray-300">Watchlist</span>
        <span class="text-xs font-bold text-white uppercase">{{ $isAdded ? 'Tersimpan' : 'Simpan' }}</span>
    </div>
</button>