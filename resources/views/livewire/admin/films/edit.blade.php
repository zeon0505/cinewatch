<div class="h-full overflow-y-auto scrollbar-hide">
    <div class="max-w-6xl mx-auto p-8 pt-0 pb-60">
        <!-- Header Section -->
        <div class="flex items-center gap-8 mb-12 animate-fadeIn">
            <a href="{{ route('admin.films.index') }}" class="w-12 h-12 bg-white/5 border border-white/10 rounded-xl flex items-center justify-center text-white hover:bg-[#E50914] hover:border-transparent transition-all shadow-xl">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h2 class="text-4xl font-black text-white uppercase tracking-tighter logo">CINEWATCH <span class="text-red-600">ENGINE</span></h2>
                <p class="text-gray-500 font-bold text-[10px] uppercase tracking-[4px] mt-2 border-l-2 border-red-600 pl-4">Update Distribusi: {{ $title }}</p>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-500 p-5 rounded-2xl text-[10px] uppercase font-black tracking-widest mb-10 animate-fadeIn">
                <span class="material-symbols-outlined text-[18px] align-middle mr-2">verified</span> {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="update" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Main Info (Left) -->
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-neutral-900/40 backdrop-blur-3xl border border-white/5 p-10 rounded-[24px] shadow-2xl relative group">
                    <div class="flex items-center gap-3 mb-8 border-b border-white/5 pb-6">
                         <span class="material-symbols-outlined text-[#E50914]">description</span>
                         <h3 class="text-xs font-black uppercase text-gray-500 tracking-[3px]">Metadata Utama</h3>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <label class="block text-gray-400 text-[10px] font-black uppercase tracking-[3px] mb-4 ml-1">Judul Film</label>
                            <input wire:model="title" type="text" class="w-full bg-black/40 border border-white/10 rounded-xl p-4 text-white focus:ring-1 focus:ring-[#E50914] focus:bg-white/5 outline-none font-bold placeholder:text-gray-800" />
                            @error('title') <span class="text-red-500 text-[9px] font-bold mt-2 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-gray-400 text-[10px] font-black uppercase tracking-[3px] mb-4 ml-1">Deskripsi Narasi</label>
                            <textarea wire:model="description" rows="5" class="w-full bg-black/40 border border-white/10 rounded-xl p-4 text-white focus:ring-1 focus:ring-[#E50914] focus:bg-white/5 outline-none font-bold placeholder:text-gray-800"></textarea>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div>
                                <label class="block text-gray-400 text-[10px] font-black uppercase tracking-widest mb-4 ml-1">Tahun Rilis</label>
                                <input wire:model="year" type="number" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-1 focus:ring-red-600 focus:bg-white/5 outline-none font-bold text-sm" />
                            </div>
                            <div>
                                <label class="block text-gray-400 text-[10px] font-black uppercase tracking-widest mb-4 ml-1">Durasi (Mnt/Jam)</label>
                                <input wire:model="duration" type="text" placeholder="1h 45m" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-1 focus:ring-red-600 focus:bg-white/5 outline-none font-bold text-sm placeholder:text-gray-800" />
                            </div>
                            <div>
                                <label class="block text-gray-400 text-[10px] font-black uppercase tracking-widest mb-4 ml-1">Skor Rating (0-10)</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-yellow-500 text-[16px]">star</span>
                                    <input wire:model="rating_value" type="number" step="0.1" max="10" class="w-full bg-black/40 border border-white/10 rounded-xl pl-9 pr-3 py-3 text-white focus:ring-1 focus:ring-red-600 focus:bg-white/5 outline-none font-bold text-sm" />
                                </div>
                            </div>
                            <div class="relative transition-all" x-data="{ open: false }" :class="open ? 'z-50' : 'z-10'">
                                <label class="block text-gray-400 text-[10px] font-black uppercase tracking-widest mb-4 ml-1">Batas Umur (Age)</label>
                                <div @click="open = !open" @click.away="open = false" 
                                     class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-2.5 hover:border-white/20 hover:bg-white/5 transition-all cursor-pointer flex justify-between items-center group">
                                     <span class="font-bold text-xs uppercase tracking-wider text-white">
                                        {{ $age_rating ?: 'Pilih...' }}
                                     </span>
                                     <span class="material-symbols-outlined text-gray-500 text-[16px] transition-transform" :class="open ? 'rotate-180 text-white' : 'group-hover:text-white'">expand_more</span>
                                </div>
                                <div x-show="open" x-transition.opacity 
                                     class="absolute top-full left-0 right-0 mt-2 bg-[#0A0A0A] border border-white/10 rounded-xl shadow-[0_30px_60px_rgba(0,0,0,0.8)] z-50 overflow-hidden flex flex-col p-1.5" x-cloak style="display: none;">
                                     @php $ratings = ['SU', '13+', '17+', '21+', 'R', 'PG-13', 'G', 'TV-14', 'TV-MA', 'TV-PG']; @endphp
                                     @foreach($ratings as $val)
                                     <div wire:click="$set('age_rating', '{{ $val }}')" @click="open = false" 
                                          class="px-4 py-2 flex items-center gap-3 rounded-lg text-xs font-bold uppercase tracking-wider cursor-pointer transition-all {{ $age_rating == $val ? 'bg-red-600/10 text-red-500 border-l-[3px] border-red-600' : 'text-gray-400 hover:text-white hover:bg-white/5 border-l-[3px] border-transparent' }}">
                                          <span class="material-symbols-outlined text-[16px] {{ $age_rating == $val ? 'opacity-100' : 'opacity-0' }}">check</span>
                                          {{ $val }}
                                     </div>
                                     @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-neutral-900/40 backdrop-blur-3xl border border-white/5 p-10 rounded-[24px] shadow-2xl">
                    <div class="flex items-center gap-3 mb-8 border-b border-white/5 pb-6">
                         <span class="material-symbols-outlined text-[#E50914]">video_library</span>
                         <h3 class="text-xs font-black uppercase text-gray-500 tracking-[3px]">Media Streaming</h3>
                    </div>
                    <div>
                        <label class="block text-gray-400 text-[10px] font-black uppercase tracking-[3px] mb-4 ml-1">Alamat Sumber Video (URL)</label>
                        <div class="relative">
                            <input wire:model="video_url" type="text" class="w-full bg-black/40 border border-white/10 rounded-xl p-4 pl-12 text-white focus:ring-1 focus:ring-[#E50914] focus:bg-white/5 outline-none font-bold placeholder:text-gray-800" />
                            <span class="material-symbols-outlined absolute left-4 top-4 text-gray-700">link</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar (Right) -->
            <div class="space-y-10">
                <div class="bg-neutral-900/40 backdrop-blur-3xl border border-white/5 p-10 rounded-[24px] shadow-2xl text-center">
                    <div class="flex items-center gap-3 mb-8 border-b border-white/5 pb-6 justify-center">
                         <span class="material-symbols-outlined text-[#E50914]">image</span>
                         <h3 class="text-xs font-black uppercase text-gray-500 tracking-[3px]">Thumbnail</h3>
                    </div>
                    
                    <div class="mb-8 p-3 bg-black/50 border border-white/5 rounded-2xl relative group overflow-hidden">
                        <img src="{{ $thumbnail }}" class="w-full aspect-[2/3] object-cover rounded-xl shadow-2xl opacity-60 group-hover:opacity-100 transition-all group-hover:scale-105" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-80"></div>
                    </div>

                    <div>
                        <label class="block text-gray-400 text-[10px] font-black uppercase tracking-[3px] mb-4">Ubah Alamat Gambar</label>
                        <input wire:model="thumbnail" type="text" class="w-full bg-black/40 border border-white/10 rounded-xl p-4 text-[10px] text-white focus:ring-1 focus:ring-[#E50914] focus:bg-white/5 outline-none font-bold" />
                    </div>
                </div>

                <div class="bg-neutral-900/40 backdrop-blur-3xl border border-white/5 p-10 rounded-[24px] shadow-2xl">
                     <div class="flex items-center gap-3 mb-8 border-b border-white/5 pb-6">
                         <span class="material-symbols-outlined text-red-600">category</span>
                         <h3 class="text-xs font-black uppercase text-gray-500 tracking-[3px]">Genre & Kategori</h3>
                    </div>
                    <div class="grid grid-cols-1 gap-2 max-h-[220px] overflow-y-auto custom-scrollbar p-1">
                        @foreach(\App\Models\Category::all() as $cat)
                        <label class="flex items-center gap-3 p-3 rounded-xl bg-white/[0.02] border border-white/5 hover:bg-white/[0.05] cursor-pointer transition-all group has-[:checked]:bg-red-600/10 has-[:checked]:border-red-600/30">
                            <input type="checkbox" wire:model="selectedCategories" value="{{ $cat->id }}" class="hidden peer">
                            <div class="w-5 h-5 rounded border-2 border-white/10 flex items-center justify-center peer-checked:bg-red-600 peer-checked:border-red-600 transition-all">
                                <span class="material-symbols-outlined text-white text-[14px] scale-0 peer-checked:scale-100 transition-transform">check</span>
                            </div>
                            <span class="text-[11px] font-bold text-gray-400 group-hover:text-white peer-checked:text-white uppercase tracking-wider">{{ $cat->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="bg-neutral-900/40 backdrop-blur-3xl border border-white/5 p-10 rounded-[24px] shadow-2xl relative transition-all" x-data="{ open: false }" :class="open ? 'z-50' : 'z-10'">
                     <div class="flex items-center gap-3 mb-8 border-b border-white/5 pb-6">
                         <span class="material-symbols-outlined text-red-600">collections</span>
                         <h3 class="text-xs font-black uppercase text-gray-500 tracking-[3px]">Koleksi & Series</h3>
                    </div>
                    
                    <div @click="open = !open" @click.away="open = false" 
                         class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 hover:border-white/20 hover:bg-white/5 transition-all cursor-pointer flex justify-between items-center group">
                         <span class="font-bold text-xs uppercase tracking-wider transition-colors {{ $series_id ? 'text-white' : 'text-gray-500' }}">
                            @if($series_id) 
                                {{ collect($series)->where('id', $series_id)->first()->name ?? '-- Tidak Terhubung --' }} 
                            @else 
                                -- Tidak Terhubung Series -- 
                            @endif
                         </span>
                         <span class="material-symbols-outlined text-gray-500 transition-transform" :class="open ? 'rotate-180 text-white' : 'group-hover:text-white'">expand_more</span>
                    </div>

                    <!-- Dropdown Menu -->
                    <div x-show="open" x-transition.opacity 
                         class="absolute top-full left-0 right-0 mt-2 bg-[#0A0A0A] border border-white/10 rounded-xl shadow-[0_30px_60px_rgba(0,0,0,0.8)] z-50 overflow-hidden flex flex-col p-1.5" x-cloak style="display: none;">
                         
                         <div wire:click="$set('series_id', null)" @click="open = false" 
                              class="px-4 py-2.5 flex items-center gap-3 rounded-lg text-xs font-bold uppercase tracking-wider cursor-pointer transition-all {{ !$series_id ? 'bg-red-600/10 text-red-500 border-l-[3px] border-red-600' : 'text-gray-400 hover:text-white hover:bg-white/5 border-l-[3px] border-transparent' }}">
                              <span class="material-symbols-outlined text-[16px] {{ !$series_id ? 'opacity-100' : 'opacity-0' }}">check</span>
                              -- Tidak Terhubung Series --
                         </div>
                         
                         @foreach($series as $s)
                         <div wire:click="$set('series_id', {{ $s->id }})" @click="open = false" 
                              class="px-4 py-2.5 flex items-center gap-3 rounded-lg text-xs font-bold uppercase tracking-wider cursor-pointer transition-all {{ $series_id == $s->id ? 'bg-red-600/10 text-red-500 border-l-[3px] border-red-600' : 'text-gray-400 hover:text-white hover:bg-white/5 border-l-[3px] border-transparent' }}">
                              <span class="material-symbols-outlined text-[16px] {{ $series_id == $s->id ? 'opacity-100' : 'opacity-0' }}">check</span>
                              {{ $s->name }}
                         </div>
                         @endforeach
                    </div>
                </div>

                <div class="bg-neutral-900/40 backdrop-blur-3xl border border-white/5 p-10 rounded-[24px] shadow-2xl">
                    <div class="flex items-center gap-3 mb-8 border-b border-white/5 pb-6">
                         <span class="material-symbols-outlined text-red-600">no_adult_content</span>
                         <h3 class="text-xs font-black uppercase text-gray-500 tracking-[3px]">Target Penonton</h3>
                    </div>
                    <div class="flex flex-col gap-3">
                        <label class="cursor-pointer group flex items-center gap-4 p-4 rounded-2xl bg-white/[0.02] border border-white/5 transition-all group-hover:bg-white/[0.05] has-[:checked]:bg-red-600/10 has-[:checked]:border-red-600/50">
                            <input type="radio" wire:model="audience_type" value="adult" class="hidden">
                            <span class="material-symbols-outlined text-gray-500 group-has-[:checked]:text-red-500 transition-colors">no_adult_content</span>
                            <p class="text-[10px] font-black uppercase text-gray-400 group-has-[:checked]:text-white">DEWASA (ADULT)</p>
                        </label>
                        <label class="cursor-pointer group flex items-center gap-4 p-4 rounded-2xl bg-white/[0.02] border border-white/5 transition-all group-hover:bg-white/[0.05] has-[:checked]:bg-yellow-500/10 has-[:checked]:border-yellow-500/50">
                            <input type="radio" wire:model="audience_type" value="kids" class="hidden">
                            <span class="material-symbols-outlined text-gray-500 group-has-[:checked]:text-yellow-500 transition-colors">child_care</span>
                            <p class="text-[10px] font-black uppercase text-gray-400 group-has-[:checked]:text-white">ANAK (KIDS)</p>
                        </label>
                    </div>
                </div>

                <div class="space-y-4">
                    <button type="submit" class="w-full bg-[#E50914] text-white py-5 rounded-xl font-black uppercase text-[11px] tracking-[4px] shadow-[0_15px_35px_rgba(229,9,20,0.3)] hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                        <span class="material-symbols-outlined">save</span> Perbarui Data
                    </button>
                    <p class="text-center text-[9px] text-gray-700 font-bold uppercase tracking-[3px] italic">Terakhir diperbarui: {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                </div>
            </div>
        </form>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .animate-fadeIn { animation: fadeIn 0.4s ease-out; }
    </style>
</div>
