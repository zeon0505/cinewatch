<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center gap-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="w-10 h-10 flex items-center justify-center rounded-xl border border-white/5 bg-white/[0.02] text-gray-700 cursor-not-allowed">
                    <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                </span>
            @else
                <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev" class="w-10 h-10 flex items-center justify-center rounded-xl border border-white/5 bg-white/[0.03] text-gray-400 hover:border-[#E50914] hover:text-white hover:bg-[#E50914]/10 transition-all group">
                    <span class="material-symbols-outlined text-[18px] group-hover:-translate-x-0.5 transition-transform">chevron_left</span>
                </button>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="w-10 h-10 flex items-center justify-center text-gray-600 font-black text-[10px]">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-[#E50914] text-white font-black text-[11px] border border-[#E50914] shadow-[0_0_20px_rgba(229,9,20,0.3)] z-10">
                                {{ $page }}
                            </span>
                        @else
                            <button wire:click="gotoPage({{ $page }})" class="w-10 h-10 flex items-center justify-center rounded-xl border border-white/5 bg-white/[0.03] text-gray-400 font-black text-[10px] hover:border-[#E50914] hover:text-white hover:bg-[#E50914]/10 transition-all">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" wire:loading.attr="disabled" rel="next" class="w-10 h-10 flex items-center justify-center rounded-xl border border-white/5 bg-white/[0.03] text-gray-400 hover:border-[#E50914] hover:text-white hover:bg-[#E50914]/10 transition-all group">
                    <span class="material-symbols-outlined text-[18px] group-hover:translate-x-0.5 transition-transform">chevron_right</span>
                </button>
            @else
                <span class="w-10 h-10 flex items-center justify-center rounded-xl border border-white/5 bg-white/[0.02] text-gray-700 cursor-not-allowed">
                    <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                </span>
            @endif
        </nav>
    @endif
</div>
