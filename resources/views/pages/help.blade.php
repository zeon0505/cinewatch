<x-layouts.app>
<div class="min-h-screen bg-[#050505] text-white pt-32 pb-20 px-6 md:px-20">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tighter mb-6 logo">Pusat <span class="text-red-600">Bantuan</span></h1>
            <p class="text-gray-500 max-w-2xl mx-auto text-lg font-medium">Temukan jawaban atas pertanyaan Anda atau pelajari cara memaksimalkan pengalaman menonton Anda di Cinewatch.</p>
        </div>

        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto mb-20">
            <div class="relative group">
                <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-red-600 transition-colors">search</span>
                <input type="text" placeholder="Cari bantuan (misal: cara bayar, ganti profil...)" class="w-full bg-white/[0.03] border border-white/10 rounded-2xl py-5 pl-14 pr-6 text-white focus:ring-1 focus:ring-red-600 outline-none transition-all placeholder:text-gray-700">
            </div>
        </div>

        <!-- Categories -->
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white/[0.03] border border-white/10 p-10 rounded-3xl hover:bg-white/[0.05] transition-all group">
                <span class="material-symbols-outlined text-4xl text-red-600 mb-6 scale-100 group-hover:scale-110 transition-transform">account_circle</span>
                <h3 class="text-xl font-black uppercase tracking-widest mb-4">Akun & Profil</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-6">Kelola profil Anda, ganti password, atau atur batasan usia (Mode Anak).</p>
                <a href="#" class="text-red-600 text-xs font-black uppercase tracking-widest flex items-center gap-2 hover:gap-3 transition-all">Pelajari <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
            </div>

            <div class="bg-white/[0.03] border border-white/10 p-10 rounded-3xl hover:bg-white/[0.05] transition-all group">
                <span class="material-symbols-outlined text-4xl text-red-600 mb-6 scale-100 group-hover:scale-110 transition-transform">payments</span>
                <h3 class="text-xl font-black uppercase tracking-widest mb-4">Langganan VIP</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-6">Informasi mengenai paket VIP, metode pembayaran, dan riwayat transaksi.</p>
                <a href="#" class="text-red-600 text-xs font-black uppercase tracking-widest flex items-center gap-2 hover:gap-3 transition-all">Pelajari <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
            </div>

            <div class="bg-white/[0.03] border border-white/10 p-10 rounded-3xl hover:bg-white/[0.05] transition-all group">
                <span class="material-symbols-outlined text-4xl text-red-600 mb-6 scale-100 group-hover:scale-110 transition-transform">devices</span>
                <h3 class="text-xl font-black uppercase tracking-widest mb-4">Teknis & Player</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-6">Kendala pemutaran video, pengaturan subtitle, atau cara menginstall PWA.</p>
                <a href="#" class="text-red-600 text-xs font-black uppercase tracking-widest flex items-center gap-2 hover:gap-3 transition-all">Pelajari <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
            </div>
        </div>

        <!-- Contact Support Floating -->
        <div class="mt-20 p-12 bg-gradient-to-r from-red-600/20 to-transparent border border-red-600/20 rounded-3xl flex flex-col md:flex-row items-center justify-between gap-8">
            <div>
                <h2 class="text-2xl font-black uppercase tracking-widest mb-2">Masih butuh bantuan?</h2>
                <p class="text-gray-400">Tim support kami siap membantu Anda 24/7.</p>
            </div>
            <a href="{{ route('contact') }}" class="bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-xl font-black uppercase tracking-widest transition-all">Hubungi Kami Sekarang</a>
        </div>
    </div>
</div>
</x-layouts.app>
