<x-layouts.app>
<div class="min-h-screen bg-[#050505] text-white pt-32 pb-20 px-6 md:px-20">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-16">
            <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tighter mb-4 logo">Lapor <span class="text-red-600">Link Mati</span></h1>
            <p class="text-gray-500 font-medium">Bantu kami menjaga kualitas layanan. Jika Anda menemukan film yang tidak bisa diputar, beritau kami segera.</p>
        </div>

        <div class="grid lg:grid-cols-5 gap-12">
            <!-- Form Card -->
            <div class="lg:col-span-3 bg-white/[0.03] border border-white/10 rounded-3xl p-10">
                <form class="space-y-6">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2 italic">Judul Film / Serial</label>
                        <input type="text" placeholder="Contoh: Spongebob The Movie" class="w-full bg-black/40 border border-white/10 rounded-xl px-5 py-4 text-sm text-white focus:ring-1 focus:ring-red-600 outline-none transition-all placeholder:text-gray-800">
                    </div>

                    <div x-data="{ open: false, selected: 'Video tidak bisa diputar (Loading terus)' }" class="relative transition-all" :class="open ? 'z-50' : 'z-10'">
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2 italic">Kendala yang Dialami</label>
                        <input type="hidden" name="issue" :value="selected">
                        <div @click="open = !open" @click.away="open = false" 
                             class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white hover:border-white/20 transition-all cursor-pointer flex justify-between items-center group">
                             <span x-text="selected" class="font-bold"></span>
                             <span class="material-symbols-outlined text-gray-500 transition-transform" :class="open ? 'rotate-180 text-white' : 'group-hover:text-white'">expand_more</span>
                        </div>
                        
                        <div x-show="open" x-transition.opacity 
                             class="absolute top-full left-0 right-0 mt-2 bg-[#0A0A0A] border border-white/10 rounded-xl shadow-[0_30px_60px_rgba(0,0,0,0.8)] z-50 overflow-hidden flex flex-col p-1.5" x-cloak style="display: none;">
                             @foreach(['Video tidak bisa diputar (Loading terus)', 'Video terhapus (File missing)', 'Subtitle tidak muncul / error', 'Suara hilang / pecah', 'Lainnya'] as $opt)
                             <div @click="selected = '{{ $opt }}'; open = false" 
                                  class="px-4 py-2.5 rounded-lg text-xs font-bold cursor-pointer transition-all flex items-center gap-3"
                                  :class="selected === '{{ $opt }}' ? 'bg-red-600/10 text-red-500 border-l-[3px] border-red-600' : 'text-gray-400 hover:text-white hover:bg-white/5 border-l-[3px] border-transparent'">
                                  <span class="material-symbols-outlined text-[16px]" :class="selected === '{{ $opt }}' ? 'opacity-100' : 'opacity-0'">check</span>
                                  {{ $opt }}
                             </div>
                             @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2 italic">Pesan Tambahan (Opsional)</label>
                        <textarea rows="4" placeholder="Jelaskan lebih detail jika perlu..." class="w-full bg-black/40 border border-white/10 rounded-xl px-5 py-4 text-sm text-white focus:ring-1 focus:ring-red-600 outline-none transition-all placeholder:text-gray-800"></textarea>
                    </div>

                    <button type="button" onclick="alert('Terima kasih! Laporan Anda telah kami terima.')" class="w-full bg-red-600 hover:bg-red-700 text-white py-5 rounded-xl font-black uppercase tracking-widest transition-all shadow-lg shadow-red-600/20">Kirim Laporan</button>
                </form>
            </div>

            <!-- Sidebar Info -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-red-600/10 border border-red-600/30 p-8 rounded-3xl">
                    <h3 class="text-sm font-black uppercase tracking-widest mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-red-600">info</span> Prioritas Perbaikan
                    </h3>
                    <p class="text-xs text-red-600/90 leading-relaxed font-medium">Laporan link mati akan diproses oleh tim teknis kami dalam waktu maksimal <span class="font-black text-red-600">12 jam</span> sejak laporan diterima.</p>
                </div>

                <div class="p-8 border border-white/5 rounded-3xl">
                    <h3 class="text-sm font-black uppercase tracking-widest mb-6">Tips Cepat</h3>
                    <ul class="space-y-4 text-xs font-medium text-gray-500">
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-white/5 flex items-center justify-center text-[10px] text-gray-400 font-bold shrink-0">1</span>
                            Coba refresh halaman atau ganti server pemutaran sebelum melapor.
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-white/5 flex items-center justify-center text-[10px] text-gray-400 font-bold shrink-0">2</span>
                            Pastikan koneksi internet Anda stabil untuk streaming.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
