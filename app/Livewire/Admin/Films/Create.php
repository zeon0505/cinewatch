<?php

namespace App\Livewire\Admin\Films;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Movie;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;

class Create extends Component
{
    use WithFileUploads;

    // Film Data Properties
    public $title, $slug, $description, $thumbnail, $video_url, $duration, $year, $tmdb_id;
    public $category_id; // Legacy, keeping for minimal backward compatibility
    public $selectedCategories = []; // NEW: Array for many-to-many
    public $audience_type = 'adult'; // NEW: adult/kids
    public $rating_value = 0.0; // NEW: manual rating
    public $age_rating = 'PG-13'; // NEW: extra metadata
    public $is_premium = false; // NEW: VIP logic
    public $posterFile; // For local file upload
    
    public $apiSource = 'tmdb'; // New property for source selection
    public $sq = ''; // Renamed from searchQuery to avoid collisions
    public $searchSource = 'tmdb'; // 'tmdb' or 'local'
    public $searchResults = [];
    public $showResults = false;
    public $apiStatus = 'checking'; // 'checking', 'online', 'offline'

    public function scrapeOfficial()
    {
        $url = request('url');
        if (!$url) return response()->json(['error' => 'URL Kosong'], 400);

        try {
            $response = Http::withoutVerifying()->timeout(20)->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36'
            ])->get($url);

            if (!$response->successful()) throw new \Exception('Gagal akses situs provider.');

            $html = $response->body();
            $res = [
                'title' => '',
                'image' => '',
                'description' => 'Nonton movie streaming online kualitas tinggi.',
                'video' => $url
            ];

            if (preg_match('/<meta property="og:title" content="([^"]+)"/i', $html, $m)) $res['title'] = html_entity_decode($m[1]);
            if (preg_match('/<meta property="og:image" content="([^"]+)"/i', $html, $m)) $res['image'] = $m[1];
            if (preg_match('/<meta property="og:description" content="([^"]+)"/i', $html, $m)) $res['description'] = html_entity_decode($m[1]);

            if (empty($res['title']) && preg_match('/<title>([^<]+)<\/title>/i', $html, $m)) $res['title'] = $m[1];

            $bad_words = ['Nonton', 'LayarKaca21', 'LK21', 'IDLIX', 'D21', 'Streaming', 'Subtitle Indonesia', 'Online', 'Movie', 'Film', 'Indoxxi', 'Official'];
            $res['title'] = trim(preg_replace('/\b(' . implode('|', $bad_words) . ')\b/i', '', $res['title'] ?? ''));
            $res['title'] = trim($res['title'], " -|[]()\t\n\r\0\x0B");

            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected $api_key = 'c9772ee20fb25405e32ca19208a0ab6e';

    protected $rules = [
        'title' => 'required|min:2',
        'category_id' => 'required|exists:categories,id',
    ];

    public function changeSource($source)
    {
        $this->searchSource = $source;
        $this->executeSearch();
    }

    public function testSearch()
    {
        $this->searchResults = [
            [
                'id' => 'tt0120804',
                'title' => 'FIX: Resident Evil (PROVED)',
                'poster' => 'https://m.media-amazon.com/images/M/MV5BMTY0NjY1MTYyM15BMl5BanBnXkFtZTYwNjc3Njc3._V1_SX300.jpg',
                'year' => '2002',
                'type' => 'omdb'
            ]
        ];
        $this->showResults = true;
    }

