<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-white uppercase tracking-tighter logo">Laporan Masalah</h1>
            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">Kelola laporan teknis dari pengguna</p>
        </div>
    </div>

    <div class="bg-[#0A0A0A] border border-white/5 rounded-2xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 text-[10px] uppercase font-black tracking-[2px] text-gray-400">
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Film</th>
                        <th class="px-6 py-4">Jenis</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($reports as $report)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-zinc-800 flex items-center justify-center text-[10px] font-bold text-white uppercase">
                                        {{ substr($report->user->name ?? 'G', 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-white">{{ $report->user->name ?? 'Guest' }}</span>
                                        <span class="text-[9px] text-gray-600 font-bold uppercase">{{ $report->user->email ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold text-red-500 hover:underline cursor-pointer">{{ $report->movie->title }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded bg-zinc-800 text-[9px] font-bold uppercase tracking-tighter text-gray-300">
                                    {{ str_replace('_', ' ', $report->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-[10px] text-gray-400 line-clamp-1 max-w-xs">{{ $report->description ?: '-' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if($report->status === 'pending')
                                    <span class="flex items-center gap-1.5 text-yellow-500 text-[10px] font-black uppercase">
                                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full animate-pulse"></span> Pending
                                    </span>
                                @else
                                    <span class="flex items-center gap-1.5 text-green-500 text-[10px] font-black uppercase">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Resolved
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                @if($report->status === 'pending')
                                    <button wire:click="resolve({{ $report->id }})" class="p-2 bg-green-500/10 text-green-500 hover:bg-green-500 hover:text-white rounded-lg transition-all" title="Tandai Selesai">
                                        <span class="material-symbols-outlined text-sm">check_circle</span>
                                    </button>
                                @endif
                                <a href="{{ route('admin.films.edit', $report->movie_id) }}" wire:navigate class="inline-block p-2 bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white rounded-lg transition-all" title="Perbaiki Link Video">
                                    <span class="material-symbols-outlined text-sm">edit_square</span>
                                </a>
                                <button wire:click="delete({{ $report->id }})" wire:confirm="Hapus laporan ini?" class="p-2 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition-all" title="Hapus">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-2 opacity-20">
                                    <span class="material-symbols-outlined text-4xl">inventory_2</span>
                                    <span class="text-xs font-bold uppercase tracking-[3px]">Belum ada laporan</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reports->hasPages())
            <div class="px-6 py-4 bg-white/[0.01] border-t border-white/5">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
</div>
