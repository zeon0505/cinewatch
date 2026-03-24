<?php

namespace App\Livewire;

use Livewire\Component;

class AiChatWidget extends Component
{
    public $messages = [];
    public $isOpen = false;

    public function mount()
    {
        $this->messages[] = [
            'role'    => 'assistant',
            'content' => 'Halo! Saya Zeon, asisten pintar Cinewatch 🎬 Ada yang bisa saya bantu soal film, langganan VIP, atau hal lain?',
        ];
    }

    /**
     * Dipanggil dari JS setelah respons AI diterima di browser,
     * supaya pesan tersimpan ke Livewire state dan bisa di-render ulang.
     */
    public function addMessage(string $role, string $content)
    {
        $this->messages[] = [
            'role'    => $role,
            'content' => $content,
        ];
    }

    public function render()
    {
        return view('livewire.ai-chat-widget');
    }
}
