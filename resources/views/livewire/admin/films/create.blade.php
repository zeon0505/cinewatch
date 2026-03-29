<div class="h-full overflow-y-auto scrollbar-hide">
    <!-- Main Full-Width Wrapper -->
    <div class="w-full px-4 md:px-10 pb-60">
        
        <!-- Premium Header Section -->
        <header class="flex flex-col md:flex-row items-center justify-between gap-8 mb-16 mt-6 animate-fadeInSlow">
            <div class="flex items-center gap-8">
                <a href="{{ route('admin.films.index') }}" class="group w-14 h-14 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center text-white hover:bg-red-600 hover:border-red-600 transition-all shadow-[0_10px_30px_rgba(0,0,0,0.5)] active:scale-95">
                    <span class="material-symbols-outlined transition-transform group-hover:-translate-x-1">arrow_back</span>
                </a>
                <div class="flex flex-col">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 bg-red-600 rounded-full animate-pulse shadow-[0_0_10px_#E50914]"></span>
                        <h2 class="text-4xl font-black text-white uppercase tracking-tighter leading-none logo select-none">
                            CINEWATCH <span class="bg-gradient-to-r from-red-600 to-red-400 bg-clip-text text-transparent">ENGINE</span>
                        </h2>
                    </div>
                    <p class="text-gray-500 font-bold text-[10px] uppercase tracking-[6px] mt-3 border-l-2 border-red-600/50 pl-5">
                        MODUL DISTRIBUSI & INTEGRASI KONTEN DIGITAL
                    </p>
                </div>
            </div>
            
            <div class="hidden xl:flex items-center gap-10">
                <div class="text-right">
                    <p class="text-gray-600 font-black text-[9px] uppercase tracking-[3px]">STATUS SISTEM</p>
                    <p class="text-white font-bold text-xs uppercase">TERHUBUNG KE CDN</p>
                </div>
                <div class="h-10 w-[1px] bg-white/10"></div>
                <div class="text-right">
                    <p class="text-gray-600 font-black text-[9px] uppercase tracking-[3px]">WAKTU LOKAL</p>
                    <p class="text-white font-bold text-xs uppercase">{{ \Carbon\Carbon::now()->format('H:i T') }}</p>
                </div>
            </div>
        </header>

        <!-- Dynamic Search & Intelligence -->
        <div class="mb-16 relative z-[200]" x-data="{ query: '' }">
            <div class="relative group max-w-5xl mx-auto">
                <div class="absolute -inset-1 bg-gradient-to-r from-red-600/20 to-transparent rounded-[28px] blur opacity-25 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative bg-neutral-900 border border-white/10 p-1.5 rounded-[24px] shadow-2xl flex items-center gap-3">
                    <div class="flex-1 relative">
                        <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-red-600 text-xl opacity-60">database</span>
                        <input
                            x-model="query"
                            @keydown.enter="$wire.executeSearch(query)"
                            type="text"
                            placeholder="Cari metadata film dari TMDb/OMDb..."
                            class="w-full bg-white/5 border-none rounded-xl pl-14 pr-6 py-3.5 text-white text-base font-medium outline-none focus:ring-0 placeholder:text-gray-700"
                        />
                    </div>
                    <button type="button" 
                        @click="$wire.executeSearch(query)"
                        class="bg-red-600 hover:bg-black text-white px-8 py-3.5 rounded-xl font-black text-[10px] uppercase tracking-[2px] transition-all hover:ring-2 hover:ring-red-600 shadow-xl shadow-red-900/20 active:scale-95 flex items-center gap-3">
                        <span>SYNC</span>
                        <div wire:loading wire:target="executeSearch" class="w-3 h-3 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                    </button>
                </div>
            </div>

            <!-- Intelligent Results Panel -->
            @if(count($searchResults) > 0)
            <div class="absolute top-full left-0 right-0 mt-4 bg-[#050505] border border-white/10 rounded-[24px] shadow-[0_40px_100px_rgba(0,0,0,0.9)] z-[300] overflow-hidden animate-slideUp max-w-5xl mx-auto">
                <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-red-600 text-sm">travel_explore</span>
                        <h4 class="text-white font-black text-[10px] uppercase tracking-[3px]">Hasil Pencarian</h4>
                    </div>
                    <button wire:click="$set('searchResults', [])" class="text-gray-600 hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>
                
                <div class="max-h-[400px] overflow-y-auto custom-scrollbar p-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                    @foreach($searchResults as $index => $item)
                    <div wire:click="selectItem({{ $index }})" 
                         class="flex items-center gap-4 p-3 rounded-xl bg-white/5 border border-white/5 hover:border-red-600/50 hover:bg-red-600/5 cursor-pointer transition-all group active:scale-[0.98]">
                        <div class="w-10 h-14 bg-neutral-900 rounded-lg overflow-hidden shrink-0 shadow-2xl relative">
                            @if($item['poster'])
                                <img src="{{ $item['poster'] }}" class="w-full h-full object-cover transition-transform group-hover:scale-110">
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-white font-black text-xs uppercase truncate tracking-tight group-hover:text-red-500 transition-colors">{{ $item['title'] }}</h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-red-600 font-black text-[9px] uppercase tracking-widest">{{ $item['year'] }}</span>
                                <span class="px-1.5 py-0.5 bg-white/5 border border-white/10 rounded text-[7px] text-gray-600 font-black uppercase tracking-widest">{{ $item['type'] }}</span>
                            </div>
                        </div>
                        <div class="w-7 h-7 rounded-lg bg-white/5 flex items-center justify-center text-gray-600 group-hover:bg-red-600 group-hover:text-white transition-all">
                            <span class="material-symbols-outlined text-xs">add</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Main Form Grid -->
        <form wire:submit.prevent="store" class="flex flex-col xl:flex-row gap-10 items-start">
            
            <!-- Information Layer -->
            <div class="flex-1 w-full space-y-10">
                
                <!-- Primary Metadata Card -->
                <div class="group relative">
                    <div class="absolute -inset-1 bg-gradient-to-b from-white/10 to-transparent rounded-[40px] blur-sm opacity-50"></div>
                    <div class="relative bg-[#0A0A0A] border border-white/10 rounded-[36px] overflow-hidden shadow-2xl">
                        <div class="p-8 md:p-12">
                            <div class="flex items-center justify-between mb-12 border-b border-white/5 pb-8">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 bg-red-600/10 rounded-2xl flex items-center justify-center text-red-600">
                                        <span class="material-symbols-outlined">data_object</span>
                                    </div>
                                    <h3 class="text-lg font-black uppercase text-white tracking-[3px]">Primari Metadata</h3>
                                </div>
                                <span class="text-[9px] font-black uppercase tracking-[4px] text-gray-700">Tahap 01/03</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
                                <div class="md:col-span-12">
                                    <label class="block text-gray-500 text-[10px] font-black uppercase tracking-[4px] mb-4 ml-1">Judul Resmi</label>
                                    <input wire:model="title" type="text" placeholder="Masukkan judul..." 
                                           class="w-full bg-black/60 border border-white/10 rounded-2xl p-5 text-white text-lg font-bold focus:ring-2 focus:ring-red-600/50 focus:border-red-600/50 outline-none transition-all placeholder:text-gray-800 shadow-inner" />
                                    @error('title') <span class="text-red-500 text-[10px] font-bold mt-3 block">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-12">
                                    <label class="block text-gray-500 text-[10px] font-black uppercase tracking-[4px] mb-4 ml-1">Deskripsi & Sinopsis</label>
                                    <textarea wire:model="description" rows="5" placeholder="Tuliskan alur cerita menarik di sini..." 
                                              class="w-full bg-black/60 border border-white/10 rounded-2xl p-6 text-white font-medium focus:ring-2 focus:ring-red-600/50 outline-none transition-all placeholder:text-gray-800 leading-relaxed shadow-inner"></textarea>
                                </div>

                                <div class="md:col-span-3">
                                    <label class="block text-gray-500 text-[10px] font-black uppercase tracking-[3px] mb-4 ml-1">Tahun Rilis</label>
                                    <input wire:model="year" type="number" 
                                           class="w-full bg-black/60 border border-white/10 rounded-2xl p-4 text-white text-center font-black focus:ring-1 focus:ring-red-600 outline-none" />
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-gray-500 text-[10px] font-black uppercase tracking-[3px] mb-4 ml-1">Durasi</label>
                                    <input wire:model="duration" type="text" placeholder="1h 30m" 
                                           class="w-full bg-black/60 border border-white/10 rounded-2xl p-4 text-white text-center font-black focus:ring-1 focus:ring-red-600 outline-none" />
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-gray-500 text-[10px] font-black uppercase tracking-[3px] mb-4 ml-1">Skor IMDb/TMDB</label>
                                    <div class="relative">
                                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-yellow-500 text-lg">star</span>
                                        <input wire:model="rating_value" type="number" step="0.1" max="10" 
                                               class="w-full bg-black/60 border border-white/10 rounded-2xl pl-12 pr-4 py-4 text-white text-center font-black focus:ring-1 focus:ring-red-600 outline-none" />
                                    </div>
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-gray-500 text-[10px] font-black uppercase tracking-[3px] mb-4 ml-1">Rating Umur</label>
                                    <div x-data="{ open: false }" class="relative">
                                        <div @click="open = !open" 
                                             class="w-full bg-black/60 border border-white/10 rounded-2xl p-4 text-white text-center font-black cursor-pointer hover:border-red-600/50 transition-all flex items-center justify-center gap-2">
                                             <span class="text-xs">{{ $age_rating ?: 'PILIH' }}</span>
                                             <span class="material-symbols-outlined text-xs transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                                        </div>
                                        <div x-show="open" @click.away="open = false" 
                                             class="absolute bottom-full left-0 right-0 mb-3 bg-[#111] border border-white/10 rounded-2xl shadow-3xl z-[300] overflow-hidden p-2 backdrop-blur-3xl">
                                             @foreach(['SU', '13+', '17+', '21+', 'R', 'PG-13', 'G', 'TV-MA'] as $val)
                                             <div wire:click="$set('age_rating', '{{ $val }}')" @click="open = false" 
                                                  class="px-5 py-3 rounded-xl text-[10px] font-black text-center cursor-pointer transition-all {{ $age_rating == $val ? 'bg-red-600 text-white shadow-lg shadow-red-900/40' : 'text-gray-500 hover:text-white hover:bg-white/5' }}">
                                                  {{ $val }}
                                             </div>
                                             @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media Assets Card -->
                <div class="relative bg-[#0A0A0A] border border-white/10 rounded-[36px] overflow-hidden shadow-2xl p-8 md:p-12">
                    <div class="flex items-center gap-5 mb-12 border-b border-white/5 pb-8">
                        <div class="w-12 h-12 bg-red-600/10 rounded-2xl flex items-center justify-center text-red-600">
                            <span class="material-symbols-outlined">video_stable</span>
                        </div>
                        <h3 class="text-lg font-black uppercase text-white tracking-[3px]">Aset Streaming</h3>
                        <span class="ml-auto text-[9px] font-black uppercase tracking-[4px] text-gray-700">Tahap 02/03</span>
                    </div>

                    <div class="space-y-6">
                        <label class="block text-gray-500 text-[10px] font-black uppercase tracking-[4px] mb-4 ml-1">Source URL (Embed Iframe / HLS M3U8)</label>
                        <div class="relative group">
                            <input wire:model="video_url" type="text" placeholder="https://..." 
                                   class="w-full bg-black/60 border border-white/10 rounded-2xl p-6 pl-14 text-white font-mono text-sm focus:ring-2 focus:ring-red-600/50 outline-none transition-all shadow-inner" />
                            <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-gray-700 group-focus-within:text-red-600 transition-colors">cloud_sync</span>
                        </div>
                        <div class="p-5 flex items-start gap-4 bg-red-600/5 border border-red-600/10 rounded-2xl">
                            <span class="material-symbols-outlined text-red-600 text-lg">info</span>
                            <p class="text-[9px] text-gray-500 uppercase font-black leading-relaxed tracking-widest">Gunakan URL langsung atau embed yang sudah divalidasi. Jangan gunakan link yang memicu redirect iklan berlebih.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuration Layer (Sidebar) -->
            <div class="w-full xl:w-[400px] space-y-10 shrink-0">
                
                <!-- Poster Manager -->
                <div class="bg-[#0A0A0A] border border-white/10 rounded-[36px] overflow-hidden shadow-2xl p-8 text-center" x-data="{ mode: 'file' }">
                    <div class="flex items-center gap-3 mb-8 justify-center">
                         <span class="material-symbols-outlined text-red-600 text-xl font-bold">photo_camera</span>
                         <h3 class="text-xs font-black uppercase text-white tracking-[3px]">Visual Poster</h3>
                    </div>

                    <div class="relative aspect-[2/3] bg-black/80 rounded-3xl mb-8 border border-white/5 overflow-hidden group shadow-2xl">
                        @if($posterFile)
                            <img src="{{ $posterFile->temporaryUrl() }}" class="w-full h-full object-cover rounded-2xl" />
                        @elseif($thumbnail)
                            <img src="{{ $thumbnail }}" class="w-full h-full object-cover rounded-2xl" />
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-800">
                                <span class="material-symbols-outlined text-6xl mb-4 opacity-10">broken_image</span>
                                <p class="text-[9px] font-black uppercase tracking-[3px]">Menunggu Aset Visual</p>
                            </div>
                        @endif
                        
                        <div wire:loading wire:target="posterFile" class="absolute inset-0 bg-black/90 flex flex-col items-center justify-center gap-4">
                            <div class="w-10 h-10 border-4 border-red-600 border-t-transparent rounded-full animate-spin"></div>
                            <span class="text-[9px] font-black uppercase text-red-600 tracking-widest">Mengunggah...</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-8">
                        <button type="button" @click="mode = 'file'" :class="mode === 'file' ? 'bg-red-600 text-white shadow-lg shadow-red-900/40' : 'bg-white/5 text-gray-500'" class="py-3 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all">FILE</button>
                        <button type="button" @click="mode = 'url'" :class="mode === 'url' ? 'bg-red-600 text-white shadow-lg shadow-red-900/40' : 'bg-white/5 text-gray-500'" class="py-3 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all">LINK</button>
                    </div>

                    <div x-show="mode === 'file'" class="animate-fadeIn">
                        <label class="block group cursor-pointer">
                            <span class="block w-full py-4 bg-white/5 rounded-2xl border border-white/10 group-hover:bg-red-600/10 group-hover:border-red-600/30 transition-all text-xs font-black text-gray-500 group-hover:text-red-600 uppercase tracking-widest leading-none pt-5">
                                AMBIL FILE
                            </span>
                            <input type="file" wire:model="posterFile" class="hidden" accept="image/*" />
                        </label>
                    </div>

                    <div x-show="mode === 'url'" class="animate-fadeIn">
                        <input wire:model="thumbnail" type="text" placeholder="Masukkan URL Gambar..." 
                               class="w-full bg-black/60 border border-white/10 rounded-2xl p-4 text-[10px] text-center text-white focus:ring-1 focus:ring-red-600 outline-none font-bold" />
                    </div>
                </div>

                <!-- Classification Manager -->
                <div class="bg-[#0A0A0A] border border-white/10 rounded-[36px] overflow-hidden shadow-2xl p-8">
                    <div class="flex items-center gap-4 mb-10 pb-6 border-b border-white/5">
                         <span class="material-symbols-outlined text-red-600">category</span>
                         <h3 class="text-xs font-black uppercase text-white tracking-[3px]">Pengaturan Tag</h3>
                    </div>

                    <div class="space-y-10">
                        <!-- GENRE -->
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <label class="text-[9px] text-gray-500 font-black uppercase tracking-[3px]">Genre Terkait</label>
                                <span class="text-[8px] text-red-600 font-black uppercase">{{ count($selectedCategories) }} Terpilih</span>
                            </div>
                            <div class="grid grid-cols-1 gap-2 max-h-[180px] overflow-y-auto custom-scrollbar pr-2">
                                @foreach(\App\Models\Category::all() as $cat)
                                <label class="flex items-center gap-3 p-3 rounded-2xl bg-white/[0.01] border border-white/5 hover:bg-white/[0.04] cursor-pointer transition-all group has-[:checked]:bg-red-600/5 has-[:checked]:border-red-600/20">
                                    <input type="checkbox" wire:model="selectedCategories" value="{{ $cat->id }}" class="hidden">
                                    <div class="w-5 h-5 rounded-lg border-2 border-white/10 flex items-center justify-center group-has-[:checked]:bg-red-600 group-has-[:checked]:border-red-600 transition-all">
                                        <span class="material-symbols-outlined text-white text-[14px] scale-0 group-has-[:checked]:scale-100 transition-transform">check</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-500 group-has-[:checked]:text-white uppercase">{{ $cat->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- SERIES -->
                        <div class="space-y-4" x-data="{ open: false }">
                            <label class="text-[9px] text-gray-500 font-black uppercase tracking-[3px]">Series / Koleksi</label>
                            <div class="relative">
                                <div @click="open = !open" 
                                     class="w-full bg-black/60 border border-white/10 rounded-2xl p-4 text-white text-[10px] font-black cursor-pointer hover:border-red-600/50 transition-all flex items-center justify-between group">
                                     <span class="uppercase tracking-widest">{{ $series_id ? collect($series)->where('id', $series_id)->first()->name ?? 'PILIH SERIES' : 'TANPA SERIES' }}</span>
                                     <span class="material-symbols-outlined text-sm transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                                </div>
                                <div x-show="open" @click.away="open = false" 
                                     class="absolute bottom-full left-0 right-0 mb-3 bg-[#111] border border-white/10 rounded-2xl shadow-3xl z-[300] overflow-hidden p-2 backdrop-blur-3xl max-h-[250px] overflow-y-auto custom-scrollbar">
                                     <div wire:click="$set('series_id', null)" @click="open = false" 
                                          class="px-5 py-3 rounded-xl text-[10px] font-black cursor-pointer transition-all {{ !$series_id ? 'bg-red-600 text-white' : 'text-gray-500 hover:text-white hover:bg-white/5' }}">
                                          -- TANPA SERIES --
                                     </div>
                                     @foreach($series as $s)
                                     <div wire:click="$set('series_id', {{ $s->id }})" @click="open = false" 
                                          class="px-5 py-3 rounded-xl text-[10px] font-black cursor-pointer transition-all {{ $series_id == $s->id ? 'bg-red-600 text-white' : 'text-gray-500 hover:text-white hover:bg-white/5' }}">
                                          {{ strtoupper($s->name) }}
                                     </div>
                                     @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- VIP TOGGLE -->
                        <div class="space-y-4">
                            <label class="flex items-center justify-between p-5 rounded-2xl bg-yellow-500/5 border border-yellow-500/10 cursor-pointer group hover:bg-yellow-500/10 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-yellow-500/10 flex items-center justify-center text-yellow-500">
                                        <span class="material-symbols-outlined">verified</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-black uppercase text-yellow-500 tracking-tighter">Gold VIP Access</span>
                                        <span class="text-[8px] text-gray-600 font-bold uppercase">Hanya Berlangganan</span>
                                    </div>
                                </div>
                                <div class="relative">
                                    <input type="checkbox" wire:model="is_premium" class="sr-only peer">
                                    <div class="w-10 h-5 bg-white/5 rounded-full peer-checked:bg-yellow-500/20 transition-all relative after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-gray-700 after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-5 peer-checked:after:bg-yellow-500"></div>
                                </div>
                            </label>
                        </div>

                        <!-- AUDIENCE CLASSIFICATION -->
                        <div>
                            <label class="text-[9px] text-gray-500 font-black uppercase tracking-[3px] mb-4 block">Segmen Penonton</label>
                            <div class="flex gap-2">
                                <label class="flex-1 cursor-pointer group">
                                    <input type="radio" wire:model="audience_type" value="adult" class="hidden peer">
                                    <div class="py-3 rounded-2xl bg-white/[0.01] border border-white/5 text-center transition-all peer-checked:bg-red-600/10 peer-checked:border-red-600/40 peer-checked:shadow-[0_0_20px_rgba(229,9,20,0.1)]">
                                        <span class="text-[9px] font-black uppercase text-gray-500 peer-checked:text-white tracking-widest">DEWASA</span>
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer group">
                                    <input type="radio" wire:model="audience_type" value="kids" class="hidden peer">
                                    <div class="py-3 rounded-2xl bg-white/[0.01] border border-white/5 text-center transition-all peer-checked:bg-yellow-500/10 peer-checked:border-yellow-500/40 peer-checked:shadow-[0_0_20px_rgba(245,158,11,0.1)]">
                                        <span class="text-[9px] font-black uppercase text-gray-500 peer-checked:text-white tracking-widest">ANAK</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Layer -->
                <div class="space-y-4">
                    <button type="submit" class="w-full bg-red-600 text-white py-6 rounded-2xl font-black uppercase text-xs tracking-[5px] shadow-[0_20px_40px_rgba(229,9,20,0.3)] hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-4 border-t-2 border-white/20 group">
                        <span class="material-symbols-outlined group-hover:rotate-12 transition-transform">cloud_upload</span>
                        PUBLIKASIKAN DATA
                    </button>
                    <p class="text-center text-[8px] text-gray-700 font-bold uppercase tracking-[4px] leading-relaxed">Pastikan seluruh metadata sudah valid sebelum sinkronisasi server dimulai.</p>
                </div>

            </div>
        </form>
    </div>

    <!-- Premium Styles & Animations -->
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .custom-scrollbar::-webkit-scrollbar { width: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E50914; border-radius: 20px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }

        @keyframes fadeInSlow { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
        
        .animate-fadeInSlow { animation: fadeInSlow 1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
        .animate-slideUp { animation: slideUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
        
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: white;
            -webkit-box-shadow: 0 0 0px 1000px #050505 inset;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</div>
