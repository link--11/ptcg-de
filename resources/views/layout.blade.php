<!DOCTYPE html>
<html lang="de">

@php
    $fallback_title = 'Pokémon Organized Play Deutschland';
    $fallback_desc = $fallback_desc ?? '';
    $fallback_image = URL::to('/images/preview.png');

    $yield = function ($section, $fallback) {
        return trim(htmlspecialchars_decode(View::yieldContent($section, $fallback), ENT_QUOTES));
    };

    $page_title = $yield('title', $fallback_title) . ' – PTCG DE';
    $page_desc = $yield('description', $fallback_desc);
    $page_image = $yield('image', $fallback_image);
    $page_type = $yield('type', 'website');
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_title }}</title>
    <meta name="description" content="{{ $page_desc }}">

    @section('meta.og')
        <meta property="og:title" content="{{ $page_title }}">
        <meta property="og:description" content="{{ $page_desc }}">
        <meta property="og:image" content="{{ $page_image }}">
        <meta property="og:type" content="{{ $page_type }}">
        <meta property="og:site_name" content="PTCG DE">
    @show

    @section('meta.twitter')
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="{{ $page_title }}">
        <meta name="twitter:description" content="{{ $page_desc }}">
        <meta name="twitter:image" content="{{ $page_image }}">
    @show

    <link rel="manifest" href="/app.webmanifest">

    @vite(['resources/styles/main.sass', 'resources/scripts/main.js'])

    @section('styles')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400..700&family=Open+Sans+Condensed:wght@700&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400..700&family=Open+Sans+Condensed:wght@700&display=swap">
        <link rel="stylesheet" href="/inc/fontawesome/css/all.min.css?v=5.11.2">
    @show

    @section('scripts')
    @show
</head>

<body>
    @include('header')

    <div class="before-content">@yield('before-content')</div>

    <main>
        <div class="container content">@yield('content')</div>
    </main>

    <div class="after-content">@yield('after-content')</div>

    @include('footer')
</body>

</html>