    public function executeSearch($manualQuery = null)
    {
        $query = $manualQuery ? trim($manualQuery) : trim($this->sq);
        if ($manualQuery) $this->sq = $manualQuery; // Update server state
        
        if (strlen($query) < 2) {
            $this->searchResults = [];
            $this->showResults = false;
            return;
        }

        $this->searchResults = [];
        $this->showResults = true; // FORCE PANEL SHOW
        
        try {
            Log::info('Search triggered for: ' . $query);
            
            // CHECK CONNECTIVITY FIRST
            $check = Http::withoutVerifying()->timeout(3)->get("https://www.omdbapi.com/");
            $this->apiStatus = $check->successful() || $check->status() === 401 ? 'online' : 'offline';

            // Priority 1: OMDB
            $res = Http::withoutVerifying()->timeout(10)->get("https://www.omdbapi.com/", [
                'apikey' => 'b9bd48a6',
                's' => $query,
                'type' => 'movie'
            ]);
            
            if ($res->successful() && ($res->json()['Response'] ?? '') === 'True') {
                $this->searchResults = collect($res->json()['Search'])->take(15)->map(function($item) {
                    return [
                        'id' => $item['imdbID'],
                        'title' => $item['Title'],
                        'poster' => ($item['Poster'] ?? '') !== 'N/A' ? $item['Poster'] : '',
                        'year' => $item['Year'],
                        'type' => 'omdb'
                    ];
                })->toArray();
                Log::info('Found results in OMDB: ' . count($this->searchResults));
            } else {
                Log::info('OMDB failed or empty, trying TMDB...');
                // Priority 2: TMDB
                $this->fetchFromTMDB($query);
            }
        } catch (\Exception $e) {
            Log::error('Search Exception: ' . $e->getMessage());
            $this->fetchFromTMDB($query);
        }

        if (count($this->searchResults) === 0) {
            session()->flash('info', 'Film "' . $query . '" tidak ditemukan di database.');
            $this->showResults = true; // Show the "NOT FOUND" message
        }
    }

    private function fetchFromTMDB($query)
    {
        $res = Http::withoutVerifying()->timeout(5)->get("https://api.themoviedb.org/3/search/movie", [
            'api_key' => $this->api_key,
            'query' => $query,
            'language' => 'id-ID'
        ]);
        if ($res->successful()) {
            $this->searchResults = collect($res->json()['results'])->take(10)->map(function($item) {
                return [
                    'id' => $item['id'],
                    'title' => $item['title'],
                    'poster' => $item['poster_path'] ? 'https://image.tmdb.org/t/p/w200' . $item['poster_path'] : '',
                    'year' => substr($item['release_date'] ?? '', 0, 4),
                    'type' => 'tmdb'
                ];
            })->toArray();
        }
    }

