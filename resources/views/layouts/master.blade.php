<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VOVOI - Beyond Ordinary')</title>
    <meta name="description" content="Explore our curated collection of premium electronics, synced in real-time across all locations.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vovoi.css') }}">
    @yield('extra_css')
</head>
<body style="min-height: 100vh; display: flex; flex-direction: column; background-color: var(--bg-primary, #FFFFFF); color: var(--text-primary, #0F172A);">

    <x-navbar />

    <main style="flex: 1; display: flex; flex-direction: column;">
        @yield('konten_utama')
    </main>

    <x-footer />

    @yield('extra_js')
</body>
</html>

