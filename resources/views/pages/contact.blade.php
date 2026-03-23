<x-layouts.app>
<div class="min-h-screen bg-[#0a0a0a] text-white pt-32 pb-20 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16 animate-fadeIn">
            <h1 class="text-5xl font-black uppercase tracking-tighter mb-4 logo">Hubungi <span class="text-[#E50914]">Kami</span></h1>
            <p class="text-gray-500 font-bold uppercase tracking-[4px] text-xs">Punya pertanyaan atau masukan? Kami siap membantu.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-12 lg:gap-24 items-start">
            <!-- Contact Info -->
            <div class="space-y-12 animate-fadeInLeft">
                <div class="flex gap-6">
                    <div class="w-14 h-14 bg-[#E50914]/10 rounded-2xl flex items-center justify-center border border-[#E50914]/20 shrink-0">
                        <span class="material-symbols-outlined text-[#E50914]">location_on</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black uppercase tracking-widest mb-2">Kantor Pusat</h3>
                        <p class="text-gray-400">Jl. Digital No. 101, Lantai 4<br>Jakarta Selatan, Indonesia 12190</p>
                    </div>
                </div>

                <div class="flex gap-6">
                    <div class="w-14 h-14 bg-[#E50914]/10 rounded-2xl flex items-center justify-center border border-[#E50914]/20 shrink-0">
                        <span class="material-symbols-outlined text-[#E50914]">mail</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black uppercase tracking-widest mb-2">Layanan Email</h3>
                        <p class="text-gray-400">Support: support@cinewatch.test<br>Bisnis: business@cinewatch.test</p>
                    </div>
                </div>

                <div class="flex gap-6">
                    <div class="w-14 h-14 bg-[#E50914]/10 rounded-2xl flex items-center justify-center border border-[#E50914]/20 shrink-0">
                        <span class="material-symbols-outlined text-[#E50914]">phone</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black uppercase tracking-widest mb-2">Telepon</h3>
                        <p class="text-gray-400">Senin - Jumat, 09:00 - 17:00<br>+62 21 1234 5678</p>
                    </div>
                </div>
            </div>

            <!-- Simple Form Mockup -->
            <div class="bg-white/[0.03] border border-white/10 rounded-3xl p-8 lg:p-12 animate-fadeInRight">
                <h3 class="text-2xl font-black uppercase tracking-widest mb-8">Kirim Pesan Cepat</h3>
                <form class="space-y-6">
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Nama Lengkap</label>
                            <input type="text" placeholder="John Doe" class="w-full bg-black/50 border border-white/10 rounded-xl px-5 py-3.5 text-sm text-white focus:border-[#E50914] outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Alamat Email</label>
                            <input type="email" placeholder="john@example.com" class="w-full bg-black/50 border border-white/10 rounded-xl px-5 py-3.5 text-sm text-white focus:border-[#E50914] outline-none transition-all">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Pesan Anda</label>
                        <textarea rows="5" placeholder="Tuliskan pesan Anda di sini..." class="w-full bg-black/50 border border-white/10 rounded-xl px-5 py-3.5 text-sm text-white focus:border-[#E50914] outline-none transition-all"></textarea>
                    </div>
                    <button type="button" class="w-full bg-[#E50914] text-white py-4 rounded-xl font-black uppercase tracking-widest text-xs hover:scale-[1.02] transition-all shadow-xl shadow-red-900/20">Kirim Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeInLeft { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }
@keyframes fadeInRight { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }

.animate-fadeIn { animation: fadeIn 0.8s ease-out forwards; }
.animate-fadeInLeft { animation: fadeInLeft 0.8s ease-out forwards; }
.animate-fadeInRight { animation: fadeInRight 0.8s ease-out forwards; }
</style>
</x-layouts.app>