    public function selectItem($index)
    {
        if (!isset($this->searchResults[$index])) return;
        
        $item = $this->searchResults[$index];
        $this->title = $item['title'];
        $this->slug = Str::slug($item['title']);
        $this->year = $item['year'];
        $this->tmdb_id = $item['id'] ?? null; // Use 'id' from searchResults, which could be TMDB ID or IMDB ID
        $this->thumbnail = ($item['poster'] ?? '') !== 'N/A' ? $item['poster'] : '';
        
        // Auto-fetch extra details for duration & rating if possible
        // Prioritize OMDB for detailed info if an IMDB ID is available
        $imdbID = ($item['type'] === 'omdb') ? $item['id'] : null;

        if ($imdbID) {
            try {
                $response = Http::timeout(5)->get("http://www.omdbapi.com/", [
                    'apikey' => 'b9bd48a6', // Using the OMDB API key from executeSearch
                    'i' => $imdbID
                ]);
                
                if ($response->successful()) {
                    $data = $response->json();
                    $this->description = $data['Plot'] ?? '';
                    $this->duration = $data['Runtime'] ?? '';
                    $this->rating_value = isset($data['imdbRating']) && $data['imdbRating'] !== 'N/A' ? (float)$data['imdbRating'] : 0.0;
                    $this->age_rating = $data['Rated'] ?? 'PG-13';

                    // Simple auto-detect for kids (G, TV-Y, etc)
                    if (in_array($this->age_rating, ['G', 'TV-Y', 'TV-G', 'TV-Y7'])) {
                        $this->audience_type = 'kids';
                    } else {
                        $this->audience_type = 'adult';
                    }
                    // If video_url is not set, try to set it from IMDB ID
                    if (empty($this->video_url)) {
                        $this->video_url = "https://vidsrc.to/embed/movie/{$imdbID}";
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error fetching OMDB details in selectItem: ' . $e->getMessage());
            }
        } elseif ($item['type'] === 'tmdb' && $this->tmdb_id) {
            // Fallback to TMDB for details if no IMDB ID or OMDB failed
            try {
                $res = Http::timeout(5)->get("https://api.themoviedb.org/3/movie/{$this->tmdb_id}", [
                    'api_key' => $this->api_key, // Using the TMDB API key
                    'language' => 'id-ID'
                ]);
                if ($res->successful()) {
                    $data = $res->json();
                    $this->description = $data['overview'] ?? '';
                    $this->duration = ($data['runtime'] ?? 0) . ' min';
                    // TMDB doesn't have direct 'Rated' or 'imdbRating' in this endpoint,
                    // so we'll keep defaults or try to infer if needed.
                    // For video_url, try to get imdb_id from TMDB details
                    $tmdb_imdb_id = $data['imdb_id'] ?? null;
                    if (empty($this->video_url)) {
                        $this->video_url = $tmdb_imdb_id ? "https://vidsrc.to/embed/movie/{$tmdb_imdb_id}" : "https://vidsrc.to/embed/movie/{$this->tmdb_id}";
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error fetching TMDB details in selectItem: ' . $e->getMessage());
            }
        } else {
            // Local / Local LK21 data or other types without external API details
            $this->description = "Data film dari sumber lokal populer.";
            // No video_url set here, user would need to add manually
        }

        session()->flash('message', 'Data film "' . $this->title . '" berhasil dimuat!');
        $this->showResults = false;
        $this->searchResults = [];
        $this->sq = '';
    }

    public function selectFilm($id, $mediaType)
    {
        $this->tmdb_id = $id;
        // This method seems to be a duplicate or older version of selectItem,
        // and its call to fetchFromTMDB($mediaType) is incorrect as fetchFromTMDB expects a query.
        // Keeping it as is per instruction, but noting potential issue.
        // If this method is still used, it might need re-evaluation.
        // For now, assuming selectItem is the primary selection method.
        $this->showResults = false;
        $this->searchResults = [];
        $this->sq = '';
    }

    public function fetchAutoData($imdbID, $title, $poster, $year)
    {
        $this->title = $title;
        $this->thumbnail = $poster;
        $this->year = substr($year, 0, 4);
        $this->video_url = 'https://vidsrc.to/embed/movie/' . $imdbID;
        $this->tmdb_id = $imdbID;
        
        try {
            $response = Http::timeout(3)->get("https://www.omdbapi.com/?apikey=b9bd48a6&i={$imdbID}&plot=full");
            if ($response->successful()) {
                $d = $response->json();
                if (($d['Response'] ?? '') === 'True') {
                    if (isset($d['Plot']) && $d['Plot'] !== 'N/A') $this->description = $d['Plot'];
                    if (isset($d['Runtime']) && $d['Runtime'] !== 'N/A') $this->duration = $d['Runtime'];
                }
            }
        } catch (\Exception $e) {}
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'video_url' => 'required|url',
            'selectedCategories' => 'required|array|min:1',
            'audience_type' => 'required',
        ]);

        $thumbnailPath = $this->thumbnail;

        if ($this->posterFile) {
            $thumbnailPath = $this->posterFile->store('posters', 'public');
            $thumbnailPath = '/storage/' . $thumbnailPath;
        }

        $movie = Movie::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'thumbnail' => $thumbnailPath,
            'video_url' => $this->video_url,
            'duration' => $this->duration,
            'year' => $this->year ?? 2024,
            'tmdb_id' => $this->tmdb_id,
            'audience_type' => $this->audience_type,
            'rating_value' => $this->rating_value,
            'age_rating' => $this->age_rating,
            'is_premium' => $this->is_premium,
            'status' => 'published',
            'category_id' => $this->selectedCategories[0] ?? null, // Fallback for legacy
        ]);

        // Sync many-to-many genres
        $movie->categories()->sync($this->selectedCategories);

        return redirect()->route('admin.films.index')->with('message', 'Film CINEWATCH Berhasil Ditambahkan!');
    }

    #[Layout('admin.dashboard-layout')]
    public function render()
    {
        $categories = Category::all();
        return view('livewire.admin.films.create', compact('categories'));
    }
}
