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
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    $trendingMovies = Movie::orderBy('views', 'desc')->take(10)->get();
    $latestMovies = Movie::latest()->take(10)->get();
    $categories = Category::all();
    
    $featuredFilmIds = [];
    if (\Illuminate\Support\Facades\Storage::disk('local')->exists('settings.json')) {
        $settings = json_decode(\Illuminate\Support\Facades\Storage::disk('local')->get('settings.json'), true);
        $featuredFilmIds = $settings['featured_film_ids'] ?? [];
    }

    if (!empty($featuredFilmIds)) {
        $heroMovies = Movie::whereIn('id', $featuredFilmIds)->get();
    } else {
        $heroMovies = collect();
    }

    if ($heroMovies->isEmpty()) {
        $heroMovies = Movie::latest()->take(3)->get();
    }

    return view('welcome', compact('trendingMovies', 'latestMovies', 'categories', 'heroMovies'));
});
Route::get('/login', Login::class)->name('login')->middleware('guest');
Route::get('/register', Register::class)->name('register')->middleware('guest');

Route::get('/movie/{slug}', MovieDetail::class)->name('movie.detail');
Route::get('/watch/{id}', Player::class)->name('movie.watch');
Route::get('/category/{slug}', \App\Livewire\CategoryDetail::class)->name('category.detail');

Route::get('/about', function() { return view('pages.about'); })->name('about');
Route::get('/contact', function() { return view('pages.contact'); })->name('contact');

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
    Route::get('/reports', \App\Livewire\Admin\Reports\Index::class)->name('admin.reports.index');
    Route::get('/reviews', \App\Livewire\Admin\Reviews\Index::class)->name('admin.reviews.index');
    Route::get('/settings', \App\Livewire\Admin\Settings\SiteSettings::class)->name('admin.settings');
});
