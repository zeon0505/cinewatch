<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'CINEWATCH — Premium Experience' }}</title>
    
    <!-- Standard CDNs for Consistency -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style>
        :root {
            --red: #E50914;
            --bg: #050505;
        }
        body { background: var(--bg); color: #E5E5E5; font-family: 'Outfit', sans-serif; }
        .logo { font-family: 'Bebas Neue', sans-serif; letter-spacing: 2px; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: var(--red); border-radius: 10px; }
    </style>
    @livewireStyles
</head>
<body class="antialiased font-sans">
    {{ $slot }}
    @livewireScripts
</body>
</html>
