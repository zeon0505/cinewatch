<x-layouts.dashboard>
    @php
        $isKids = session('is_kids_mode', false);
        $watchlist = \App\Models\Watchlist::where('user_id', auth()->id())
            ->whereHas('movie', function($q) use ($isKids) {
                $q->when($isKids, fn($sq) => $sq->kids());
            })
            ->with(['movie' => function($q) use ($isKids) {
                $q->when($isKids, fn($sq) => $sq->kids());
            }])
            ->latest()
            ->get();

        $histories = \App\Models\History::where('user_id', auth()->id())
            ->whereHas('movie', function($q) use ($isKids) {
                $q->when($isKids, fn($sq) => $sq->kids());
            })
            ->with(['movie' => function($q) use ($isKids) {
                $q->when($isKids, fn($sq) => $sq->kids());
            }])
            ->latest()
            ->take(5)
            ->get();

        $ratings = \App\Models\Rating::where('user_id', auth()->id())->count();
    @endphp

    <div class="max-w-6xl mx-auto space-y-20">
        <!-- Header Welcome -->
        <div class="flex items-center justify-between animate-fadeInUp delay-100">
            <div>
                <h1 class="text-5xl md:text-6xl font-black text-white uppercase tracking-tighter mb-4">Selamat Datang, <span class="text-[#E50914]">{{ explode(' ', auth()->user()->name)[0] }}!</span></h1>
                <p class="text-gray-600 text-sm font-bold uppercase tracking-widest italic leading-relaxed">Lanjutkan pengalaman sinematik kamu yang tertunda.</p>
            </div>
            <div class="flex gap-6">
                 <div class="bg-[#141414] rounded-2xl p-8 flex flex-col items-center justify-center min-w-[140px] border border-white/5 shadow-2xl">
                      <span class="text-4xl font-black text-white">{{ $watchlist->count() }}</span>
                      <span class="text-[10px] text-gray-700 uppercase font-black tracking-widest mt-2">Daftar Saya</span>
                 </div>
                 <div class="bg-[#141414] rounded-2xl p-8 flex flex-col items-center justify-center min-w-[140px] border border-white/5 shadow-2xl">
                      <span class="text-4xl font-black text-[#E50914]">{{ $ratings }}</span>
                      <span class="text-[10px] text-gray-700 uppercase font-black tracking-widest mt-2">Total Rating</span>
                 </div>
            </div>
        </div>

        <!-- Watchlist Grid -->
        <section class="animate-fadeInUp delay-200">
            <div class="flex items-center justify-between mb-10 border-b border-white/5 pb-6">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined text-[#E50914]">favorite</span>
                    <h2 class="text-2xl font-black text-white uppercase tracking-widest">Daftar Tontonan Saya</h2>
                </div>
                <a href="/" class="text-[10px] text-gray-500 font-black uppercase hover:text-white transition-all tracking-widest">Tambah Film →</a>
            </div>

            @if($watchlist->isEmpty())
                <div class="bg-[#141414] rounded-3xl p-24 text-center border border-white/5">
                    <p class="text-gray-700 font-black text-lg uppercase tracking-widest mb-10 italic">"Belum ada karya pilihan yang masuk dalam daftar kamu."</p>
                    <a href="/" class="bg-[#E50914] px-12 py-4 text-white rounded-xl font-black uppercase text-xs tracking-widest shadow-2xl hover:scale-105 transition-all inline-block">Jelajahi Sekarang</a>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">
                    @foreach($watchlist as $index => $item)
                    <div class="group relative bg-[#141414] rounded-xl overflow-hidden border border-white/5 transition-all duration-300 hover:-translate-y-2 hover:border-red-600/30 hover:shadow-[0_10px_30px_rgba(229,9,20,0.2)]">
                        <img src="{{ $item->movie->thumbnail }}" class="w-full h-80 object-cover opacity-70 group-hover:opacity-100 transition-all duration-500" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/80 to-transparent opacity-90"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <h3 class="text-white font-black text-xs mb-1 uppercase truncate tracking-wide">{{ $item->movie->title }}</h3>
                            <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest md:truncate">{{ $item->movie->category->name ?? 'Uncategorized' }}</p>
                        </div>
                        <div class="absolute top-6 right-6 opacity-0 group-hover:opacity-100 transition-all transform translate-y-2 group-hover:translate-y-0">
                             <a href="{{ route('movie.detail', $item->movie->slug) }}" class="w-10 h-10 bg-white text-black rounded-full shadow-2xl flex items-center justify-center hover:bg-[#E50914] hover:text-white transition-all">
                                <span class="material-symbols-outlined text-md m-0">play_arrow</span>
                             </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Recent Activity -->
        <section class="max-w-4xl animate-fadeInUp delay-300 pb-20">
            <div class="flex items-center justify-between mb-10 border-b border-white/5 pb-6">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined text-gray-600">history</span>
                    <h2 class="text-2xl font-black text-white uppercase tracking-widest">Aktivitas Terakhir</h2>
                </div>
            </div>
            
            <div class="space-y-4">
                @forelse($histories as $index => $history)
                <div class="bg-[#141414] rounded-xl border border-white/5 p-6 flex items-center justify-between hover:bg-white/[0.04] transition-all group">
                    <div class="flex items-center gap-8">
                        <div class="relative overflow-hidden rounded-lg w-24 h-14">
                             <img src="{{ $history->movie->thumbnail }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500" />
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-sm uppercase tracking-tight group-hover:text-[#E50914] transition-colors">{{ $history->movie->title }}</h4>
                            <p class="text-[10px] text-gray-700 font-bold uppercase tracking-widest mt-1 italic">Dilihat {{ $history->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <a href="{{ route('movie.detail', $history->movie->slug) }}" class="text-[10px] font-black uppercase text-gray-700 hover:text-white transition-colors flex items-center gap-2 border border-white/5 px-4 py-2 rounded-lg hover:border-white/20">
                        <span class="material-symbols-outlined text-[16px] m-0">replay</span> Putar Kembali
                    </a>
                </div>
                @empty
                     <p class="text-gray-800 italic uppercase text-[11px] font-black tracking-[4px] py-20 text-center">Belum ada jejak tontonan terdeteksi.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-layouts.dashboard>
