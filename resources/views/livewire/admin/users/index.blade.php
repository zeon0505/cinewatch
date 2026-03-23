<div class="space-y-10">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-white uppercase tracking-tighter">Manajemen Pengguna</h1>
            <p class="text-[10px] text-gray-500 mt-1 uppercase font-bold tracking-widest italic tracking-widest leading-relaxed line-clamp-2 truncate">Atur hak akses dan status akun member platform.</p>
        </div>
    </div>

    <!-- Search Tool -->
    <div class="card p-4 flex gap-4">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau email..." class="flex-1 bg-black/40 border border-white/5 rounded-lg p-3 text-white focus:ring-2 focus:ring-red-600 outline-none placeholder:text-gray-700 text-sm" />
    </div>

    <!-- User Table -->
    <div class="card overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-white/5 text-[10px] text-gray-500 uppercase font-bold tracking-[2px] border-b border-white/5">
                <tr>
                    <th class="p-6">Informasi Member</th>
                    <th class="p-6">Role & Status</th>
                    <th class="p-6">Tgl Bergabung</th>
                    <th class="p-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($users as $user)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=E50914&color=fff" class="w-10 h-10 rounded-full border border-white/5 shadow-2xl" />
                                <div>
                                    <h3 class="text-white font-bold text-sm uppercase tracking-tight">{{ $user->name }}</h3>
                                    <p class="text-gray-600 text-xs italic line-clamp-2 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-6">
                             <div class="flex flex-col gap-2">
                                  <span class="px-3 py-1 bg-white/5 text-gray-400 text-[10px] font-bold uppercase tracking-widest rounded-full border border-white/5 w-fit">
                                       {{ $user->role }}
                                  </span>
                                  <span class="text-[10px] font-black uppercase {{ $user->status === 'active' ? 'text-green-500' : 'text-red-500' }}">● {{ strtoupper($user->status) }}</span>
                             </div>
                        </td>
                        <td class="p-6">
                            <span class="text-gray-700 text-[10px] font-bold uppercase tracking-widest italic tracking-tighter">{{ $user->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="p-6 text-right">
                             @if($user->role !== 'admin')
                                <div class="flex items-center justify-end gap-3">
                                    <button wire:click="toggleStatus({{ $user->id }})" class="px-6 py-2 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white rounded-lg transition-all text-[10px] font-black uppercase tracking-widest">
                                         {{ $user->status === 'active' ? 'Suspend' : 'Activate' }}
                                    </button>
                                    <button onclick="confirm('Yakin ingin menghapus user ini?') || event.stopImmediatePropagation()" wire:click="delete({{ $user->id }})" class="p-2.5 bg-red-600/10 text-red-500 hover:bg-red-600 hover:text-white rounded-lg transition-all">🗑️</button>
                                </div>
                             @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-6">
            {{ $users->links() }}
        </div>
    </div>
</div>
