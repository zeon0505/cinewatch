<div class="pt-24 min-h-screen bg-black text-white px-6 md:px-16 container mx-auto max-w-4xl">
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-black mb-4 uppercase tracking-tight" style="font-family:'Bebas Neue',sans-serif">Request Film</h1>
        <p class="text-gray-400">Film yang Anda cari tidak ada? Beritahu kami dan kami akan berusaha menyediakannya untuk Anda.</p>
    </div>

    @if($successMessage)
        <div class="bg-green-600/20 border border-green-500 text-green-400 p-4 rounded-lg mb-8 flex items-center gap-3">
             <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
             <span>{{ $successMessage }}</span>
        </div>
    @endif

    <div class="bg-zinc-900/50 p-8 rounded-xl border border-white/5 shadow-2xl backdrop-blur-sm">
        <form wire:submit.prevent="submit" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Judul Film <span class="text-red-500">*</span></label>
                <input type="text" wire:model="title" class="w-full bg-zinc-800 border border-white/10 rounded-lg p-3 text-white focus:outline-none focus:border-red-600 transition-colors" placeholder="Contoh: Avengers: Endgame">
                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Tahun Rilis (Opsional)</label>
                <input type="text" wire:model="year" class="w-full bg-zinc-800 border border-white/10 rounded-lg p-3 text-white focus:outline-none focus:border-red-600 transition-colors" placeholder="Contoh: 2019">
                @error('year') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Pesan atau Keterangan Tambahan (Opsional)</label>
                <textarea wire:model="description" rows="4" class="w-full bg-zinc-800 border border-white/10 rounded-lg p-3 text-white focus:outline-none focus:border-red-600 transition-colors resize-none" placeholder="Tuliskan info tambahan jika ada, misalnya versi atau link referensi..."></textarea>
                @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition-all transform active:scale-95 flex justify-center items-center gap-2">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Kirim Request
                </button>
            </div>
        </form>
    </div>

    <div class="mt-12">
        <h2 class="text-xl font-bold mb-6 flex items-center gap-3">
             <div class="w-1 h-6 bg-red-600 rounded"></div>
             Request Saya Baru-Baru Ini
        </h2>
        
        @php
            $myRequests = \App\Models\MovieRequest::where('user_id', auth()->id())->latest()->take(5)->get();
        @endphp

        @if($myRequests->count() > 0)
            <div class="space-y-4">
                @foreach($myRequests as $req)
                    <div class="flex items-center justify-between p-4 bg-zinc-900 border border-white/5 rounded-lg">
                        <div>
                            <h3 class="font-bold">{{ $req->title }} @if($req->year) <span class="text-gray-500 font-normal">({{ $req->year }})</span> @endif</h3>
                            <p class="text-xs text-gray-500">{{ $req->created_at->diffForHumans() }}</p>
                        </div>
                        <div>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-600/20 text-yellow-500',
                                    'processed' => 'bg-green-600/20 text-green-500',
                                    'rejected' => 'bg-red-600/20 text-red-500',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] uppercase font-bold {{ $statusColors[$req->status] }}">
                                {{ $req->status }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 italic text-sm">Belum ada request film yang dikirim.</p>
        @endif
    </div>
</div>
