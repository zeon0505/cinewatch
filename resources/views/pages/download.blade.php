<x-layouts.app>
<div class="min-h-screen bg-[#050505] text-white pt-32 pb-20 px-6 md:px-20">
    <div class="max-w-5xl mx-auto">
        <!-- Hero Section -->
        <div class="text-center mb-20">
            <h1 class="text-5xl md:text-7xl font-black uppercase tracking-tighter mb-6 logo">Nonton <span class="text-red-600">Dimana Saja</span></h1>
            <p class="text-gray-500 max-w-2xl mx-auto text-lg md:text-xl font-medium">Bawa pengalaman bioskop ke dalam saku Anda. Instal aplikasi Cinewatch di smartphone Anda tanpa perlu melalui store.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-12">
            <!-- iOS Guide -->
            <div class="bg-white/[0.03] border border-white/10 rounded-[3rem] p-10 md:p-14 hover:bg-white/[0.05] transition-all group">
                <div class="flex items-center gap-4 mb-10">
                    <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center border border-white/10">
                        <span class="material-symbols-outlined text-4xl text-gray-400">phone_iphone</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black uppercase tracking-widest">Apple iOS</h2>
                        <p class="text-xs text-gray-600 font-bold uppercase tracking-widest">Safari Browser</p>
                    </div>
                </div>

                <div class="space-y-8 text-gray-400">
                    <div class="flex gap-6">
                        <span class="text-4xl font-black text-red-600/20">01</span>
                        <p class="text-sm leading-relaxed">Buka situs <span class="text-white font-bold">Cinewatch</span> menggunakan browser <span class="text-white font-bold">Safari</span> di iPhone Anda.</p>
                    </div>
                    <div class="flex gap-6">
                        <span class="text-4xl font-black text-red-600/20">02</span>
                        <p class="text-sm leading-relaxed">Ketuk ikon <span class="text-white font-bold">Share</span> (kotak dengan panah ke atas) di bagian bawah layar.</p>
                    </div>
                    <div class="flex gap-6">
                        <span class="text-4xl font-black text-red-600/20">03</span>
                        <p class="text-sm leading-relaxed">Scroll ke bawah dan pilih <span class="text-white font-bold">"Add to Home Screen"</span> atau <span class="text-white font-bold">"Tambahkan ke Layar Utama"</span>.</p>
                    </div>
                </div>
            </div>

            <!-- Android Guide -->
            <div class="bg-white/[0.03] border border-white/10 rounded-[3rem] p-10 md:p-14 hover:bg-white/[0.05] transition-all group">
                <div class="flex items-center gap-4 mb-10">
                    <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center border border-white/10">
                        <span class="material-symbols-outlined text-4xl text-gray-400">android</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black uppercase tracking-widest">Android</h2>
                        <p class="text-xs text-gray-600 font-bold uppercase tracking-widest">Chrome Browser</p>
                    </div>
                </div>

                <div class="space-y-8 text-gray-400">
                    <div class="flex gap-6">
                        <span class="text-4xl font-black text-red-600/20">01</span>
                        <p class="text-sm leading-relaxed">Buka situs <span class="text-white font-bold">Cinewatch</span> menggunakan browser <span class="text-white font-bold">Chrome</span>.</p>
                    </div>
                    <div class="flex gap-6">
                        <span class="text-4xl font-black text-red-600/20">02</span>
                        <p class="text-sm leading-relaxed">Ketuk ikon <span class="text-white font-bold">Tiga Titik</span> di pojok kanan atas layar.</p>
                    </div>
                    <div class="flex gap-6">
                        <span class="text-4xl font-black text-red-600/20">03</span>
                        <p class="text-sm leading-relaxed">Pilih <span class="text-white font-bold">"Install App"</span> atau <span class="text-white font-bold">"Instal Aplikasi"</span>.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Why PWA info -->
        <div class="mt-20 text-center bg-white/[0.02] border border-white/5 p-12 rounded-[3rem]">
            <h3 class="text-xs font-black uppercase tracking-[5px] text-gray-600 mb-6">Mengapa Aplikasi Kami Berbeda?</h3>
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <span class="material-symbols-outlined text-red-600 mb-4">bolt</span>
                    <h4 class="text-sm font-black uppercase mb-2">Ringan</h4>
                    <p class="text-[10px] text-gray-500 uppercase leading-relaxed font-bold">Tidak memenuhi memori smartphone Anda.</p>
                </div>
                <div>
                    <span class="material-symbols-outlined text-red-600 mb-4">update</span>
                    <h4 class="text-sm font-black uppercase mb-2">Selalu Update</h4>
                    <p class="text-[10px] text-gray-500 uppercase leading-relaxed font-bold">Pembaruan otomatis tanpa download ulang.</p>
                </div>
                <div>
                    <span class="material-symbols-outlined text-red-600 mb-4">offline_pin</span>
                    <h4 class="text-sm font-black uppercase mb-2">Akses Cepat</h4>
                    <p class="text-[10px] text-gray-500 uppercase leading-relaxed font-bold">Satu klik dari layar utama untuk menonton.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
