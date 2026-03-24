<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\MovieDetail;
use App\Livewire\Player;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;
use App\Models\Category;
use App\Models\History;
use Illuminate\Support\Facades\Artisan;
use App\Livewire\User\Subscription;

Route::get('/', function () {
    $isKids = session('is_kids_mode', false);
    
    $trendingMovies = Movie::when($isKids, fn($q) => $q->kids())
        ->orderBy('views', 'desc')
        ->take(10)
        ->get();
        
    $latestMovies = Movie::when($isKids, fn($q) => $q->kids())
        ->latest()
        ->take(10)
        ->get();

    $continueWatching = collect();
    if (Auth::check()) {
        $continueWatching = History::where('user_id', Auth::id())
            ->where('progress', '>', 0)
            ->with(['movie' => function($q) use ($isKids) {
                $q->when($isKids, fn($query) => $query->kids());
            }])
            ->whereHas('movie')
            ->orderBy('last_watched', 'desc')
            ->take(10)
            ->get();
    }
        
    $categories = Category::withCount(['movies' => function($q) use ($isKids) {
        $q->when($isKids, fn($query) => $query->kids());
    }])->get();
    
    $featuredFilmIds = [];
    if (\Illuminate\Support\Facades\Storage::disk('local')->exists('settings.json')) {
        $settings = json_decode(\Illuminate\Support\Facades\Storage::disk('local')->get('settings.json'), true);
        $featuredFilmIds = $settings['featured_film_ids'] ?? [];
    }

    if (!empty($featuredFilmIds)) {
        $heroMovies = Movie::when($isKids, fn($q) => $q->kids())
            ->whereIn('id', $featuredFilmIds)
            ->get();
    } else {
        $heroMovies = collect();
    }

    if ($heroMovies->isEmpty()) {
        $heroMovies = Movie::when($isKids, fn($q) => $q->kids())
            ->latest()
            ->take(3)
            ->get();
    }

    return view('welcome', compact('trendingMovies', 'latestMovies', 'categories', 'heroMovies', 'continueWatching'));
})->name('home');
Route::get('/login', Login::class)->name('login')->middleware('guest');
Route::get('/register', Register::class)->name('register')->middleware('guest');

Route::get('/movie/{slug}', MovieDetail::class)->name('movie.detail');
Route::get('/watch/{id}', Player::class)->name('movie.watch');
Route::get('/vip', Subscription::class)->name('subscription');
Route::get('/profiles', \App\Livewire\Auth\ProfileSelection::class)->name('profiles')->middleware('auth');
Route::get('/trending', \App\Livewire\Trending::class)->name('trending');
Route::get('/new-releases', \App\Livewire\NewReleases::class)->name('new.releases');
Route::get('/category/{slug}', \App\Livewire\CategoryDetail::class)->name('category.detail');

Route::get('/about', function() { return view('pages.about'); })->name('about');
Route::get('/contact', function() { return view('pages.contact'); })->name('contact');
Route::get('/help', function() { return view('pages.help'); })->name('help');
Route::get('/faq', function() { return view('pages.faq'); })->name('faq');
Route::get('/report-link', function() { return view('pages.report'); })->name('report.link');
Route::get('/app', function() { return view('pages.download'); })->name('app.download');
Route::get('/privacy', function() { return view('pages.privacy'); })->name('privacy');
Route::get('/terms', function() { return view('pages.terms'); })->name('terms');

Route::post('/payments/webhook', [App\Http\Controllers\PaymentController::class, 'webhook']);

