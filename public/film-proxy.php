<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$type = $_GET['type'] ?? 'search';
$source = $_GET['source'] ?? 'tmdb';
$query = $_GET['query'] ?? '';
$id = $_GET['id'] ?? '';
$url_to_scrape = $_GET['url'] ?? '';

$tmdb_key = 'c9772ee20fb25405e32ca19208a0ab6e';

function fetch_url($url) {
    if (empty($url)) return null;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 25);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

if ($type === 'scrape') {
    $html = fetch_url($url_to_scrape);
    if (!$html) {
        echo json_encode(['error' => 'Gagal koneksi ke situs tersebut. Browser/ISP mungkin memblokir akses proxy.']);
        exit;
    }

    $res = [
        'title' => '',
        'image' => '',
        'description' => 'Nonton movie streaming online kualitas tinggi.',
        'video' => $url_to_scrape
    ];

    // Meta Tags Extraction (Common across D21, IDLIX, LK21)
    if (preg_match('/<meta property="og:title" content="([^"]+)"/i', $html, $m)) $res['title'] = html_entity_decode($m[1]);
    if (preg_match('/<meta property="og:image" content="([^"]+)"/i', $html, $m)) $res['image'] = $m[1];
    if (preg_match('/<meta property="og:description" content="([^"]+)"/i', $html, $m)) $res['description'] = html_entity_decode($m[1]);

    // Fallback if OG tags missing
    if (empty($res['title']) && preg_match('/<title>([^<]+)<\/title>/i', $html, $m)) $res['title'] = $m[1];

    // Specific Cleanups for D21/IDLIX/LK21 branding in titles
    $bad_words = ['Nonton', 'LayarKaca21', 'LK21', 'IDLIX', 'D21', 'Streaming', 'Subtitle Indonesia', 'Online', 'Movie', 'Film', 'Indoxxi', 'Official'];
    $res['title'] = trim(preg_replace('/\b(' . implode('|', $bad_words) . ')\b/i', '', $res['title']));
    $res['title'] = trim($res['title'], " -|[]()\t\n\r\0\x0B");

    echo json_encode($res);
    exit;
}

if ($source === 'lk21' || $source === 'idlix') {
    $api_url = "https://lk21-api-febriadj.vercel.app/search?query=" . urlencode($query);
    $data = fetch_url($api_url);
    echo $data ?: json_encode(['error' => 'API LK21 sedang sibuk.']);
} else {
    $api_url = ($type === 'search') 
        ? "https://api.themoviedb.org/3/search/movie?api_key={$tmdb_key}&query=" . urlencode($query) . "&language=id-ID"
        : "https://api.themoviedb.org/3/movie/{$id}?api_key={$tmdb_key}&language=id-ID";
    echo fetch_url($api_url);
}
