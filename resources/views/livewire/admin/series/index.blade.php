<div class="space-y-10">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-white uppercase tracking-tighter">Series & Koleksi</h1>
            <p class="text-[10px] text-gray-500 mt-1 uppercase font-bold tracking-widest italic tracking-widest leading-relaxed line-clamp-2 truncate">Atur koleksi berseri agar mudah dicari (cth: Boboiboy Series, Kartun).</p>
        </div>
        <button wire:click="openModal" class="btn-red px-10 py-3.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold transition-all shadow-xl shadow-red-900/20 uppercase tracking-widest text-[11px]">
            + Tambah Series
        </button>
    </div>

    <!-- Table -->
    <div class="bg-neutral-900/40 backdrop-blur-3xl border border-white/5 rounded-[28px] overflow-hidden shadow-2xl animate-fadeIn relative z-10">
        <table class="w-full text-left border-collapse">
            <thead class="bg-white/[0.02] text-[10px] text-gray-400 uppercase font-black tracking-[3px] border-b border-white/5">
                <tr>
                    <th class="p-8">Nama Series/Koleksi</th>
                    <th class="p-8">Slug System</th>
                    <th class="p-8">Statistik Konten</th>
                    <th class="p-8 text-right">Manajemen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($series as $s)
                    <tr class="hover:bg-white/[0.03] transition-all group">
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="text-white font-black text-xl tracking-tighter">{{ $s->name }}</span>
                                <span class="text-[9px] text-gray-600 font-bold uppercase tracking-widest mt-1">ID Series: {{ $s->id }}</span>
                            </div>
                        </td>
                        <td class="p-8">
                            <span class="px-4 py-1.5 bg-black/40 text-blue-500 text-[10px] font-black uppercase tracking-widest rounded-lg border border-blue-500/20 shadow-lg">
                                {{ $s->slug }}
                            </span>
                        </td>
                        <td class="p-8">
                             <div class="inline-flex items-center gap-3 px-4 py-2 bg-white/5 rounded-2xl border border-white/5">
                                  <span class="text-white font-black text-base">{{ $s->movies_count }}</span>
                                  <span class="text-gray-500 text-[9px] font-black uppercase tracking-widest leading-none border-l border-white/10 pl-3">Film<br>Terarsip</span>
                             </div>
                        </td>
                        <td class="p-8 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <button wire:click="edit({{ $s->id }})" class="w-10 h-10 flex items-center justify-center bg-blue-600/10 text-blue-500 hover:bg-blue-600 hover:text-white rounded-xl transition-all shadow-lg active:scale-95 group/btn">
                                    <span class="material-symbols-outlined text-[20px]">edit_note</span>
                                </button>
                                <button onclick="confirm('Yakin ingin menghapus?') || event.stopImmediatePropagation()" wire:click="delete({{ $s->id }})" class="w-10 h-10 flex items-center justify-center bg-red-600/10 text-red-500 hover:bg-red-600 hover:text-white rounded-xl transition-all shadow-lg active:scale-95 group/btn">
                                    <span class="material-symbols-outlined text-[20px]">delete_forever</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 animate-popIn">
            <div class="card w-full max-w-md p-10 space-y-8 bg-[#0D0D0D] border-white/10 shadow-2xl">
                <div class="flex items-center justify-between border-b border-white/5 pb-6">
                    <h1 class="text-2xl font-black text-white uppercase tracking-tighter">Konfigurasi Series</h1>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-white transition-colors">✕</button>
                </div>
                
                <form wire:submit.prevent="save" class="space-y-6">
                    <div>
                        <label class="block text-gray-500 text-[10px] font-black uppercase tracking-widest mb-2">Nama Series / Koleksi</label>
                        <input type="text" wire:model="name" placeholder="Contoh: Tokusatsu Series" class="w-full bg-black/40 border border-white/5 rounded-xl p-3.5 text-white focus:ring-2 focus:ring-red-600 outline-none text-sm placeholder:text-gray-700" />
                        @error('name') <span class="text-red-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                    </div>

                    <p class="text-[10px] text-gray-700 font-bold uppercase tracking-widest leading-relaxed italic">*Slug otomatis digenerate.</p>

                    <div class="pt-4 border-t border-white/5 flex gap-4">
                        <button type="submit" class="flex-1 px-8 py-3.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-black text-sm uppercase tracking-widest shadow-xl shadow-red-900/20 transition-all">Simpan Data</button>
                        <button type="button" wire:click="closeModal" class="px-8 py-3.5 bg-white/5 hover:bg-white/10 text-gray-500 hover:text-white rounded-xl font-bold text-xs uppercase tracking-widest transition-all">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
