<div class="px-6 py-8">
    <div class="mb-10">
        <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Pengaturan Terminal</h2>
        <p class="text-gray-500 mt-1 uppercase text-[10px] font-bold tracking-widest italic">Kustomisasi identitas dan fungsionalitas utama platform</p>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-600/20 border border-green-600/20 text-green-500 px-4 py-3 rounded-lg mb-6 text-xs font-bold animate-popIn">
            {{ session('message') }}
        </div>
    @endif

    <div class="card p-10 max-w-4xl space-y-10">
        <form wire:submit.prevent="save" class="space-y-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div>
                    <label class="block text-gray-500 text-[10px] font-black uppercase tracking-widest mb-2">Nama Website</label>
                    <input type="text" wire:model="site_name" class="w-full bg-black/40 border border-white/5 rounded-xl p-3.5 text-white focus:ring-2 focus:ring-red-600 outline-none text-sm placeholder:text-gray-700" />
                </div>
                <div>
                     <label class="block text-gray-500 text-[10px] font-black uppercase tracking-widest mb-2">Judul SEO / Slogan</label>
                     <input type="text" wire:model="site_description" class="w-full bg-black/40 border border-white/5 rounded-xl p-3.5 text-white focus:ring-2 focus:ring-red-600 outline-none text-sm placeholder:text-gray-700" />
                </div>
            </div>

            <div class="border-t border-white/5 pt-10">
                 <h3 class="text-lg font-black text-white uppercase tracking-widest mb-6 border-b border-white/5 pb-4">Mode & Keamanan</h3>
                 <div class="flex items-center justify-between p-6 bg-red-600/5 rounded-2xl border border-red-600/10">
                      <div>
                           <p class="font-black text-white uppercase tracking-tight">Maintenance Mode</p>
                           <p class="text-[10px] text-red-500 font-bold uppercase tracking-widest mt-1 italic">Mengunci akses user ke website secara total.</p>
                      </div>
                      <label class="relative inline-flex items-center cursor-pointer">
                           <input type="checkbox" wire:model="maintenance_mode" class="sr-only peer">
                           <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600 shadow-xl"></div>
                      </label>
                 </div>
            </div>

            <div class="border-t border-white/5 pt-10">
                 <h3 class="text-lg font-black text-white uppercase tracking-widest mb-6 border-b border-white/5 pb-4">Hero Slider</h3>
                 <div>
                      <label class="block text-gray-500 text-[10px] font-black uppercase tracking-widest mb-2">Featured Films (Maksimal 3 direkomendasikan)</label>
                      <select multiple wire:model="featured_film_ids" class="w-full bg-black/40 border border-white/5 rounded-xl p-3.5 text-white focus:ring-2 focus:ring-red-600 outline-none text-sm h-48">
                          @foreach($movies as $movie)
                              <option value="{{ $movie->id }}" class="bg-[#0D0D0D] text-white">{{ $movie->title }}</option>
                          @endforeach
                      </select>
                      <p class="text-gray-500 mt-2 text-[10px] italic">Tahan tombol Ctrl (Windows) atau Cmd (Mac) untuk memilih lebih dari satu.</p>
                 </div>
            </div>

            <div class="flex justify-end pt-10 border-t border-white/5">
                 <button type="submit" class="px-14 py-4 bg-white hover:bg-red-600 hover:text-white text-black rounded-xl font-black text-xs uppercase tracking-widest shadow-2xl transition-all active:scale-95">Simpan Konfigurasi</button>
            </div>
        </form>
    </div>
</div>
