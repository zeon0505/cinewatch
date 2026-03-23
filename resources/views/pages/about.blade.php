<x-layouts.app>
<div class="min-h-screen bg-[#0a0a0a] text-white pt-32 pb-20 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-16 animate-fadeIn">
            <h1 class="text-5xl font-black uppercase tracking-tighter mb-4 logo">Tentang <span class="text-[#E50914]">Cinewatch</span></h1>
            <div class="w-24 h-1 bg-[#E50914] mx-auto rounded-full"></div>
        </div>

        <div class="grid gap-12 text-gray-300 leading-relaxed text-lg">
            <section class="animate-fadeIn" style="animation-delay: 200ms">
                <h2 class="text-2xl font-black text-white uppercase tracking-widest mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-[#E50914] flex items-center justify-center text-sm">01</span>
                    Visi Kami
                </h2>
                <p>
                    Cinewatch hadir sebagai platform streaming film masa depan yang mengutamakan kualitas visual dan pengalaman pengguna yang luar biasa. Kami percaya bahwa menonton film bukan sekadar hiburan, melainkan sebuah perjalanan emosional yang layak dinikmati dengan teknologi terbaik.
                </p>
            </section>

            <section class="animate-fadeIn" style="animation-delay: 400ms">
                <h2 class="text-2xl font-black text-white uppercase tracking-widest mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-[#E50914] flex items-center justify-center text-sm">02</span>
                    Apa yang Kami Tawarkan?
                </h2>
                <ul class="grid sm:grid-cols-2 gap-4">
                    <li class="bg-white/5 p-6 rounded-2xl border border-white/10 hover:border-[#E50914]/50 transition-colors">
                        <span class="material-symbols-outlined text-[#E50914] mb-3">high_quality</span>
                        <h3 class="text-white font-bold mb-2">Kualitas Kreatif</h3>
                        <p class="text-sm">Mendukung kreator lokal untuk membagikan karya mereka secara langsung kepada audiens.</p>
                    </li>
                    <li class="bg-white/5 p-6 rounded-2xl border border-white/10 hover:border-[#E50914]/50 transition-colors">
                        <span class="material-symbols-outlined text-[#E50914] mb-3">tv</span>
                        <h3 class="text-white font-bold mb-2">Akses Dimanapun</h3>
                        <p class="text-sm">Tonton film favorit Anda di PC, Tablet, maupun Smartphone dengan antarmuka yang responsif.</p>
                    </li>
                </ul>
            </section>

            <section class="animate-fadeIn" style="animation-delay: 600ms">
                <h2 class="text-2xl font-black text-white uppercase tracking-widest mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-[#E50914] flex items-center justify-center text-sm">03</span>
                    Komunitas
                </h2>
                <p>
                    Lebih dari sekadar situs web, Cinewatch adalah rumah bagi para pecinta sinema. Kami memberikan ruang bagi setiap pengguna untuk memberikan rating, ulasan, dan menyusun daftar tontonan pribadi mereka sendiri.
                </p>
            </section>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.8s ease-out forwards;
}
</style>
</x-layouts.app>
