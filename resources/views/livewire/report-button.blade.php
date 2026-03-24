<div x-data="{ open: false }" @report-submitted.window="open = false">
    <button @click="open = true" class="text-xs text-gray-500 hover:text-white flex items-center gap-1 transition-colors">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        Lapor Masalah
    </button>

    <!-- Modal -->
    <div x-show="open" 
         class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        
        <div @click.away="open = false" class="bg-zinc-900 border border-white/10 p-6 rounded-xl w-full max-w-md shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold uppercase tracking-tight" style="font-family:'Bebas Neue',sans-serif">Lapor Masalah</h3>
                <button @click="open = false" class="text-gray-500 hover:text-white">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Jenis Masalah</label>
                    <select wire:model="type" class="w-full bg-zinc-800 border border-white/10 rounded p-2 text-sm text-white focus:outline-none focus:border-red-600">
                        <option value="link_mati">Link Mati / Video Tidak Putar</option>
                        <option value="subtitle_rusak">Subtitle Kosong / Error</option>
                        <option value="audio_rusak">Audio Bermasalah</option>
                        <option value="lainnya">Masalah Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Keterangan (Opsional)</label>
                    <textarea wire:model="description" rows="3" class="w-full bg-zinc-800 border border-white/10 rounded p-2 text-sm text-white focus:outline-none focus:border-red-600 resize-none" placeholder="Jelaskan kendala Anda..."></textarea>
                    @error('description') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full btn-red py-2 rounded font-bold uppercase tracking-widest text-xs flex justify-center items-center gap-2">
                         <span wire:loading.remove>Kirim Laporan</span>
                         <span wire:loading>Mengirim...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($successMessage)
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="fixed bottom-10 right-10 bg-green-600 text-white px-6 py-3 rounded-lg shadow-2xl z-[300] flex items-center gap-3 transition-all">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
            <span class="text-sm font-bold">{{ $successMessage }}</span>
        </div>
    @endif
</div>
