<div class="h-full overflow-y-auto scrollbar-hide">
    <div class="max-w-full p-4 md:p-8 pt-0 pb-60">
        <!-- Header Section -->
        <div class="flex items-center gap-8 mb-12 animate-fadeIn">
            <a href="{{ route('admin.films.index') }}" class="w-12 h-12 bg-white/5 border border-white/10 rounded-xl flex items-center justify-center text-white hover:bg-[#E50914] transition-all shadow-xl">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div class="mb-10 animate-fadeInLeft">
            <h2 class="text-4xl font-black text-white uppercase tracking-tighter leading-none logo">CINEWATCH <span class="text-red-600">ENGINE</span></h2>
            <p class="text-gray-500 font-bold text-[10px] uppercase tracking-[4px] mt-2 border-l-2 border-red-600 pl-4">Pusat Distribusi & Pengelolaan Konten Digital</p>
        </div>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-500 p-5 rounded-2xl text-[10px] uppercase font-black tracking-widest mb-10 animate-fadeIn">
                <span class="material-symbols-outlined text-[18px] align-middle mr-2">verified_user</span> {{ session('message') }}
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="bg-red-500/10 border border-red-500/20 text-red-500 p-5 rounded-2xl text-[10px] uppercase font-black tracking-widest mb-10 animate-fadeIn">
                <span class="material-symbols-outlined text-[18px] align-middle mr-2">warning</span> {{ session('error') }}
            </div>
        @endif

        <!-- NEW PROFESSIONAL SEARCH ENGINE (V4.1) -->
        <div class="mb-16 relative z-[100]" x-data="{ query: '' }">
            <div class="bg-neutral-900/40 backdrop-blur-3xl border border-white/5 p-1 rounded-[32px] shadow-2xl overflow-hidden">
                <div class="flex items-center p-2 gap-2">
                    <div class="flex-1 relative">
                        <span class="material-symbols-outlined absolute left-6 top-1/2 -translate-y-1/2 text-gray-500 text-2xl">search</span>
                        <input
                            x-model="query"
                            @keydown.enter="$wire.executeSearch(query)"
                            type="text"
                            placeholder="Cari judul film untuk auto-fill data..."
                            class="w-full bg-white/5 border-none rounded-2xl pl-16 pr-8 py-5 text-white text-lg font-medium outline-none focus:ring-2 focus:ring-red-600/50 transition-all placeholder:text-gray-600"
                        />
                    </div>
                    <button type="button" 
                        @click="$wire.executeSearch(query)"
                        class="bg-red-600 hover:bg-red-700 text-white px-10 py-5 rounded-2xl font-black text-sm uppercase transition-all shadow-xl shadow-red-900/20 active:scale-95 flex items-center gap-3">
                        <span>TEMUKAN</span>
                        <div wire:loading wire:target="executeSearch" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                    </button>
                </div>
            </div>

            <!-- FLOATING RESULTS PANEL -->
            @if(count($searchResults) > 0)
            <div class="absolute top-full left-0 right-0 mt-4 bg-[#0D0D0D] border border-white/10 rounded-[28px] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.8)] overflow-hidden animate-fadeInUp">
                <div class="p-6 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
                    <h4 class="text-gray-400 font-black text-[10px] uppercase tracking-[3px]">Hasil Pencarian Intelijen</h4>
                    <span class="text-[10px] bg-red-600/10 text-red-500 px-3 py-1 rounded-full font-black uppercase">{{ count($searchResults) }} Data Meluncur</span>
                </div>
                
                <div class="max-h-[480px] overflow-y-auto custom-scrollbar p-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($searchResults as $index => $item)
                    <div wire:click="selectItem({{ $index }})" 
                         class="flex items-center gap-5 p-4 rounded-2xl bg-white/[0.03] hover:bg-white/[0.08] border border-white/5 hover:border-white/10 cursor-pointer transition-all group active:scale-[0.98]">
                        <div class="w-14 h-20 bg-neutral-800 rounded-xl overflow-hidden shrink-0 shadow-2xl group-hover:scale-105 transition-transform">
                            @if($item['poster'])
                                <img src="{{ $item['poster'] }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-700">
                                    <span class="material-symbols-outlined">image</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-white font-black text-sm uppercase truncate group-hover:text-red-500 transition-colors">{{ $item['title'] }}</h4>
                            <div class="flex items-center gap-3 mt-1.5">
                                <span class="text-red-500 font-black text-[10px] uppercase tracking-widest">{{ $item['year'] }}</span>
                                <span class="px-2 py-0.5 bg-white/5 rounded text-[8px] text-gray-500 font-black uppercase tracking-widest">{{ $item['type'] }}</span>
                            </div>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-gray-500 group-hover:bg-red-600 group-hover:text-white transition-all">
                            <span class="material-symbols-outlined text-sm">add</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="p-4 bg-white/[0.01] border-t border-white/5 text-center">
                    <p class="text-[9px] text-gray-600 font-bold uppercase tracking-[2px]">Klik data untuk auto-fill formulir di bawah ini</p>
                </div>
            </div>
            @endif

            <!-- EMPTY STATE -->
            @if($showResults && count($searchResults) === 0)
            <div class="absolute top-full left-0 right-0 mt-4 bg-red-600/10 border border-red-600/20 p-10 rounded-[28px] text-center animate-shake">
                <span class="material-symbols-outlined text-red-500 text-5xl mb-3">error_meditation</span>
                <h3 class="text-white font-black text-lg uppercase tracking-tight">Data Tidak Terdeteksi</h3>
                <p class="text-red-500/60 font-bold text-[10px] uppercase tracking-widest mt-1">Gunakan judul bahasa Inggris atau periksa ejaan Anda.</p>
            </div>
            @endif
        </div>
        <form wire:submit.prevent="store" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Info (Left) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="relative transition-all" x-data="{ open: false }" :class="open ? 'z-[100]' : 'z-10'">
                    <div class="absolute inset-0 bg-neutral-900/40 backdrop-blur-3xl border border-white/5 rounded-[28px] shadow-2xl pointer-events-none"></div>
                    <div class="relative p-6">
                    <div class="flex items-center gap-3 mb-8 border-b border-white/5 pb-6">
                         <span class="material-symbols-outlined text-[#E50914]">description</span>
                         <h3 class="text-xs font-black uppercase text-gray-400 tracking-[3px]">Metadata Utama</h3>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <label class="block text-gray-500 text-[10px] font-black uppercase tracking-[3px] mb-4 ml-1">Judul Film</label>
                            <input wire:model="title" type="text" placeholder="Masukkan judul..." class="w-full bg-black/40 border border-white/10 rounded-xl p-3.5 text-white focus:ring-1 focus:ring-[#E50914] outline-none font-bold" />
                            @error('title') <span class="text-red-500 text-[9px] font-bold mt-2 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-gray-500 text-[10px] font-black uppercase tracking-[3px] mb-4 ml-1">Deskripsi Narasi</label>
                            <textarea wire:model="description" rows="4" placeholder="Alur cerita singkat..." class="w-full bg-black/40 border border-white/10 rounded-xl p-3.5 text-white focus:ring-1 focus:ring-[#E50914] outline-none font-bold"></textarea>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black uppercase tracking-widest mb-4 ml-1">Tahun Rilis</label>
                                <input wire:model="year" type="number" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-1 focus:ring-red-600 focus:bg-white/5 outline-none font-bold text-sm" />
                            </div>
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black uppercase tracking-widest mb-4 ml-1">Durasi (Mnt/Jam)</label>
                                <input wire:model="duration" type="text" placeholder="Contoh: 1h 45m" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-1 focus:ring-red-600 focus:bg-white/5 outline-none font-bold text-sm" />
                            </div>
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black uppercase tracking-widest mb-4 ml-1">Skor Rating (0-10)</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-yellow-500 text-[16px]">star</span>
                                    <input wire:model="rating_value" type="number" step="0.1" max="10" class="w-full bg-black/40 border border-white/10 rounded-xl pl-9 pr-3 py-3 text-white focus:ring-1 focus:ring-red-600 focus:bg-white/5 outline-none font-bold text-sm" />
                                </div>
                            </div>
                            <div class="relative transition-all">
                                <label class="block text-gray-500 text-[10px] font-black uppercase tracking-widest mb-4 ml-1">Batas Umur (Age)</label>
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

                <div class="bg-neutral-900/40 backdrop-blur-3xl border border-white/5 p-6 rounded-[28px] shadow-2xl">
                    <div class="flex items-center gap-3 mb-8 border-b border-white/5 pb-6">
                         <span class="material-symbols-outlined text-[#E50914]">play_circle</span>
                         <h3 class="text-xs font-black uppercase text-gray-400 tracking-[3px]">Media & Stream</h3>
                    </div>
                    <div>
                        <label class="block text-gray-500 text-[10px] font-black uppercase tracking-[3px] mb-4 ml-1">Source Video URL (Embed/Direct)</label>
                        <input wire:model="video_url" type="text" placeholder="https://..." class="w-full bg-black/40 border border-white/10 rounded-xl p-3.5 text-white focus:ring-1 focus:ring-[#E50914] outline-none font-bold" />
                        <p class="text-[8px] text-gray-700 uppercase font-bold mt-2 tracking-widest italic leading-relaxed">Peringatan: Gunakan URL yang diizinkan untuk iframe/embed agar player berfungsi.</p>
                    </div>
                </div>
            </div>

            <!-- Sidebar (Right) -->
            <div class="space-y-6">
                <div class="bg-neutral-900/40 backdrop-blur-3xl border border-white/5 p-10 rounded-[28px] shadow-2xl" x-data="{ uploadType: 'file' }">
                    <div class="flex items-center gap-3 mb-8 border-b border-white/5 pb-6 justify-center">
                         <span class="material-symbols-outlined text-[#E50914]">image</span>
                         <h3 class="text-xs font-black uppercase text-gray-400 tracking-[3px]">Visual Poster</h3>
                    </div>
                    
                    <div class="flex justify-center mb-8 gap-4">
                        <button type="button" @click="uploadType = 'file'" :class="uploadType === 'file' ? 'bg-[#E50914] text-white' : 'bg-white/5 text-gray-500'" class="px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all">UPLOAD FILE</button>
                        <button type="button" @click="uploadType = 'url'" :class="uploadType === 'url' ? 'bg-[#E50914] text-white' : 'bg-white/5 text-gray-500'" class="px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all">URL LINK</button>
                    </div>

                    <div class="mb-8 aspect-[2/3] bg-black/40 border-2 border-dashed border-white/5 rounded-2xl flex flex-col items-center justify-center text-gray-700 relative overflow-hidden group">
                        @if($posterFile)
                            <img src="{{ $posterFile->temporaryUrl() }}" class="w-full h-full object-cover rounded-xl" />
                        @elseif($thumbnail)
                            <img src="{{ $thumbnail }}" class="w-full h-full object-cover rounded-xl" />
                        @else
                            <span class="material-symbols-outlined text-5xl mb-2">image_not_supported</span>
                            <p class="text-[10px] font-black uppercase tracking-widest">No Poster Selected</p>
                        @endif
                        <div wire:loading wire:target="posterFile" class="absolute inset-0 bg-black/80 flex items-center justify-center">
                            <span class="animate-spin material-symbols-outlined text-red-500 text-4xl">sync</span>
                        </div>
                    </div>

                    <div x-show="uploadType === 'file'" class="animate-fadeIn">
                        <label class="relative cursor-pointer block">
                            <div class="w-full bg-[#E50914]/10 border border-[#E50914]/30 rounded-xl p-4 text-center hover:bg-[#E50914]/20 transition-all">
                                <span class="text-[#E50914] text-[10px] font-black uppercase tracking-widest">PILIH DARI KOMPUTER</span>
                            </div>
                            <input type="file" wire:model="posterFile" class="hidden" accept="image/*" />
                        </label>
                    </div>

                    <div x-show="uploadType === 'url'" class="animate-fadeIn">
                        <label class="block text-gray-500 text-[10px] font-black uppercase tracking-[3px] mb-4 text-center">URL Thumbnail</label>
                        <input wire:model="thumbnail" type="text" placeholder="https://..." class="w-full bg-black/40 border border-white/10 rounded-xl p-4 text-[10px] text-white focus:ring-1 focus:ring-[#E50914] outline-none font-bold" />
                    </div>
                </div>

                <div class="relative transition-all" x-data="{ openSeries: false }" :class="openSeries ? 'z-[100]' : 'z-10'">
                    <div class="absolute inset-0 bg-neutral-900/40 backdrop-blur-3xl border border-white/5 rounded-[28px] shadow-2xl pointer-events-none"></div>
                    <div class="relative p-10 overflow-visible">
                         <div class="flex items-center gap-3 mb-8 border-b border-white/5 pb-6">
                             <span class="material-symbols-outlined text-[#E50914]">stars</span>
                             <h3 class="text-xs font-black uppercase text-gray-400 tracking-[3px]">Klasifikasi Kategori</h3>
                        </div>
                    <!-- GENRE MULTI-SELECT -->
                    <div class="space-y-4">
                        <label class="text-[10px] text-gray-500 font-black uppercase tracking-[3px]">Genre & Kategorisasi</label>
                        <div class="grid grid-cols-2 gap-2 max-h-[220px] overflow-y-auto custom-scrollbar p-1">
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
                        @error('selectedCategories') <span class="text-red-500 text-[10px] font-bold uppercase">{{ $message }}</span> @enderror
                    </div>

                    <!-- SERIES DROPDOWN -->
                    <div class="space-y-4 mt-8 relative transition-all" x-init="$watch('open', value => openSeries = value)" x-data="{ open: false }">
                        <label class="text-[10px] text-gray-500 font-black uppercase tracking-[3px]">Series / Koleksi (Opsional)</label>
                        
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

                    <!-- AUDIENCE CLASSIFICATION -->
                    <div class="space-y-4 mt-8">
                        <label class="text-[10px] text-gray-500 font-black uppercase tracking-[3px]">Klasifikasi Penonton</label>
                        <div class="flex gap-3">
                            <label class="flex-1 cursor-pointer group">
                                <input type="radio" wire:model="audience_type" value="adult" class="hidden peer">
                                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5 text-center transition-all group-hover:bg-white/[0.05] peer-checked:bg-red-600/10 peer-checked:border-red-600/50">
                                    <span class="material-symbols-outlined text-gray-500 mb-1 group-hover:text-red-500 peer-checked:text-red-500 transition-colors">no_adult_content</span>
                                    <p class="text-[10px] font-black uppercase text-gray-400 group-hover:text-white peer-checked:text-white">DEWASA (ADULT)</p>
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer group">
                                <input type="radio" wire:model="audience_type" value="kids" class="hidden peer">
                                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5 text-center transition-all group-hover:bg-white/[0.05] peer-checked:bg-yellow-500/10 peer-checked:border-yellow-500/50">
                                    <span class="material-symbols-outlined text-gray-500 mb-1 group-hover:text-yellow-500 peer-checked:text-yellow-500 transition-colors">child_care</span>
                                    <p class="text-[10px] font-black uppercase text-gray-400 group-hover:text-white peer-checked:text-white">ANAK (KIDS)</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- VIP ONLY TOGGLE -->
                    <div class="mt-8">
                        <label class="flex items-center justify-between p-4 rounded-2xl bg-yellow-500/5 border border-yellow-500/20 cursor-pointer hover:bg-yellow-500/10 transition-all group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-yellow-500/20 flex items-center justify-center text-yellow-500">
                                    <span class="material-symbols-outlined">workspace_premium</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black uppercase text-yellow-500 tracking-widest">Konten VIP</span>
                                    <span class="text-[8px] text-gray-600 font-bold uppercase">Hanya untuk member berbayar</span>
                                </div>
                            </div>
                            <div class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="is_premium" class="sr-only peer">
                                <div class="w-11 h-6 bg-white/5 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-gray-500 peer-checked:after:bg-yellow-500 after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-500/20"></div>
                            </div>
                        </label>
                    </div>


                </div>

                <div class="space-y-4">
                    <button type="submit" class="w-full bg-[#E50914] text-white py-6 rounded-xl font-black uppercase text-[12px] tracking-[4px] shadow-[0_20px_40px_rgba(229,9,20,0.3)] hover:scale-[1.03] active:scale-[0.97] transition-all flex items-center justify-center gap-3">
                        <span class="material-symbols-outlined">publish</span> Publikasikan Karya
                    </button>
                    <p class="text-center text-[9px] text-gray-700 font-bold uppercase tracking-[4px] italic">Pastikan data sesuai Kebijakan CineVault.</p>
                </div>
            </div>
        </form>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fadeIn { animation: fadeIn 0.6s ease-out forwards; }
    </style>
</div>
