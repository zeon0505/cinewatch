<div class="space-y-10">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-white uppercase tracking-tighter">Rating & Ulasan</h1>
            <p class="text-[10px] text-gray-500 mt-1 uppercase font-bold tracking-widest italic tracking-widest leading-relaxed line-clamp-2 truncate">Atur ketersediaan dan reputasi film di platform.</p>
        </div>
    </div>

    <!-- Review Table -->
    <div class="card overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-white/5 text-[10px] text-gray-500 uppercase font-bold tracking-[2px] border-b border-white/5">
                <tr>
                    <th class="p-6">Informasi Member</th>
                    <th class="p-6">Judul Movie</th>
                    <th class="p-6">Penilaian (Bintang)</th>
                    <th class="p-6">Waktu Rating</th>
                    <th class="p-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($reviews as $review)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ $review->user->name }}&background=E50914&color=fff" class="w-10 h-10 rounded-full border border-white/5 shadow-2xl" />
                                <div>
                                    <h3 class="text-white font-bold text-sm uppercase tracking-tight">{{ $review->user->name }}</h3>
                                    <p class="text-gray-600 text-xs italic line-clamp-2 truncate">Member Silver</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-6">
                             <div class="flex items-center gap-4">
                                  <img src="{{ $review->movie->thumbnail }}" class="w-12 h-16 object-cover rounded shadow-2xl transition-transform group-hover:scale-110" />
                                  <div>
                                       <h3 class="text-white font-bold text-sm uppercase tracking-tight">{{ $review->movie->title }}</h3>
                                       <p class="text-gray-600 text-xs italic line-clamp-2 truncate">{{ $review->movie->category->name }}</p>
                                  </div>
                             </div>
                        </td>
                        <td class="p-6">
                             <div class="flex items-center gap-1">
                                  @for($i=1; $i<=5; $i++)
                                       <span class="{{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-700' }} text-xs">★</span>
                                  @endfor
                                  <span class="text-white font-black text-xs ml-2">{{ $review->rating }}.0</span>
                             </div>
                        </td>
                        <td class="p-6">
                             <span class="text-gray-700 text-[10px] font-bold uppercase tracking-widest italic tracking-tighter">{{ $review->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="p-6 text-right">
                             <div class="flex items-center justify-end gap-3">
                                  <button onclick="confirm('Yakin ingin menghapus rating ini?') || event.stopImmediatePropagation()" wire:click="delete({{ $review->id }})" class="p-2.5 bg-red-600/10 text-red-500 hover:bg-red-600 hover:text-white rounded-lg transition-all">🗑️</button>
                             </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-6">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
