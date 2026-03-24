<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiChatWidget extends Component
{
    public $messages = [];
    public $newMessage = '';
    public $isOpen = false;
    public $isTyping = false;

    public function mount()
    {
        // Pesan sambutan awal dari AI CS
        $this->messages[] = [
            'role' => 'assistant',
            'content' => 'Halo! Saya asisten pintar Cinewatch. Ada yang bisa saya bantu terkait langganan VIP, kesulitan mencari film, atau hal lain?'
        ];
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|string|max:500'
        ]);

        $userMessage = $this->newMessage;
        
        // Simpan pesan user ke array
        $this->messages[] = [
            'role' => 'user',
            'content' => $userMessage
        ];

        // Kosongkan input dan set typing
        $this->newMessage = '';
        $this->isTyping = true;

        // Panggil API (jalan di belakang layar tanpa memblok UI karena Livewire call)
        $this->getAiResponse($userMessage);
    }

    protected function getAiResponse($userMessage)
    {
        // Menggunakan Pollinations AI network sebagai fallback utama karena Gemini diblokir oleh region/policy akun.
        // Tidak memerlukan API key dan dijamin lolos dari restriksi Google.
        
        $systemPrompt = 'Kamu adalah Customer Service pintar dari platform film legal bernama "Cinewatch". Gunakan bahasa gaul tapi sopan. Sangat membantu, ringkas, maksimal 2 paragraf singkat.';
        $userQuestion = $userMessage;
        $encodedPrompt = urlencode($userQuestion);
        $encodedSystem = urlencode($systemPrompt);
        $url = "https://text.pollinations.ai/{$encodedPrompt}?model=openai&system={$encodedSystem}";

        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
            $replyText = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError || $httpCode < 200 || $httpCode >= 300 || empty($replyText)) {
                Log::error('AI Proxy Error: HTTP ' . $httpCode . ' cURL: ' . $curlError);
                $this->messages[] = [
                    'role' => 'assistant',
                    'content' => 'Maaf, server AI sedang sibuk atau mengalami gangguan integrasi. Mohon coba beberapa saat lagi.'
                ];
            } else {
                $this->messages[] = [
                    'role' => 'assistant',
                    'content' => trim($replyText)
                ];
            }
        } catch (\Exception $e) {
            Log::error('AI Chat Error: ' . $e->getMessage());
            $this->messages[] = [
                'role' => 'assistant',
                'content' => 'Yah, koneksi ke asisten AI terputus. Boleh cek koneksimu atau coba lagi nanti ya!'
            ];
        }

        $this->isTyping = false;
    }

    public function render()
    {
        return view('livewire.ai-chat-widget');
    }
}
