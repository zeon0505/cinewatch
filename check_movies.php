<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Movie;

$movies = Movie::latest()->take(5)->get(['id', 'title', 'video_url', 'tmdb_id']);
foreach($movies as $m) {
    echo "ID: {$m->id} | Title: {$m->title} | URL: {$m->video_url} | TMDB: {$m->tmdb_id}\n";
}
