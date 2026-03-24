<?php

use Livewire\Volt\Component;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $movieId;
    public $isAdded = false;
    public $showText = true;

    public function mount($movieId, $showText = true)
    {
        $this->movieId = $movieId;
        $this->showText = $showText;
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
        <div class="{{ $showText ? 'w-12 h-12' : 'w-10 h-10' }} bg-red-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-red-600/20 group-hover:scale-110 active:scale-95 transition-all">
            <span class="material-symbols-outlined fill-1 {{ $showText ? '' : 'text-[20px]' }}">bookmark</span>
        </div>
    @else
        <div class="{{ $showText ? 'w-12 h-12' : 'w-10 h-10' }} bg-white/5 border border-white/10 text-white rounded-2xl flex items-center justify-center hover:bg-white/10 group-hover:scale-110 active:scale-95 transition-all">
            <span class="material-symbols-outlined {{ $showText ? '' : 'text-[20px]' }}">bookmark_add</span>
        </div>
    @endif
    
    @if($showText)
        <div class="flex flex-col items-start translate-y-[1px]">
            <span class="text-[9px] font-black uppercase tracking-[2px] text-white/30 group-hover:text-red-500 transition-colors leading-none mb-1">Watchlist</span>
            <span class="text-[11px] font-black text-white uppercase leading-none">{{ $isAdded ? 'Saved' : 'Save It' }}</span>
        </div>
    @endif
</button>