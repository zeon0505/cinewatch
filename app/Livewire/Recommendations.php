<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Movie;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Recommendations extends Component
{
    public $recommendations = [];
    public $loading = true;

    public function mount()
    {
        $this->loadRecommendations();
    }

    public function loadRecommendations()
    {
        if (!Auth::check()) {
            $this->loading = false;
            return;
        }

        $history = History::where('user_id', Auth::id())
            ->with('movie')
            ->orderBy('last_watched', 'desc')
            ->take(5)
            ->get();

        if ($history->isEmpty()) {
            // Suggeest trending if no history
            $isKids = session('is_kids_mode', false);
            $this->recommendations = Movie::when($isKids, fn($q) => $q->kids())
                ->orderBy('views', 'desc')
                ->take(6)
                ->get();
            $this->loading = false;
            return;
        }

        $titles = $history->pluck('movie.title')->toArray();
        $titlesStr = implode(', ', $titles);

        try {
            // Call the local proxy with a specialized system prompt for recommendation
            $response = $this->askZeonForAdvice($titlesStr);
            
            if ($response) {
                // Parse AI response to find potential movie titles
                // Zeon will return a list. We try to match them in our DB.
                $suggestedTitles = $this->parseTitles($response);
                
                if (!empty($suggestedTitles)) {
                    $isKids = session('is_kids_mode', false);
                    $this->recommendations = Movie::where(function($q) use ($suggestedTitles) {
                        foreach ($suggestedTitles as $title) {
                            $q->orWhere('title', 'like', '%' . $title . '%');
                        }
                    })
                    ->when($isKids, fn($q) => $q->kids())
                    ->take(6)
                    ->get();
                }
            }
        } catch (\Exception $e) {
            Log::error("Recommendation failed: " . $e->getMessage());
        }

        // Fallback to latest movies if AI failed or returned no matches
        if (empty($this->recommendations)) {
            $isKids = session('is_kids_mode', false);
            $this->recommendations = Movie::when($isKids, fn($q) => $q->kids())
                ->latest()
                ->take(6)
                ->get();
        }

        $this->loading = false;
    }

    protected function askZeonForAdvice($history)
    {
        $groqKey = config('services.groq.key');
        if (!$groqKey) return null;

        $payload = [
            'model'    => 'llama-3.3-70b-versatile',
            'messages' => [
                ['role' => 'system',  'content' => 'Kamu adalah Zeon, AI Rekomendasi Cinewatch. User baru saja menonton: ' . $history . '. Sebutkan 5 judul film populer lain yang sejenis (bisa yang ada di database umum). Jawab HANYA dengan daftar judul film, dipisahkan koma, tanpa tambahan kata lain.'],
                ['role' => 'user',    'content' => 'Berikan rekomendasi film yang mirip.'],
            ],
            'max_tokens' => 100,
            'temperature' => 0.5,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $groqKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', $payload);

        if ($response->successful()) {
            return $response->json()['choices'][0]['message']['content'] ?? null;
        }

        return null;
    }

    protected function parseTitles($aiOutput)
    {
        // Simple comma split and clean up
        $rawTitles = explode(',', $aiOutput);
        return array_map(fn($t) => trim(str_replace(['"', "'", '-', '1.', '2.', '3.', '4.', '5.'], '', $t)), $rawTitles);
    }

    public function render()
    {
        return view('livewire.recommendations');
    }
}
