<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-white uppercase tracking-tighter logo">Request Film</h1>
            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">Daftar film yang diminta oleh pengguna</p>
        </div>
    </div>

    <div class="bg-[#0A0A0A] border border-white/5 rounded-2xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 text-[10px] uppercase font-black tracking-[2px] text-gray-400">
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Judul Film</th>
                        <th class="px-6 py-4">Tahun</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($requests as $req)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-zinc-800 flex items-center justify-center text-[10px] font-bold text-white uppercase">
                                        {{ substr($req->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-white">{{ $req->user->name ?? 'User' }}</span>
                                        <span class="text-[9px] text-gray-600 font-bold uppercase tracking-tighter">{{ $req->user->email ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-white">{{ $req->title }}</span>
                                    @if($req->description)
                                        <span class="text-[9px] text-gray-500 italic mt-0.5">"{{ $req->description }}"</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold text-gray-400">{{ $req->year ?: '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'text-yellow-500',
                                        'processed' => 'text-green-500',
                                        'rejected' => 'text-red-500',
                                    ];
                                @endphp
                                <span class="flex items-center gap-1.5 {{ $statusColors[$req->status] }} text-[10px] font-black uppercase">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $req->status === 'pending' ? 'bg-yellow-500 animate-pulse' : ($req->status === 'processed' ? 'bg-green-500' : 'bg-red-500') }}"></span> 
                                    {{ $req->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                @if($req->status === 'pending')
                                    <button wire:click="process({{ $req->id }})" class="p-2 bg-green-500/10 text-green-500 hover:bg-green-500 hover:text-white rounded-lg transition-all" title="Proses">
                                        <span class="material-symbols-outlined text-sm">check_circle</span>
                                    </button>
                                    <button wire:click="reject({{ $req->id }})" class="p-2 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition-all" title="Tolak">
                                        <span class="material-symbols-outlined text-sm">cancel</span>
                                    </button>
                                @endif
                                <button wire:click="delete({{ $req->id }})" wire:confirm="Hapus data request ini?" class="p-2 bg-gray-500/10 text-gray-500 hover:bg-gray-500 hover:text-white rounded-lg transition-all" title="Hapus">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-2 opacity-20">
                                    <span class="material-symbols-outlined text-4xl">playlist_add</span>
                                    <span class="text-xs font-bold uppercase tracking-[3px]">Belum ada request film</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($requests->hasPages())
            <div class="px-6 py-4 bg-white/[0.01] border-t border-white/5">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</div>
