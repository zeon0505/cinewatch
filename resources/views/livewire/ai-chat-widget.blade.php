<div 
    x-data="{ 
        isOpen: @entangle('isOpen'),
        scrollToBottom() {
            const chatBox = document.getElementById('ai-chat-box')
            if (chatBox) {
                setTimeout(() => {
                    chatBox.scrollTop = chatBox.scrollHeight
                }, 100)
            }
        }
    }" 
    x-init="$watch('isOpen', value => { if(value) scrollToBottom() })"
    class="fixed bottom-6 right-6 z-[9999] flex flex-col items-end"
    @chat-updated.window="scrollToBottom()"
>
    <!-- Chat Widget Panel -->
    <div 
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 translate-y-8 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-8 scale-95"
        class="mb-4 w-[350px] sm:w-[380px] h-[500px] bg-zinc-900/95 backdrop-blur-2xl border border-white/10 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] flex flex-col overflow-hidden"
        style="display: none;"
    >
        <!-- Header -->
        <div class="p-4 bg-gradient-to-r from-red-600 to-red-900 flex items-center justify-between shadow-md relative z-10 shrink-0">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center p-1">
                        <img src="https://api.dicebear.com/7.x/bottts/svg?seed=Cinewatch&backgroundColor=transparent" class="w-full h-full object-cover rounded-full" />
                    </div>
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-red-900 rounded-full"></span>
                </div>
                <div>
                    <h3 class="text-white font-black text-sm uppercase tracking-widest leading-tight">Yoyo.AI</h3>
                    <p class="text-[10px] text-white/70 font-bold uppercase tracking-widest mt-0.5">Cinewatch Support</p>
                </div>
            </div>
            <button @click="isOpen = false" class="w-8 h-8 flex items-center justify-center text-white/50 hover:text-white hover:bg-white/10 rounded-full transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- Chat Area -->
        <div id="ai-chat-box" class="flex-1 overflow-y-auto p-4 space-y-4 custom-scrollbar bg-[#050505]/50">
            @foreach($messages as $msg)
                @if($msg['role'] === 'assistant')
                    <!-- AI Message -->
                    <div class="flex gap-3 max-w-[85%]">
                        <div class="w-6 h-6 shrink-0 bg-white rounded-full flex items-center justify-center p-0.5 mt-1 border border-white/10">
                            <img src="https://api.dicebear.com/7.x/bottts/svg?seed=Cinewatch&backgroundColor=transparent" class="w-full h-full rounded-full" />
                        </div>
                        <div class="bg-zinc-800 text-gray-200 text-xs px-4 py-3 rounded-2xl rounded-tl-sm border border-white/5 leading-relaxed shadow-sm">
                            {!! Str::markdown($msg['content']) !!}
                        </div>
                    </div>
                @else
                    <!-- User Message -->
                    <div class="flex gap-3 max-w-[85%] self-end ml-auto justify-end">
                        <div class="bg-red-600 text-white text-xs px-4 py-3 rounded-2xl rounded-tr-sm shadow-md leading-relaxed">
                            {{ $msg['content'] }}
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Typing Indicator -->
            @if($isTyping)
                <div class="flex gap-3 max-w-[85%]">
                    <div class="w-6 h-6 shrink-0 bg-white rounded-full flex items-center justify-center p-0.5 mt-1 border border-white/10">
                        <img src="https://api.dicebear.com/7.x/bottts/svg?seed=Cinewatch&backgroundColor=transparent" class="w-full h-full rounded-full" />
                    </div>
                    <div class="bg-zinc-800 text-gray-200 text-xs px-4 py-3 rounded-2xl rounded-tl-sm border border-white/5 flex items-center gap-1 shadow-sm">
                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce [animation-delay:-0.3s]"></span>
                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce [animation-delay:-0.15s]"></span>
                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce"></span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Input Area -->
        <div class="p-3 bg-zinc-900 border-t border-white/5 relative shrink-0">
            <!-- Intercepting purely through Livewire, prevent default form submit -->
            <form wire:submit.prevent="sendMessage" x-data="{ msg: @entangle('newMessage') }" class="flex gap-2 relative">
                <input 
                    type="text" 
                    x-model="msg"
                    placeholder="Tanya Yoyo seputar film..." 
                    class="w-full bg-black/50 border border-white/10 text-white text-xs rounded-xl px-4 py-3 pb-3 pr-12 focus:outline-none focus:border-red-500/50 focus:ring-1 focus:ring-red-500/50 transition-all font-medium placeholder-gray-600"
                    {{ $isTyping ? 'disabled' : '' }}
                >
                <button 
                    type="submit" 
                    class="absolute right-1.5 top-1.5 bottom-1.5 w-8 flex items-center justify-center bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    x-bind:disabled="!msg || msg.trim().length === 0 || {{ $isTyping ? 'true' : 'false' }}"
                    @click="setTimeout(() => scrollToBottom(), 100)"
                >
                    <span class="material-symbols-outlined text-[16px] -rotate-45 ml-1">send</span>
                </button>
            </form>
            <div class="text-center mt-2">
                <span class="text-[8px] text-gray-600 font-bold uppercase tracking-widest">Powered by Gemini AI</span>
            </div>
        </div>
    </div>

    <!-- Floating Trigger Button -->
    <button 
        @click="isOpen = !isOpen"
        class="w-14 h-14 bg-red-600 hover:bg-red-700 text-white rounded-full flex items-center justify-center shadow-[0_0_20px_rgba(229,9,20,0.4)] hover:scale-105 active:scale-95 transition-all group relative border border-red-400/30"
    >
        <span x-show="!isOpen" class="material-symbols-outlined text-[28px] group-hover:rotate-12 transition-transform">smart_toy</span>
        <span x-show="isOpen" style="display: none;" class="material-symbols-outlined text-[28px] rotate-90 group-hover:rotate-0 transition-transform">close</span>
        
        <!-- Online Indicator Pulse -->
        <span x-show="!isOpen" class="absolute top-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-[#050505] rounded-full z-10"></span>
        <span x-show="!isOpen" class="absolute top-0 right-0 w-3.5 h-3.5 bg-green-500 rounded-full animate-ping z-0"></span>
    </button>
</div>