// AI Chat Proxy — browser call this, server forwards to Groq (Pollinations blocked by ISP)
Route::post('/ai/chat', function (\Illuminate\Http\Request $request) {
    $request->validate(['message' => 'required|string|max:500']);
    $userMessage = $request->input('message');

    $groqKey = config('services.groq.key');

    if (!$groqKey) {
        return response()->json(['error' => 'API key belum diset. Hubungi admin.'], 503);
    }

    $payload = [
        'model'    => 'llama-3.3-70b-versatile',
        'messages' => [
            ['role' => 'system',  'content' => 'Kamu adalah Zeon, Customer Service pintar dari platform film legal bernama "Cinewatch". Gunakan bahasa gaul tapi sopan. Sangat membantu, ringkas, maksimal 2 paragraf singkat.'],
            ['role' => 'user',    'content' => $userMessage],
        ],
        'max_tokens' => 300,
        'temperature' => 0.7,
    ];

    $ch = curl_init('https://api.groq.com/openai/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $groqKey,
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr  = curl_error($ch);
    curl_close($ch);

    if ($curlErr || $httpCode < 200 || $httpCode >= 300) {
        \Illuminate\Support\Facades\Log::error("Groq AI error: HTTP $httpCode | cURL: $curlErr | Response: $response");
        return response()->json(['error' => 'Koneksi ke AI gagal. Coba lagi ya!'], 502);
    }

    $data  = json_decode($response, true);
    $reply = $data['choices'][0]['message']['content'] ?? 'Maaf, respons AI kosong.';

    return response()->json(['reply' => trim($reply)]);
})->name('ai.chat');

// Subtitle CORS Proxy
Route::get('/subtitle-cors/{id}', function($id) {
    $movie = \App\Models\Movie::findOrFail($id);
    if(!$movie->subtitle_url) abort(404);
    
    $path = public_path($movie->subtitle_url);
    if(!file_exists($path)) {
        $path = storage_path('app/public/' . str_replace('/storage/', '', $movie->subtitle_url));
    }
    
    if(!file_exists($path)) abort(404);
    
    return response()->file($path, [
        'Access-Control-Allow-Origin' => '*',
        'Content-Type' => 'text/vtt',
    ]);
})->name('subtitle.cors');

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    Route::get('/profile', \App\Livewire\User\Profile::class)->name('user.profile');
    Route::get('/request-film', \App\Livewire\RequestFilm::class)->name('request.film');

    // Fitur Kelola Film Khusus User
    Route::get('/dashboard/films', \App\Livewire\User\Films\Index::class)->name('user.films.index');
    Route::get('/dashboard/films/create', \App\Livewire\User\Films\Create::class)->name('user.films.create');
    Route::get('/dashboard/films/edit/{id}', \App\Livewire\User\Films\Edit::class)->name('user.films.edit');
});

Route::middleware(['auth', 'can:admin'])->prefix('admin')->group(function () {
    Route::get('/run-migration', function() {
        try {
            Artisan::call('migrate', ['--force' => true]);
            return "MIGRASI BERHASIL: " . Artisan::output();
        } catch (\Exception $e) {
            return "MIGRASI GAGAL: " . $e->getMessage();
        }
    });

    Route::get('/', \App\Livewire\Admin\Reports\Index::class)->name('admin.dashboard');
    
    Route::get('/films', \App\Livewire\Admin\Films\Index::class)->name('admin.films.index');
    Route::get('/films/create', \App\Livewire\Admin\Films\Create::class)->name('admin.films.create');
    Route::get('/film-helper/scrape', [\App\Livewire\Admin\Films\Create::class, 'scrapeOfficial'])->name('admin.film.scrape');
    Route::get('/films/edit/{id}', \App\Livewire\Admin\Films\Edit::class)->name('admin.films.edit');
    Route::get('/films/edit/{id}', \App\Livewire\Admin\Films\Edit::class)->name('admin.films.edit');
    
    Route::get('/genres', \App\Livewire\Admin\Genres\Index::class)->name('admin.genres.index');
    Route::get('/users', \App\Livewire\Admin\Users\Index::class)->name('admin.users.index');
    Route::get('/reports', \App\Livewire\Admin\Reports\ListReports::class)->name('admin.reports.index');
    Route::get('/requests', \App\Livewire\Admin\Requests\ListRequests::class)->name('admin.requests.index');
    Route::get('/reviews', \App\Livewire\Admin\Reviews\Index::class)->name('admin.reviews.index');
    Route::get('/settings', \App\Livewire\Admin\Settings\SiteSettings::class)->name('admin.settings');
});
