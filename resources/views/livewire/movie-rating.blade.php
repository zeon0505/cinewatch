<div class="mt-8 border-t border-white/5 pt-8">
    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-4">Berikan Rating Kamu</h3>
    
    @if (session()->has('rating_message'))
        <div class="text-green-500 text-xs mb-3 font-bold">{{ session('rating_message') }}</div>
    @endif

    <div class="flex items-center gap-1">
        @for($i=1; $i<=5; $i++)
            <button wire:click="setRating({{ $i }})" class="focus:outline-none transition-transform hover:scale-125">
                <svg width="24" height="24" fill="{{ $i <= $rating ? '#F5C518' : 'none' }}" stroke="{{ $i <= $rating ? '#F5C518' : '#808080' }}" stroke-width="2" viewBox="0 0 24 24">
                     <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
            </button>
        @endfor
    </div>
    
    <p class="text-[10px] text-gray-600 mt-2 italic font-bold">Pilih bintang untuk memberikan nilai pada film ini</p>
</div>
