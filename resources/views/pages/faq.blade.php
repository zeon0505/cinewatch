<x-layouts.app>
<div class="min-h-screen bg-[#050505] text-white pt-32 pb-20 px-6 md:px-20">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-20 underline-red">
            <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tighter mb-4 logo">Fequently Asked <span class="text-red-600">Questions</span></h1>
            <div class="w-20 h-1 bg-red-600 mx-auto rounded-full shadow-[0_0_15px_rgba(220,38,38,0.5)]"></div>
        </div>

        <!-- FAQ Accordion -->
        <div class="space-y-4" x-data="{ active: null }">
            <!-- Q1 -->
            <div class="border border-white/10 rounded-2xl overflow-hidden bg-white/[0.02]">
                <button @click="active = (active === 1 ? null : 1)" class="w-full px-8 py-6 flex items-center justify-between group transition-all" :class="active === 1 ? 'bg-white/[0.04]' : ''">
                    <span class="text-lg font-bold text-gray-300 group-hover:text-white transition-colors">Bagaimana cara berlangganan VIP?</span>
                    <span class="material-symbols-outlined transition-transform duration-300" :class="active === 1 ? 'rotate-180 text-red-600' : 'text-gray-600'">expand_more</span>
                </button>
                <div x-show="active === 1" x-collapse class="px-8 py-6 text-gray-400 border-t border-white/5 leading-relaxed bg-black/40">
                    Anda dapat berlangganan VIP dengan mengklik menu 'VIP' di bilah navigasi atas. Kami mendukung berbagai metode pembayaran mulai dari E-Wallet (OVO, Dana, GoPay) hingga Transfer Bank. Akun Anda akan otomatis aktif setelah pembayaran terverifikasi.
                </div>
            </div>

            <!-- Q2 -->
            <div class="border border-white/10 rounded-2xl overflow-hidden bg-white/[0.02]">
                <button @click="active = (active === 2 ? null : 2)" class="w-full px-8 py-6 flex items-center justify-between group transition-all" :class="active === 2 ? 'bg-white/[0.04]' : ''">
                    <span class="text-lg font-bold text-gray-300 group-hover:text-white transition-colors">Apakah saya bisa menonton di banyak perangkat?</span>
                    <span class="material-symbols-outlined transition-transform duration-300" :class="active === 2 ? 'rotate-180 text-red-600' : 'text-gray-600'">expand_more</span>
                </button>
                <div x-show="active === 2" x-collapse class="px-8 py-6 text-gray-400 border-t border-white/5 leading-relaxed bg-black/40">
                    Tentu! Anda bisa login ke akun Cinewatch Anda di berbagai perangkat. Untuk kenyamanan maksimal, kami menyarankan fitur 'Multi-Profile' agar riwayat tontonan setiap anggota keluarga tetap terpisah dan personal.
                </div>
            </div>

            <!-- Q3 -->
            <div class="border border-white/10 rounded-2xl overflow-hidden bg-white/[0.02]">
                <button @click="active = (active === 3 ? null : 3)" class="w-full px-8 py-6 flex items-center justify-between group transition-all" :class="active === 3 ? 'bg-white/[0.04]' : ''">
                    <span class="text-lg font-bold text-gray-300 group-hover:text-white transition-colors">Apa itu Mode Anak (Kids Mode)?</span>
                    <span class="material-symbols-outlined transition-transform duration-300" :class="active === 3 ? 'rotate-180 text-red-600' : 'text-gray-600'">expand_more</span>
                </button>
                <div x-show="active === 3" x-collapse class="px-8 py-6 text-gray-400 border-t border-white/5 leading-relaxed bg-black/40">
                    Mode Anak adalah fitur penyaringan konten yang memastikan hanya film dengan kategori ramah anak yang akan muncul. Anda bisa mengaktifkan mode ini melalui setelan profil saat membuat profil baru untuk buah hati Anda.
                </div>
            </div>

            <!-- Q4 -->
            <div class="border border-white/10 rounded-2xl overflow-hidden bg-white/[0.02]">
                <button @click="active = (active === 4 ? null : 4)" class="w-full px-8 py-6 flex items-center justify-between group transition-all" :class="active === 4 ? 'bg-white/[0.04]' : ''">
                    <span class="text-lg font-bold text-gray-300 group-hover:text-white transition-colors">Saya menemukan link yang mati, apa yang harus dilakukan?</span>
                    <span class="material-symbols-outlined transition-transform duration-300" :class="active === 4 ? 'rotate-180 text-red-600' : 'text-gray-600'">expand_more</span>
                </button>
                <div x-show="active === 4" x-collapse class="px-8 py-6 text-gray-400 border-t border-white/5 leading-relaxed bg-black/40">
                    Kami sangat menghargai laporan Anda. Silakan klik link 'Lapor Link Mati' di bagian footer atau gunakan fitur lapor pada halaman detail film tersebut. Tim teknis kami akan segera memperbaikinya dalam waktu kurang dari 24 jam.
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <p class="text-center mt-12 text-gray-600 text-sm font-bold uppercase tracking-widest">Punya pertanyaan lain? <a href="{{ route('contact') }}" class="text-red-600 hover:underline">Tanya Kami Langsung</a></p>
    </div>
</div>

<script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
</x-layouts.app>
